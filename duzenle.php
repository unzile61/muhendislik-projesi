<?php

include 'kategori.php';
$gelen_id = $_REQUEST['id'];
 
readbyid($gelen_id);

$kayit_kontrol = $_REQUEST['kayit'];
$kayit_id = $_REQUEST['id'];
$kayit_kategori = $_REQUEST['katadi'];

if ($kayit_kontrol=='Kaydet') {
	updatebyid($kayit_id,$kayit_kategori);
	echo "<b>DÜZENLEME İŞLEMİ BAŞARILI</b>";
	header("Refresh: 2; url=kategori.php?txt=&kayitlar=full");

}
 
?>