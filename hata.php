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


$phpkf_ayarlar_kip = "";
if (!defined('DOSYA_AYAR')) include 'ayar.php';
if (!defined('DOSYA_GERECLER')) include 'bilesenler/gerecler.php';



//  ZARARLI KODLAR TEMİZLENİYOR  //

if ((!isset($_GET['mesaj_no'])) OR (!is_numeric($_GET['mesaj_no']))) $_GET['mesaj_no'] = 0;

if ((!isset($_GET['cevapno'])) OR (!is_numeric($_GET['cevapno']))) $_GET['cevapno'] = 0;

if ((!isset($_GET['cevap_no'])) OR (!is_numeric($_GET['cevap_no']))) $_GET['cevap_no'] = 0;

if ((!isset($_GET['fno'])) OR (!is_numeric($_GET['fno']))) $_GET['fno'] = 0;

if ((!isset($_GET['fno1'])) OR (!is_numeric($_GET['fno1']))) $_GET['fno1'] = 0;

if ((!isset($_GET['fno2'])) OR (!is_numeric($_GET['fno2']))) $_GET['fno2'] = 0;

if ((!isset($_GET['o'])) OR (!preg_match('/^[A-Za-z0-9]+$/', $_GET['o']))) $_GET['o'] = '';



if (isset($_GET['fsayfa']))
{
	if (!is_numeric($_GET['fsayfa'])) $_GET['fsayfa'] = 0;
	if ($_GET['fsayfa'] != 0) $fs = '&amp;fs='.$_GET['fsayfa'];
	else $fs = '';
}
else
{
	$fs = '';
	$_GET['fsayfa'] = '';
}

if (isset($_GET['sayfa']))
{
	if (is_numeric($_GET['sayfa']) == false) $_GET['sayfa'] = 0;
	if ($_GET['sayfa'] != 0) $ks = '&amp;ks='.$_GET['sayfa'];
	else $ks = '';
}
else
{
	$ks = '';
	$_GET['sayfa'] = '';
}

if (isset($_GET['git']))
{
	$git = '?git='.@zkTemizle($_GET['git']);
	$git = @zkTemizle4($git);
}
elseif (isset($_SERVER['HTTP_REFERER']))
{
	$git = '?git='.@zkTemizle($_SERVER['HTTP_REFERER']);
	$git = @zkTemizle4($git);
}
else $git = '';





//  BİLGİ İLETİLERİ - BAŞI  //


$bilgi_no[1] = '<meta http-equiv="Refresh" content="5;url=konu.php?k='.$_GET['mesaj_no'].$ks.'#c'.$_GET['cevapno'].'">
İletiniz gönderilmiştir, okumak için <a href="konu.php?k='.$_GET['mesaj_no'].$ks.'#c'.$_GET['cevapno'].'">tıklayın.</a>
<br>Foruma dönmek için <a href="forum.php?f='.$_GET['fno'].'">tıklayın.</a>';

$bilgi_no[2] = '<meta http-equiv="Refresh" content="5;url=konu.php?k='.$_GET['mesaj_no'].'">
İletiniz gönderilmiştir, okumak için <a href="konu.php?k='.$_GET['mesaj_no'].'">tıklayın.</a>
<br>Foruma dönmek için <a href="forum.php?f='.$_GET['fno'].'">tıklayın.</a>';

$bilgi_no[3] = '<meta http-equiv="Refresh" content="5;url=konu.php?k='.$_GET['mesaj_no'].'&amp;f='.$_GET['fno'].$fs.'">
İletiniz değiştirilmiştir, okumak için <a href="konu.php?k='.$_GET['mesaj_no'].'&amp;f='.$_GET['fno'].$fs.'">tıklayın.</a>
<br>Foruma dönmek için <a href="forum.php?f='.$_GET['fno'].'">tıklayın.</a>';

$bilgi_no[4] = '<meta http-equiv="Refresh" content="5;url=konu.php?k='.$_GET['mesaj_no'].$ks.'&amp;f='.$_GET['fno'].$fs.'#c'.$_GET['cevapno'].'">
İletiniz değiştirilmiştir, okumak için <a href="konu.php?k='.$_GET['mesaj_no'].$ks.'&amp;f='.$_GET['fno'].$fs.'#c'.$_GET['cevapno'].'">tıklayın.</a>
<br>Foruma dönmek için <a href="forum.php?f='.$_GET['fno'].'">tıklayın.</a>';

$bilgi_no[5] = 'Konuyu ve altındaki tüm cevapları silmek istediğinize emin misiniz ?<br><br><a href="bilesenler/mesaj_sil.php?onay=kabul&amp;kip=mesaj&amp;fno='.$_GET['fno'].'&amp;mesaj_no='.$_GET['mesaj_no'].'&amp;o='.$_GET['o'].$fs.'">Evet</a> &nbsp; - &nbsp; <a href="konu.php?k='.$_GET['mesaj_no'].$fs.'">Hayır</a>';

$bilgi_no[6] = 'Konu ve tüm cevapları silinmiştir.<br><br>Foruma geri dönmek için <a href="forum.php?f='.$_GET['fno'].$fs.'">tıklayın</a>';

$bilgi_no[7] = 'Cevabı silmek istediğinize emin misiniz ?<br><br><a href="bilesenler/mesaj_sil.php?onay=kabul&amp;kip=cevap&amp;mesaj_no='.$_GET['mesaj_no'].'&amp;cevap_no='.$_GET['cevap_no'].'&amp;o='.$_GET['o'].$fs.$ks.'">Evet</a> &nbsp; - &nbsp; <a href="konu.php?k='.$_GET['mesaj_no'].$fs.$ks.'">Hayır</a>';

$bilgi_no[8] = 'Cevap silinmiştir.<br><br>Konuya geri dönmek için <a href="konu.php?k='.$_GET['mesaj_no'].$fs.$ks.'">tıklayın.</a>';

$bilgi_no[9] = 'Seçtiğiniz konu taşınmıştır.<br><br>Geldiğiniz foruma dönmek için <a href="forum.php?f='.$_GET['fno1'].'">tıklayın.</a><br>Konuyu taşıdığınız foruma dönmek için <a href="forum.php?f='.$_GET['fno2'].'">tıklayın.</a>';

$bilgi_no[10] = 'Profiliniz Güncellenmiştir...<br><br>Profilinizi görmek için <a href="profil.php">tıklayın.</a><meta http-equiv="Refresh" content="5;url=profil.php">';

