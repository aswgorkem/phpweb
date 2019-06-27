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



		//		GİRİŞ YAP TIKLANMIŞSA  -  BAŞI		//

if ((isset($_POST['kayit_yapildi_mi'])) AND ($_POST['kayit_yapildi_mi'] == 'form_dolu')):


//	GEÇERSİZ BİR ÇEREZ VARSA ÇIKIS SAYFASINA YÖNLENDİRİLİYOR	//

if (isset($_COOKIE['kullanici_kimlik']))
{
	if (!defined('DOSYA_KULLANICI_KIMLIK')) include 'bilesenler/kullanici_kimlik.php';

	if (empty($kullanici_kim['id']))
	{
		setcookie('kullanici_kimlik', '', 0, $cerez_dizin, $cerez_alanadi);
		setcookie('yonetim_kimlik', '', 0, $cerez_dizin, $cerez_alanadi);
		setcookie('kfk_okundu', '', 0, $cerez_dizin, $cerez_alanadi);

		header('Location: giris.php');
		exit();
	}


	//	GİRİŞ YAPILMIŞSA PROFİLE YÖNLENDİR	//
	else
	{
		header('Location: profil.php');
		exit();
	}
}



//	FORM DOLU DEĞİLSE UYAR		//

if ((empty($_POST['kullanici_adi'])) OR (empty($_POST['sifre'])))
{
	header('Location: hata.php?hata=18');
	exit();
}

if ((strlen($_POST['kullanici_adi']) > 20) OR (strlen($_POST['kullanici_adi']) < 4))
{
	header('Location: hata.php?hata=19');
	exit();
}

if ((strlen($_POST['sifre']) > 20) OR ( strlen($_POST['sifre']) < 5))
{
	header('Location: hata.php?hata=20');
	exit();
}



$phpkf_ayarlar_kip = "";
if (!defined('DOSYA_AYAR')) include 'ayar.php';
if (!defined('DOSYA_GERECLER')) include 'bilesenler/gerecler.php';



// zararlı kodlar temizleniyor

$_POST['kullanici_adi'] = @zkTemizle($_POST['kullanici_adi']);
$_POST['sifre'] = @zkTemizle($_POST['sifre']);
$_SERVER['REMOTE_ADDR'] = @zkTemizle($_SERVER['REMOTE_ADDR']);
$_COOKIE['misafir_kimlik'] = @zkTemizle($_COOKIE['misafir_kimlik']);
$tarih = time();
$sayfa_adi = 'Kullanıcı giriş yaptı';



// ŞİFRE ANAHTAR İLE KARIŞTIRILARAK VERİTABANINDAKİ İLE KARŞILAŞTIRIYOR //

$karma = sha1(($anahtar.$_POST['sifre']));

$vtsorgu = "SELECT id,sifre,kul_etkin,engelle,giris_denemesi,kilit_tarihi,son_giris,kullanici_kimlik
		FROM $tablo_kullanicilar WHERE kullanici_adi='$_POST[kullanici_adi]' LIMIT 1";
$vtsonuc = $vt->query($vtsorgu) or die ($vt->hata_ver());

$kullanici_denetim = $vt->fetch_assoc($vtsonuc);


//	HESAP KİLİT TARİHİ KONTROL EDİLİYOR	//

if ( (isset($kullanici_denetim['kilit_tarihi'])) AND
(($kullanici_denetim['kilit_tarihi'] + $ayarlar['kilit_sure']) > $tarih) AND
($kullanici_denetim['giris_denemesi'] > 4) )
{
	header('Location: hata.php?hata=21');
	exit();
}




//	KULLANICI ADI VE ŞİFRE UYUŞMUYORSA	//

elseif ((!$vt->num_rows($vtsonuc)) OR ($kullanici_denetim['sifre'] != $karma))
{

	//	BAŞARISIZ GİRİŞLER BEŞE ULAŞTIĞINDA HESAP KİLİTLENİYOR	//

	$vtsorgu = "UPDATE $tablo_kullanicilar
				SET kilit_tarihi='$tarih',
				giris_denemesi=giris_denemesi + 1
				WHERE kullanici_adi='$_POST[kullanici_adi]' LIMIT 1";
	$vtsonuc = $vt->query($vtsorgu) or die ($vt->hata_ver());


	if ($kullanici_denetim['giris_denemesi'] > 3)
	{
		header('Location: hata.php?hata=21');
		exit();
	}

	else
	{
		if (isset($kullanici_denetim['id'])) header('Location: hata.php?hata=22');
		else
		{
			if (preg_match('/@/i', $_POST['kullanici_adi'])) header('Location: hata.php?hata=208');
			else header('Location: hata.php?hata=207');
		}
		exit();
	}
}


