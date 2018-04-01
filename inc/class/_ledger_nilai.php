<?php
///////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////
/////// SISFOKOL_SMK_v5.0_(PernahJaya)                          ///////
/////// (Sistem Informasi Sekolah untuk SMK)                    ///////
///////////////////////////////////////////////////////////////////////
/////// Dibuat oleh :                                           ///////
/////// Agus Muhajir, S.Kom                                     ///////
/////// URL 	:                                               ///////
///////     * http://omahbiasawae.com/                          ///////
///////     * http://sisfokol.wordpress.com/                    ///////
///////     * http://hajirodeon.wordpress.com/                  ///////
///////     * http://yahoogroup.com/groups/sisfokol/            ///////
///////     * http://yahoogroup.com/groups/linuxbiasawae/       ///////
/////// E-Mail	:                                               ///////
///////     * hajirodeon@yahoo.com                              ///////
///////     * hajirodeon@gmail.com                              ///////
/////// HP/SMS/WA : 081-829-88-54                               ///////
///////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////



require("fpdf/fpdf.php");




////////////////////////////////////

class PDF extends FPDF
{
//variables of html parser
var $B;
var $I;
var $U;
var $HREF;
var $fontList;
var $issetfont;
var $issetcolor;

function PDF($orientation='L',$unit='mm',$format='F4')
	{
	//Call parent constructor
	$this->FPDF($orientation,$unit,$format);
	//Initialization
	$this->B=0;
	$this->I=0;
	$this->U=0;
	$this->HREF='';

	$this->tableborder=0;
	$this->tdbegin=false;
	$this->tdwidth=0;
	$this->tdheight=0;
	$this->tdalign="L";
	$this->tdbgcolor=false;

	$this->oldx=0;
	$this->oldy=0;

	$this->fontlist=array("arial","times","courier","helvetica","symbol");
	$this->issetfont=false;
	$this->issetcolor=false;
	}

//////////////////////////////////////
//html parser

function WriteHTML($html)
	{
	$html=strip_tags($html,"<b><u><i><a><img><p><br><strong><em><font><tr><blockquote><hr><td><tr><table><sup>"); //remove all unsupported tags
	$html=str_replace("\n",'',$html); //replace carriage returns by spaces
	$html=str_replace("\t",'',$html); //replace carriage returns by spaces
	$a=preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE); //explodes the string
	foreach($a as $i=>$e)
	{
		if($i%2==0)
		{
			//Text
			if($this->HREF)
				$this->PutLink($this->HREF,$e);
			elseif($this->tdbegin) {
				if(trim($e)!='' and $e!="&nbsp;") {
					$this->Cell($this->tdwidth,$this->tdheight,$e,$this->tableborder,'',$this->tdalign,$this->tdbgcolor);
				}
				elseif($e=="&nbsp;") {
					$this->Cell($this->tdwidth,$this->tdheight,'',$this->tableborder,'',$this->tdalign,$this->tdbgcolor);
				}
			}
			else
				$this->Write(5,stripslashes(txtentities($e)));
		}
		else
		{
			//Tag
			if($e{0}=='/')
				$this->CloseTag(strtoupper(substr($e,1)));
			else
			{
				//Extract attributes
				$a2=explode(' ',$e);
				$tag=strtoupper(array_shift($a2));
				$attr=array();
				foreach($a2 as $v)
					if(ereg('^([^=]*)=["\']?([^"\']*)["\']?$',$v,$a3))
						$attr[strtoupper($a3[1])]=$a3[2];
				$this->OpenTag($tag,$attr);
				}
			}
		}
	}