$bilgi_no[11] = 'Özel iletiniz gönderilmiştir.<br><br>Gönderilen kutusuna gitmek için <a href="ozel_ileti.php?kip=gonderilen">tıklayın.</a><meta http-equiv="Refresh" content="5;url=ozel_ileti.php?kip=gonderilen"><br><br>Yazdığınız özel iletiyi görmek için <a href="oi_oku.php?oino='.$_GET['cevap_no'].'#hzlcvp">tıklayın.</a>';

$bilgi_no[12] = 'Forum ayarlarınız güncellenmiştir.<br><br>Yönetim ana sayfasına dönmek için <a href="yonetim/index.php">tıklayın.</a><meta http-equiv="Refresh" content="5;url=yonetim/index.php">';

$bilgi_no[13] = 'E-POSTANIZ GÖNDERİLMİŞTİR...';

$bilgi_no[14] = 'Etkinleştirme kodu başvurunuz tamamlanmıştır.<br><br>Size gelen E-Postadaki bağlantıyı tıklayarak hesabınızı etkinleştirebilirsiniz.<br><br>Giriş yapmak için <a href="giris.php">tıklayın.</a>';

$bilgi_no[15] = 'Kayıt işleminiz başarıyla tamamlanmıştır. <br><br>Giriş yapmak için <a href="giris.php">tıklayın.</a>';

$bilgi_no[16] = 'Kayıt işleminiz başarıyla tamamlanmıştır.<br><br>Hesabınızı etkinleştirmek için yapmanız gerekenler<br>size gönderilen E-Postada anlatılmaktadır.<br><br>Giriş yapmak için <a href="giris.php">tıklayın.</a>';

$bilgi_no[17] = 'Kayıt işleminiz başarıyla tamamlanmıştır.<br><br>Hesabınızın etkinleştirilmesi için forum yöneticisinin onayını beklemelisiniz.';

$bilgi_no[18] = 'Hesabınız zaten etkinleştirilmiş.';

$bilgi_no[19] = 'Hesabınız etkinleştirilmiştir.<br><br>Giriş yapmak için <a href="giris.php">tıklayın.</a>';

$bilgi_no[20] = 'Yeni şifre başvurunuz tamamlanmıştır.<br><br>Şifrenizi sıfırlamanız için yapmanız gerekenler size gönderilen<br>E-Postada anlatılmaktadır.<br><br>Giriş yapmak için <a href="giris.php">tıklayın.</a>';

$bilgi_no[21] = 'Yeni şifreniz oluşturulmuştur.<br><br>Yeni şifrenizle giriş yapmak için <a href="giris.php">tıklayınız.</a>';

$bilgi_no[22] = 'Yeni Şifre başvurunuz iptal edilmiştir. Eski şifreniz hâlâ geçerlidir.';

$bilgi_no[23] = 'Kullanıcı hesabı silinmiştir.<br><br>Geri dönmek için <a href="yonetim/kullanicilar.php?kip=engelli">tıklayın.</a>';

$bilgi_no[24] = 'Kullanıcının engeli kaldırılmıştır.<br><br>Geri dönmek için <a href="yonetim/kullanicilar.php?kip=engelli">tıklayın.</a><br><br>Engeli olmayan kullanıcıları görmek için <a href="yonetim/kullanicilar.php">tıklayın.</a>';

$bilgi_no[25] = 'Kullanıcı hesabı etkinleştirilmiştir.<br>Geri dönmek için <a href="yonetim/kullanicilar.php?kip=etkisiz">tıklayın.</a><br><br>Etkinleştirilmiş kullanıcıları görmek için <a href="yonetim/kullanicilar.php">tıklayın.</a>';

$bilgi_no[26] = 'Kullanıcı hesabı silinmiştir.<br><br>Geri dönmek için <a href="yonetim/kullanicilar.php?kip=etkisiz">tıklayın.</a>';

$bilgi_no[27] = 'Forum dalı içinde bulunan; forumlar, alt forumlar, konular ve <br> cevaplarıyla beraber başarıyla silinmiştir.<br><br>Forum Yönetimi sayfasına dönmek için <a href="yonetim/forumlar.php">tıklayın.</a>';

$bilgi_no[28] = 'Tüm forumlar, seçmiş olduğunuz forum dalına başarıyla taşınmıştır.<br><br>Forum Yönetimi sayfasına dönmek için <a href="yonetim/forumlar.php">tıklayın.</a>';

$bilgi_no[29] = 'Forum, forumun konuları ve konuların cevapları başarıyla silinmiştir.<br><br>Forum Yönetimi sayfasına dönmek için <a href="yonetim/forumlar.php">tıklayın.</a>';

$bilgi_no[30] = 'Forumun konuları ve konuların cevapları başarıyla taşınmıştır.<br><br>Forum Yönetimi sayfasına dönmek için <a href="yonetim/forumlar.php">tıklayın.</a>';

$bilgi_no[31] = 'Forum, seçtiğiniz forum dalına başarıyla taşınmıştır.<br><br>Forum Yönetimi sayfasına dönmek için <a href="yonetim/forumlar.php">tıklayın.</a>';

$bilgi_no[32] = 'Üyenin profili güncellenmiştir, görmek için <a href="profil.php?u='.$_GET['mesaj_no'].'">tıklayın.</a><br /><br />Etkin Kullanıcılar sayfasına dönmek için <a href="yonetim/kullanicilar.php">tıklayın.</a><meta http-equiv="Refresh" content="5;url=yonetim/kullanicilar.php">';

$bilgi_no[33] = 'Kullanıcı hesabı etkisizleştirilmiştir.<br>Geri dönmek için <a href="yonetim/kullanicilar.php">tıklayın.</a><br><br>Etkinleştirilmemiş kullanıcıları görmek için <a href="yonetim/kullanicilar.php?kip=etkisiz">tıklayın.</a>';

$bilgi_no[34] = 'Kullanıcı hesabı silinmiştir.<br><br>Geri dönmek için <a href="yonetim/kullanicilar.php">tıklayın.</a>';

$bilgi_no[35] = 'Kullanıcı engellenmiştir.<br>Geri dönmek için <a href="yonetim/kullanicilar.php">tıklayın.</a><br><br>Engellenmiş kullanıcıları görmek için <a href="yonetim/kullanicilar.php?kip=engelli">tıklayın.</a>';

$bilgi_no[36] = 'Forumdaki eski mesajlar silinmiştir.';

$bilgi_no[37] = 'E-POSTALARINIZ YOLLANMIŞTIR...';

