 
 <script src="https://maps.googleapis.com/maps/api/js?callback=initMap"></script>
<style>
    th { font-size: 12px; }
    td { font-size: 11px; }
    #map {
      	width: 100%;
        height: 70%;
      }
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
</style>
</head>
<body>
<?php
session_start();
include ("../layout/header.php");
include ("../koneksi.php");
include ("../menu.php"); ?>
<div class="container">
  <table id="map">
        
    </table>

  <div class="panel panel-primary">
  <div class="panel-heading">Filter Data</div>
  <div class="panel-body">
        <div id="formtabel" >
    <form id="forminput" action="" method="post" >
        <div class="col-lg-6">
            <div id="tabelinput" class="form-group">
                    <label >Pencarian Berdasarkan Kecamatan</label>
                    <select class="form-control" name="crkcmtn" action=""  class="searchinput" id="select1">
                    <option value=''>Pilih Kecamatan </option>
                    <?php
                    $querykecamatan = pg_prepare( $db,"my_query","SELECT * FROM kec_banjar ORDER BY kode_kec ASC");
                    $querykecamatan = pg_execute( $db,"my_query",array());
                    while ( $datakcmtn = pg_fetch_array($querykecamatan) )  { 
                       echo "<option value='$datakcmtn[kecamatan]'>$datakcmtn[kecamatan]</option>";     
                     }
                    ?>
                    </select>       
            </div>
            <div id="tabelinput" class="form-group">
                    <label >Pencarian Berdasarkan Desa</label>
                    <select class="form-control" name="crdesa" class="searchinput" id="select2">
                    <option value=''>Pilih Desa</option>
                    <?php
                    $querydesa = pg_prepare( $db,"desabanjar","SELECT * FROM desa_banjar ORDER BY kode_kec, kode_desa ASC");
                    $querydesa = pg_execute( $db,"desabanjar",array());
                    while ( $datadesa = pg_fetch_array($querydesa) )  { 
                    echo "<option data-value='$datadesa[kecamatan]' value='$datadesa[desa]'>$datadesa[desa]</option>";  
                    }
                    ?>
                    </select>
            </div>
            <div id="tabelinput" class="form-group">
                    <label >Pencarian Berdasarkan Titik</label>
                    <select class="form-control"  name="crjnsttk" class="searchinput">
                    <option value=''>Pilih Titik</option>
                    <?php
                    
                    $queryjenistitik = pg_prepare($db,"jenistitik", "SELECT * FROM jenis_titik ORDER BY No ASC");
                    $queryjenistitik = pg_execute($db,"jenistitik", array());
                    while ( $datajnsttk = pg_fetch_array($queryjenistitik) ) { 
                       echo "<option value='$datajnsttk[jenis_titik]'>$datajnsttk[jenis_titik]</option>";   
                     }
                    ?>
                    </select>
             </div>
             <div id="tabelinput" class="form-group">
                    <label >Pencarian Berdasarkan Jenis Lampu</label>
                    <select class="form-control" name="crjnslmp" class="searchinput">
                    <option value=''>Pilih Jenis Lampu</option>
                    <?php
                    $queryjenislampu = pg_prepare( $db,"jenislampu","SELECT * FROM jenis_lampu ORDER BY No ASC");
                    $queryjenislampu = pg_execute( $db,"jenislampu",array());
                    while ( $datajenislampu = pg_fetch_array($queryjenislampu) ) { 
                       echo "<option value='$datajenislampu[jenis_lampu]'>$datajenislampu[jenis_lampu]</option>";   
                     }
                    ?>
                    </select>
            </div>
             <div id="tabelinput" class="form-group">
                    <label >Pencarian Berdasarkan Termeter / Tidak </label>
                    <select class="form-control" name="crtrmtr" class="searchinput">
                    <option value=''>Pilih Status</option>
                    <option value='t'>Termeter</option>
                    <option value='v'>Tidak Termeter</option>
                    
                    </select>
            </div>
        <input class="btn btn-primary" type="submit" value="TAMPILKAN DATA" class="inputsubmit" name="inputsubmit">
        <input class="btn btn-success" type="submit" value="TAMPILKAN SEMUA DATA" class="inputsubmit" name="inputsubmit">
     </form>
     </div>

    
  </div>





