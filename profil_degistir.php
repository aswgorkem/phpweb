<?php
/*
 +-=========================================================================-+
 |                       php Kolay Forum (phpKF) v2.00                       |
 +---------------------------------------------------------------------------+
 |               Telif - Copyright (c) 2007 - 2015 phpKF Ekibi               |
 |                 http://www.phpKF.com   -   phpKF@phpKF.com                |
 |                 Tüm hakları saklıdır - All Rights Reserved                |
 +---------------------------------------------------------------------------+
 |  Bu yazılım ücretsiz olarak kullanıma sunulmuştur.                        |
 |  Ücretli olarak satılamaz veya phpKF.com`dan başka bir yerde dağıtılamaz  |
 |  Yazılımı dağıtma ve resmi sürüm çıkartma hakları sadece phpKF`ye aittir  |
 |  Yazılım kodları hiçbir şekilde başka bir yazılımda kullanılamaz.         |
 |  Kodlardaki ve sayfa altındaki telif yazıları silinemez, değiştirilemez,  |
 |  veya bu telif ile çelişen başka bir telif eklenemez.                     |
 |  Telif maddelerinin değiştirilme hakkı saklıdır.                          |
 |  Güncel telif maddeleri için  www.phpKF.com  adresini ziyaret edin.       |
 +-=========================================================================-+*/


@ini_set('magic_quotes_runtime', 0);

if (!defined('DOSYA_AYAR')) include 'ayar.php';
if (!defined('DOSYA_GUVENLIK')) include 'bilesenler/guvenlik.php';


// oturum kodu
$o = $satir['kullanici_kimlik'];
$o = $o[3].$o[6].$o[8].$o[10].$o[13].$o[17].$o[19].$o[25].$o[30].$o[33];

$_COOKIE['kullanici_kimlik'] = $vt->real_escape_string($_COOKIE['kullanici_kimlik']);



    //  E-POSTA - ŞİFRE DEĞİŞTİRME - BAŞI  //

if ( (isset($_GET['kosul'])) AND ($_GET['kosul'] == 'sifre') ):


$sayfano = 29;
$sayfa_adi = 'E-Posta ve Şifre Değiştir';
include_once('bilesenler/sayfa_baslik.php');

// tema dosyası
$ornek1 = new phpkf_tema();
$tema_dosyasi = 'temalar/'.$temadizini.'/profil_degistir.php';
eval($ornek1->tema_dosyasi($tema_dosyasi));


// kullanıcı bilgilileri çekiliyor

$vtsorgu = "SELECT id,posta FROM $tablo_kullanicilar WHERE kullanici_kimlik='$_COOKIE[kullanici_kimlik]' LIMIT 1";
$vtsonuc = $vt->query($vtsorgu) or die ($vt->hata_ver());
$satir = $vt->fetch_array($vtsonuc);

$javascript_kodu = '<script type="text/javascript">
<!--
function denetle(){
var dogruMu = true;
for (var i=0; i<7; i++){
	if (document.form1.elements[i].value==""){
		dogruMu = false;
		alert("* İŞARETLİ ALANLARIN DOLDURULMASI ZORUNLUDUR !");
		break;}}
if (document.form1.ysifre.value != document.form1.ysifre2.value){
	dogruMu = false; 
	alert("YAZDIĞINIZ ŞİFRELER UYUŞMUYOR !");}
return dogruMu;}
//  -->
</script>';


// okunmamış özel iletisi varsa
if ($ayarlar['o_ileti'] == 1)
{
	if ($kullanici_kim['okunmamis_oi'])
		$okunmamis_oi = ' ('.$kullanici_kim['okunmamis_oi'].')';
	else $okunmamis_oi = '';
}

else $okunmamis_oi = '';


//	TEMA UYGULANIYOR	//

$ornek1->dongusuz(array('{JAVASCRIPT_KODU}' => $javascript_kodu,
'{FORM_BILGI}' => '<form name="form1" action="bilesenler/profil_degistir_yap.php?o='.$o.'" method="post" onsubmit="return denetle()">
<input type="hidden" name="profil_degisti_mi" value="form_dolu">
<input type="hidden" name="islem_turu" value="sifre">',
'{ALAN_BILGI}' => '<font size="1"><i>&nbsp;&nbsp; * işaretli alanların doldurulması zorunludur!</i></font>',
'{B_DEGISTIR}' => '<a href="profil_degistir.php">Bilgilerimi Değiştir</a>',
'{ES_DEGISTIR}' => '<font style="font-size: 10px"><b>E-Posta - Şifre Değiştir</b></font>',
'{YUKLEMELER}' => '<a href="profil_degistir.php?kosul=yuklemeler">Yüklemeler</a>',
'{BILDIRIMLER}' => '<a href="profil_degistir.php?kosul=bildirim">Bildirimler</a>',
'{TAKIP}' => '<a href="profil_degistir.php?kosul=takip">Takip Edilenler</a>',
'{SAYFA_BASLIK}' => 'E-Posta ve Şifre Değiştir',
'{OKUNMAMIS_OI}' => $okunmamis_oi));

$dongusuz2 = array('{UYE_EPOSTA}' => $satir['posta']);

$ornek1->kosul('6', array('' => ''), false);
$ornek1->kosul('8', array('' => ''), false);
$ornek1->kosul('9', array('' => ''), false);
$ornek1->kosul('7', $dongusuz2, true);


    //  E-POSTA - ŞİFRE DEĞİŞTİRME - SONU  //





    //  YÜKLEMELER - BAŞI  //

elseif ( (isset($_GET['kosul'])) AND ($_GET['kosul'] == 'yuklemeler') ):


$sayfano = 40;
$sayfa_adi = 'Yüklemeler';
include_once('bilesenler/sayfa_baslik.php');