$bilgi_no[38] = 'Veritabanı yedeğiniz başarıyla geri yüklenmiştir.';

$bilgi_no[39] = 'Yasaklama bilgileri güncellenmiştir.<br>Geri dönmek için <a href="yonetim/yasaklamalar.php">tıklayın.</a>';

$bilgi_no[40] = 'Güncelleme Başarıyla Tamamlanmıştır.';

$bilgi_no[41] = 'Kullanıcı engellenmiştir.<br>Geri dönmek için <a href="yonetim/kullanicilar.php?kip=etkisiz">tıklayın.</a><br><br>Engellenmiş kullanıcıları görmek için <a href="yonetim/kullanicilar.php?kip=engelli">tıklayın.</a>';

$bilgi_no[42] = 'E-Posta adresiniz kaydedilmiştir. <br><br>Adres değişikliğin tamamlanması için yapmanız gerekenler <br>size gönderilen E-Postada anlatılmaktadır.<br><br>Profilinizi görmek için <a href="profil.php">tıklayın.</a><meta http-equiv="Refresh" content="5;url=profil.php">';

$bilgi_no[43] = 'Şifreniz değiştirilmiştir...<br><br>Profilinizi görmek için <a href="profil.php">tıklayın.</a><meta http-equiv="Refresh" content="5;url=profil.php">';

$bilgi_no[44] = 'Şifreniz ve E-Posta adresiniz kaydedilmiştir. <br><br>Adres değişikliğin tamamlanması için yapmanız gerekenler <br>size gönderilen E-Postada anlatılmaktadır.<br><br>Profilinizi görmek için <a href="profil.php">tıklayın.</a><meta http-equiv="Refresh" content="5;url=profil.php">';

$bilgi_no[45] = 'Yeni E-Posta adresiniz onaylanmış ve değiştirilmiştir.<br><br>Profilinizi görmek için <a href="profil.php">tıklayın.</a><meta http-equiv="Refresh" content="5;url=profil.php">';

$bilgi_no[46] = 'Özel ileti ayarlarınız güncellenmiştir.<br><br>Geri dönmek için <a href="ozel_ileti.php?kip=ayarlar">tıklayın.</a><meta http-equiv="Refresh" content="5;url=ozel_ileti.php?kip=ayarlar">';

$bilgi_no[47] = 'Forumdaki eski özel iletiler silinmiştir.<br><br>Yönetim ana sayfasına dönmek için <a href="yonetim/index.php">tıklayın.</a><meta http-equiv="Refresh" content="5;url=yonetim/index.php">';

$bilgi_no[48] = 'Üye başarıyla oluşturulmuştur, geri dönmek için <a href="yonetim/yeni_uye.php">tıklayın.</a><br><br>Üyenin profilini görmek için <a href="profil.php?u='.$_GET['fno'].'">tıklayın.</a><br>Üyenin profilini değiştirmek için <a href="yonetim/kullanici_degistir.php?u='.$_GET['fno'].'">tıklayın.</a>';

$bilgi_no[49] = 'Dosya silinmiştir.<br><br>Geri dönmek için <a href="yonetim/yuklemeler.php">tıklayın.</a>';

$bilgi_no[50] = 'Dosya silinmiştir.<br><br>Geri dönmek için <a href="profil_degistir.php?kosul=yuklemeler">tıklayın.</a>';

$bilgi_no[51] = 'E-Posta adresiniz onaylanmıştır.<br><br>Hesabınızın etkinleştirilmesi için forum yöneticisinin onayını beklemelisiniz.';

$bilgi_no[52] = 'Yorum silinmiştir.<br><br>Geri dönmek için <a href="yonetim/silinmis.php">tıklayın.</a>';

$bilgi_no[53] = 'Yorum başarıyla geri yüklenmiştir.<br><br>Geri dönmek için <a href="yonetim/silinmis.php">tıklayın.</a>';

$bilgi_no[54] = 'Bildirim silinmiştir.<br><br>Geri dönmek için <a href="profil_degistir.php?kosul=bildirim">tıklayın.</a>';

$bilgi_no[55] = 'Takip ayarlarınız değiştirilmiştir....<br><br>Geri dönmek için <a href="profil_degistir.php?kosul=takip">tıklayın.</a>';


//  BİLGİ İLETİLERİ - SONU  //







//  HATA İLETİLERİ - BAŞI  //


$hata_no[1] = 'Son aramanızın üzerinden belli bir süre geçmeden yeni arama yapamazsınız !';

$hata_no[2] = 'Tüm alanlar boş bırakılamaz !<br>Aradığınız sözcük 3 harfden uzun olmalıdır !<br><br>Lütfen <a href="arama.php">geri</a> dönüp aramak istediğiniz sözcüğü ilgili bölüme giriniz.';

$hata_no[3] = 'Bu konuyu taşımaya yetkiniz yok !';

$hata_no[4] = 'Gönderilen kısmı boş bırakılamaz !';

$hata_no[5] = 'E-posta başlığı en az 3, en fazla 60 karakterden oluşmalıdır.<br><br>E-posta içeriği en az 3 karakterden oluşmalıdır.';

$hata_no[6] = 'Yolladığınız son iletinin üzerinden<br>'.$ayarlar['ileti_sure'].' saniye geçmeden başka bir ileti gönderemezsiniz.';

$hata_no[7] = 'Hatalı kullanıcı adı !<br><br>Göndermek istediğiniz kişiyi kontrol edip tekrar deneyiniz.';

$hata_no[8] = 'Lütfen E-Posta adresinizi yazınız !';

$hata_no[9] = 'E-Posta adresiniz 70 karakterden uzun olamaz !';

$hata_no[10] = 'E-Posta adresiniz hatalı !';

$hata_no[11] = '<font color="#007900">Kayıt işleminiz başarıyla tamamlanmıştır.</font> <br><br>Fakat sunucudaki bir hatadan dolayı E-postanız gönderilememiştir !<br><br>İstediğiniz zaman <a href="etkinlestir.php">buradan</a> etkinleştirme kodu başvurusunda bulunabilirsiniz.';

$hata_no[12] = 'Bu E-Posta adresine bağlı hesabınız zaten etkinleştirilmiş !';

$hata_no[13] = 'Yazdığınız E-Posta adresi veritabanında bulunmamaktadır !';

$hata_no[14] = 'Seçtiğiniz forum veritabanında bulunmamaktadır !';

$hata_no[15] = 'Bu foruma sadece yöneticiler girebilir !';

