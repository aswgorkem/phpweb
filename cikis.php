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


if (!defined('DOSYA_AYAR')) include 'ayar.php';
if (!defined('DOSYA_KULLANICI_KIMLIK')) include 'bilesenler/kullanici_kimlik.php';
if (!defined('DOSYA_GERECLER')) include 'bilesenler/gerecler.php';


// oturum bilgisine bakılıyor
if (isset($_GET['o'])) $_GET['o'] = @zkTemizle($_GET['o']);
else $_GET['o'] = '';

$o = $kullanici_kim['kullanici_kimlik'];
$o = $o[3].$o[6].$o[8].$o[10].$o[13].$o[17].$o[19].$o[25].$o[30].$o[33];

if ($_GET['o'] != $o)
{
	header('Location: hata.php?hata=45');
	exit();
}


// Android uygulaması için
if (@!preg_match('/phpKF\ Android\ Uygulamasi/', $_SERVER['HTTP_USER_AGENT']))
	$kul_ip = ",kul_ip='$_SERVER[REMOTE_ADDR]',kullanici_kimlik='',yonetim_kimlik=''";
else $kul_ip = '';


$_SERVER['REMOTE_ADDR'] = zkTemizle($_SERVER['REMOTE_ADDR']);
$sayfano = '-1';
$sayfa_adi = 'Kullanıcı çıkış yaptı';
$tarih = time();


$vtsorgu = "UPDATE $tablo_kullanicilar
		SET son_hareket='$tarih', hangi_sayfada='$sayfa_adi', sayfano='$sayfano'
		$kul_ip
		WHERE id='$kullanici_kim[id]'";
$vtsonuc = $vt->query($vtsorgu) or die ($vt->hata_ver());


setcookie('kullanici_kimlik', '', 0, $cerez_dizin, $cerez_alanadi);
setcookie('yonetim_kimlik', '', 0, $cerez_dizin, $cerez_alanadi);
setcookie('kfk_okundu', '', 0, $cerez_dizin, $cerez_alanadi);


if ( ( empty($_SERVER['HTTP_REFERER']) ) OR ($_SERVER['HTTP_REFERER'] == '') 
	OR ( preg_match('/hata.php/i', $_SERVER['HTTP_REFERER'])) )
{
	header('Location: index.php');
	exit();
}

else
{
	if (preg_match('/.php\?/i', $_SERVER['HTTP_REFERER']))
	{
		header('Location: '.$_SERVER['HTTP_REFERER'].'&cikiss=1');
		exit();
	}

	else
	{
		header('Location: '.$_SERVER['HTTP_REFERER'].'?cikiss=1');
		exit();
	}
}
?>