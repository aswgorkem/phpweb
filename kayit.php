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


if (!defined('PHPKF_ICINDEN')) define('PHPKF_ICINDEN', true);
if (!defined('DOSYA_AYAR')) include 'ayar.php';
$sayfano = 9;


// üye alımı kapalıysa
if ($ayarlar['uye_kayit'] != 1)
{
	header('Location: hata.php?uyari=9');
	exit();
}


//  KULLANICI ADI KONTROLÜ - BAŞI  //

if ((isset($_GET['kosul'])) AND ($_GET['kosul'] == 'kadi')):

header("Content-type: text/html; charset=utf-8");

@session_start();



if ((!isset($_GET['kadi'])) OR ($_GET['kadi'] == ''))
{
	echo 'Kullanıcı adı girmediniz.';
	exit();
}

if (!preg_match('/^[A-Za-z0-9-_ğĞüÜŞşİıÖöÇç.]+$/', $_GET['kadi']))
{
	echo 'Geçersiz karakterler var.';
	exit();
}

if (( strlen($_GET['kadi']) > 20) or ( strlen($_GET['kadi']) < 4))
{
	echo 'En az 4, en fazla 20 karakter olmalıdır.';
	exit();
}



//  YASAK KULLANICI ADLARI ALINIYOR //

$vtsorgu = "SELECT deger FROM $tablo_yasaklar WHERE etiket='kulad' LIMIT 1";
$yasak_sonuc = $vt->query($vtsorgu) or die ($vt->hata_ver());
$yasak_kulad = $vt->fetch_row($yasak_sonuc);
$ysk_kuladd = explode("\r\n", $yasak_kulad[0]);


//  KULLANICI ADI YASAKLARLARI    //

if ($ysk_kuladd[0] != '')
{
	$dongu_sayi = count($ysk_kuladd);
	for ($d=0; $d < $dongu_sayi; $d++)
	{
		if ( (!preg_match('/^\*/', $ysk_kuladd[$d])) AND (!preg_match('/\*$/', $ysk_kuladd[$d])) )
			$ysk_kuladd[$d] = '^'.$ysk_kuladd[$d].'$';

		elseif (!preg_match('/^\*/', $ysk_kuladd[$d])) $ysk_kuladd[$d] = '^'.$ysk_kuladd[$d];

		elseif (!preg_match('/\*$/', $ysk_kuladd[$d])) $ysk_kuladd[$d] .= '$';

		$ysk_kuladd[$d] = str_replace('*', '', $ysk_kuladd[$d]);


		if (preg_match("/$ysk_kuladd[$d]/i", $_GET['kadi']))
		{
			echo 'Bu kullanıcı adı yasaklanmıştır.';
			exit();
		}
	}
}


// KULLANICI ADININ DAHA ÖNCE ALINIP ALINMADIĞI DENETLENİYOR //

$vtsorgu = "SELECT kullanici_adi FROM $tablo_kullanicilar WHERE kullanici_adi='$_GET[kadi]'";
$vtsonuc = $vt->query($vtsorgu) or die ($vt->hata_ver());

if ($vt->num_rows($vtsonuc))
{
	echo 'Bu kullanıcı adı kullanılmaktadır.';
	exit();
}


// Sorun yok ise session`a kaydediliyor
$_SESSION['fbkullanici_adi'] = $_GET['kadi'];


echo '<font color="green"><b>Uygun</b></font>';

//  KULLANICI ADI KONTROLÜ - SONU  //




//     NORMAL GÖSTERİM     //
//     NORMAL GÖSTERİM     //


else:


//	GEÇERSİZ BİR ÇEREZ VARSA ÇIKIS SAYFASINA YÖNLENDİRİLİYOR	//

if (isset($_COOKIE['kullanici_kimlik'])):
if (!defined('DOSYA_KULLANICI_KIMLIK')) include 'bilesenler/kullanici_kimlik.php';

if (empty($kullanici_kim['id'])):
setcookie('kullanici_kimlik', '', 0, $cerez_dizin, $cerez_alanadi);
header('Location: '.$forum_index);
exit();