$hata_no[16] = 'Bu foruma sadece yöneticiler ve yardımcılar girebilir !';

$hata_no[17] = 'Bu foruma sadece, yöneticinin verdiği özel yetkilere sahip üyeler girebilir !';

$hata_no[18] = 'Lütfen kullanıcı adı ve şifrenizi giriniz !';

$hata_no[19] = 'Kullanıcı adı en az 4, en fazla 20 karakter olmalıdır !';

$hata_no[20] = 'Şifreniz en az 5, en fazla 20 karakter olmalıdır !';

$hata_no[21] = 'Beş başarısız giriş denemesi yaptınız.<br>'.($ayarlar['kilit_sure'] / 60).' dakika boyunca hesabınız kilitlenmiştir.';

$hata_no[22] = 'Şifreniz Hatalı!<br>Caps Lock açık kalmış olabilir, şifrelerde büyük/küçük harf ayrımı vardır.<br><br>Lütfen geri dönüp <a href="giris.php">tekrar</a> deneyin.';

$hata_no[23] = 'Hesabınız henüz etkinleştirilmemiş !<br><br>Hesabınızı etkinleştirmek için yapmanız gerekenler <br>size gönderilen E-Postada anlatılmaktadır.<br><br><a href="etkinlestir.php">Etkinleştirme kodunu tekrar yolla</a>';

$hata_no[24] = 'Hesabınız engellenmiştir !';

$hata_no[25] = 'Çok fazla kayıt girişiminde bulundunuz. Daha sonra tekrar deneyin !';

$hata_no[26] = 'Tüm bölümlerin doldurulması zorunludur !';

$hata_no[27] = 'Kullanıcı adında geçersiz karakterler var ! <br><br>Latin ve Türkçe harf, rakam, alt çizgi( _ ), tire ( - ), nokta ( . ) kullanılabilir. <br>Bunların dışındaki özel karakterleri ve boşluk karakterini içeremez.';

$hata_no[28] = 'Kullanıcı adı en az 4, en fazla 20 karakter olmalıdır !';

$hata_no[29] = 'Bu kullanıcı adı yasaklanmıştır, lütfen başka bir kullanıcı adı deneyin !';

$hata_no[30] = 'Bu E-Posta adresi yasaklanmıştır !';

$hata_no[31] = '"Ad Soyad - Lâkap" alanında geçersiz karakterler var !<br><br>Latin ve Türkçe harf, rakam, boşluk, alt çizgi( _ ), tire ( - ), nokta ( . ) kullanılabilir. <br>Bunların dışındaki özel karakterleri içeremez.';

$hata_no[32] = '"Ad Soyad - Lâkap" en az 4, en fazla 30 karakter olmalıdır !';

$hata_no[33] = 'Yazdığınız şifreler uyuşmuyor !';

$hata_no[34] = 'Şifrenizde geçersiz karakterler var ! <br><br>Latin harf, rakam, alt çizgi( _ ), tire ( - ), and ( & ), nokta ( . ) kullanılabilir. <br>Bunların dışındaki özel karakterleri, Türkçe karakterleri ve boşluk karakterini içeremez.';

$hata_no[35] = 'Şifreniz en az 5, en fazla 20 karakter olmalıdır !';

$hata_no[36] = 'Şehir geçersiz !';

$hata_no[37] = 'Doğum tarihi geçersiz !';

$hata_no[38] = 'Doğum tarihinin yıl kısmı geçersiz !<br>Lütfen 1981 şeklinde 4 rakam ile yazınız.';

$hata_no[39] = 'Silmeye çalıştığınız forumun alt forumları var. Önce alt forumlarını  silin !';

$hata_no[40] = 'E-Posta adresiniz 70 karakterden uzun olamaz !';

$hata_no[41] = 'Kayıt güvenlik sorusunun cevabı hatalı !<br><br>Genelde buraya sadece robot programların giremeyeceği çok kolay sorular yazılır.<br><br>Cevabı tahmin edemiyorsanız forum yöneticisiyle iletişime geçin.';

$hata_no[42] = 'Bu kullanıcı adı kullanılmaktadır, lütfen başka bir isim deneyin !';

$hata_no[43] = 'Bu E-posta adresiyle daha önce kayıt yapılmıştır !';

$hata_no[44] = 'Onay kodunu yanlış girdiniz. Lütfen geri dönüp <a href="kayit.php">tekrar</a> deneyiniz.';

$hata_no[45] = 'Hatalı Adres !<br>Lütfen kontrol edip tekrar deneyin.';

$hata_no[46] = 'Forumda bu isimde bir üye bulunmamaktadır !';

$hata_no[47] = 'Seçtiğiniz konu veritabanında bulunmamaktadır !';

$hata_no[48] = 'Etkinleştirme kodunuzda eksik var, ya da adresi eksik kopyaladınız.<br><br>Lütfen kontrol edip tekrar deneyiniz.<br>Yine aynı sorunla karşılaşırsanız forum yöneticisine başvurun.';

$hata_no[49] = 'Etkinleştirme kodunuz hatalı, ya da adresi eksik kopyaladınız.<br><br>Lütfen kontrol edip tekrar deneyiniz.<br>Yine aynı sorunla karşılaşırsanız forum yöneticisine başvurun.';

$hata_no[50] = 'Kilitli konuları değiştiremezsiniz !';

$hata_no[51] = 'Kilitli konuların cevaplarını değiştiremezsiniz !';

$hata_no[52] = 'Bu iletiyi değiştirmeye yetkiniz yok !';

$hata_no[53] = 'İleti başlığı en az 3, en fazla 200 karakterden oluşmalıdır.<br><br>İleti içeriği en az 3 karakterden oluşmalıdır.';

$hata_no[54] = 'Bu konuyu kilitlemeye veya açmaya yetkiniz yok !';

$hata_no[55] = 'Seçtiğiniz cevap veritabanında bulunmamaktadır !';

$hata_no[56] = 'Bu iletiyi silmeye yetkiniz yok !';

$hata_no[57] = 'Kilitli konulara cevap yazamazsınız !';

$hata_no[58] = 'Bu foruma sadece yöneticiler cevap yazabilir !';

$hata_no[59] = 'Bu foruma sadece yöneticiler ve yardımcılar cevap yazabilir !';

$hata_no[60] = 'Bu foruma sadece, yöneticinin verdiği özel yetkilere sahip üyeler cevap yazabilir !';

$hata_no[61] = 'Site kurucusunu etkisizleştiremezsiniz !';

