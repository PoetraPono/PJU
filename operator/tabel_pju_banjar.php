<?php
  include ("../koneksi.php");
  include('aksesoperator.php'); 
  include ("../layout/header.php");         
  
?>


<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.15/css/jquery.dataTables.css">
 <link rel="stylesheet" href="../layout/lbox/css/lightbox.css">

<style>
    th { font-size: 12px; }
    td { font-size: 11px; }
</style>


</head>
<body>

 

   
<?php           
   
  include ("../menu.php");
  
?>

            

<br />
<br />
 

    <!-- Page Content -->
<div class="container">

      
    
    <div class="row  ">
    


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
        
        
        
        <input class="btn btn-primary" name="tampildata" type="submit" value="TAMPILKAN DATA" class="inputsubmit">
        
        
        <!-- <a href="" class="btn btn-success" id="tombol_export" onClick ="javascript:fnExcelReport();">Export Excel</a>  -->

    </form>
    </div>

    <div class="col-lg-6">
   
       <div class="alert alert-success" role="alert">Informasi   Data Seluruh PJU</div>
     
    </div>

    
    <script>
    $("#select1").change(function() {
          if ($(this).data('options') == undefined) {
            /*Taking an array of all options-2 and kind of embedding it on the select1*/
            $(this).data('options', $('#select2 option').clone());
          }
          var id = $(this).val();
          var options = $(this).data('options').filter('[data-value=' + id + ']');
          $('#select2').html(options);
        });
        
    function fnExcelReport() {
    var tab_text = '<html xmlns:x="urn:schemas-microsoft-com:office:excel">';
    tab_text = tab_text + '<head><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet>';

    tab_text = tab_text + '<x:Name>Test Sheet</x:Name>';

    tab_text = tab_text + '<x:WorksheetOptions><x:Panes></x:Panes></x:WorksheetOptions></x:ExcelWorksheet>';
    tab_text = tab_text + '</x:ExcelWorksheets></x:ExcelWorkbook></xml></head><body>';

    tab_text = tab_text + "<table border='1px'>";
    tab_text = tab_text + $('#example').html();
    tab_text = tab_text + '</table></body></html>';

    var data_type = 'data:application/vnd.ms-excel';

    $('#tombol_export').attr('href', data_type + ', ' + encodeURIComponent(tab_text));
    $('#tombol_export').attr('download', 'PJU_Banjar.xls');

        }
    
    </script>
    
    <?php
  
    if (isset($_POST['tampildata'])) {

        $carikecamatan=@$_POST['crkcmtn'];  
        $caridesa=@$_POST['crdesa'];
        $carijenistitik=@$_POST['crjnsttk'];
        $carijenislampu=@$_POST['crjnslmp'];
        $carilatitude=@$_POST['crlttd'];
        $carilongitude=@$_POST['crltgd'];
        $caritermeter=@$_POST['crtrmtr'];
        //echo $caritermeter;
         
        $query = "SELECT * FROM data_pju_banjar
        WHERE     kecamatan  LIKE '%$carikecamatan%' AND desa LIKE '%$caridesa%' AND jenistitik LIKE '%$carijenistitik%' AND jenislampu LIKE '%$carijenislampu%' AND nonmeter LIKE '%$caritermeter%'  
        ORDER BY nokec, nodesa, nolamp ASC ";
        //latitude LIKE '%$carilatitude%' AND longitude LIKE '%$carilongitude%' ORDER BY nodesa ASC"; 
        $hasil = pg_query($db,$query);
        //$hasil = pg_execute($db,"hasilsearch",array());
        $jmldataresult =pg_num_rows($hasil);
        
    
        
    ?>

        <?php
            if (!empty($jmldataresult)) {
            ?>
            <div class="col-lg-6">
                

                <div class="panel panel-primary"> 

                    <div class=panel-heading> <h3 class=panel-title>Panel title</h3></div>
                        <div class=panel-body> Panel content 
                            <p class="keteranganjumlah">
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
             </div>   
            <?php      
            }   
        ?>
                
    </div>


        <h1><p class="bg-primary">  </p></h1>
        <table  id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead >
                <tr >
                <th>KECAMATAN</th>
                <th>DESA</th>
                <th>LATITUDE</th>
                <th>LONGITUDE</th>
                <th>KODE LAMPU</th>
                <th>TERMETER / TIDAK</th>
                <th>DAYA APP</th>
                <th>JENIS TITIK</th>
                <th>JENIS LAMPU</th>
                <th>DAYA LAMPU</th>
                <th>INFORMASI FOTO</th>
                <th>KONDISI / KETERANGAN</th> 
                <?php 
                if(isset($_SESSION["adminlpjubanjar"])){
                echo "<th>OPERASI</th>";}?>
                </tr>
             
      </thead>
       <tbody>
            <?php
                while ( $data = pg_fetch_array($hasil) )  { 
                     echo "<tr>
                        <td>$data[kecamatan]</td>
                        <td>$data[desa]</td>
                        <td>$data[latitude]</td>
                        <td>$data[longitude]</td>
                        <td><a class='btn btn-success' target='_blank' href='https://www.google.co.id/maps/place/$data[latitude]+$data[longitude]'> $data[nokec].$data[nodesa].$data[nolamp]</a></td>
                        <td>$data[termeter]</td>
                        <td>$data[dayaapp]</td>
                        <td>$data[jenistitik]</td>
                        <td>$data[jenislampu]</td>
                        <td>$data[dayalamp]</td>

                        <td><a class='example-image-link' href='../resources/foto/$data[nokec].$data[nodesa].$data[nolamp]A.JPG' data-lightbox='example-2' data-title='$data[desa] $data[nokec].$data[nodesa].$data[nolamp]'>
                                      <img class='example-image' src='../resources/foto/$data[nokec].$data[nodesa].$data[nolamp]A.JPG' height='20' width='20' >

                                     </a>

                                     <a class='example-image-link' href='../resources/foto/$data[nokec].$data[nodesa].$data[nolamp]B.JPG' data-lightbox='example-2' data-title='$data[desa] $data[nokec].$data[nodesa].$data[nolamp]'>
                                      <img class='example-image' src='../resources/foto/$data[nokec].$data[nodesa].$data[nolamp]B.JPG' height='20' width='20' alt='image-1'>

                                     </a>
                                      
                        </td>



                        <td>$data[kondisi]</td>";
                        if(isset($_SESSION["adminlpjubanjar"])){
                        echo "<td width='10%''><button style='padding:5px'><a href='aksi_edittitikpju.php?idlpju=$data[id_lpju]' 
                        style='text-decoration:none; color:black;'>Edit</a></button>
                        <button style='padding:5px'><a href='aksi_deletetitikpju.php?idlpju=$data[id_lpju]' 
                        onClick='return confirm_delete()' style='text-decoration:none; color:black;'>Hapus</a></button></td>
                        </tr>";   }
                
                     }
                
            
             ?>
    </tbody>
    </table>
</div>



    
    <?php
    }
     ?>
 

 
<footer class="div class="row marketing"">
        <div class="container">
            <p class="m-0 text-center text-white">Copyright &copy; Your Website 2017</p>
        </div>
         
    </footer>

    

    <!-- Bootstrap core JavaScript -->
    <script src="template/vendor/jquery/jquery.min.js"></script>
    <script src="template/vendor/popper/popper.min.js"></script>
    <script src="template/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.15/js/jquery.dataTables.js"></script>
    <script src="../layout/lbox/js/lightbox.js"></script>

    <script>
        $(document).ready(function()  {

        $('#example').DataTable();



        } );
    </script>

</body>

</html>