//	HESAP ETKİNLEŞTİRİLMEMİŞSE	//

elseif ($kullanici_denetim['kul_etkin'] == 0)
{
	header('Location: hata.php?hata=23');
	exit();
}


//	HESAP ENGELLENMİŞSE	//

elseif ($kullanici_denetim['engelle'] == 1)
{
	header('Location: hata.php?hata=24');
	exit();
}




//	SORUN YOK GİRİŞ YAPILIYOR	//

//	ZAMAN DEĞERİ SHA1 İLE ŞİFRELENEREK ÇEREZE YAZILIYOR //
//	BENİ HATIRLA İŞARETLİ İSE ÇEREZ GEÇERLİLİK SÜRESİ EKLENİYOR	//

elseif ($kullanici_denetim['sifre'] == $karma)
{
	$kullanici_kimlik = sha1(microtime());

	// Android uygulaması için
	if (@preg_match('/phpKF\ Android\ Uygulamasi/', $_SERVER['HTTP_USER_AGENT']))
	{
		if ($kullanici_denetim['kullanici_kimlik'] != '')
		{
			$kullanici_kimlik = $kullanici_denetim['kullanici_kimlik'];
			$kul_ip = '';
		}
		else $kul_ip = ", kul_ip='$_SERVER[REMOTE_ADDR]'";
	}
	else $kul_ip = ", son_hareket='$tarih', kul_ip='$_SERVER[REMOTE_ADDR]'";



	if (isset($_POST['hatirla'])) $cerez_tarih = $tarih +$ayarlar['k_cerez_zaman'];
	else $cerez_tarih = 0;

	// çerez yazılıyor
	setcookie('kullanici_kimlik', $kullanici_kimlik, $cerez_tarih, $cerez_dizin, $cerez_alanadi);
	setcookie('kfk_okundu', '', 0, $cerez_dizin, $cerez_alanadi);



	//	KULLANICI GİRİŞ YAPINCA AÇILAN MİSAFİR OTURUMU VE ÇEREZİ SİLİNİYOR	//

	if ((isset($_COOKIE['misafir_kimlik'])) OR ($_COOKIE['misafir_kimlik'] != ''))
	{
		$vtsorgu = "DELETE FROM $tablo_oturumlar WHERE sid='$_COOKIE[misafir_kimlik]'";
		$vtsonuc = $vt->query($vtsorgu) or die ($vt->hata_ver());
		setcookie('misafir_kimlik', '', 0, $cerez_dizin, $cerez_alanadi);
	}


	//	KULLANICI KİMLİK VERİTABANINA YAZILIYOR //
	// son_hareket tarihi son_girise yazdırılıyor

	$vtsorgu = "UPDATE $tablo_kullanicilar SET
				kullanici_kimlik='$kullanici_kimlik', yonetim_kimlik='',
				giris_denemesi=0, kilit_tarihi=0, yeni_sifre=0,
				son_giris=son_hareket, hangi_sayfada='$sayfa_adi' $kul_ip
				WHERE id='$kullanici_denetim[id]' LIMIT 1";
	$vtsonuc = $vt->query($vtsorgu) or die ($vt->hata_ver());


	//	KULLANICI GİRİŞ SAYFASINA YÖNLENDİRİLMİŞSE AYNI ADRESE GERİ YOLLANIYOR	//

	if ( (isset($_POST['git'])) AND ($_POST['git'] != '') )
	{
		if (@preg_match('/hata.php/i', $_POST['git'])) $git = 'index.php';
		else $git = $_POST['git'];
	}
	elseif (isset($_SERVER['HTTP_REFERER'])) $git = $_SERVER['HTTP_REFERER'];
	else $git = 'index.php';


	if ( (@preg_match('/http:\/\//i', $git)) AND (!@preg_match('/http:\/\/'.$ayarlar['alanadi'].'/i', $git)) )
	{
		header('Location: index.php');
		exit();
	}

	else
	{
		$git = @str_replace('veisareti', '&', $git);
		$git = @zkTemizle($git);
		header('Location: '.$git);
		exit();
	}
}
$gec = '';

        //      GİRİŞ YAP TIKLANMIŞSA   -   SONU    //





