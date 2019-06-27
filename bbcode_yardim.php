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
$sayfano = 6;
$sayfa_adi = 'BBCode Yardım';
include_once('bilesenler/sayfa_baslik.php');



//	TEMA UYGULANIYOR	//

$ornek1 = new phpkf_tema();

$tema_dosyasi = 'temalar/'.$temadizini.'/bbcode_yardim.php';
eval($ornek1->tema_dosyasi($tema_dosyasi));

eval(TEMA_UYGULA);

?>