$hata_no[62] = 'Aradığınız özel ileti bulunamıyor.<br>Silinmiş ya da okuma yetkiniz olmayabilir.';

$hata_no[63] = 'Gönderilen kısmı boş bırakılamaz !';

$hata_no[64] = 'Özel ileti başlığı en az 3, en fazla 60 karakterden oluşmalıdır.<br><br>Özel İleti içeriği en az 3 karakterden oluşmalıdır.';

$hata_no[65] = 'Yolladığınız son iletinin üzerinden '.$ayarlar['ileti_sure'].' saniye geçmeden başka bir ileti gönderemezsiniz.';

$hata_no[66] = 'Forumda bu isimde bir üye bulunmamaktadır.<br>Lütfen geri dönüp tekrar deneyin.';

$hata_no[67] = 'Gönderdiğiniz kişinin Gelen Kutusu dolu olduğundan ileti gönderilemedi.';

$hata_no[68] = 'Seçim yapmadınız !';

$hata_no[69] = 'Bu özel iletiyi silmeye yetkiniz yok!';

$hata_no[70] = 'Kaydedilen kutunuz dolu.<br>Boşaltmadan başka ileti kaydedemezsiniz.';

$hata_no[71] = 'Bu iletiyi kaydetmeye yetkiniz yok!';

$hata_no[72] = 'Kullanıcı adı 20 karakterden uzun olamaz !';

$hata_no[73] = '* işaretli bölümlerin doldurulması zorunludur !';

$hata_no[74] = 'Doğum tarihi geçersiz !<br>Lütfen tire(-)lerde dahil olmaz üzere 31-12-1985 şeklinde yazınız.';

$hata_no[75] = 'Web Adresiniz 100 karakterden uzun olamaz !';

$hata_no[76] = 'Tema dizini adı, alt çizgi( _ ) ve tire ( - ) dışındaki özel karakterleri ve Türkçe karakterleri içeremez !';

$hata_no[77] = 'Tema klasörünün adı 20 karakterden uzun olamaz !';

$hata_no[78] = 'İmzanız '.$ayarlar['imza_uzunluk'].' karakterden uzun olamaz !';

$hata_no[79] = 'ICQ Numaranız 30 karakterden uzun olamaz !';

$hata_no[80] = 'Facebook adresiniz 100 karakterden uzun olamaz !';

$hata_no[81] = 'Skype - MSN Messenger Adınız 100 karakterden uzun olamaz !';

$hata_no[82] = 'Yahoo! Messenger Adınız 100 karakterden uzun olamaz !';

$hata_no[83] = 'Twitter adresiniz 100 karakterden uzun olamaz !';

$hata_no[84] = 'Yüklemeye çalıştığınız resim bozuk !';

$hata_no[85] = 'Sadece jpeg, gif veya png resimleri yüklenebilir ! <br>Eğer dosyanız doğru tipte ise bozuk olabilir.';

$hata_no[86] = 'Yüklemeye çalıştığınız resim '.($ayarlar['resim_boyut']/1024).' kilobayt`dan büyük !';

$hata_no[87] = 'Yüklemeye çalıştığınız resmin boyutları '.$ayarlar['resim_genislik'].'x'.$ayarlar['resim_yukseklik'].'`den büyük !';

$hata_no[88] = 'Dosya yüklenemedi !<br><br>Yöneticiyseniz FTP programınızdan dosyalar/resimler/yuklenen/<br>dizinine yazma hakkı vermeyi (chmod 777) deneyin.';

$hata_no[89] = 'Uzak resim, kontrol edilirken bir sorunla karşılaşıldı.<br>Sunucunun uzak dosya erişimi kapatılmış olabilir ya da <br>adreste veya resim dosyasında bir sorun olabilir.';

$hata_no[90] = 'Eklemeye çalıştığınız resim '.($ayarlar['resim_boyut']/1024).' kilobayt`dan büyük !';

$hata_no[91] = 'Eklemeye çalıştığınız resmin boyutları '.$ayarlar['resim_genislik'].'x'.$ayarlar['resim_yukseklik'].'`den büyük !';

$hata_no[92] = 'E-Posta Adresini Göster, Doğum Tarihini Göster, Şehir Göster ve <br>Çevrimiçi Durumunu Göster ayarları sadece açık-kapalı değeri alabilir !';

$hata_no[93] = 'Bu E-posta adresi başka bir kullanıcıya aittir !';

$hata_no[94] = 'YETKİNİZ YOK !!!';

$hata_no[95] = 'Buradaki yazıları ancak forum üzerinden okuyabilirsiniz.';

$hata_no[96] = 'Yeni Şifre kodunuz hatalı, ya da adresi eksik kopyaladınız.<br>Lütfen kontrol edip tekrar deneyiniz.<br>Yine aynı sorunla karşılaşırsanız forum yöneticisine başvurun.';

$hata_no[97] = 'Çok fazla girişiminde bulundunuz. Daha sonra tekrar deneyin !';

$hata_no[98] = 'Tüm alanları doldurmalısınız! <i>(SMTP sunucusu ayarları hariç)</i>';

$hata_no[99] = 'Sayfa başlığı 100 karakterden uzun olamaz !';

$hata_no[100] = 'Alan adı 100 karakterden uzun olamaz !';

$hata_no[101] = 'Dizin adı 100 karakterden uzun olamaz !';

$hata_no[102] = 'Konu ve cevap sayısı alanlarına en fazla 99 değerini girebilirsiniz !';

$hata_no[103] = 'Konu ve cevap sayısı alanları sadece rakamdan oluşabilir !';

$hata_no[104] = 'Çerez geçerlilik süresi sadece rakamdan oluşabilir !';

$hata_no[105] = 'Çerez geçerlilik süreleri en fazla 5 rakamdan oluşabilir !<br><br>Yani en fazla 99`999 dakika değerini alabilir ki bu da 69 gün eder.';

$hata_no[106] = 'İki ileti arası bekleme süresi sadece rakamdan oluşabilir !';

$hata_no[107] = 'İki ileti arası bekleme süresi en fazla 86`400 saniye alabilir ki bu da 24 saat eder.';

$hata_no[108] = 'Hesap kilit süresi sadece rakamdan oluşabilir !';

$hata_no[109] = 'Beş başarısız girişten sonra hesabın kilitli kalacağı süre<br>en fazla 1440 dakika olabilir ki bu da 24 saat eder.';

$hata_no[110] = 'Kayıt sorusu açık kapalı ayarları sadece açık-kapalı değeri alabilir !';