<script>
        function initMap() {
        <?php
        if ($_POST['inputsubmit']) {
$carikecamatan=@$_POST['crkcmtn'];  
        $caridesa=@$_POST['crdesa'];
        $carijenistitik=@$_POST['crjnsttk'];
        $carijenislampu=@$_POST['crjnslmp'];
        $carilatitude=@$_POST['crlttd'];
        $carilongitude=@$_POST['crltgd'];
        $caritermeter=@$_POST['crtrmtr'];
        
            
        $query = "SELECT * FROM desa_banjar JOIN lpju_banjar ON desa_banjar.kode_kec = lpju_banjar.nokec AND desa_banjar.kode_desa = lpju_banjar.nodesa
        WHERE kecamatan LIKE '%$carikecamatan%' AND desa LIKE '%$caridesa%' AND jenistitik LIKE '%$carijenistitik%' AND jenislampu LIKE '%$carijenislampu%' AND nonmeter LIKE '%$caritermeter%'
        ORDER BY kode_kec, kode_desa, nolamp ASC ";

        $hasil = pg_query($db,$query);
        $jmldataresult =pg_num_rows($hasil);
        $lokasi_default = pg_fetch_array($hasil);
        if (empty($jmldataresult)){?>
          alert("Data Tidak Ditemukan");
            var map = new google.maps.Map(document.getElementById('map'), {
            center: new google.maps.LatLng( -7.447390 , 109.553857),
            zoom: 15
        });
            <?php
        } else {
            ?>

        var map = new google.maps.Map(document.getElementById('map'), {
          center: new google.maps.LatLng(<?php echo "$lokasi_default[latitude]"; ?> , <?php echo "$lokasi_default[longitude]";?>),
          zoom: 15
        });

            <?php
        }
    
        while ( $data = pg_fetch_array($hasil) )  { 


        ?>

        
        var kondisi = '<?php echo "$data[kondisi]";?>';

        if (kondisi == "nyala") {
            var marker = new google.maps.Marker({
                map: map,
                position: new google.maps.LatLng(<?php echo "$data[latitude]"; ?> , <?php echo "$data[longitude]";?> ),
                icon: '../layout/images/green.png'
        });
        } else {
            var marker = new google.maps.Marker({
                map: map,
                position: new google.maps.LatLng(<?php echo "$data[latitude]"; ?> , <?php echo "$data[longitude]";?> ),
                icon: '../layout/images/red.png'
        });
        }

         
         
       marker.content = '<div class="panel panel-primary"> '+
                        '<div class=panel-heading> <h3 class=panel-title>Info Titik LPJU</h3>' +
                        '</div> <div class=panel-body>'+
                        '<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">' +

                        '<tr><td>ID LPJU</td><td><?php echo "$data[kode_kec]"?></td></tr>'+
                         '<tr><td>Nomor Lampu</td><td><?php echo "$data[nolamp]"; ?></td></tr>'+
                         '<tr><td>Nomor Latitude</td><td><?php echo "$data[latitude]"; ?></td></tr>'+
                         '<tr><td>Nomor Longitude</td><td><?php echo "$data[longitude]";?></td></tr>'+
                         '<tr><td>Kondisi</td><td><?php echo "$data[kondisi]";?></td></tr>'+
                         '<tr><td>Desa</td><td><?php echo "$data[desa]";?></td></tr>'+
                         '<tr><td>Kecamatan</td><td><?php echo "$data[kecamatan]";?></td></tr>'+
                         '<tr><td>jenislampu</td><td><?php echo "$data[jenislampu]";?></td></tr>'+
                         '<tr><td>jenistitik</td><td><?php echo "$data[jenistitik]";?></td></tr>'+    

                        '</table></div></div>' ;

        var infoWindow = new google.maps.InfoWindow();
          google.maps.event.addListener(marker, 'click', function () {
           infoWindow.setContent(this.content);
           infoWindow.open(this.getMap(), this);
          });
        <?php
    }
  } else {
    ?> 
 var map = new google.maps.Map(document.getElementById('map'), {
            center: new google.maps.LatLng( -7.447390 , 109.553857),
            zoom: 15
        });   
    <?php
  }
      ?>   

    }




    $("#select1").change(function() {
          if ($(this).data('options') == undefined) {
            /*Taking an array of all options-2 and kind of embedding it on the select1*/
            $(this).data('options', $('#select2 option').clone());
          }
          var id = $(this).val();
          var options = $(this).data('options').filter('[data-value=' + id + ']');
          $('#select2').html(options);
        });
    </script>

    <?php
    if (!empty($jmldataresult)) {
      ?>
 <div class="col-lg-6">
            <p class="keteranganjumlah">

            <div class="panel panel-primary"> 
            <div class=panel-heading> <h3 class=panel-title>Panel title</h3> 
            </div> <div class=panel-body> Panel content 

            Terdapat <?php 
            switch ($caritermeter)
                    {case "":$ketmeter=""; break;
                    case "t":$ketmeter="Termeter"; break;
                    case "v":$ketmeter="Tidak Termeter"; break;}
            echo "$jmldataresult data untuk hasil pencarian :<br>
            Kecamatan : $carikecamatan <br>
            Desa : $caridesa <br> 
            Jenis Titik : $carijenistitik <br> 
            Jenis Lampu : $carijenislampu 
            <br> Termeter : $ketmeter";?>
            </p>
            </div>
      <?php
    }
  ?>

    
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBPu7v8IKDV89TjxHfrBNeT36niaPGUH1Y&callback=initMap">
    </script>
  
<?php
include("../footer.php");
?>

</body>
</html>