// tema dosyası
$ornek1 = new phpkf_tema();
$tema_dosyasi = 'temalar/'.$temadizini.'/profil_degistir.php';
eval($ornek1->tema_dosyasi($tema_dosyasi));



// okunmamış özel iletisi varsa
if ($ayarlar['o_ileti'] == 1)
{
	if ($kullanici_kim['okunmamis_oi'])
		$okunmamis_oi = ' ('.$kullanici_kim['okunmamis_oi'].')';
	else $okunmamis_oi = '';
}

else $okunmamis_oi = '';



$vtsorgu = "SELECT * FROM $tablo_yuklemeler WHERE uye_id='$kullanici_kim[id]' ORDER BY id ASC";
$vtsonuc2 = $vt->query($vtsorgu) or die ($vt->hata_ver());
$sira = 0;
$tboyut = 0;


// yüklü dosya varsa

if ($vt->num_rows($vtsonuc2))
{
	while ($yukleme = $vt->fetch_array($vtsonuc2))
	{
		$sira++;

		$dosya = $yukleme['dosya'];

		$tarih = zonedate($ayarlar['tarih_bicimi'], $ayarlar['saat_dilimi'], false, $yukleme['tarih']);

		$boyut = NumaraBicim($yukleme['boyut']).' <b>kb.</b>';

		$sil = '<a href="profil_degistir.php?kosul=dsil&amp;o='.$o.'&amp;sil='.$yukleme['id'].'" onclick="return window.confirm(\'Dosyayı silmek istediğinize emin misiniz ?\nDosyayı herhangi bir iletide kullandıysanız sildikten sonra erişilemez olacaktır.\')">Sil</a>';

		$ara = '<a href="arama.php?a=1&amp;b=1&amp;forum=tum&amp;tarih=tum_zamanlar&amp;sozcuk_hepsi='.$yukleme['dosya'].'">Ara</a>';

		$ac = '<a href="dosyalar/yuklemeler/'.$yukleme['dosya'].'" target="_blank">Aç</a>';

		$tboyut += $yukleme['boyut'];

		$tekli1[] = array('{SIRA}' => $sira.')',
		'{DOSYA}' => $dosya,
		'{TARIH}' => $tarih,
		'{BOYUT}' => $boyut,
		'{SIL}' => $sil,
		'{ARA}' => $ara,
		'{AC}' => $ac);
	}

	$toplam = '<b>Toplam dosya boyutu:&nbsp; '.NumaraBicim($tboyut).' kb.</b>';
}


// yüklü dosya yoksa

else
{
	$tekli1[] = array('{SIRA}' => '</b></td><td colspan="6" width="99%"><br><center><b>Yüklediğiniz dosya yok</b></center><br><!-- ',
	'{DOSYA}' => '',
	'{TARIH}' => '',
	'{BOYUT}' => '',
	'{SIL}' => '',
	'{ARA}' => '',
	'{AC}' => '-->');

	$toplam = '';
}

$alan_bilgi = 'Forum üzerinden yüklediğiniz dosyalar bu sayfada sıralanmaktadır.
<br>Dosyanın hangi iletilerde kullanıldığını bulmak için <b>Ara</b>yı tıklayın. Dosyayı indirmek veya adresini almak için <b>Aç</b>ı tıklayın. Dosyayı silmek için <b>Sil</b>i tıklayın. Dosyayı herhangi bir iletide kullandıysanız sildikten sonra erişilemez olacaktır.
<br>&nbsp;&nbsp; Gereksiz yüklemeler yöneticiler tarafından silinecektir.
<br><br>';


//	TEMA UYGULANIYOR	//

$ornek1->dongusuz(array('{JAVASCRIPT_KODU}' => '',
'{FORM_BILGI}' => '',
'<input class="dugme" type="submit" value="Değiştir">' => '',
'<input class="dugme" type="reset">' => $toplam,
'</form>' => '',
'{ALAN_BILGI}' => $alan_bilgi,
'{B_DEGISTIR}' => '<a href="profil_degistir.php">Bilgilerimi Değiştir</a>',
'{ES_DEGISTIR}' => '<a href="profil_degistir.php?kosul=sifre">E-Posta - Şifre Değiştir</a>',
'{YUKLEMELER}' => '<font style="font-size: 10px"><b>Yüklemeler</b></font>',
'{BILDIRIMLER}' => '<a href="profil_degistir.php?kosul=bildirim">Bildirimler</a>',
'{TAKIP}' => '<a href="profil_degistir.php?kosul=takip">Takip Edilenler</a>',
'{SAYFA_BASLIK}' => 'Yüklemeler',
'{OKUNMAMIS_OI}' => $okunmamis_oi));

$ornek1->kosul('6', array('' => ''), false);
$ornek1->kosul('7', array('' => ''), false);
$ornek1->kosul('9', array('' => ''), false);
$ornek1->kosul('8', array('' => ''), true);
$ornek1->tekli_dongu('1',$tekli1);


    //  YÜKLEMELER - SONU  //





    //  BİLDİRİMLER - BAŞI  //

elseif ( (isset($_GET['kosul'])) AND ($_GET['kosul'] == 'bildirim') ):

$sayfano = 43;
$sayfa_adi = 'Bildirimler';
include_once('bilesenler/sayfa_baslik.php');


// tema dosyası
$ornek1 = new phpkf_tema();
$tema_dosyasi = 'temalar/'.$temadizini.'/profil_degistir.php';
eval($ornek1->tema_dosyasi($tema_dosyasi));


$vtsorgu = "SELECT * FROM $tablo_bildirimler WHERE uye_id='$kullanici_kim[id]' ORDER BY id DESC";
$vtsonuc2 = $vt->query($vtsorgu) or die ($vt->hata_ver());
$sira = 0;


