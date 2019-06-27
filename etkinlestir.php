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


//	GİRİŞ YAPILMIŞSA ANA SAYFAYA YÖNLENDİR	//

if (isset($_COOKIE['kullanici_kimlik']))
{
	header('Location: index.php');
	exit();
}


//	ETKİNLEŞTİRME KODU TALEBİ YAPILIYORSA	//

if (isset($_POST['kayit_yapildi_mi']) and ($_POST['kayit_yapildi_mi'] == 'etkinlestirme_talebi')):

if ( strlen($_POST['posta']) == ''):
	header('Location: hata.php?hata=8');
	exit();
endif;

if ( strlen($_POST['posta']) > 70):
	header('Location: hata.php?hata=40');
	exit();
endif;

if (!preg_match('/^([~&+.0-9a-z_-]+)@(([~&+0-9a-z-]+\.)+[0-9a-z]{2,4})$/i', $_POST['posta'])):
	header('Location: hata.php?hata=10');
	exit();
endif;





//	FORM DOĞRU DOLDURULDUYSA İŞLEMLERE DEVAM	//

if (!defined('DOSYA_GERECLER')) include 'bilesenler/gerecler.php';

$_POST['posta'] = @zkTemizle($_POST['posta']);


//	E-POSTA ADRESİNİN DOĞRULUĞU KONTROL EDİLİYOR	//

$vtsorgu = "SELECT id,kullanici_adi,posta,gercek_ad,dogum_tarihi,sehir,kul_etkin_kod,kul_etkin
            FROM $tablo_kullanicilar WHERE posta='$_POST[posta]' LIMIT 1";
$etkin_sonuc = $vt->query($vtsorgu) or die ($vt->hata_ver());

if ($vt->num_rows($etkin_sonuc)):
$etkin_satir = $vt->fetch_array($etkin_sonuc);


if ( $etkin_satir['kul_etkin'] == 1 )
{
	header('Location: hata.php?hata=12');
	exit();
}




//		postalar/etkinlestirme.txt DOSYASINDAKİ YAZILAR ALINIYOR...		//
//		... BELİRTİLEN YERLERE YENİ BİLGİLER GİRİLİYOR		// 


if (!($dosya_ac = fopen('./bilesenler/postalar/etkinlestirme.txt','r'))) die ('Dosya Açılamıyor');
$posta_metni = fread($dosya_ac,1024);
fclose($dosya_ac);

$bul = array('{forumadi}',
'{alanadi}',
'{f_dizin}',
'{kullanici_adi}',
'{posta}',
'{gercek_ad}',
'{dogum_tarihi}',
'{sehir}',
'{kulid}',
'{kul_etkin_kod}');

$cevir = array($ayarlar['anasyfbaslik'],
$ayarlar['alanadi'],
$ayarlar['f_dizin'],
$etkin_satir['kullanici_adi'],
$etkin_satir['posta'],
$etkin_satir['gercek_ad'],
$etkin_satir['dogum_tarihi'],
$etkin_satir['sehir'],
$etkin_satir['id'],
$etkin_satir['kul_etkin_kod']);

if ($cevir[2] == '/')
$cevir[2] = '';

$posta_metni = str_replace($bul,$cevir,$posta_metni);




//	ETKİNLEŞTİRME BİLGİLERİ POSTALANIYOR		//

require('bilesenler/eposta_sinif.php');
$mail = new eposta_yolla();


if ($ayarlar['eposta_yontem'] == 'mail') $mail->MailKullan();
elseif ($ayarlar['eposta_yontem'] == 'smtp') $mail->SMTPKullan();


$mail->sunucu = $ayarlar['smtp_sunucu'];
if ($ayarlar['smtp_kd'] == 'true') $mail->smtp_dogrulama = true;
else $mail->smtp_dogrulama = false;
$mail->kullanici_adi = $ayarlar['smtp_kullanici'];
$mail->sifre = $ayarlar['smtp_sifre'];

$mail->gonderen = $ayarlar['y_posta'];
$mail->gonderen_adi = $ayarlar['anasyfbaslik'];
$mail->GonderilenAdres($etkin_satir['posta']);
$mail->YanitlamaAdres($ayarlar['y_posta']);
$mail->konu = $ayarlar['anasyfbaslik'].' - Etkinleştirme Kodu';
$mail->icerik = $posta_metni;


if ($mail->Yolla())
{
// E-POSTA YOLLANDI, EKRAN ÇIKTISI VERİLİYOR //

	header('Location: hata.php?bilgi=14');
	exit();
}

else
{
	echo '<br><br><center><h3><font color="red">E-posta gönderilemedi !<p>Hata iletisi: ';
	echo $mail->hata_bilgi;
	echo '</p></font></h3></center>';
	exit();
}

//	GİRİLEN E-POSTA VERİTABANINDA YOKSA 	//

else:
	header('Location: hata.php?hata=13');
	exit();
endif;





//	SAYFAYA İLK DEFA GİRİLİYORSA BURADAN SONRASI GÖSTERİLİYOR	//

else :

$sayfano = 35;
$sayfa_adi = 'Etkinleştirme Kodu Başvurusu';
include_once('bilesenler/sayfa_baslik.php');



$javascript_kodu = '<script type="text/javascript">
<!--
function denetle(){
var dogruMu = true;
if (document.giris.posta.value.length < 4){
	dogruMu = false; 
	alert("Lütfen E-Posta adresinizi giriniz !");
}
else;
return dogruMu;
}
//  -->
</script>';



//	TEMA UYGULANIYOR	//

$ornek1 = new phpkf_tema();
$tema_dosyasi = 'temalar/'.$temadizini.'/etkinlestir.php';
eval($ornek1->tema_dosyasi($tema_dosyasi));

$ornek1->dongusuz(array('{JAVASCRIPT_KODU}' => $javascript_kodu));

eval(TEMA_UYGULA);
endif;

?>