function OpenTag($tag,$attr)
	{
	//Opening tag
	switch($tag)
		{
		case 'SUP':
			if($attr['SUP'] != '') {
				//Set current font to: Bold, 6pt
				$this->SetFont('','',6);
				//Start 125cm plus width of cell to the right of left margin
				//Superscript "1"
				$this->Cell(2,2,$attr['SUP'],0,0,'L');
			}
			break;

		case 'TABLE': // TABLE-BEGIN
			if( $attr['BORDER'] != '' ) $this->tableborder=$attr['BORDER'];
			else $this->tableborder=0;
			break;
		case 'TR': //TR-BEGIN
			break;
		case 'TD': // TD-BEGIN
			if( $attr['WIDTH'] != '' ) $this->tdwidth=($attr['WIDTH']/4);
			else $this->tdwidth=40; // SET to your own width if you need bigger fixed cells
			if( $attr['HEIGHT'] != '') $this->tdheight=($attr['HEIGHT']/6);
			else $this->tdheight=6; // SET to your own height if you need bigger fixed cells
			if( $attr['ALIGN'] != '' ) {
				$align=$attr['ALIGN'];
				if($align=="LEFT") $this->tdalign="L";
				if($align=="CENTER") $this->tdalign="C";
				if($align=="RIGHT") $this->tdalign="R";
			}
			else $this->tdalign="L"; // SET to your own
			if( $attr['BGCOLOR'] != '' ) {
				$coul=hex2dec($attr['BGCOLOR']);
					$this->SetFillColor($coul['R'],$coul['G'],$coul['B']);
					$this->tdbgcolor=true;
				}
			$this->tdbegin=true;
			break;

		case 'HR':
			if( $attr['WIDTH'] != '' )
				$Width = $attr['WIDTH'];
			else
				$Width = $this->w - $this->lMargin-$this->rMargin;
			$x = $this->GetX();
			$y = $this->GetY();
			$this->SetLineWidth(0.2);
			$this->Line($x,$y,$x+$Width,$y);
			$this->SetLineWidth(0.2);
			$this->Ln(1);
			break;
		case 'STRONG':
			$this->SetStyle('B',true);
			break;
		case 'EM':
			$this->SetStyle('I',true);
			break;
		case 'B':
		case 'I':
		case 'U':
			$this->SetStyle($tag,true);
			break;
		case 'A':
			$this->HREF=$attr['HREF'];
			break;
		case 'IMG':
			if(isset($attr['SRC']) and (isset($attr['WIDTH']) or isset($attr['HEIGHT']))) {
				if(!isset($attr['WIDTH']))
					$attr['WIDTH'] = 0;
				if(!isset($attr['HEIGHT']))
					$attr['HEIGHT'] = 0;
				$this->Image($attr['SRC'], $this->GetX(), $this->GetY(), px2mm($attr['WIDTH']), px2mm($attr['HEIGHT']));
			}
			break;
		//case 'TR':
		case 'BLOCKQUOTE':
		case 'BR':
			$this->Ln(5);
			break;
		case 'P':
			$this->Ln(10);
			break;
		case 'FONT':
			if (isset($attr['COLOR']) and $attr['COLOR']!='') {
				$coul=hex2dec($attr['COLOR']);
				$this->SetTextColor($coul['R'],$coul['G'],$coul['B']);
				$this->issetcolor=true;
			}
			if (isset($attr['FACE']) and in_array(strtolower($attr['FACE']), $this->fontlist)) {
				$this->SetFont(strtolower($attr['FACE']));
				$this->issetfont=true;
			}
			if (isset($attr['FACE']) and in_array(strtolower($attr['FACE']), $this->fontlist) and isset($attr['SIZE']) and $attr['SIZE']!='') {
				$this->SetFont(strtolower($attr['FACE']),'',$attr['SIZE']);
				$this->issetfont=true;
			}
			break;
		}
	}

function CloseTag($tag)
	{
	//Closing tag
	if($tag=='SUP') {
	}

	if($tag=='TD') { // TD-END
		$this->tdbegin=false;
		$this->tdwidth=0;
		$this->tdheight=0;
		$this->tdalign="L";
		$this->tdbgcolor=false;
	}
	if($tag=='TR') { // TR-END
		$this->Ln();
	}
	if($tag=='TABLE') { // TABLE-END
		//$this->Ln();
		$this->tableborder=0;
	}

	if($tag=='STRONG')
		$tag='B';
	if($tag=='EM')
		$tag='I';
	if($tag=='B' or $tag=='I' or $tag=='U')
		$this->SetStyle($tag,false);
	if($tag=='A')
		$this->HREF='';
	if($tag=='FONT'){
		if ($this->issetcolor==true) {
			$this->SetTextColor(0);
		}
		if ($this->issetfont) {
			$this->SetFont('arial');
			$this->issetfont=false;
			}
		}
	}

