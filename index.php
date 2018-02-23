 

<?php 
session_start();
  include ("koneksi.php");         
 
?>

  
<script src="https://maps.googleapis.com/maps/api/js?callback=initMap"></script>
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.15/css/jquery.dataTables.css">
<link rel="stylesheet" href="layout/lbox/css/lightbox.css">

<style>
.imagen {
    border:2px solid #eee;
     display:inline-block;
    width:100px;
    height:100px;
}





</style>

</head>
<body>


<?php
include ("layout/header1.php");
include ("menu.php"); ?>


<div class="jumbotron">

<div class="container">

    <div class="col-lg-6">
    <div class="bg"></div>
    <h2>Laporkan Kondisi Lampu, Sekitarmu!</h2>
        
        <br />
        <div id="formtabel" >
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
             </p> 

             <?php 

             if (!empty($_SESSION['username']))
             { ?>
                <input class="btn btn-success btn-lg btn-block" type="submit" value="Cari" class="inputsubmit" name="inputsubmit"> 
              <?php } else { ?>  

                <input   class="btn btn-success btn-lg btn-block"   value="Cari" onclick="location.href='login.php';">
              <?php  } ?>
        </form>
     </div>
     </div>


    
    
     

</div>

<script>
        var map, marker, infoWindow, kondisi; 
        function initMap() {

        <?php


        if (!empty($_SESSION['username']))
        {


        if ($_POST['inputsubmit']) {

        $carikecamatan=@$_POST['crkcmtn'];  
        $caridesa=@$_POST['crdesa'];
        $carijenistitik=@$_POST['crjnsttk'];
        $carijenislampu=@$_POST['crjnslmp'];
        $carilatitude=@$_POST['crlttd'];
        $carilongitude=@$_POST['crltgd'];
        $caritermeter=@$_POST['crtrmtr'];
        
            
        $query = "SELECT *
                  FROM desa_banjar
                  JOIN  lpju_banjar ON  desa_banjar.kode_kec =  lpju_banjar.nokec AND  desa_banjar.kode_desa =  lpju_banjar.nodesa
                  WHERE kecamatan LIKE '%$carikecamatan%' AND desa LIKE '%$caridesa%' AND jenistitik LIKE '%$carijenistitik%' AND jenislampu LIKE '%$carijenislampu%' AND nonmeter LIKE '%$caritermeter%'
        ORDER BY kode_kec, kode_desa, nolamp ASC ";

        $query2 = "SELECT * FROM data_pju_banjar
        WHERE     kecamatan  LIKE '%$carikecamatan%' AND desa LIKE '%$caridesa%' AND jenistitik LIKE '%$carijenistitik%' AND jenislampu LIKE '%$carijenislampu%' AND nonmeter LIKE '%$caritermeter%'  
        ORDER BY nokec, nodesa, nolamp ASC ";

        $hasil = pg_query($db,$query);
        $hasil2 = pg_query($db,$query2);

        $jmldataresult =pg_num_rows($hasil);


        $lokasi_default = pg_fetch_array($hasil);
        if (empty($jmldataresult)){ ?>
            alert("Data Tidak Ditemukan");
            getCurrentLocation(document.getElementById('map')); 
        <?php } else { ?>

        map = new google.maps.Map(document.getElementById('map'), {
          center: new google.maps.LatLng(<?php echo "$lokasi_default[latitude]"; ?> , <?php echo "$lokasi_default[longitude]";?>),
          zoom: 18
        });
        <?php }
        while ( $data = pg_fetch_array($hasil) )  { ?>
        jenis_lampu= '<?php echo "$data[jenislampu]";?>';

        if (jenis_lampu == "HPL") {
            getMarker(<?php echo "$data[latitude]"; ?>, <?php echo "$data[longitude]";?>, 'layout/images/hpl.png');
        } else if (jenis_lampu == "HPS") {
            getMarker(<?php echo "$data[latitude]"; ?>, <?php echo "$data[longitude]";?>, 'layout/images/hps.png');
        } else if (jenis_lampu == "TL") {
            getMarker(<?php echo "$data[latitude]"; ?>, <?php echo "$data[longitude]";?>, 'layout/images/tl.png');
        } else if (jenis_lampu == "SL") {
            getMarker(<?php echo "$data[latitude]"; ?>, <?php echo "$data[longitude]";?>, 'layout/images/sl.png');
        } else {
            getMarker(<?php echo "$data[latitude]"; ?>, <?php echo "$data[longitude]";?>, 'layout/images/led.png');
        }

        kondisilampu = '<?php echo "$data[kondisi]";?>';
        if ( kondisilampu == "nyala" ) {

        marker.content = '<div class="panel panel-primary"> '+
                        '<div class=panel-heading> <h3 class=panel-title>Info Titik LPJU</h3>' +
                        '</div> <div class=panel-body>'+
                        '<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">' +
                        '<tr><td>ID LPJU</td><td><?php echo "$data[id_lpju]"?></td></tr>'+
                         '<tr><td>Nomor Lampu</td><td><?php echo "$data[nolamp]"; ?></td></tr>'+
                         '<tr><td>Nomor Latitude</td><td><?php echo "$data[latitude]"; ?></td></tr>'+
                         '<tr><td>Nomor Longitude</td><td><?php echo "$data[longitude]";?></td></tr>'+
                         '<tr><td>Kondisi</td><td><?php echo "$data[kondisi]";?></td></tr>'+
                         '<tr><td>Desa</td><td><?php echo "$data[desa]";?></td></tr>'+
                         '<tr><td>Kecamatan</td><td><?php echo "$data[kecamatan]";?></td></tr>'+
                         '<tr><td>jenislampu</td><td><?php echo "$data[jenislampu]";?></td></tr>'+
                         '<tr><td>jenistitik</td><td><?php echo "$data[jenistitik]";?></td></tr>'+

                         '<tr><td>foto<td><img height="100" width="100" src="resources/foto/<?php echo "$data[kode_kec].$data[kode_desa].$data[nolamp]";?>A.JPG" ><img height="100" width="100" src="resources/foto/<?php echo "$data[kode_kec].$data[kode_desa].$data[nolamp]";?>B.JPG" ></td></tr>'+   
                        '</table>'+

                         

                          '<form id="forminput" action="" method="post" >'+
                              '<div id="tabelinput" class="form-group">'+
                            
                              '<input type="hidden" name="idlpju" value="<?php echo "$data[id_lpju]";?>">'+
                              '<input type="hidden" name="date" value="<?php echo date('m/d/Y h:i:s a', time());?>"/>'+
                              '<textarea class="form-control" name="isi" rows="3"><?php $isi ?></textarea>'+
                              '<input type="hidden" name="status" value="aduan">'+
                               '</li>'+
                           
                            
                            '<input class="btn btn-success btn-block" type="submit" value="Laporkan" class="inputsubmit" name="laporkan">  '+ 
                        '</div>'+ 
                        '</form></div></div>';
                    } else {

                      marker.content = '<input class="btn btn-success btn-block"  value="Sudah dilaporkan"  >  '; 
                        


                    }
             

        infoWindow = new google.maps.InfoWindow();
          google.maps.event.addListener(marker, 'click', function () {
           infoWindow.setContent(this.content);
           infoWindow.open(this.getMap(), this);
        });
        <?php
    }
    } else {
       

    } 

  } else {
    header('Location:index.html');;
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

    <br />

     
        

    <?php 
    if (isset($_POST['ubahstatus'])) {
        $newStatus = $_POST['status'];
        $idlpju = $_POST['idlpju'];

        echo $newStatus;
        echo $idlpju;

        $queryUbahData = pg_query($db,"UPDATE lpju_banjar SET kondisi = '$newStatus' WHERE id_lpju='$idlpju'");

        if ($queryUbahData) {
            ?>
                <div class="alert alert-success">
                <strong>Berhasil!</strong> Dilaporkan, Cek <a href="laporan_warga.php">menu laporan</a> warga untuk melihat laporan anda.
                </div>
            <?php
        } else {
            ?>
                <div class="alert alert-danger">
                <strong>Terjadi Kesalahan!</strong> 
                </div>
            <?php
        }
        ?>
</div>
<?php    
    }
  ?>


</div>


 <?php 
  
    if (isset($_POST['laporkan'])) {
        $status = $_POST['status'];
        $id_lpju = $_POST['idlpju'];
        $nama_pengguna = $_SESSION['username'];
        $isi = $_POST['isi'];
        $date = $_POST['date'] ;
        $date = date("Y-m-d H:i:s",strtotime($date));
       

        

        //$queryUbahData = pg_query($db,"UPDATE lpju_banjar SET kondisi = '$newStatus' WHERE id_lpju='$idlpju'");

         $queryUbahData  = pg_query($db,"INSERT INTO laporan (nama_pengguna,status, id_lpju,   isi, date) 
                           values 
                           ( '$nama_pengguna', '$status', '$id_lpju','$isi','$date')");

         $queryUpdateData = pg_query($db,"UPDATE lpju_banjar SET kondisi = 'mati' WHERE id_lpju='$id_lpju'");                  



        if ($queryUbahData && $queryUpdateData ) {


            ?>
                <div class="alert alert-success">
                <strong>Berhasil!</strong> Dilaporkan, Cek <a href="laporan_warga.php">menu laporan</a> warga untuk melihat laporan anda.
                </div>
            <?php
        } else {
            ?>
                <div class="alert alert-danger">
                <strong>Terjadi Kesalahan!</strong> 
                </div>
            <?php
        }
       

    
    }
  ?>


<br />
<br />
 <div class="container">  
 <div class="row">



    <!--DIV MAP-->
    <div class="col-lg-6">
       <table  id="map"  >
      
       </table>
       
    </div>
     <div class="col-lg-6">
     <?php
                if (!empty($jmldataresult)) {
                ?>

        
                <table  id="example" class="table table-striped  " cellspacing="0" width="100%">
                    <thead >
                            <tr >
                            <th>Alamat</th>
                            <th>Kode Lampu</th>
                            <th>Info Gambar</th> 
                            <th>Kondisi </th>                          
                            <th>Status</th>            
                </thead>
                <tbody>
                 <?php
                            $imagepath = "resources/foto/";

                            while ( $data = pg_fetch_array($hasil2) )  { 
                                 echo "<tr>
                                    <td>$data[kecamatan].$data[desa]</td>
                                    <td><a class='btn btn btn-primary btn-xs  ' target='_blank' href='https://www.google.co.id/maps/place/$data[latitude]+$data[longitude]'><span class='glyphicon glyphicon-map-marker' aria-hidden='true'></span> $data[nokec].$data[nodesa].$data[nolamp]</td>

                                    


                                    <td><a class='example-image-link' class='imagen' href='$imagepath$data[foto1].jpg' data-lightbox='example-2'>
                                          <img class='example-image' class='imagen' src='$imagepath$data[foto1].jpg' height='20' width='20' >

                                         </a>

                                         <a class='example-image-link' class='imagen' href='$imagepath$data[foto2].jpg' data-lightbox='example-2' data-title='$data[desa] $data[nokec].$data[nodesa].$data[nolamp]'>
                                          <img class='example-image' class='imagen' src='$imagepath$data[foto2].jpg' height='20' width='20' alt='image-1'>

                                         </a>
                                      <td>$data[kondisi]</td>
                                    </td>
                                    ";

                                    if ( $data['kondisi'] == 'nyala') {
                                      echo "<td><a href='#' class='btn btn-primary btn-xs btn-block'   data-toggle='modal' data-target='#myModal$data[id_lpju]'><span class='glyphicon glyphicon-thumbs-down' aria-hidden='true'></span> Laporkan</a> </td>
                                        </tr>";  

                                    } else {
                                         echo "<td><a href='#' class='btn btn-success btn-xs btn-block'   data-toggle='modal' data-target=''><span class='glyphicon glyphicon-thumbs-up' aria-hidden='true'></span> Sudah Dilaporkan</a> </td>
                                        </tr>"; 

                                    }

                                    
                                    
                                     


                                    ?>

           

            <div id="myModal<?php echo "$data[id_lpju]";?>" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
            <div class="modal-dialog  " role="document">

                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Info PJU</h4>
                  </div>
                  <div class="modal-body">


                              
                         
                             <ul class="list-group">

                             <li class="list-group-item"> 
                                <img height="140" width="140"  src="resources/foto/<?php echo"$data[foto2].jpg";?>" >
                              
                                <img height="140" width="140"  src="resources/foto/<?php echo"$data[foto1].jpg";?>" >
                                 
                             </li>
                            
                              <li class="list-group-item">
                              <li class="list-group-item"><b> Latitude </b>
                                <?php echo "$data[latitude]"; ?>, <b> Longitude </b>
                                <?php echo "$data[longitude]";?> <b> Kondisi </b>
                                <?php echo "$data[kondisi]";?> </li>
                              <li class="list-group-item"><b> Kecamatan </b>
                                <?php echo "$data[kecamatan]";?> ,  <b> Desa </b>
                                <?php echo "$data[desa]"; ?></li>
                               
                              <li class="list-group-item"><b> Jenis Lampu </b>
                                <?php echo "$data[jenislampu]";?> , <b> Jenis titik </b>
                                <?php echo "$data[jenistitik]";?>
                              </li>

                             

                            </ul>


                          <form id="forminput" action="" method="post" >
                          <div id="tabelinput" class="form-group">
                          <label >Bagaimanakah Kondisi PJU di titik ini ? </label>
                          <input type="hidden" name="idlpju" value="<?php echo "$data[id_lpju]";?>">
                          <input type="hidden" name="date" value="<?php echo date('m/d/Y h:i:s a', time());?>"/>
                          <textarea class="form-control" name="isi" rows="3"><?php $isi ?></textarea>
                          <input type="hidden" name="status" value="aduan">
                           
                          </div> 
                            
                             
                  </div>
                  <div class="modal-footer">
                  <input class="btn btn-large btn-primary" type="submit" value="Lamporkan" class="inputsubmit" name="laporkan">                             

                  </form>

                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>
                </div>

              </div>
            </div>

                                    <?php 
                                 }           
                         ?>
                </tbody>
              </table>
            
            <?php
        }
         ?>
    </div>
</div>
   
      

           
                  
 
      <!-- Example row of columns -->
      <div class="row">


        <div class="col-md-4">
          <h2>Tentang Kami</h2>
          <p>Merupakan sebuah media Dinas Penerangan Umumm, dimana melalui website ini seluruh masyarakat dapat berpartisipasi melaporkan kondisi penerangan jalan umum. dengan adanya sistem ini, kerusakan LPJ di kabupaten banjanegara dapat ditangani dengan cepat.</p>
          <p><a class="btn btn-default" href="#" role="button">Lihat details &raquo;</a></p>
        </div>
        <div class="col-md-4">
          <h2>Panduan</h2>
          <p>Pelaporan dapat dilakukan dengan media handphone dan komputer dengan cara membuka browser, pastikan lokasi GPS anda aktif, sehingga sistem dapat mendeteksi lokasi untuk dapat melihat posisi anda lebih akurat didalam melaporakan kondisi PJU . </p>
          <p><a class="btn btn-default" href="#" role="button">Lihat details &raquo;</a></p>
       </div>
        <div class="col-md-4">
          <h2>Kontak Kami</h2>
          <address>
                <strong>Jl. Ahmad Yani No.3, Krandegan, Kec. Banjarnegara, Banjarnegara, Jawa Tengah 53474 <br>
                <abbr title="Phone">
                    P:</abbr>
                 (0286) 591081
            </address>
             
        </div>
      </div>
</div>





<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBPu7v8IKDV89TjxHfrBNeT36niaPGUH1Y&callback=initMap">
    </script>


  <script>
      $(document).ready(function()  {

      $('#example').DataTable();
      } );
  </script>

<script>

$(document).ready(function(){
            $('.imagen[src=""]').hide();
            $('.imagen:not([src=""])').show();
        });

</script>


<script src="layout/lbox/js/lightbox.js"></script>




<?php
include("layout/footer.php");
?>

</body>
</html>