$hata_no[111] = 'Kayıt sorusu ve cevabı 100 karakterden uzun olamaz !';

$hata_no[112] = 'İmza uzunluğu 1 ila 500 arası olabilir !';

$hata_no[113] = 'Tarih biçimi en fazla 20 karakter olabilir !';

$hata_no[114] = 'Zaman dilimi 1 ila  4 karakter arası olabilir !';

$hata_no[115] = 'Hatalı forum rengi !';

$hata_no[116] = 'Hesap Etkinleştirme ayarı sadece kapalı, kullanıcı ve yönetici değerlerini alabilir !';

$hata_no[117] = 'BBCode, Özel ileti ve Güncel Konular ayarları sadece açık-kapalı değeri alabilir !';

$hata_no[118] = 'Gösterilecek güncel konu sayısı ayarı sadece rakamdan oluşabilir !';

$hata_no[119] = 'Gösterilecek güncel konu sayısı ayarı 50`den fazla olamaz !';

$hata_no[120] = 'Site kurucusu adı 100 karakterden uzun olamaz !';

$hata_no[121] = 'Forum yöneticisi adı 100 karakterden uzun olamaz !';

$hata_no[122] = 'Forum yardımcısı adı 100 karakterden uzun olamaz !';

$hata_no[123] = 'Kayıtlı kullanıcı adı 100 karakterden uzun olamaz !';

$hata_no[124] = 'Gelen, ulaşan ve kaydedilen kutusu kota değerleri en fazla 3 rakamdan oluşabilir !<br><br>Yani en fazla 999 değerini alabilir.';

$hata_no[125] = 'Gelen, ulaşan ve kaydedilen kutusu kota değerleri sadece rakamdan oluşabilir !';

$hata_no[126] = 'Resim yükleme özelliği sadece açık-kapalı değeri alabilir !';

$hata_no[127] = 'Uzak resim özelliği sadece açık-kapalı değeri alabilir !';

$hata_no[128] = 'Resim galerisi özelliği sadece açık-kapalı değeri alabilir !';

$hata_no[129] = 'Resim dosyasının büyüklüğü 1 ila 999 kb. arası olabilir !';

$hata_no[130] = 'Resim boyutu en büyük 999 x 999 arası olabilir !';

$hata_no[131] = 'Yönetici E-Posta adresi 100 karakterden uzun olamaz !';

$hata_no[132] = 'E-Posta yöntemi sadece mail, sendmail ve smtp değerlerini alabilir !';

$hata_no[133] = 'SMTP kimlik doğrulaması alanı sadece true ve false değerlerini alabilir !';

$hata_no[134] = 'SMTP sunucu adresi 100 karakterden uzun olamaz !';

$hata_no[135] = 'SMTP kullanıcı adı 100 karakterden uzun olamaz !';

$hata_no[136] = 'SMTP şifresi 100 karakterden uzun olamaz !';

$hata_no[137] = 'Site kurucusunu silemezsiniz !';

$hata_no[138] = 'Bir hata oluştu ya da sayfaya doğrudan erişmeye çalışıyorsunuz. <br>Yapmak istediğiniz işlemi <a href="yonetim/forumlar.php">Forum Yönetimi</a> sayfasından seçiniz.';

$hata_no[139] = 'Seçtiğiniz forum dalı veritabanında bulunmamaktadır !';

$hata_no[140] = 'Forum dalı başlığını girmeyi unuttunuz !';

$hata_no[141] = 'Forum başlığını girmeyi unuttunuz !';

$hata_no[142] = 'Taşımak istediğniz forum dalını seçmeyi unuttunuz. <br><br>Lütfen geri dönüp tekrar deneyin.';

$hata_no[143] = 'Taşımak istediğniz forumu seçmeyi unuttunuz. <br><br>Lütfen geri dönüp tekrar deneyin.';

$hata_no[144] = 'Yönetim Yetkiniz Yok !';

$hata_no[145] = '<a href="yonetim/kullanicilar.php">Bu sayfadan</a> istediğiniz üyenin kullanıcı adını tıklayın.<br><br>Açılan "Kullanıcı Profilini Değiştir" sayfasındaki, Diğer Yetkiler bağlantısını tıklayın.<br><br>Açılan sayfadan özel yetki vermek istediğiniz forumu seçerek kullanıcıya istediğiniz özel yetkiyi verebilirsiniz. ';

$hata_no[146] = 'Seçtiğiniz forumun yetkisi sadece yöneticilere verilmiş.<br>Özel bir üyeye izin veremezsiniz !';

$hata_no[147] = 'Site kurucusunun bilgilerini buradan değişteremezsiniz !';

$hata_no[148] = 'Yetki alanı verisi geçersiz !';

$hata_no[149] = 'Site kurucusunu engelleyemezsiniz !';

$hata_no[150] = 'Varsayılan tema seçeneklerden kaldırılamaz !';

$hata_no[151] = 'Bu sayfaya sadece site kurucusu girebilir.';

$hata_no[152] = 'Forum seçmeyi unuttunuz !';

$hata_no[153] = 'Gün alanına 1 ila 999 arasında bir sayı girmelisiniz.';

$hata_no[154] = 'Seçmiş olduğunuz grupta hiçbir üye bulunmamaktadır !';

$hata_no[155] = 'Sunucunuz sıkıştırılmış dosya oluşturulmasını desteklemiyor !';

$hata_no[156] = 'Dosya Yüklenemedi, Dosya adı alınamadı !<br><br>Bunun nedeni dosyanın 2mb.`dan büyük olması ya da<br>dosya adının kabul edilemeyen karakterler içermesi olabilir. <br><br>Yedeği tablo tablo ayrı dosyalara bölmeyi deneyin veya dosya adını değiştirmeyi deneyin.';

$hata_no[157] = '2mb.`dan büyük yedek yükleyemezsiniz. <br>Yedeği tablo tablo ayrı dosyalara bölmeyi deneyin.';

$hata_no[158] = 'Sunucunuz sıkıştırılmış dosya yüklemesini desteklemiyor !';

$hata_no[159] = 'Sadece .sql ve .gz uzantılı dosyalar yüklenebilir !';

$hata_no[160] = 'BBCode, Özel ileti, Forum durumu, Portal kullanımı, Kayıt Onay Kodu, SEO,<br> Üye Alımı, Boyutlandırma, Güncel Konular, Bölüm ve Konu görüntüleyenler<br> ayarları sadece açık-kapalı değeri alabilir !';