function SetStyle($tag,$enable)
	{
	//Modify style and select corresponding font
	$this->$tag+=($enable ? 1 : -1);
	$style='';
	foreach(array('B','I','U') as $s)
		if($this->$s>0)
			$style.=$s;
	$this->SetFont('',$style);
	}

function PutLink($URL,$txt)
	{
	//Put a hyperlink
	$this->SetTextColor(0,0,255);
	$this->SetStyle('U',true);
	$this->Write(5,$txt,$URL);
	$this->SetStyle('U',false);
	$this->SetTextColor(0);
	}

//Page header
function HeaderKu()
	{
	//require
	require("../../inc/config.php");
	require("../../inc/koneksi.php");

	//nilai
	$kelkd = nosql($_REQUEST['kelkd']);
	$keahkd = nosql($_REQUEST['keahkd']);
	$rukd = nosql($_REQUEST['rukd']);
	$tapelkd = nosql($_REQUEST['tapelkd']);
	$smtkd = nosql($_REQUEST['smtkd']);


	//kelas
	$qk = mysql_query("SELECT * FROM m_kelas ".
						"WHERE kd = '$kelkd'");
	$rk = mysql_fetch_assoc($qk);
	$rkel = balikin($rk['kelas']);


	//keahlian
	$qpro = mysql_query("SELECT * FROM m_keahlian ".
							"WHERE kd = '$keahkd'");
	$rpro = mysql_fetch_assoc($qpro);
	$pro_bidang = balikin($rpro['bidang']);
	$pro_program = balikin($rpro['program']);
	$pro_keah = "$pro_program";




	//ruang
	$qu = mysql_query("SELECT * FROM m_ruang ".
						"WHERE kd = '$rukd'");
	$ru = mysql_fetch_assoc($qu);
	$rru = nosql($ru['ruang']);

	$kelas = "$rkel";


	//smt
	$qmt = mysql_query("SELECT * FROM m_smt ".
						"WHERE kd = '$smtkd'");
	$rmt = mysql_fetch_assoc($qmt);
	$smt = balikin($rmt['smt']);

	//tapel
	$qtp = mysql_query("SELECT * FROM m_tapel ".
							"WHERE kd = '$tapelkd'");
	$rtp = mysql_fetch_assoc($qtp);
	$thn1 = $rtp['tahun1'];
	$thn2 = $rtp['tahun2'];
	$tapel = "$thn1/$thn2";

	//walikelas
	$qwk = mysql_query("SELECT * FROM m_walikelas ".
							"WHERE kd_tapel = '$tapelkd' ".
							"AND kd_kelas = '$kelkd' ".
							"AND kd_ruang = '$rukd'");
	$rwk = mysql_fetch_assoc($qwk);
	$nwk = balikin2($rwk['nama']);

   $this->SetFont('Times','B',14);


	$this->WriteHTML(
						'<table width="700">'.
  						'<tr align="left">'.
    					'<td width="150" height="30">Nama Sekolah</td>'.
    					'<td height="30">: '.$sek_nama.'</td>'.
  						'</tr>'.
  						'<tr>'.
				    	'<td width="150" height="30">Alamat</td>'.
    					'<td height="30">: '.$sek_alamat.'</td>'.
  						'</tr>'.
  						'<tr>'.
			    		'<td width="150" height="30">Telepon</td>'.
    					'<td height="30">: '.$sek_kontak.'</td>'.
  						'</tr>'.
						'</table>
						<table width="600"><tr><td width="600" height="20"><hr></td></tr></table>'
					);
	$this->SetY(25);
    $this->SetFont('Times','',12);
	$this->WriteHTML('<table width="600">'.
						'<tr align="left">'.
						'<td width="120" height="30">Keahlian</td>'.
						'<td width="10" height="30">: '.$pro_keah.'</td>'.
						'<td width="350" height="30">&nbsp;</td>'.
						'<td width="120" height="30">Tahun Pelajaran</td>'.
						'<td width="3" height="30">: '.$tapel.'</td>'.
						'</tr><tr>'.
						'<td width="120" height="30">Kelas</td>'.
						'<td width="10" height="30">: '.$kelas.'</td>'.
						'<td width="350" height="30">&nbsp;</td>'.
						'<td width="120" height="30">Semester</td>'.
						'<td width="3" height="30">: '.$smt.'</td>'.
						'</tr>'.
						'</table>'.
						'<table width="600"><tr><td width="600" height="20"><hr></td></tr></table>');

	}