//	GİRİŞ YAPILMIŞSA PROFİLE YÖNLENDİR	//

elseif (isset($kullanici_kim['id'])):
header('Location: profil.php');
exit();
endif;


else:
//	oturum açlıyor	// - burası -
@session_start();




//  KAYIT KOŞULLARI - BAŞI  //

if ( (isset($_GET['kosul'])) AND ($_GET['kosul'] == 'kabul') ):
$sayfa_adi = 'Forum Üyelik Koşulları';
if (!defined('DOSYA_TEMA_SINIF')) include 'bilesenler/tema_sinif.php';

//	TEMA UYGULANIYOR	//

$ornek1 = new phpkf_tema();
$tema_dosyasi = 'temalar/'.$ayarlar['temadizini'].'/kayit.php';
eval($ornek1->tema_dosyasi($tema_dosyasi));
$ornek1->kosul('1', array('' => ''), true);
$ornek1->kosul('2', array('' => ''), false);
$ornek1->tema_uygula();
exit();

//  KAYIT KOŞULLARI - SONU  //





else:
$sayfa_adi = 'Kullanıcı Kayıt';
include_once('bilesenler/sayfa_baslik.php');




if (isset($_SESSION['kullanici_adi']))
	$kullanici_adi = zkTemizle4($_SESSION['kullanici_adi']);

else $kullanici_adi = '';


if (isset($_SESSION['posta']))
	$eposta = zkTemizle4($_SESSION['posta']);

else $eposta = '';


$onay_id = session_id().'&amp;sayi='.sha1(microtime());




//	TEMA UYGULANIYOR	//

$ornek1 = new phpkf_tema();
$tema_dosyasi = 'temalar/'.$temadizini.'/kayit.php';
eval($ornek1->tema_dosyasi($tema_dosyasi));


// kayıt sorusu özelliği açıksa

if ($ayarlar['kayit_soru'] == 1)
{
	if (isset($_SESSION['kayit_cevabi']))
		$kayit_cevabi = zkTemizle4($_SESSION['kayit_cevabi']);

	else $kayit_cevabi = '';

	$ornek1->kosul('3', array('{KAYIT_SORUSU}' => $ayarlar['kayit_sorusu'],
	'{KAYIT_CEVABI}' => $kayit_cevabi), true);

	$form_alan_sayi = 7;
}

else 
{
	$ornek1->kosul('3', array('' => ''), false);
	$form_alan_sayi = 12;
}


// onay kodu açık ise

if ($ayarlar['onay_kodu'] == '1')
{
	$ornek1->kosul('4', array('{ONAY_ID}' => $onay_id), true);
	$form_alan_sayi++;
}

else $ornek1->kosul('4', array('' => ''), false);



//  session dizisi siliniyor  - burası -
$_SESSION = 0;


$javascript_kodu = '<script type="text/javascript"><!-- //
//  php Kolay Forum (phpKF)
//  =======================
//  Telif - Copyright (c) 2007 - 2015 phpKF Ekibi
//  http://www.phpkf.com   -   phpkf @ phpkf.com
//  Tüm hakları saklıdır - All Rights Reserved

