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


if (!defined('DOSYA_GUVENLIK')) include 'bilesenler/guvenlik.php';



        //      E-POSTA YOLLA TIKLANMIŞSA   -   BAŞI    //


if ( (isset($_POST['kayit_yapildi_mi'])) AND ($_POST['kayit_yapildi_mi'] == 'form_dolu') ):


if (($_POST['eposta_kime']=='') or ( strlen($_POST['eposta_kime']) < 4))
{
	header('Location: hata.php?hata=4');
	exit();
}

if (($_POST['eposta_baslik']=='') or ( strlen($_POST['eposta_baslik']) < 3) or ( strlen($_POST['eposta_baslik']) > 60) or ($_POST['eposta_icerik']=='') or  ( strlen($_POST['eposta_icerik']) < 3))
{
	header('Location: hata.php?hata=5');
	exit();
}

if (!defined('DOSYA_AYAR')) include 'ayar.php';
if (!defined('DOSYA_GERECLER')) include 'bilesenler/gerecler.php';


//	ZARARLI KODLAR TEMİZLENİYOR	//

$_COOKIE['kullanici_kimlik'] = zkTemizle($_COOKIE['kullanici_kimlik']);
$_POST['eposta_kime'] = zkTemizle(trim($_POST['eposta_kime']));

//	KULLANICININ BİLGİLERİ ÇEKİLİYOR	//

$vtsorgu = "SELECT id,son_ileti,kullanici_adi,posta FROM $tablo_kullanicilar
			WHERE kullanici_kimlik='$_COOKIE[kullanici_kimlik]' LIMIT 1";
$vtsonuc = $vt->query($vtsorgu) or die ($vt->hata_ver());
$kullanici_kim = $vt->fetch_assoc($vtsonuc);

//	magic_quotes_gpc açıksa	//
if (get_magic_quotes_gpc())
{
	$_POST['eposta_baslik'] = stripslashes($_POST['eposta_baslik']);
	$_POST['eposta_icerik'] = stripslashes($_POST['eposta_icerik']);
}


//	İKİ İLETİ ARASI SÜRESİ DOLMAMIŞSA UYARILIYOR	//

$tarih = time();

if (($kullanici_kim['son_ileti']) > ($tarih - $ayarlar['ileti_sure']))
{
	header('Location: hata.php?hata=6');
	exit();
}


//	GÖNDERİLEN KİŞİNİN BİLGİLERİ ÇEKİLİYOR	//

$vtsorgu = "SELECT posta,kullanici_adi FROM $tablo_kullanicilar
			WHERE kullanici_adi='$_POST[eposta_kime]' LIMIT 1";
$vtsonuc = $vt->query($vtsorgu) or die ($vt->hata_ver());
$eposta_gonderilen = $vt->fetch_array($vtsonuc);

if (empty($eposta_gonderilen))
{
	header('Location: hata.php?hata=7');
	exit();
}


//		POSTALAR/OZEL_POSTA.TXT DOSYASINDAKİ YAZILAR ALINIYOR...		//
//		... BELİRTİLEN YERLERE YENİ BİLGİLER GİRİLİYOR		// 



if (!($dosya_ac = fopen('./bilesenler/postalar/ozel_posta.txt','r'))) die ('Dosya Açılamıyor');
$posta_metni = fread($dosya_ac,1024);
fclose($dosya_ac);

$bul = array('{forumadi}',
'{kullanici_adi}',
'{eposta_baslik}',
'{eposta_icerik}');

$cevir = array($ayarlar['title'],
$kullanici_kim['kullanici_adi'],
$_POST['eposta_baslik'],
$_POST['eposta_icerik']);

$posta_metni = str_replace($bul,$cevir,$posta_metni);



//		POSTA YOLLANIYOR		//

require('bilesenler/eposta_sinif.php');
$mail = new eposta_yolla();


if ($ayarlar['eposta_yontem'] == 'mail') $mail->MailKullan();
elseif ($ayarlar['eposta_yontem'] == 'smtp') $mail->SMTPKullan();


$mail->sunucu = $ayarlar['smtp_sunucu'];
if ($ayarlar['smtp_kd'] == 'true') $mail->smtp_dogrulama = true;
else $mail->smtp_dogrulama = false;
$mail->kullanici_adi = $ayarlar['smtp_kullanici'];
$mail->sifre = $ayarlar['smtp_sifre'];

$mail->gonderen = $kullanici_kim['posta'];
$mail->gonderen_adi = $kullanici_kim['kullanici_adi'];
$mail->GonderilenAdres($eposta_gonderilen['posta']);

if (!empty($_POST['eposta_kopya'])) $mail->DigerAdres($kullanici_kim['posta']);

$mail->YanitlamaAdres($kullanici_kim['posta']);
$mail->konu = $ayarlar['title'].' - Kullanıcı E-Postası';
$mail->icerik = $posta_metni;


//	 KULLANICI ALANINA SON İLETİ TARİHİ GİRİLİYOR		//

if ($mail->Yolla())
{
	$vtsorgu = "UPDATE $tablo_kullanicilar SET son_ileti='$tarih'
	WHERE id='$kullanici_kim[id]' LIMIT 1";
	$vtsonuc1 = $vt->query($vtsorgu) or die ($vt->hata_ver());
	header('Location: hata.php?bilgi=13');
	exit();
}

else
{
	echo '<br><br><center><h3><font color="red">E-posta gönderilemedi !<p><u>Hata iletisi</u>: &nbsp; ';
	echo $mail->hata_bilgi;
	echo '</p></font></h3></center>';
	exit();
}

        //      E-POSTA YOLLA TIKLANMIŞSA   -   SONU    //





else:


// üye adı yoksa
if ( (!isset($_GET['kim'])) OR ($_GET['kim'] == '') )
{
	header('Location: hata.php?hata=46');
	exit();
}


// üye adı bilgisi temizleniyor
$_GET['kim'] = @zkTemizle4(@zkTemizle(trim($_GET['kim'])));



// sayfa başlığı
$sayfano = 12;
$sayfa_adi = 'E-Posta Gönder: '.$_GET['kim'];
include_once('bilesenler/sayfa_baslik.php');



$javascript_kodu = '<script type="text/javascript">
<!-- 
function denetle(){ 
var dogruMu = true;
if (document.eposta_form.eposta_kime.value.length < 4){ 
    dogruMu = false; 
    alert("E-postayı göndermek istediğiniz kişinin adını yazınız !");}
else if (document.eposta_form.eposta_baslik.value.length < 3){ 
    dogruMu = false; 
    alert("YAZDIĞINIZ BAŞLIK 3 KARAKTERDEN UZUN OLMALIDIR !");}
else if (document.eposta_form.eposta_icerik.value.length < 3){ 
   dogruMu = false; 
   alert("YAZDIĞINIZ İLETİ 3 KARAKTERDEN UZUN OLMALIDIR !");}
else;
return dogruMu;}
//  -->
</script>';




//	TEMA UYGULANIYOR	//

$ornek1 = new phpkf_tema();
$tema_dosyasi = 'temalar/'.$temadizini.'/eposta.php';
eval($ornek1->tema_dosyasi($tema_dosyasi));

$ornek1->dongusuz(array('{JAVASCRIPT_KODU}' => $javascript_kodu,
'{EPOSTA_KIME}' => $_GET['kim']));

eval(TEMA_UYGULA);
endif;

?>