function TextWithDirection($x,$y,$txt,$direction='R')
{
	$txt=str_replace(')','\\)',str_replace('(','\\(',str_replace('\\','\\\\',$txt)));
	if ($direction=='R')
		$s=sprintf('BT %.2f %.2f %.2f %.2f %.2f %.2f Tm (%s) Tj ET',1,0,0,1,$x*$this->k,($this->h-$y)*$this->k,$txt);
	elseif ($direction=='L')
		$s=sprintf('BT %.2f %.2f %.2f %.2f %.2f %.2f Tm (%s) Tj ET',-1,0,0,-1,$x*$this->k,($this->h-$y)*$this->k,$txt);
	elseif ($direction=='U')
		$s=sprintf('BT %.2f %.2f %.2f %.2f %.2f %.2f Tm (%s) Tj ET',0,1,-1,0,$x*$this->k,($this->h-$y)*$this->k,$txt);
	elseif ($direction=='D')
		$s=sprintf('BT %.2f %.2f %.2f %.2f %.2f %.2f Tm (%s) Tj ET',0,-1,1,0,$x*$this->k,($this->h-$y)*$this->k,$txt);
	else
		$s=sprintf('BT %.2f %.2f Td (%s) Tj ET',$x*$this->k,($this->h-$y)*$this->k,$txt);
	if ($this->ColorFlag)
		$s='q '.$this->TextColor.' '.$s.' Q';
	$this->_out($s);
}

function TextWithRotation($x,$y,$txt,$txt_angle,$font_angle=0)
{
	$txt=str_replace(')','\\)',str_replace('(','\\(',str_replace('\\','\\\\',$txt)));

	$font_angle+=90+$txt_angle;
	$txt_angle*=M_PI/180;
	$font_angle*=M_PI/180;

	$txt_dx=cos($txt_angle);
	$txt_dy=sin($txt_angle);
	$font_dx=cos($font_angle);
	$font_dy=sin($font_angle);

	$s=sprintf('BT %.2f %.2f %.2f %.2f %.2f %.2f Tm (%s) Tj ET',
			 $txt_dx,$txt_dy,$font_dx,$font_dy,
			 $x*$this->k,($this->h-$y)*$this->k,$txt);
	if ($this->ColorFlag)
		$s='q '.$this->TextColor.' '.$s.' Q';
	$this->_out($s);
}
}//end of class





//function hex2dec
//returns an associative array (keys: R,G,B) from
//a hex html code (e.g. #3FE5AA)
function hex2dec($couleur = "#000000"){
	$R = substr($couleur, 1, 2);
	$rouge = hexdec($R);
	$V = substr($couleur, 3, 2);
	$vert = hexdec($V);
	$B = substr($couleur, 5, 2);
	$bleu = hexdec($B);
	$tbl_couleur = array();
	$tbl_couleur['R']=$rouge;
	$tbl_couleur['G']=$vert;
	$tbl_couleur['B']=$bleu;
	return $tbl_couleur;
}

//conversion pixel -> millimeter in 72 dpi
function px2mm($px){
	return $px*25.4/72;
}

function txtentities($html){
	$trans = get_html_translation_table(HTML_ENTITIES);
	$trans = array_flip($trans);
	return strtr($html, $trans);
}




?>