// bildirim varsa

if ($vt->num_rows($vtsonuc2))
{
	while ($bildirim = $vt->fetch_assoc($vtsonuc2))
	{
		$sira++;
		$tarih = zonedate($ayarlar['tarih_bicimi'], $ayarlar['saat_dilimi'], false, $bildirim['tarih']);
		$bsil = "bsil($sira,'$o',$bildirim[id])";


		if ($bildirim['tip'] == '1')
		{
			$bilgi = '<a href="profil.php?kim='.$bildirim['bildirim'].'">';
			if ($kullanici_kim['kullanici_adi'] == $bildirim['bildirim']) $bilgi .= '</a>Kendinize bir <a href="ozel_ileti.php">özel ileti</a> gönderdiniz.';
			else $bilgi .= $bildirim['bildirim'].'</a>&nbsp; size bir <a href="ozel_ileti.php">özel ileti</a> gönderdi.';
		}

		elseif ($bildirim['tip'] == '2') $bilgi = '<a href="profil.php?kim='.$bildirim['bildirim'].'">'.$bildirim['bildirim'].'</a>&nbsp; profilinize bir <a href="profil.php#yorum">yorum</a> yazdı.';

		elseif ($bildirim['tip'] == '4')
		{
			$tsk_konu = explode(';', $bildirim['bildirim']);
			$bilgi = '<a href="profil.php?kim='.$tsk_konu[0].'">'.$tsk_konu[0].'</a>&nbsp; bir yazınıza <a href="konu.php?'.$tsk_konu[1].'">teşekkür</a> etti.';
		}

		else $bilgi = '';


		$tekli2[] = array('{SIRA}' => $sira,
		'{TARIH}' => $tarih,
		'{BILGI}' => $bilgi,
		'{SIL}' => $bsil);
	}

	$ornek1->tekli_dongu('2',$tekli2);
	$ornek1->kosul('9', array('' => ''), true);
	$alan_bilgi = ' &nbsp; Aldığınız tüm kişisel bildirimler burada sıralanmaktadır, bunlardan istediklerinizi silebilirsiniz.';
	$toplamb = '<font class="liste-veri"><b>Toplam <span id="toplambs">'.$sira.'</span> bildiriminiz var.</b></font>';
}


// bildirim yoksa

else
{
	$ornek1->kosul('9', array('' => ''), false);
	$alan_bilgi = '<br><br><center><font class="liste-etiket">Hiç bildiriminiz yok.</font></center>';
	$toplamb = '';
}



// okunmamış özel iletisi varsa
if ($ayarlar['o_ileti'] == 1)
{
	if ($kullanici_kim['okunmamis_oi'])
		$okunmamis_oi = ' ('.$kullanici_kim['okunmamis_oi'].')';
	else $okunmamis_oi = '';
}

else $okunmamis_oi = '';