$hata_no[161] = 'Seçtiğiniz forum kapatılmış.<br>Özel bir üyeye izin veremezsiniz !';

$hata_no[162] = 'Çevrimiçi süresi sadece rakamdan oluşabilir !';

$hata_no[163] = 'Çevrimiçi süresi için en fazla 99 dakika değerini girebilirsiniz !';

$hata_no[164] = 'Bu forum kapatılmıştır !';

$hata_no[165] = 'Bu foruma sadece yöneticiler konu açabilir !';

$hata_no[166] = 'Bu foruma sadece yöneticiler ve yardımcılar konu açabilir !';

$hata_no[167] = 'Bu foruma sadece, yöneticinin verdiği özel yetkilere sahip üyeler konu açabilir !';

$hata_no[168] = 'Bu konu daha önceden geri yüklenmiş veya silinmemiş !';

$hata_no[169] = 'Bu cevap daha önceden geri yüklenmiş veya silinmemiş !';

$hata_no[170] = 'Bu konuyu üst veya alt konu yapmaya yetkiniz yok !';

$hata_no[171] = 'Kurmaya çalıştığınız eklentinin adında kabul edilmeyen karakterler var !';

$hata_no[172] = '/eklentiler dizinine yazılamıyor ! <br><br>Eklenti kurulumu için bu dizine yazma hakkı (chmod 777) vermelisiniz.';

$hata_no[173] = 'Belirtilen eklenti dosyası bulunamıyor ! <br><br>Tıkladığınız adresi kontrol edip tekrar deneyin.';

$hata_no[174] = 'Bu eklenti zaten kurulu !';

$hata_no[175] = 'Sunucudaki bir hatadan dolayı onay E-Postası gönderilememiştir !<br> <br>Lütfen daha sonra tekrar deneyin ve durumu yöneticiye bildirin.';

$hata_no[176] = 'Bu üye kimseden özel ileti kabul etmiyor !';

$hata_no[177] = 'Bu üye sizden özel ileti kabul etmiyor !';

$hata_no[178] = 'Bu üye forumdan uzaklaştırılmış !';

$hata_no[179] = 'Bu üyenin hesabı henüz etkinleştirilmemiş !';

$hata_no[180] = 'Tarayıcınız çerez kabul etmiyor !<br>Tarayıcınızın çerez özelliği kapalı veya desteklemiyor olabilir.<br><br>Giriş yapabilmeniz için çerez özelliği gereklidir.<br>Çerezlere izin verin veya başka bir tarayıcıda tekrar deneyin.';

$hata_no[181] = 'Sadece yöneticiler güncelleme yapabilir !<br><br>Yönetici olarak giriş yapıp tekrar deneyin.';

$hata_no[182] = 'Bu eklenti kurulu değil !';

$hata_no[183] = 'Bu eklenti zaten etkin !';

$hata_no[184] = 'Bu eklenti zaten etkisiz !';

$hata_no[185] = 'Bu eklenti kullandığınız sürüm ile uyumsuz görünüyor !';

$hata_no[186] = '"Ad Soyad - Lâkap" alanına girdiğiniz isim yasaklanmıştır !';

$hata_no[187] = 'Kurulu eklentileri silemezsiniz !<br>Önce eklentiyi kaldırıp sonra silmeyi deneyin.';

$hata_no[188] = 'Şifreniz yanlış !<br><br>Lütfen <a href="profil_degistir.php?kosul=sifre">geri dönüp</a> tekrar deneyiniz.';

$hata_no[189] = 'Kurmaya çalıştığınız eklenti portal için fakat sitenizde portal kurulu değil !';

$hata_no[190] = 'Hatalı ip adresi !';

$hata_no[191] = 'Bölüm yardımcısı adı 100 karakterden uzun olamaz !';

$hata_no[192] = 'Bu forum konu açmaya kapatılmıştır !';

$hata_no[193] = 'Bu forum cevap yazmaya kapatılmıştır !';

$hata_no[194] = 'Seçtiğiniz forumun yetkisi sadece yönetici ve yardımcılara verilmiş.<br>Özel bir üyeye izin veremezsiniz !';

$hata_no[195] = 'Konuyu taşıdığınız forumda yetkiniz yok !';

$hata_no[196] = 'Bu tema kullandığınız sürüm ile uyumsuz görünüyor !';

$hata_no[197] = 'Seçeneklerde olmayan bir tema varsayılan olarak ayarlanamaz !<br>Temayı önce seçenekler arasına ekleyin.';

$hata_no[198] = '<font color="#007900">Kayıt işleminiz başarıyla tamamlanmıştır.</font> <br><br>Fakat sunucudaki bir hatadan dolayı E-postanız gönderilememiştir !<br><br>Giriş yapmak için <a href="giris.php">tıklayın.</a>';

$hata_no[199] = '<font color="#007900">Kayıt işleminiz başarıyla tamamlanmıştır.</font> <br><br>Fakat sunucudaki bir hatadan dolayı E-postanız gönderilememiştir !<br><br>Hesabınızın etkinleştirilmesi için forum yöneticisinin onayını beklemelisiniz.';

$hata_no[200] = 'Bu eklenti etkisizleştirmeyi desteklemiyor !';

$hata_no[201] = 'Grup adında karakterler var !<br><br>Latin ve Türkçe harf, rakam, boşluk, alt çizgi( _ ), tire ( - ), nokta ( . ) kullanılabilir. <br>Bunların dışındaki özel karakterleri içeremez.';

$hata_no[202] = 'Grup adı en az 4, en fazla 30 karakter olmalıdır !';

$hata_no[203] = 'Bu grup adı kullanılmaktadır, başka bir ad deneyin !';

$hata_no[204] = 'Forumda böyle bir grup bulunmamaktadır !';

$hata_no[205] = 'Grubun bölüm yardımcılığı yetkisini değiştirmek için önce<br><a href="yonetim/ozel_izinler.php">özel izinler</a> sayfasında görünen bölüm yönetme izinlerini alın !';

$hata_no[206] = 'Aradığınız dosya bulunamıyor.<br>Dosya daha önceden silinmiş olabilir. Lütfen kontrol edip tekrar deneyin.';

$hata_no[207] = 'Forumda bu isimde bir üye bulunmamaktadır !<br>Kullanıcı adını yanlış girmiş olabilirsiniz.<br><br>Lütfen geri dönüp <a href="giris.php">tekrar</a> deneyin.';

