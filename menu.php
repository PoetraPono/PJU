 <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          

          <a class="navbar-brand" rel="home" href="#" title="Buy Sell Rent Everyting">
          <img style="max-width:260px; margin-top: -12px;" src="logo.png">
           </a>



        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
<?php

  if(isset($_SESSION["adminlpjubanjar"])){
  echo "    
    <li> <a   class='active' href='index.php'> <span class='glyphicon glyphicon-home' aria-hidden='true'></span> Dasboard</a></li>  
    <li> <a   class='active' href='laporan_warga.php'> <span class='glyphicon glyphicon-stats' aria-hidden='true'></span> Laporan Warga</a></li>  
   <li  ><a  class='active' href='laporan_sistem.php'><span class='glyphicon glyphicon-bullhorn aria-hidden='true'></span> Laporan Sistem</a></li>

  
    <li class='dropdown'>
                  <a href='#' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-haspopup='true' aria-expanded='false'>
                  <span class='glyphicon glyphicon-user' aria-hidden='true'></span>
                  Administrator
                  <span class='caret'></span></a>
                  <ul class='dropdown-menu'>
                     
                      <li> <a   class='active' href='admin/index.php'> <span class='glyphicon glyphicon-dashboard' aria-hidden='true'></span> Dashboard Admin</a></li>



                    <li role='separator' class='divider'></li>
                   <li ><a    href='logout.php'> <span class='glyphicon glyphicon-log-out' aria-hidden='true'></span> Logout</a></li>
                  </ul>        
    </li>
   
   

     
";} else if(isset($_SESSION["operatorlpjubanjar"])){
  echo "
  
     <li  ><a  class='active' href='index.php'><span class='glyphicon glyphicon-home' aria-hidden='true'></span> Beranda</a></li>
     <li  ><a  class='active' href='laporan_warga.php'><span class='glyphicon glyphicon-bullhorn aria-hidden='true'></span> Laporan Warga</a></li>
     <li  ><a  class='active' href='laporan_sistem.php'><span class='glyphicon glyphicon-bullhorn aria-hidden='true'></span> Laporan Sistem</a></li>
     
     <li ><a   href='logout.php'>Logout</a></li>
       
       
";} else if(isset($_SESSION["user"])){
  echo "
    <li  ><a  class='active' href='index.php'><span class='glyphicon glyphicon-home' aria-hidden='true'></span> Beranda</a></li>
    <li  ><a  class='active' href='laporan_warga.php'><span class='glyphicon glyphicon-bullhorn aria-hidden='true'></span> Laporan Warga</a></li>
     
     <li ><a   href='logout.php'>Logout</a></li>
       
";}
else {
  echo "
  
    <li  ><a  class='active' href='index.php'><span class='glyphicon glyphicon-home' aria-hidden='true'></span> Beranda</a></li>
    <li  ><a  class='active' href='laporan_warga.php'><span class='glyphicon glyphicon-bullhorn aria-hidden='true'></span> Laporan Warga</a></li>
    
 
    <a   href='login.php'><button class='btn btn-info navbar-btn'>Login</button></a>


       
";}
      
?>
  </ul>
          
    </div>
  </div>
</nav>

<br />

     