$javascript_kodu = '<script type="text/javascript"><!-- //
var toplamb = '.$sira.';
function GonderAl(adres,sira,o,sil){
var toplambs = document.getElementById("toplambs");
var katman1 = document.getElementById("bildirimkt"+sira);
var veri_yolla = "&o="+o+"&sil="+sil;
if (document.all) var istek = new ActiveXObject("Microsoft.XMLHTTP");
else var istek = new XMLHttpRequest();
istek.open("GET", adres+veri_yolla, true);
istek.onreadystatechange = function(){
if (istek.readyState == 4){
if (istek.status == 200){
toplamb--;
if(toplamb==0)katman1.innerHTML = \'<div align="center" style="position:relative;width:521px;float:center;border-left:1px solid #e0e0e0;border-right:1px solid #e0e0e0;border-bottom:1px solid #e0e0e0"><br><b>Tüm bildirimler silindi.</b><br><br></div>\';
else katman1.innerHTML = istek.responseText;
toplambs.innerHTML = toplamb;}
else katman1.innerHTML = \'<font color="#ff0000"><b>Bağlantı Kurulamadı !</b></font>\';}};
istek.send(veri_yolla);}
function bsil(sira,o,sil){
var adres = "profil_degistir.php?kosul=bsil";
var katman1 = document.getElementById("bildirimks"+sira);
katman1.innerHTML = \'<img src="dosyalar/yukleniyor.gif" width="15" height="15" border="0" alt="Yü." title="Yükleniyor...">\';
setTimeout("GonderAl(\'"+adres+"\',\'"+sira+"\',\'"+o+"\',\'"+sil+"\')",1000);}
//  -->
</script>';



//	TEMA UYGULANIYOR	//

$ornek1->dongusuz(array('{JAVASCRIPT_KODU}' => $javascript_kodu,
'{FORM_BILGI}' => '',
'<input class="dugme" type="submit" value="Değiştir">' => '',
'<input class="dugme" type="reset">' => $toplamb,
'</form>' => '',
'{ALAN_BILGI}' => $alan_bilgi,
'{B_DEGISTIR}' => '<a href="profil_degistir.php">Bilgilerimi Değiştir</a>',
'{ES_DEGISTIR}' => '<a href="profil_degistir.php?kosul=sifre">E-Posta - Şifre Değiştir</a>',
'{YUKLEMELER}' => '<a href="profil_degistir.php?kosul=yuklemeler">Yüklemeler</a>',
'{BILDIRIMLER}' => '<font style="font-size: 10px"><b>Bildirimler</b></font>',
'{TAKIP}' => '<a href="profil_degistir.php?kosul=takip">Takip Edilenler</a>',
'{SAYFA_BASLIK}' => 'Bildirimler',
'{OKUNMAMIS_OI}' => $okunmamis_oi));


$ornek1->kosul('6', array('' => ''), false);
$ornek1->kosul('7', array('' => ''), false);
$ornek1->kosul('8', array('' => ''), false);



    //  BİLDİRİMLER - SONU  //





    //  TAKİP - BAŞI  //

elseif ( (isset($_GET['kosul'])) AND ($_GET['kosul'] == 'takip') ):

$sayfano = 45;
$sayfa_adi = 'Takip Edilenler';
include_once('bilesenler/sayfa_baslik.php');


// üye takip bilgileri çekiliyor
$vtsorgu = "SELECT id,takip FROM $tablo_kullanicilar WHERE kullanici_kimlik='$_COOKIE[kullanici_kimlik]' LIMIT 1";
$vtsonuc2 = $vt->query($vtsorgu) or die ($vt->hata_ver());
$takip_veri = $vt->fetch_assoc($vtsonuc2);


if ($takip_veri['takip'] != '')
{
	$takip_secim0 = '';
	$takip_secim1 = 'checked="checked"';
}
else
{
	$takip_secim0 = 'checked="checked"';
	$takip_secim1 = '';
}


$alan_bilgi = '<table align="center" border="0" cellpadding="0" cellspacing="4" width="96%">
	<tr>
	<td align="left" valign="top">
<font class="liste-veri">Bu sayfadan; Forum üzerinden veya phpKF Android Uygulamasından takip etmek istediğiniz bölümleri seçebilirsiniz. Seçtiğiniz forum bölümlerini <a href="ymesaj.php?kip=takip"><b>şu sayfadan</b></a> takip edebilirsiniz.
<br><br>
Android uygulamasının sadece istediğiniz bölümlerden bildirim alması için: uygulama ayarlarının "Şunları Bildir" bölümünden, "Takip edilenler ve özel iletiler" ayarını seçin. Aşağıdaki alandan ise istediğiniz bölümleri seçip "<b><i>Uygula</i></b>" düğmesini tıklayın.
<br><br>
"<b><i>Takip Yok</i></b>" seçildiğinde forumda özel olarak hiçbir bölüm takip edilmeyecektir.
Android uygulamasında ise ayarlardan "Takip edilenler ve özel iletiler" seçişi ise sadece özel iletiler bildirilir. Tüm bildirimleri almak için tekrar "Her şey" ayarı seçilmelidir.</font>
<br><br>
	</td>
	</tr>

	<tr>
	<td align="left" valign="top" class="liste-veri">
<label style="cursor: pointer;" onclick="denetle_takip(0)">
<input type="radio" name="takip_secim" value="0" '.$takip_secim0.'>
<b>Takip Yok</b></label>
&nbsp; &nbsp;
<label style="cursor: pointer;">
<input type="radio" name="takip_secim" value="1" '.$takip_secim1.'>
<b>Seçili bölümleri takip et</b></label>
	</td>
	</tr>';



// Forum bölümleri sıralanıyor //

$alan_bilgi .= '<tr><td align="left" valign="top" class="liste-veri">
<select name="takip[]" id="takip" multiple="multiple" class="formlar" size="15" onchange="denetle_takip(1)">';


// forum dalı adları çekiliyor
$vtsorgu = "SELECT id,ana_forum_baslik FROM $tablo_dallar ORDER BY sira";
$dallar_sonuc = $vt->query($vtsorgu) or die ($vt->hata_ver());


while ($dallar_satir = $vt->fetch_array($dallar_sonuc))
{
	$alan_bilgi .= '<option value="d-'.$dallar_satir['id'].'">[ '.$dallar_satir['ana_forum_baslik'].' ]';


	// forum adları çekiliyor
	$vtsorgu = "SELECT id,forum_baslik,alt_forum FROM $tablo_forumlar WHERE alt_forum='0' AND dal_no='$dallar_satir[id]' ORDER BY sira";
	$vtsonuc = $vt->query($vtsorgu) or die ($vt->hata_ver());


	while ($forum_satir = $vt->fetch_array($vtsonuc))
	{
		// alt forumuna bakılıyor
		$vtsorgu = "SELECT id,forum_baslik FROM $tablo_forumlar WHERE alt_forum='$forum_satir[id]' ORDER BY sira";
		$vtsonuca = $vt->query($vtsorgu) or die ($vt->hata_ver());

		if (!$vt->num_rows($vtsonuca))
		{
			if (preg_match('/f-'.$forum_satir['id'].';/i', $takip_veri['takip']))
				$alan_bilgi .= '<option value="f-'.$forum_satir['id'].'" selected="selected"> &nbsp; - '.$forum_satir['forum_baslik'];
			else $alan_bilgi .= '<option value="f-'.$forum_satir['id'].'"> &nbsp; - '.$forum_satir['forum_baslik'];
		}

		else
		{
			if (preg_match('/f-'.$forum_satir['id'].';/i', $takip_veri['takip']))
				$alan_bilgi .= '<option value="f-'.$forum_satir['id'].'" selected="selected"> &nbsp; - '.$forum_satir['forum_baslik'];
			else $alan_bilgi .= '<option value="f-'.$forum_satir['id'].'"> &nbsp; - '.$forum_satir['forum_baslik'];

			while ($alt_forum_satir = $vt->fetch_array($vtsonuca))
			{
				if (preg_match('/f-'.$alt_forum_satir['id'].';/i', $takip_veri['takip']))
					$alan_bilgi .= '<option value="f-'.$alt_forum_satir['id'].'" selected="selected"> &nbsp; &nbsp; &nbsp; -- '.$alt_forum_satir['forum_baslik'];
				else $alan_bilgi .= '<option value="f-'.$alt_forum_satir['id'].'"> &nbsp; &nbsp; &nbsp; -- '.$alt_forum_satir['forum_baslik'];
			}
		}
	}
}

$alan_bilgi .= '</select>
<br>
<font size="1" style="font-style:italic">CTRL tuşuna basılı tutarak çoklu seçim yapabilirsiniz.</font>
	</td>
	</tr>
</table>';




// tema dosyası
$ornek1 = new phpkf_tema();
$tema_dosyasi = 'temalar/'.$temadizini.'/profil_degistir.php';
eval($ornek1->tema_dosyasi($tema_dosyasi));
$ornek1->kosul('9', array('' => ''), false);


// okunmamış özel iletisi varsa
if ($ayarlar['o_ileti'] == 1)
{
	if ($kullanici_kim['okunmamis_oi'])
		$okunmamis_oi = ' ('.$kullanici_kim['okunmamis_oi'].')';
	else $okunmamis_oi = '';
}

else $okunmamis_oi = '';


$javascript_kodu = '<script type="text/javascript">
<!-- //
function denetle_takip(sec){
if(document.form1.takip_secim){
if(sec==1)document.form1.takip_secim[1].checked= true;
else{var select=document.getElementById(\'takip\');
for(var i=0,l=select.options.length,o;i<l;i++)select.options[i].selected=false;}}}
//  -->
</script>';



//	TEMA UYGULANIYOR	//

$ornek1->dongusuz(array('{JAVASCRIPT_KODU}' => $javascript_kodu,
'{FORM_BILGI}' => '<form name="form1" action="bilesenler/profil_degistir_yap.php?o='.$o.'" method="post">
<input type="hidden" name="profil_degisti_mi" value="form_dolu">
<input type="hidden" name="islem_turu" value="takip">',
'<input class="dugme" type="submit" value="Değiştir">' => '<input type="submit" value="Uygula" class="dugme">',
'{ALAN_BILGI}' => $alan_bilgi,
'{B_DEGISTIR}' => '<a href="profil_degistir.php">Bilgilerimi Değiştir</a>',
'{ES_DEGISTIR}' => '<a href="profil_degistir.php?kosul=sifre">E-Posta - Şifre Değiştir</a>',
'{YUKLEMELER}' => '<a href="profil_degistir.php?kosul=yuklemeler">Yüklemeler</a>',
'{BILDIRIMLER}' => '<a href="profil_degistir.php?kosul=bildirim">Bildirimler</a>',
'{TAKIP}' => '<font style="font-size: 10px"><b>Takip Edilenler</b></font>',
'{SAYFA_BASLIK}' => 'Bildirimler',
'{OKUNMAMIS_OI}' => $okunmamis_oi));


$ornek1->kosul('6', array('' => ''), false);
$ornek1->kosul('7', array('' => ''), false);
$ornek1->kosul('8', array('' => ''), false);



    //  TAKİP - SONU  //





    //  BİLDİRİM SİLME İŞLEMLERİ - BAŞI  //

elseif ( (isset($_GET['kosul'])) AND ($_GET['kosul'] == 'bsil') ):


if (!defined('DOSYA_KULLANICI_KIMLIK')) include 'bilesenler/kullanici_kimlik.php';


// oturum bilgisine bakılıyor
if (isset($_GET['o'])) $_GET['o'] = @zkTemizle($_GET['o']);
else $_GET['o'] = '';

$o = $satir['kullanici_kimlik'];
$o = $o[3].$o[6].$o[8].$o[10].$o[13].$o[17].$o[19].$o[25].$o[30].$o[33];

if ($_GET['o'] != $o)
{
	echo '<font color="#ff0000"><b>Hatalı Adres !</b></font>';
	exit();
}


if (!isset($_GET['sil'])) $_GET['sil'] = 0;
$_GET['sil'] = @zkTemizle($_GET['sil']);
$_GET['sil'] = @str_replace(array('-','x'), '', $_GET['sil']);
if ($_GET['sil'] < 0) $_GET['sil'] = 0;


// Veri rakam değilse hata ver
if ((!is_numeric($_GET['sil'])) OR ($_GET['sil'] == 0))
{
	echo '<font color="#ff0000"><b>Hatalı Adres !</b></font>';
	exit();
}


// bildirimin bilgileri çekiliyor
$vtsorgu = "SELECT id FROM $tablo_bildirimler WHERE uye_id='$kullanici_kim[id]' AND id='$_GET[sil]' LIMIT 1";
$vtsonuc = $vt->query($vtsorgu) or die ($vt->hata_ver());
$bildirim = $vt->fetch_array($vtsonuc);


// bildirim yoksa hata ver
if (!isset($bildirim['id']))
{
	echo '<font color="#ff0000"><b>Bildirim Yok !</b></font>';
	exit();
}



// bildirim veritabanından siliniyor
$vtsorgu = "DELETE FROM $tablo_bildirimler WHERE id='$_GET[sil]' LIMIT 1";
$vtsonuc = $vt->query($vtsorgu) or die ($vt->hata_ver());
exit();


    //  BİLDİRİM SİLME İŞLEMLERİ - SONU  //





    //  DOSYA SİLME İŞLEMLERİ - BAŞI  //

elseif ( (isset($_GET['kosul'])) AND ($_GET['kosul'] == 'dsil') ):


if (!defined('DOSYA_KULLANICI_KIMLIK')) include 'bilesenler/kullanici_kimlik.php';


// oturum bilgisine bakılıyor
if (isset($_GET['o'])) $_GET['o'] = @zkTemizle($_GET['o']);
else $_GET['o'] = '';

$o = $satir['kullanici_kimlik'];
$o = $o[3].$o[6].$o[8].$o[10].$o[13].$o[17].$o[19].$o[25].$o[30].$o[33];

if ($_GET['o'] != $o)
{
	header('Location: hata.php?hata=45');
	exit();
}


if (!isset($_GET['sil'])) $_GET['sil'] = 0;
$_GET['sil'] = @zkTemizle($_GET['sil']);
$_GET['sil'] = @str_replace(array('-','x'), '', $_GET['sil']);
if ($_GET['sil'] < 0) $_GET['sil'] = 0;


// Veri rakam değilse hata ver
if ((!is_numeric($_GET['sil'])) OR ($_GET['sil'] == 0))
{
	header('Location: hata.php?hata=45');
	exit();
}


// dosyanın bilgileri çekiliyor
$vtsorgu = "SELECT id,dosya FROM $tablo_yuklemeler WHERE uye_id='$kullanici_kim[id]' AND id='$_GET[sil]' LIMIT 1";
$vtsonuc = $vt->query($vtsorgu) or die ($vt->hata_ver());
$dosya = $vt->fetch_array($vtsonuc);


// dosya yoksa hata ver
if (!isset($dosya['id']))
{
	header('Location: hata.php?hata=206');
	exit();
}


// dosya sunucudan siliniyor
@unlink('dosyalar/yuklemeler/'.$dosya['dosya']);


// dosya girdisi veritabanından siliniyor
$vtsorgu = "DELETE FROM $tablo_yuklemeler WHERE id='$_GET[sil]' LIMIT 1";
$vtsonuc = $vt->query($vtsorgu) or die ($vt->hata_ver());


header('Location: hata.php?bilgi=50');
exit();


    //  DOSYA SİLME İŞLEMLERİ - SONU  //





    // NORMAL PROFİL DEĞİŞTİRME - BAŞI  //

else:


$sayfano = 30;
$sayfa_adi = 'Profil Değiştir';
include_once('bilesenler/sayfa_baslik.php');

// tema dosyası
$ornek1 = new phpkf_tema();
$tema_dosyasi = 'temalar/'.$temadizini.'/profil_degistir.php';
eval($ornek1->tema_dosyasi($tema_dosyasi));


// kullanıcı bilgilileri çekiliyor

$vtsorgu = "SELECT
id,kullanici_adi,gercek_ad,dogum_tarihi,sehir,web,resim,imza,posta_goster,dogum_tarihi_goster,sehir_goster,gizli,icq,msn,yahoo,aim,skype,temadizini,temadizinip,cinsiyet,hakkinda
FROM $tablo_kullanicilar WHERE kullanici_kimlik='$_COOKIE[kullanici_kimlik]' LIMIT 1";
$vtsonuc = $vt->query($vtsorgu) or die ($vt->hata_ver());
$satir = $vt->fetch_array($vtsonuc);



			//	RESİM YÜKLEME AYARLARI - BAŞI	//


if ( ($ayarlar['uzak_resim'] == 1) OR ($ayarlar['resim_yukle'] == 1) OR
	($ayarlar['resim_galerisi'] == 1) )
{
	$resim_yuleme_bilgi = 'Resim sadece jpeg, gif veya png tipinde olabilir.<br>
Dosya <b>boyutu '.($ayarlar['resim_boyut']/1024).'</b> kilobayt, <b>yüksekliği '.$ayarlar['resim_yukseklik'].'</b> ve <b>genişliği '.$ayarlar['resim_genislik'].'</b> noktadan büyük olamaz.';


	// GEÇERLİ RESİM GÖSTERİLİYOR	//

	if ( (isset($_POST['secim_yap'])) AND (isset($_POST['galeri_resimi']))
			AND ($_POST['galeri_resimi'] != '') )
		$gecerli_resim = '<img src="'.$_POST['galeri_resimi'].'" alt="Kullanıcı Resmi">&nbsp;
<label style="cursor: pointer;">
<input type="checkbox" name="resim_sil">Geçerli Resmi Sil</label>';

	elseif ($satir['resim'])
		$gecerli_resim = '<img src="'.$satir['resim'].'" alt="Kullanıcı Resmi">&nbsp;
<label style="cursor: pointer;">
<input type="checkbox" name="resim_sil">Geçerli Resmi Sil</label>';

	else $gecerli_resim = 'YOK';

	$ornek1->kosul('1', array('{RESIM_YUKLEME_BILGI}' => $resim_yuleme_bilgi,
								'{GECERLI_RESIM}' => $gecerli_resim), true);



	// RESİM YÜKLEME AÇIKSA	//

	if ($ayarlar['resim_yukle'] == 1)
		$ornek1->kosul('2', array('' => ''), true);

	else $ornek1->kosul('2', array('' => ''), false);


	// UZAK RESİM YÜKLEME AÇIKSA	//

	if ($ayarlar['uzak_resim'] == 1)
		$ornek1->kosul('3', array('' => ''), true);

	else $ornek1->kosul('3', array('' => ''), false);
	

	// RESİM GALERİSİ AÇIKSA	//

	if ($ayarlar['resim_galerisi'] == 1)
	{
		if ( (isset($_POST['secim_yap'])) AND (isset($_POST['galeri_resimi']))
				AND	($_POST['galeri_resimi'] != '') )
			$uzak_resim2 = $_POST['galeri_resimi'];

		else $uzak_resim2 = '';
		
		$ornek1->kosul('4', array('{UZAK_RESIM2}' => $uzak_resim2), true);
	}

	else $ornek1->kosul('4', array('' => ''), false);
}


//	TÜM RESİM YÜKLEME AYARLARI KAPALIYSA	//

else
{
	$ornek1->kosul('1', array('' => ''), false);
	$ornek1->kosul('2', array('' => ''), false);
	$ornek1->kosul('3', array('' => ''), false);
	$ornek1->kosul('4', array('' => ''), false);
}

				//	RESİM YÜKLEME AYARLARI - SONU	//







if($satir['posta_goster'] == 1) $posta_goster_evet = 'checked="checked"';
else $posta_goster_evet = '';

if($satir['posta_goster'] == 0) $posta_goster_hayir = 'checked="checked"';
else $posta_goster_hayir = '';



if($satir['dogum_tarihi_goster'] == 1) $dogum_goster_evet = 'checked="checked"';
else $dogum_goster_evet = '';

if($satir['dogum_tarihi_goster'] == 2) $yas_goster_evet = 'checked="checked"';
else $yas_goster_evet = '';

if($satir['dogum_tarihi_goster'] == 0) $dogum_goster_hayir = 'checked="checked"';
else $dogum_goster_hayir = '';



if($satir['sehir_goster'] == 1) $sehir_goster_evet = 'checked="checked"';
else $sehir_goster_evet = '';

if($satir['sehir_goster'] == 0) $sehir_goster_hayir = 'checked="checked"';
else $sehir_goster_hayir = '';



if($satir['gizli'] == 0) $cevrimici_goster_evet = 'checked="checked"';
else $cevrimici_goster_evet = '';

if($satir['gizli'] == 1) $cevrimici_goster_hayir = 'checked="checked"';
else $cevrimici_goster_hayir = '';


// forum tema seçimi alanı

$temalar = explode(',',$ayarlar['tema_secenek']);

$adet = count($temalar);

$uye_tema = '<select class="formlar" name="tema_secim">';


for ($i=0; $adet-1 > $i; $i++)
{
	if ($satir['temadizini'] != $temalar[$i])
		$uye_tema .= '<option value="'.$temalar[$i].'">'.$temalar[$i].'</option>';

	else $uye_tema .= '<option value="'.$temalar[$i].'" selected="selected">'.$temalar[$i].'</option>';
}

$uye_tema .= '</select>';



// portal tema seçimi alanı

if ($portal_kullan == '1')
{
	$tablo_portal_ayarlar = $tablo_oneki.'portal_ayarlar';

	$vtsorgu = "SELECT * FROM $tablo_portal_ayarlar where isim='tema_secenek' LIMIT 1";
	$pt_sonuc = @$vt->query($vtsorgu) or die ($vt->hata_ver());
	$portal_temalari = $vt->fetch_assoc($pt_sonuc);


	$ptemalar = explode(',',$portal_temalari['sayi']);
	$adet = count($ptemalar);
	$uye_portal_tema = '<select class="formlar" name="tema_secimp">';


	for ($i=0; $adet-1 > $i; $i++)
	{
		if ($satir['temadizinip'] != $ptemalar[$i])
			$uye_portal_tema .= '<option value="'.$ptemalar[$i].'">'.$ptemalar[$i].'</option>';

		else $uye_portal_tema .= '<option value="'.$ptemalar[$i].'" selected="selected">'.$ptemalar[$i].'</option>';
	}

	$uye_portal_tema .= '</select>';
	$ornek1->kosul('5', array('{UYE_PORTAL_TEMA}' => $uye_portal_tema), true);
}


else $ornek1->kosul('5', array('' => ''), false);



// okunmamış özel iletisi varsa
if ($ayarlar['o_ileti'] == 1)
{
	if ($kullanici_kim['okunmamis_oi'])
		$okunmamis_oi = ' ('.$kullanici_kim['okunmamis_oi'].')';
	else $okunmamis_oi = '';
}

else $okunmamis_oi = '';



//	DOĞUM TARİHİ SEÇENEKLERİ	//

$dogum = explode('-', $satir['dogum_tarihi']);

$uye_dogum = '<select class="formlar" name="dogum_gun">';
if ($dogum[0] == '00') $uye_dogum .= '<option value="">Gün</option>';

for ($i=1; $i<32; $i++)
{
	if ($i<10) $a = '0'.$i;
	else $a = $i;
	$uye_dogum .= '<option value="'.$a.'"';
	if ($dogum[0] == $i) $uye_dogum .= ' selected="selected"';
	$uye_dogum .= '>'.$a.'</option>';
}

$uye_dogum .= '</select> &nbsp;<select class="formlar" name="dogum_ay">';
if ($dogum[1] == '00') $uye_dogum .= '<option value="">Ay</option>';

for ($i=1; $i<13; $i++)
{
	if ($i<10) $a = '0'.$i;
	else $a = $i;
	$uye_dogum .= '<option value="'.$a.'"';
	if ($dogum[1] == $i) $uye_dogum .= ' selected="selected"';
	$uye_dogum .= '>'.$a.'</option>';
}

$uye_dogum .= '</select> &nbsp;<select class="formlar" name="dogum_yil">';
if ($dogum[2] == '0000') $uye_dogum .= '<option value="">Yıl</option>';

$i=date('Y');
for ($i; $i>1929; $i--)
{
	if ($dogum[2] != $i) $uye_dogum .= '<option value="'.$i.'">'.$i.'</option>';
	else $uye_dogum .= '<option value="'.$i.'" selected="selected">'.$i.'</option>';
}

$uye_dogum .= '</select>';



// Cinsiyet seçimi
$uye_cinsiyet = '<select class="formlar" name="cinsiyet">
<option value="0">Seçin</option>
<option value="1"';
if ($satir['cinsiyet'] == '1') $uye_cinsiyet .= ' selected="selected"';
$uye_cinsiyet .= '>Erkek</option>
<option value="2"';
if ($satir['cinsiyet'] == '2') $uye_cinsiyet .= ' selected="selected"';
$uye_cinsiyet .= '>Kadın</option></select>';




$imza_bilgi = 'İmza bilgisi profil sayfasında ve foruma bıraktığınız yazıların altında görünür.
<br>En fazla '.$ayarlar['imza_uzunluk'].' karakter olabilir, BBCode ve ifade kullanabilirsiniz.';

$hakkinda_uzunluk = 1000;

$hakkinda_bilgi = 'Hakkkında bilgisi sadece profil sayfasında görünür.
<br>En fazla '.$hakkinda_uzunluk.' karakter olabilir, BBCode ve ifade kullanabilirsiniz.';



$javascript_kodu = '<script type="text/javascript">
<!--
function denetle(){
var dogruMu = true;
for (var i=0; i<9; i++){
if (document.form1.elements[i].value==""){
	dogruMu = false; 
	alert("* İŞARETLİ ALANLARIN DOLDURULMASI ZORUNLUDUR !");
	break;}}
return dogruMu;}
//  -->
</script>';


$javascript_kodu2 = '<script type="text/javascript">
<!-- //
function imzaUzunluk(){
var div_katman = document.getElementById(\'imza_uzunluk\');
div_katman.innerHTML = \'Eklenebilir karakter sayısı: \' + ('.$ayarlar['imza_uzunluk'].'-document.form1.imza.value.length);
if (document.form1.imza.value.length > '.$ayarlar['imza_uzunluk'].'){
alert(\'İmza alanına en fazla '.$ayarlar['imza_uzunluk'].' karakter girebilirsiniz.\');
document.form1.imza.value = document.form1.imza.value.substr(0,'.$ayarlar['imza_uzunluk'].');
div_katman.innerHTML = \'Eklenebilir karakter sayısı: 0\';}
return true;}
function hakkindaUzunluk(){
var div_katman = document.getElementById(\'hakkinda_uzunluk\');
div_katman.innerHTML = \'Eklenebilir karakter sayısı: \' + ('.$hakkinda_uzunluk.'-document.form1.hakkinda.value.length);
if (document.form1.hakkinda.value.length > '.$hakkinda_uzunluk.'){
alert(\'Hakkında alanına en fazla '.$hakkinda_uzunluk.' karakter girebilirsiniz.\');
document.form1.hakkinda.value = document.form1.hakkinda.value.substr(0,'.$hakkinda_uzunluk.');
div_katman.innerHTML = \'Eklenebilir karakter sayısı: 0\';}
return true;}
imzaUzunluk();
hakkindaUzunluk();
//  -->
</script>';




//	TEMA UYGULANIYOR	//

$ornek1->dongusuz(array('{JAVASCRIPT_KODU}' => $javascript_kodu,
'{SAYFA_BASLIK}' => 'ÜYELİK BİLGİLERİ',
'{FORM_BILGI}' => '<form name="form1" action="bilesenler/profil_degistir_yap.php?o='.$o.'" method="post" enctype="multipart/form-data" onsubmit="return denetle()">
<input type="hidden" name="profil_degisti_mi" value="form_dolu">
<input type="hidden" name="MAX_FILE_SIZE" value="1022999">
<input type="hidden" name="islem_turu" value="normal">',
'{ALAN_BILGI}' => '<font size="1"><i>&nbsp;&nbsp; * işaretli alanların doldurulması zorunludur!</i></font>',
'{B_DEGISTIR}' => '<font style="font-size: 10px"><b>Bilgilerimi Değiştir</b></font>',
'{ES_DEGISTIR}' => '<a href="profil_degistir.php?kosul=sifre">E-Posta - Şifre Değiştir</a>',
'{YUKLEMELER}' => '<a href="profil_degistir.php?kosul=yuklemeler">Yüklemeler</a>',
'{BILDIRIMLER}' => '<a href="profil_degistir.php?kosul=bildirim">Bildirimler</a>',
'{TAKIP}' => '<a href="profil_degistir.php?kosul=takip">Takip Edilenler</a>',
'{OKUNMAMIS_OI}' => $okunmamis_oi));

$dongusuz1 = array('{JAVASCRIPT_KODU2}' => $javascript_kodu2,
'{UYE_ADI}' => $satir['kullanici_adi'],
'{UYE_GERCEK_AD}' => $satir['gercek_ad'],
'{UYE_DOGUM}' => $uye_dogum,
'{UYE_CINSIYET}' => $uye_cinsiyet,
'{UYE_SEHIR}' => $satir['sehir'],
'{UYE_WEB}' => $satir['web'],
'{UYE_TEMA}' => $uye_tema,
'{IMZA_BILGI}' => $imza_bilgi,
'{HAKKINDA_BILGI}' => $hakkinda_bilgi,
'{UYE_IMZA}' => $satir['imza'],
'{UYE_HAKKINDA}' => $satir['hakkinda'],
'{UYE_ICQ}' => $satir['icq'],
'{UYE_AIM}' => $satir['aim'],
'{UYE_MSN}' => $satir['msn'],
'{UYE_YAHOO}' => $satir['yahoo'],
'{UYE_SKYPE}' => $satir['skype'],
'{POSTA_GOSTER_EVET}' => $posta_goster_evet,
'{POSTA_GOSTER_HAYIR}' => $posta_goster_hayir,
'{DOGUM_GOSTER_EVET}' => $dogum_goster_evet,
'{YAS_GOSTER_EVET}' => $yas_goster_evet,
'{DOGUM_GOSTER_HAYIR}' => $dogum_goster_hayir,
'{SEHIR_GOSTER_EVET}' => $sehir_goster_evet,
'{SEHIR_GOSTER_HAYIR}' => $sehir_goster_hayir,
'{CEVRIMICI_GOSTER_EVET}' => $cevrimici_goster_evet,
'{CEVRIMICI_GOSTER_HAYIR}' => $cevrimici_goster_hayir);


$ornek1->kosul('6', $dongusuz1, true);
$ornek1->kosul('7', array('' => ''), false);
$ornek1->kosul('8', array('' => ''), false);
$ornek1->kosul('9', array('' => ''), false);


    // NORMAL PROFİL DEĞİŞTİRME - SONU  //

endif;

eval(TEMA_UYGULA);

?>