$hata_no[208] = 'Kullanıcı adı olarak E-posta adresi kullanılmamaktadır !<br><br>Lütfen  kayıt olurken yazdığınız kullanıcı adını giriniz.';

$hata_no[209] = 'Seçtiğiniz yorum veritabanında bulunmamaktadır !';

$hata_no[210] = 'Bu yorum daha önceden geri yüklenmiş veya silinmemiş !';

$hata_no[220] = 'Aradığınız dosya bulunamıyor.<br>Dosya daha önceden silinmiş olabilir. Lütfen kontrol edip tekrar deneyin.';

$hata_no[221] = 'Hesabınızın etkinleştirilmesi için yöneticinin onayını beklemelisiniz !';

$hata_no[223] = 'Hesabınız henüz etkinleştirilmemiş !<br><br>Hesabınızın etkinleştirilmesi için önce size gönderilen E-Postadaki<br> bağlantıyı tıklayın daha sonra yöneticinin onayını bekleyin.';

$hata_no[224] = 'Hakkında bilgisi 1000 karakterden uzun olamaz !';


//  HATA İLETİLERİ - SONU  //










//  UYARI İLETİLERİ - BAŞI  //


$uyari_no[1] = '<font color="orange">Sürüm güncellemesi yapılmış !</font>';

$uyari_no[2] = '<font color="orange">Özel İleti hizmeti kapatılmıştır !</font>';

$uyari_no[3] = '<font color="orange">Seçtiğiniz kullanıcı bir yönetici !<br> Yöneticilerin yetkileri sınırsızdır.</font>';

$uyari_no[4] = '<font color="orange">Seçtiğiniz kullanıcı forum yardımcısı !<br> Forum yardımcıları tüm forum bölümleri üzerinde yetki sahibidir.</font>';

$uyari_no[5] = 'Konuyu ve altındaki tüm cevapları silmek istediğinize emin misiniz ?<br><br><a href="bilesenler/mesaj_sil.php?onay=kabul&amp;kip=mesaj&amp;fno='.$_GET['fno'].'&amp;mesaj_no='.$_GET['mesaj_no'].'&amp;o='.$_GET['o'].'&amp;fsayfa='.$_GET['fsayfa'].'">Evet</a> &nbsp; - &nbsp; <a href="konu.php?k='.$_GET['mesaj_no'].$fs.'">Hayır</a>';

$uyari_no[6] = '<font color="orange">Bu sayfaya sadece üyeler girebilir !</font><br><br>Giriş yapmak için <a href="giris.php'.$git.'">tıklayın.</a> <br><br> Üye olmak için <a href="kayit.php">tıklayın.</a>';

$uyari_no[7] = 'Cevabı silmek istediğinize emin misiniz ?<br><br><a href="bilesenler/mesaj_sil.php?onay=kabul&amp;kip=cevap&amp;mesaj_no='.$_GET['mesaj_no'].'&amp;cevap_no='.$_GET['cevap_no'].'&amp;o='.$_GET['o'].'&amp;fsayfa='.$_GET['fsayfa'].'&amp;sayfa='.$_GET['sayfa'].'">Evet</a> &nbsp; - &nbsp; <a href="konu.php?k='.$_GET['mesaj_no'].$ks.$fs.'">Hayır</a>';

$uyari_no[8] = 'Herhangi bir değişiklik yapmadınız.<br><br>Geri dönmek için <a href="profil_degistir.php?kosul=sifre">tıklayın.</a><meta http-equiv="Refresh" content="5;url=profil_degistir.php?kosul=sifre">';

$uyari_no[9] = '<font color="orange">Üye alımı geçici bir süre için durdurulmuştur !</font>';


//  UYARI İLETİLERİ - SONU  //









//  GELEN VERİYE GÖRE SAYFA HAZIRLANIYOR - BAŞI  //

if ( isset($_GET['bilgi']) )
{
		if (!is_numeric($_GET['bilgi'])) $_GET['bilgi'] = 0;

		if ( (empty($bilgi_no[$_GET['bilgi']])) OR (is_numeric($_GET['bilgi']) == false) )
		{
			$sayfa_adi = 'Hatalı Adres !';
			$hata_baslik = 'Hatalı Adres !';
			$hata_icerik = 'Hatalı Adres !';
		}

		else
		{
			$sayfa_adi = 'Bilgi iletisi ';
			$hata_baslik = 'Bilgi iletisi :';
			$hata_icerik = $bilgi_no[$_GET['bilgi']];
		}
}



elseif ( isset($_GET['hata']) )
{
		if (!is_numeric($_GET['hata'])) $_GET['hata'] = 0;

		if ( (empty($hata_no[$_GET['hata']])) OR (is_numeric($_GET['hata']) == false) )
		{
			$sayfa_adi = 'Hatalı Adres !';
			$hata_baslik = 'Hatalı Adres !';
			$hata_icerik = 'Hatalı Adres !';
		}

		else
		{
			$sayfa_adi = 'Hata iletisi ';
			$hata_baslik = 'Hata iletisi :';
			$hata_icerik = '<font color="red">'.$hata_no[$_GET['hata']].'</font>';
		}
}



elseif ( isset($_GET['uyari']) )
{
		if (!is_numeric($_GET['uyari'])) $_GET['uyari'] = 0;

		if ( (empty($uyari_no[$_GET['uyari']])) OR (is_numeric($_GET['uyari']) == false) )
		{
			$sayfa_adi = 'Hatalı Adres !';
			$hata_baslik = 'Hatalı Adres !';
			$hata_icerik = 'Hatalı Adres !';
		}

		else
		{
			$sayfa_adi = 'Uyarı iletisi ';
			$hata_baslik = 'Uyarı iletisi :';
			$hata_icerik = $uyari_no[$_GET['uyari']];
		}
}



else
{
	$sayfa_adi = 'Hatalı Adres !';
	$hata_baslik = 'Hatalı Adres !';
	$hata_icerik = 'Hatalı Adres !';
}

//  GELEN VERİYE GÖRE SAYFA HAZIRLANIYOR - SONU  //




//  TEMA UYGULANIYOR  //

include_once('bilesenler/sayfa_baslik.php');

$ornek1 = new phpkf_tema();
$tema_dosyasi = 'temalar/'.$temadizini.'/hata.php';
eval($ornek1->tema_dosyasi($tema_dosyasi));


$ornek1->dongusuz(array('{HATA_BASLIK}' => $hata_baslik,
						'{HATA_ICERIK}' => $hata_icerik));

eval(TEMA_UYGULA);

?>