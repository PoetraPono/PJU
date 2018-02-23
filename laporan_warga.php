

<html>
<head>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css" type="text/css"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.3.1/css/buttons.dataTables.min.css" type="text/css"/>


    
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

   <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

   <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>


   
    <!-- Custom styles for this template -->
    <link href="template/css/modern-business.css" rel="stylesheet">




    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#example').DataTable( {
                dom: 'Bfrtip',
                buttons: [
                    'copyHtml5',
                    'excelHtml5',
                    'csvHtml5',
                    'pdfHtml5'
                ],
                "order": [[ 2, "asc" ]]
            } );
        } );
    </script>

    <script src="https://maps.googleapis.com/maps/api/js?callback=initMap"></script>

    <style>
    th { font-size: 12px; }
    td { font-size: 14px; }
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



 


 <title>Sistem Informasi Grafis LPJU Kab. Banjarnegara</title>


</head>
<body>

<?php
  session_start();
  include ("koneksi.php");
            
  include ("menu.php");
?>
<div class="container">


<h1>Laporan Warga <span class="badge badge-secondary">New</span></h1>
  <table id="map">
        
    </table>

 

 


<script>
        function initMap() {
        <?php
         
        $carikecamatan=@$_POST['crkcmtn'];  
        $caridesa=@$_POST['crdesa'];
        $carijenistitik=@$_POST['crjnsttk'];
        $carijenislampu=@$_POST['crjnslmp'];
        $carilatitude=@$_POST['crlttd'];
        $carilongitude=@$_POST['crltgd'];
        $caritermeter=@$_POST['crtrmtr'];
        
            
        $query = "SELECT *
                  FROM desa_banjar
                  JOIN  lpju_banjar ON  desa_banjar.kode_kec =  lpju_banjar.nokec AND  desa_banjar.kode_desa =  lpju_banjar.nodesa ,laporan where laporan.id_lpju = lpju_banjar.id_lpju AND laporan.status != 'selesai'
                  ";

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

         
 
            var marker = new google.maps.Marker({
                map: map,
                position: new google.maps.LatLng(<?php echo "$data[latitude]"; ?> , <?php echo "$data[longitude]";?> ),
                icon: 'layout/images/mati.png'
        });

        <?php
        
        if (isset($_SESSION['adminlpjubanjar']) OR isset($_SESSION['operatorlpjubanjar'])){

        ?>
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
                        '<input type="hidden" name="idlaporan" value="<?php echo "$data[id_laporan]";?>">'+
                        '<select class="form-control" name="status" class="searchinput">'+
                        '<option value="<?php echo "$data[status]";?>">Ubah Status</option>'+
                        '<option value="proses">Proses Perbaikan</option>'+
                        '<option value="selesai">Selesai Perbaikan</option>'+
                        '</select>'+
                        '</div>'+ 
                        '  <input class="btn btn-primary" type="submit" value="Ubah Status" class="inputsubmit" name="ubahstatus"> </form></div></div>' ;
         <?php } ?>
          

         
        infoWindow = new google.maps.InfoWindow();
          google.maps.event.addListener(marker, 'click', function () {
           infoWindow.setContent(this.content);
           infoWindow.open(this.getMap(), this);
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

        //echo $caritermeter;
         
        $query = "SELECT * FROM laporan
           
        ORDER BY date ASC ";
         
        $hasillaporan = pg_query($db,$query);
        
        $jmldataresult =pg_num_rows($hasillaporan);
?>




     <?php 
  
    if (isset($_POST['ubahstatus'])) {
        $status = $_POST['status'];
        $idlaporan = $_POST['idlaporan'];
       
        //echo $idlaporan;

        

        $queryUpdateData = pg_query($db,"UPDATE laporan SET status = '$status' WHERE id_laporan='$idlaporan'");

          
       // $queryupdate =pg_query($db,$queryUpdateData);

        if ( $queryUpdateData) {


            ?>
               <div class="alert alert-success">
                <strong>Berhasil!</strong>Dirubah 
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



    <h1><p class="bg-primary">  </p></h1>
        <table  id="example" class="table table-striped  " cellspacing="0" width="100%">
        <thead >
                <tr >
                <th>id_laporan</th>
                <th>Tanggal Laporan</th>
                <th>Isi Laporan</th>
                <th>Titik LPJU</th>
                <th>Pelapor</th>
                <th>status</th>
                
                 
             
      </thead>
       <tbody>
            <?php
                while ( $data = pg_fetch_array($hasillaporan) )  { 
                     echo "<tr>
                        <td><div class='list-group-item list-group-item-info'>$data[id_laporan]</td>
                        <td> <span class='glyphicon glyphicon-calendar' aria-hidden='true'> $data[date] </td>
                        <td>$data[isi]</td>
                        <td><div class='list-group-item list-group-item-warning'><span class='glyphicon glyphicon-map-marker' aria-hidden='false'> $data[id_lpju]</td>
                        <td><div class='list-group-item list-group-item-info'><span class='glyphicon glyphicon-user'></span> $data[nama_pengguna]</td>

                         
                         
                         ";   
                         ?>
                        
                      <?php
                      $status = $data['status'];

                      if ($status == "proses" ) {
                        echo " <td><a href='#' class='btn btn-warning btn-block' data-toggle='modal' data-target='#myModal$data[id_laporan]'> <span class='glyphicon glyphicon-wrench'></span>  Proses Perbaikan </td>";

                      } else if ($status == "aduan" ){
                        echo " <td><a href='#' class='btn btn-danger btn-block' data-toggle='modal' data-target='#myModal$data[id_laporan]'><span class='glyphicon glyphicon-send'></span> Laporan Masuk </td>";
                      }else {
                        echo " <td><a href='#' class='btn btn-success btn-block' data-toggle='modal' data-target='#myModal$data[id_laporan]'>  Selesai Perbaikan </td>";
                      }
                      ?>

                      
            <?php 

            if (isset($_SESSION['adminlpjubanjar']) OR isset($_SESSION["operatorlpjubanjar"])){ ?>

            <div id="myModal<?php echo "$data[id_laporan]";?>" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
            <div class="modal-dialog" role="document">

                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Ubah Status</h4>
                  </div>
                  <div class="modal-body">

                  <form id="forminput" action="" method="post" >
                        <div id="tabelinput" class="form-group">


                     <small   class="form-text text-muted"><?php echo "$data[id_laporan]";?></small>
                      <small   class="form-text text-muted"><?php echo "$data[isi]";?></small>

                       <input type="hidden" name="idlaporan" value="<?php echo "$data[id_laporan]";?>">
                        <input type="hidden" name="idlpju" value="<?php echo "$data[id_lpju]";?>">
                        <select class="form-control" name="status" class="searchinput">
                        <option value="aduan">Ubah Status</option>
                        <option value="proses">Proses Perbaikan</option>
                        <option value="Selesai">Selesai Perbaikan</option>
                        </select>
                        </div>
                        
                          
                            
                             
                  </div>
                  <div class="modal-footer">
                  <input class="btn btn-large btn-primary" type="submit" value="Ubah Status" class="inputsubmit" name="ubahstatus">                             

                  </form>

                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>
                </div>

              </div>
            </div>



            <?php
            } else {

            }
          }

            
             ?>
    </tbody>
    </table>

    
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBPu7v8IKDV89TjxHfrBNeT36niaPGUH1Y&callback=initMap">
    </script>
  
<?php
include("layout/footer.php");
?>
</body>
</html>