//	GEÇERSİZ BİR ÇEREZ VARSA SİLİNİYOR	//

elseif ((isset($_COOKIE['kullanici_kimlik'])) AND ($_COOKIE['kullanici_kimlik'] != '')):
if (!defined('DOSYA_KULLANICI_KIMLIK')) include 'bilesenler/kullanici_kimlik.php';

if (empty($kullanici_kim['id']))
{
	setcookie('kullanici_kimlik', '', 0, $cerez_dizin, $cerez_alanadi);
	setcookie('yonetim_kimlik', '', 0, $cerez_dizin, $cerez_alanadi);
	setcookie('kfk_okundu', '', 0, $cerez_dizin, $cerez_alanadi);
	header('Location: giris.php');
}


//	GİRİŞ YAPILMIŞSA PROFİLE YÖNLENDİR	//

elseif (isset($kullanici_kim['id']))
{
	header('Location: profil.php');
	exit();
}
$gec = '';





// GİRİŞ YAPILMAMIŞSA GİRİŞ EKRANINI VER    //

else:
$sayfano = 8;
$sayfa_adi = 'Kullanıcı Giriş';
include_once('bilesenler/sayfa_baslik.php');

if (!defined('DOSYA_GERECLER')) include 'bilesenler/gerecler.php';



if (isset($_GET['git']))
{
	$gelinen_adres = @zkTemizle3($_GET['git']);
	$gelinen_adres = @zkTemizle4($gelinen_adres);
}

elseif (isset($_SERVER['HTTP_REFERER']))
{
	$gelinen_adres = @zkTemizle3($_SERVER['HTTP_REFERER']);
	$gelinen_adres = @zkTemizle4($gelinen_adres);
}

else $gelinen_adres = '';



$javascript_kodu = '<script type="text/javascript"><!-- //
//  php Kolay Forum (phpKF)
//  =======================
//  Telif - Copyright (c) 2007 - 2015 phpKF Ekibi
//  http://www.phpkf.com   -   phpkf @ phpkf.com
//  Tüm hakları saklıdır - All Rights Reserved

function denetle(){ 
var dogruMu = true;
if ((document.giris.kullanici_adi.value.length < 4) || (document.giris.sifre.value.length < 5)){ 
	dogruMu = false; 
	alert("Lütfen kullanıcı adı ve şifrenizi giriniz !");}
else;
return dogruMu;}
function dogrula(girdi_ad, girdi_deger){
var alan = girdi_ad + \'-alan\';
if (girdi_ad == \'kullanici_adi\'){
	var kucuk = 4;
	var buyuk = 20;
	var desen = /^[A-Za-z0-9-_ğĞüÜŞşİıÖöÇç.]+$/;}
else if (girdi_ad == \'sifre\'){
	var kucuk = 5;
	var buyuk = 20;
	var desen = /^[A-Za-z0-9-_.&]+$/;}
if ( girdi_deger.length < kucuk || girdi_deger.length > buyuk )
	document.getElementById(alan).innerHTML=\'<img width="17" height="17" src="temalar/'.$ayarlar['temadizini'].'/resimler/yanlis.png" alt="yanlış">\';
else if ( !girdi_deger.match(desen) )
	document.getElementById(alan).innerHTML=\'<img width="17" height="17" src="temalar/'.$ayarlar['temadizini'].'/resimler/yanlis.png" alt="yanlış">\';
else document.getElementById(alan).innerHTML=\'<img width="17" height="17" src="temalar/'.$ayarlar['temadizini'].'/resimler/dogru.png" alt="doğru">\';}
//  -->
</script>';


$ek_girisler = '';


$ornek1 = new phpkf_tema();
$tema_dosyasi = 'temalar/'.$temadizini.'/giris.php';
eval($ornek1->tema_dosyasi($tema_dosyasi));

$dongusuz = array('{GELINEN_ADRES}' => $gelinen_adres,
'{EK_GIRISLER}' => $ek_girisler,
'{JAVASCRIPT_KODU}' => $javascript_kodu);

$ornek1->dongusuz($dongusuz);

eval(TEMA_UYGULA);
endif;

?>