<?php
  include ("../koneksi.php");
  include('aksesadmin.php');          
  
?>
 
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
      body {
        padding-top: 50px;
        padding-bottom: 20px;
        }


</style>
</head>
<body>

<?php           
   
  include ("../admin/menu.php");
  include ("../layout/header.php");
?>


<br />


<div class="container">
<div class="row">
   <table id="map">
        
    </table>

  <div class="panel panel-primary">
  <div class="panel-heading">Filter Data</div>
  <div class="panel-body">
        <div id="formtabel" >
        <div class="col-lg-6">
        <form id="forminput" action="" method="post" >
        
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
        var map, marker, infoWindow, kondisi; 
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
        if (empty($jmldataresult)){ ?>
            alert("Data Tidak Ditemukan");
            getCurrentLocation(document.getElementById('map')); 
        <?php } else { ?>

        map = new google.maps.Map(document.getElementById('map'), {
          center: new google.maps.LatLng(<?php echo "$lokasi_default[latitude]"; ?> , <?php echo "$lokasi_default[longitude]";?>),
          zoom: 15
        });
         <?php }
        while ( $data = pg_fetch_array($hasil) )  { ?>
        kondisi = '<?php echo "$data[jenislampu]";?>';

        if (kondisi == "HPL") {
            getMarker(<?php echo "$data[latitude]"; ?>, <?php echo "$data[longitude]";?>, '../layout/images/hpl.png');
        } else if (kondisi == "HPS") {
            getMarker(<?php echo "$data[latitude]"; ?>, <?php echo "$data[longitude]";?>, '../layout/images/hps.png');
        } else if (kondisi == "TL") {
            getMarker(<?php echo "$data[latitude]"; ?>, <?php echo "$data[longitude]";?>, '../layout/images/tl.png');
        } else if (kondisi == "SL") {
            getMarker(<?php echo "$data[latitude]"; ?>, <?php echo "$data[longitude]";?>, '../layout/images/sl.png');
        } else {
            getMarker(<?php echo "$data[latitude]"; ?>, <?php echo "$data[longitude]";?>, '../layout/images/led.png');
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
                        '</table>'+
                        ' <form id="forminput" action="" method="post" >'+
                        '<div id="tabelinput" class="form-group">'+
                        '<label >Ubah status lampu </label>'+
                        '<input type="hidden" name="idlpju" value="<?php echo "$data[id_lpju]";?>">'+
                        '<select class="form-control" name="status" class="searchinput">'+
                        '<option value="<?php echo "$data[kondisi]";?>">Ubah Status</option>'+
                        '<option value="nyala">Menyala</option>'+
                        '<option value="mati">Mati</option>'+
                        '</select>'+
                        '</div>'+ 
                        '  <input class="btn btn-primary" type="submit" value="Ubah data" class="inputsubmit" name="ubahstatus"> </form></div></div>' ;

        infoWindow = new google.maps.InfoWindow();
          google.maps.event.addListener(marker, 'click', function () {
           infoWindow.setContent(this.content);
           infoWindow.open(this.getMap(), this);
        });
        <?php
    }
    } else {
    	 
    }
    ?>  

    function getMarker(lat, long, images) {
        marker = new google.maps.Marker({
                map: map,
                position: new google.maps.LatLng(lat , long ),
                icon: images
        });
    }

    //-----------------------------------------------
      
        // Try HTML5 geolocation.
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            var pos = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };


   
             // Do whatever you want with userLatLng.
            var marker = new google.maps.Marker({
                position: pos,
                title: 'Your Location',
                map: map
            });
            

            infoWindow.setPosition(pos);
            infoWindow.setContent('Lokasi Kamu');
            infoWindow.open(map);
            map.setCenter(pos);
          }, function() {
            handleLocationError(true, infoWindow, map.getCenter());
          });
        } else {
          // Browser doesn't support Geolocation
          handleLocationError(false, infoWindow, map.getCenter());
        }
     

      //-----------------------------------------

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

            <div class="panel panel-default"> 
            <div class=panel-heading> <h3 class=panel-title> <a> <img src="layout/images/hpl.png"> HPL </a>
                  <a> <img src="../layout/images/hps.png"> HPS </a>
                  <a> <img src="../layout/images/tl.png"> TL  </a>
                  <a> <img src="../layout/images/sl.png"> SL  </a>
                  <a> <img src="../layout/images/led.png"> LED  </a></h3> 
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
            </div>
			<?php
		}
	?>

    <?php 
    if (isset($_POST['ubahstatus'])) {
        $newStatus = $_POST['status'];
        $idlpju = $_POST['idlpju'];

        echo $newStatus;
        echo $idlpju;

        $queryUbahData = pg_query($db,"UPDATE lpju_banjar SET kondisi = '$newStatus' WHERE id_lpju='$idlpju'");

        if ($queryUbahData) {
            ?>
                <script type="text/javascript">
                    alert("Sukses ubah data");
                </script>
            <?php
        } else {
            ?>
                <script type="text/javascript">
                    alert("Gagal ubah data");
                </script>
            <?php
        }
    }
    ?>
     
  

<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBPu7v8IKDV89TjxHfrBNeT36niaPGUH1Y&callback=initMap">
    </script>

<?php
   include ("../layout/footer.php");
?>



</body>
</html>