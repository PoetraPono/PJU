
<?php
  include('aksesoperator.php');          
  include ("../koneksi.php");
?>
<link rel="stylesheet" href="../layout/phi/jquery.circliful.css"">
<link rel="stylesheet" href="../layout/phi/material-design-iconic-font.min.css"">
 
</head>
<body>

 

<?php           
include ("../layout/header.php");
 

  include ("../menu.php");
?>

<div class="jumbotron">
      <div class="container">
         
                    <div class="col-lg-2">
                        <div id="test-circle"></div>
                    </div>

                    <div class="col-lg-2">
                        <div id="test-circle2"></div>
                    </div>
                    

                    <div class="col-lg-2">
                        <div id="test-circle3"></div>
                    </div>

                    <div class="col-lg-2">
                        <div id="test-circle4"></div>
                    </div>

                    <div class="col-lg-2">
                        <div id="test-circle5"></div>
                    </div>

                    <div class="col-lg-2">
                        <div id="test-circle6"></div>
                    </div>
            
      </div>
 </div>


<div class="container">

 
 <div class="container">
         
                    <div class="col-lg-2">
                        <div id="test-circle7"></div>
                    </div>

                    <div class="col-lg-2">
                        <div id="test-circle8"></div>
                    </div>
                    

                    <div class="col-lg-2">
                        <div id="test-circle9"></div>
                    </div>

                    <div class="col-lg-2">
                        <div id="test-circle10"></div>
                    </div>

                    <div class="col-lg-2">
                        <div id="test-circle11"></div>
                    </div>

                    <div class="col-lg-2">
                        <div id="test-circle12"></div>
                    </div>
 
 

                    
            
      </div>

</div>


<div class="container">
 
      <div class="row">
         
      </div>