function denetle(){ 
var dogruMu = true;

if ((document.form1.kullanici_adi.value == \'\') || (document.form1.posta.value == \'\') || (document.form1.sifre.value == \'\') || (document.form1.sifre2.value == \'\') || (document.form1.onay_kodu.value == \'\') ){
dogruMu = false; 
alert(\'TÜM ALANLARIN DOLDURULMASI ZORUNLUDUR !\');}
if (document.form1.sifre.value != document.form1.sifre2.value){
	dogruMu = false; 
	alert(\'YAZDIĞINIZ ŞİFRELER UYUŞMUYOR !\');}
if (document.form1.kosul.checked != true ){
	dogruMu = false; 
	alert(\'Kayıt olmak için üyelik koşullarını kabul etmelisiniz !\');}
return dogruMu;}
function dogrula(girdi_ad, girdi_deger){
var alan = girdi_ad + \'-alan\';
if (girdi_ad == \'kullanici_adi\'){
	var kucuk = 4;
	var buyuk = 20;
	var desen = /^[A-Za-z0-9-_ğĞüÜŞşİıÖöÇç.]+$/;
	var katman = document.getElementById("kullanici_adi-alan2");
	katman.innerHTML = \'<a href="javascript:void(0);" onclick="KAdi()"><b>Kontrol Et</b></a>\';}
else if (girdi_ad == \'posta\'){
	var kucuk = 4;
	var buyuk = 70;
	var desen = /^([-!#\$%&*+./0-9=?A-Z^_`a-z{|}~])+\@(([-!#\$%&*+/0-9=?A-Z^_`a-z{|}~])+\.)+([a-zA-Z0-9]{2,4})+$/;}
else if (girdi_ad == \'sifre\'){
	var kucuk = 5;
	var buyuk = 20;
	var desen = /^[A-Za-z0-9-_.&]+$/;}
else if (girdi_ad == \'sifre2\'){
	var kucuk = 5;
	var buyuk = 20;
	var desen = /^[A-Za-z0-9-_.&]+$/;}
else if (girdi_ad == \'onay_kodu\'){
	var kucuk = 6;
	var buyuk = 6;
	var desen = /^[A-Za-z0-9]+$/;}
if ( girdi_deger.length < kucuk || girdi_deger.length > buyuk )
	document.getElementById(alan).innerHTML=\'<img width="17" height="17" src="temalar/'.$ayarlar['temadizini'].'/resimler/yanlis.png" alt="yanlış">\';
else if ( !girdi_deger.match(desen) )
	document.getElementById(alan).innerHTML=\'<img width="17" height="17" src="temalar/'.$ayarlar['temadizini'].'/resimler/yanlis.png" alt="yanlış">\';
else document.getElementById(alan).innerHTML=\'<img width="17" height="17" src="temalar/'.$ayarlar['temadizini'].'/resimler/dogru.png" alt="doğru">\';}
function GonderAl(adres,katman){
var katman1 = document.getElementById(katman);
var veri_yolla = "name=value";
if (document.all) var istek = new ActiveXObject("Microsoft.XMLHTTP");
else var istek = new XMLHttpRequest();
istek.open("GET", adres, true);
istek.onreadystatechange = function(){
if (istek.readyState == 4){
	if (istek.status == 200) katman1.innerHTML = istek.responseText;
	else katman1.innerHTML = "<b>Bağlantı Kurulamadı !</b>";}};
istek.send(veri_yolla);}
function KAdi(){
var veri = document.form1.kullanici_adi.value;
if(veri != \'\'){
var adres = "kayit.php?kosul=kadi&kadi="+veri;
var katman = "kullanici_adi-alan2";
var katman1 = document.getElementById(katman);
katman1.innerHTML = \'<img src="dosyalar/yukleniyor.gif" width="18" height="18" alt="Yü." title="Yükleniyor...">\';
setTimeout("GonderAl(\'"+adres+"\',\'"+katman+"\')",1000);}}
//  -->
</script>';



$session_id = @session_id();
if (isset($_COOKIE['PHPSESSID']))
{
	$php_session = zkTemizle4($_COOKIE['PHPSESSID']);
	$php_session = zkTemizle($php_session);
}
else $php_session = '';


$ornek1->kosul('1', array('' => ''), false);
$ornek1->kosul('2', array('{JAVASCRIPT_KODU}' => $javascript_kodu), true);


$ek_girisler = '';


$ornek1->dongusuz(array('{SESSION_ID}' => $session_id,
'{KULLANICI_ADI}' => $kullanici_adi,
'{EPOSTA}' => $eposta,
'{EK_GIRISLER}' => $ek_girisler,
'{PHP_SESSID}' => $php_session));


eval(TEMA_UYGULA);
endif;
endif;
endif;

?>