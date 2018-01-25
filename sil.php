<?php

include 'kategori.php';
$gelen_id = $_REQUEST['id'];
 
 deletebyid($gelen_id);
 echo "<b>SİLME İŞLEMİ BAŞARILI</b>";
 header("Refresh: 2; url=kategori.php?txt=&kayitlar=full");
 
?>