</div>
  


  <?php
  
  $querykecamatan = pg_query( $db," 
    select 
    count(nullif(termeter,'')) as termeter,
    count(nullif(nonmeter,'')) as nonmeter,
    count(nullif(kondisi,'nyala')) as kondisimati,
    count(nullif(kondisi,'mati')) as kondisinyala,
    count(*) as total

    from lpju_banjar
    ");

  
     
  while($row = pg_fetch_array($querykecamatan)){
              $termeter = $row["termeter"];
              $nonmeter = $row["total"] - $row["termeter"];
              $kondisinyala =$row["total"] - $row["kondisinyala"];
              $kondisimati =$row["total"] - $row["kondisimati"];
              $total= $row["total"];
               }      
  ?>
  
    


 <script src="../layout/phi/jquery.circliful.js"></script>

<script>
    $( document ).ready(function() { // 6,32 5,38 2,34
        $("#test-circle").circliful({
            animation: 1,
            animationStep: 6,
            foregroundBorderWidth: 15,
            backgroundBorderWidth: 15,
            fillColor: '#eee',
            percent:  <?php echo $termeter/$total ?>*100,
            iconColor: '#3498DB',
            icon: 'f283',
            iconSize: '40',
            iconPosition: 'middle',
            textColor: '#666',
            text: '<?php echo $termeter ?> Termeter',
            textBelow: true
        });

        $("#test-circle2").circliful({
            animation: 1,
            animationStep: 6,
            foregroundBorderWidth: 15,
            backgroundBorderWidth: 15,
            fillColor: '#eee',
            percent: <?php echo $total-$termeter ?>/<?php echo $total ?>*100,
              iconColor: '#3498DB',
            icon: 'f283',
            iconSize: '40',
            iconPosition: 'middle',
            textColor: '#666',
            text: '<?php echo $nonmeter ?> Nonmeter',
            textBelow: true
        });



        $("#test-circle3").circliful({
            animation: 1,
            animationStep: 6,
            foregroundBorderWidth: 15,
            backgroundBorderWidth: 15,
            fillColor: '#eee',
            percent: <?php echo $kondisinyala / $total ?> *100,
              iconColor: '#3498DB',
            icon: 'f0eb',
            iconSize: '40',
            iconPosition: 'middle',
            textColor: '#666',
            text: ' <?php echo $kondisinyala ?> Mati ',
            textBelow: true
        });

        $("#test-circle4").circliful({
            animation: 1,
            animationStep: 6,
            foregroundBorderWidth: 15,
            backgroundBorderWidth: 15,
            fillColor: '#eee',
            percent: <?php echo $kondisimati / $total ?> *100,
              iconColor: '#3498DB',
            icon: 'f0eb',
            iconSize: '40',
            iconPosition: 'middle',
            textColor: '#666',
            text: ' <?php echo $kondisimati ?> Menyala ',
            textBelow: true
        });

        $("#test-circle5").circliful({
            animation: 1,
            animationStep: 6,
            foregroundBorderWidth: 15,
            backgroundBorderWidth: 15,
            fillColor: '#eee',
            percent: <?php echo $kondisinyala / $total ?> *100,
              iconColor: '#3498DB',
            icon: 'f1e6',
            iconSize: '40',
            iconPosition: 'middle',
            textColor: '#666',
            text: ' <?php echo $kondisinyala ?> Mati ',
            textBelow: true
        });

        $("#test-circle6").circliful({
            animation: 1,
            animationStep: 6,
            foregroundBorderWidth: 15,
            backgroundBorderWidth: 15,
            fillColor: '#eee',
            percent: <?php echo $kondisimati / $total ?> *100,
              iconColor: '#3498DB',
            icon: 'f1e6',
            iconSize: '40',
            iconPosition: 'middle',
            textColor: '#666',
            text: ' <?php echo $kondisimati ?> Menyala ',
            textBelow: true
        });


        // JENIS LAMPU

         $("#test-circle7").circliful({
            animation: 1,
            animationStep: 6,
            foregroundBorderWidth: 15,
            backgroundBorderWidth: 15,
            fillColor: '#eee',
            percent:  <?php echo $termeter/$total ?>*100,
            iconColor: '#3498DB',
            icon: 'f283',
            iconSize: '40',
            iconPosition: 'middle',
            textColor: '#666',
            text: '<?php echo $termeter ?> Termeter',
            textBelow: true
        });

        $("#test-circle8").circliful({
            animation: 1,
            animationStep: 6,
            foregroundBorderWidth: 15,
            backgroundBorderWidth: 15,
            fillColor: '#eee',
            percent: <?php echo $total-$termeter ?>/<?php echo $total ?>*100,
              iconColor: '#3498DB',
            icon: 'f283',
            iconSize: '40',
            iconPosition: 'middle',
            textColor: '#666',
            text: '<?php echo $nonmeter ?> Nonmeter',
            textBelow: true
        });



        $("#test-circle9").circliful({
            animation: 1,
            animationStep: 6,
            foregroundBorderWidth: 15,
            backgroundBorderWidth: 15,
            fillColor: '#eee',
            percent: <?php echo $kondisinyala / $total ?> *100,
              iconColor: '#3498DB',
            icon: 'f283',
            iconSize: '40',
            iconPosition: 'middle',
            textColor: '#666',
            text: ' <?php echo $kondisinyala ?> Mati ',
            textBelow: true
        });

        $("#test-circle10").circliful({
            animation: 1,
            animationStep: 6,
            foregroundBorderWidth: 15,
            backgroundBorderWidth: 15,
            fillColor: '#eee',
            percent: <?php echo $kondisimati / $total ?> *100,
              iconColor: '#3498DB',
            icon: 'f283',
            iconSize: '40',
            iconPosition: 'middle',
            textColor: '#666',
            text: ' <?php echo $kondisimati ?> Menyala ',
            textBelow: true
        });
 
        $("#test-circle11").circliful({
            animation: 1,
            animationStep: 6,
            foregroundBorderWidth: 15,
            backgroundBorderWidth: 15,
            fillColor: '#eee',
            percent: <?php echo $kondisimati / $total ?> *100,
              iconColor: '#3498DB',
            icon: 'f283',
            iconSize: '40',
            iconPosition: 'middle',
            textColor: '#666',
            text: ' <?php echo $kondisimati ?> Maaaa ',
            textBelow: true
        });

        $("#test-circle12").circliful({
            animation: 1,
            animationStep: 6,
            foregroundBorderWidth: 15,
            backgroundBorderWidth: 15,
            fillColor: '#eee',
            percent: <?php echo $kondisimati / $total ?> *100,
              iconColor: '#3498DB',
            icon: 'f283',
            iconSize: '40',
            iconPosition: 'middle',
            textColor: '#666',
            text: ' <?php echo $kondisimati ?> Maaaa ',
            textBelow: true
        });

         
         
        
          
         
    });
</script>           
            
<?php
   include ("../layout/footer.php");
?>

