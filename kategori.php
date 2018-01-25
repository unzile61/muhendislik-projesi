  <body style="background-color:slategrey;">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<?php

error_reporting(0);

$gelen=$_REQUEST['txt'];


$kayit_getir=$_REQUEST['kayitlar'];
$kayit_ekle=$_REQUEST['ekle'];
if ($kayit_getir!=null) {
    readall();
}

if ($gelen!=null) {

    if ($kayit_ekle!=null) {
    create($gelen);
    echo "<b>KAYIT EKLEME BAŞARILI</b>";
    header("Refresh: 2; url=kategori.php?txt=&kayitlar=full");
}
}
 

    $ns = "http://".$_SERVER['HTTP_HOST']."/kategori.php";//alanı ayarlama
    require_once 'lib/nusoap.php'; // nusoap kutuphanesini ekledim
    $server = new soap_server; // soap nesnesi olusturdum
    $server->configureWSDL("WEB SERVICE ", $ns); // wsdl yapilandirmasi
    $server->wsdl->schemaTargetNamespace = $ns; // sunucu alanı

    ########################Kategori Adı##############################
    // Karmaşık dizi ve tiplerini kategori adina gore ayarlama
    $server->wsdl->addComplexType("kategoriData","complexType","struct","all","",
        array(
        "id"=>array("name"=>"id","type"=>"xsd:int"),
        "kategori_adi"=>array("name"=>"kategori_adi","type"=>"xsd:string")
        )
    );
    $server->wsdl->addComplexType("kategoriArray","complexType","array","","SOAP-ENC:Array",
        array(),
        array(
            array(
                "ref"=>"SOAP-ENC:arrayType",
                "wsdl:arrayType"=>"tns:kategoriData[]"
            )
        ),
        "kategoriData"
    );
    // Karmaşık dizi bitişi 
    //kategori adı olusturma 
    $input_create = array('kategori_adi' => "xsd:string"); //kategori_adi parametresi olusturma
    $return_create = array("return" => "xsd:string");
    $server->register('create',
        $input_create,
        $return_create,
        $ns,
        "urn:".$ns."/create",
        "rpc",
        "kodlama",
        "Create kategori adi Ad");
    //kategori_adı olusturma bitişi
    //kategori_adı'nı id ye gore okuma
    $input_readbyid = array('id' => "xsd:int"); // okuma islemi icin parametre olusturma
    $return_readbyid = array("return" => "tns:kategoriArray");
    $server->register('readbyid',
        $input_readbyid,
        $return_readbyid,
        $ns,
        "urn:".$ns."/readbyid",
        "rpc",
        "kodlama",
        "Readbyid kategori adi by id");
    //kategori_adı id okuma bitişi
    //kategori icin guncelleme olusturma
    $input_update = array('id' => "xsd:int","kategori_adi"=>"xsd:string"); // guncelleme parametresi olusturma
    $return_update = array("return" => "xsd:string");
    $server->register('updatebyid',
        $input_update,
        $return_update,
        $ns,
        "urn:".$ns."/updatebyid",
        "rpc",
        "kodlama",
        "Guncelleme kategori by id");
    //guncelleme bitişi
    //kategori silme islemi
    $input_delete = array('id' => "xsd:string"); // silme icin parametre olusturma
    $return_delete = array("return" => "xsd:string");
    $server->register('deletebyid',
        $input_delete,
        $return_delete,
        $ns,
        "urn:".$ns."/deletebyid",
        "rpc",
        "kodlama",
        "Delete kategori by id");
    //silme isleminin bitişi
    //tum kayıtları getirmek icin
    $input_readall = array(); // getirme islemi icin parametre olusturdum
    $return_readall = array("return" => "tns:kategoriArray");
    $server->register('readall',
        $input_readall,
        $return_readall,
        $ns,
        "urn:".$ns."/readall",
        "rpc",
        "kodlama",
        "Readall Data kategori Adi");
    //tum kayıtları getirme bitisi
    ################################ Kategori Adları #######################################################
    ########################### Kategori fonksiyonları ###################################################
    function create($kategori_adi){
        require_once 'classDb/Classkategori.php';
        $kategori = new Classkategori;
        if ($kategori->create($kategori_adi)) {
            $sonuc = "başarılı";
        }else{
            $sonuc = "hata";
        }
        return $sonuc;
    }
    function readbyid($id){
        require_once 'classDb/Classkategori.php';
        $kategori = new Classkategori;
        $deger = $kategori->readbyid($id);
        $liste = array();
        while ($item = $deger->fetch_assoc()) {
            array_push($liste, array('id'=>$item['id'],'kategori_adi'=>$item['kategori_adi']));
        }

    
        foreach ($deger as $donen) {

        echo "<br><br>";
        echo "<div class='col-xs-4'>";
        echo "<form name='form1' action='duzenle.php?id='.$donen[id].'>";
        echo "<input class='form-control' style='width=' id='focusedInput' name='id' type='text' value=$donen[id]>";
        echo "<input class='form-control' style='width=' id='focusedInput' name='katadi' type='text' value=$donen[kategori_adi]>";
        echo "<input type='submit' class='btn btn-success btn-md' name='kayit' value='Kaydet'>";
        echo "</form>";
        echo "</div>";  
  
        }
        return $liste;
    }
    function readall(){
        require_once 'classDb/Classkategori.php';
        $kategori = new Classkategori;
        $deger = $kategori->readAll();
        $liste = array();
        foreach ($deger as $donen) {



    echo "<table border=3 class='table table-dark' style='width:545px; margin-left:400px; margin-top:30px;'>
    <thead>
      <tr>
        <th style='color:white;'>Kategori ID</th>
        <th style='color:white;'>Kategori Adı</th>
    </tr>
    </thead>
    <tbody>
      <tr>
        <td style='color:white;'>$donen[id]</td>
        <td style='color:white;'>$donen[kategori_adi]</td>
      </tr>

    </tbody>
  </table>";
 
    echo '<a href=duzenle.php?id='.$donen[id].' class="btn btn-warning btn-md" style="margin-left:400px;">'."Düzenle".'</a>'.'</div>';
    echo '<a href=sil.php?id='.$donen[id].' class="btn btn-danger btn-md">'."Sil".'</a>'.'</div>'.'&nbsp;'.'&nbsp;'.'&nbsp;';
    echo '<a href=index.php?id='.$donen[id].' class="btn btn-info btn-md">'."Ana Sayfa".'</a>'.'</div>'.'&nbsp;'.'&nbsp;'.'&nbsp;';

        }
 
        return $donen;
    }
 
    function updatebyid($id,$kategori_adi){
        require_once 'classDb/Classkategori.php';
        $kategori = new Classkategori;
        if ($kategori->updatebyid($id,$kategori_adi)) {
            $sonuc = "başarılı";
        }else{
            $sonuc = "hata";
        }
        return $sonuc;
    }
    function deletebyid($id){
        require_once 'classDb/Classkategori.php';
        $kategori = new Classkategori;
        if ($kategori->deletebyid($id)) {
            $sonuc = "başarılı";
        }else{
            $sonuc = "hata";
        }
        return $sonuc;
    }

 ?> 
</body>