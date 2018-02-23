<?php 
ob_start();          
include ("layout/header.php");
?>
</head>

<body>


<?php
include ("koneksi.php");
include ("menu.php");
		session_start(); // Memulai Session
			$error=''; // Variabel untuk menyimpan pesan error
			if (isset($_POST['submit'])) {
				if (empty($_POST['username']) || empty($_POST['password'])) {
						$error = "Username or Password is invalid";
				}
				else
				{
					// Variabel username dan password
					$user=$_POST['username'];
					$pass=$_POST['password'];
					// Mencegah MySQL injection 
					$user = stripslashes($user);
					$pass = stripslashes($pass);
					$user = pg_escape_string($db,$user);
					$pass = pg_escape_string($db,$pass);
					$query = pg_prepare($db,"user","select * from pengguna where username='$user' and password='$pass'");
					$query = pg_execute($db,"user",array());
					$rows = pg_num_rows($query);
					$data = pg_fetch_array($query);

					if( $rows == '0'){
						echo "<script>alert('User tidak ditemukan');</script>";
						} 
						else{ 
						$_SESSION["level"] = $data["level"];
						$_SESSION["username"] = $data["username"];
						if ($data['verifikasi'] == "ya") {
							if($data["level"] == "admin" ){
							$_SESSION["adminlpjubanjar"]=$data["username"];
							header("location: admin/index.php"); // Mengarahkan ke halaman profil
						}
						else if ($data['level'] == "operator"){
							$_SESSION["operatorlpjubanjar"]=$data["username"];
							header("location: index.php"); // Mengarahkan ke halaman profil
						} else if ($data['level'] == "user") {
							$_SESSION['user'] = $data["username"];
							header("location: index.php"); // Mengarahkan ke halaman profil
						}

						} else {
							echo "<script>alert('User belum terverifikasi');</script>";
						}
					}
				}
			} else if (isset($_POST['register'])) {
				header("location: register.php");
			} 
			
?>

<div class="jumbotron">
<div class="container">
<div class="row">

            <div class="col-lg-8 mb-4">
                <h3>Login </h3>
                <form action="" method="post">
                    <div class="control-group form-group">
                        <div class="controls">
                            <label>Username:</label>
                            <input type="text" class="form-control" id="name" name="username"   type="text">
                            <p class="help-block"></p>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <div class="controls">
                            <label>Password:</label>
                            <input   class="form-control" id="password" name="password"   type="password">
                        </div>
                    </div>
                   
                    <div id="success"></div>
                    <!-- For success/fail messages -->
                    <button type="submit" class="btn btn-primary" name="submit" id="submit" value="Login">Login</button>
                    <button type="submit" class="btn btn-success" name="register" id="submit" value="Login">Register</button>
                </form>
          </div>
          </div>
          </div>

</div>
<script type="text/javascript">
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
</div>
</div>    
<div class="container">
      <!-- Example row of columns -->
      <div class="row">
        <div class="col-md-4">
          <h2>Tentang Kami</h2>
          <p>Merupakan sebuah media Dinas Penerangan Umumm, dimana melalui website ini seluruh masyarakat dapat berpartisipasi melaporkan kondisi penerangan jalan umum. dengan adanya sistem ini diharapkan penanganan listrik dikabupaten banjanegara dapat ditangani dengan cepat.</p>
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
                <strong>Dinas Penerangan Jalan dan Pengelolaan Reklame </strong><br>
               Jl. Pemuda No 148 <br>
                <abbr title="Phone">
                    P:</abbr>
                 (024) 358 3892 
            </address>
            <address>
                <strong>Full Name</strong><br>
                <a href="mailto:#">first.last@example.com</a>
            </address><a class="btn btn-default" href="#" role="button">Lihat details &raquo;</a></p>
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
<?php
include("layout/footer.php");
?>