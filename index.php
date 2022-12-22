<!DOCTYPE html>
<html>

    <head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <title>TWO TIER KELOMPOK 5</title>
        <nav class="navbar navbar-dark shadow-sm">
            <div class="container">
                <b  class="navbar-brand nav-link active text-center  dark" href="#">TWO TIER</b>       
            </div>
         </nav>
    </head>

    
<body>
    <?php
    require("sistem/koneksi.php");
    session_start();
$users = [
    [
        "name" => "ADMIN",
        "role" => "admin",
        "username" => "admin", 
        "password" => "21232f297a57a5a743894a0e4a801fc3"
    ],
    [
        "name" => "MUTIARA",
        "role" => "mutiara",
        "username" => "mutiara", 
        "password" => "ee11cbb19052e40b07aac0ca060c23ee"
    ],

    [
        "name" => "ANDRA",
        "role" => "andra",
        "username" => "andra", 
        "password" => "ee11cbb19052e40b07aac0ca060c23ee"
    ],

    [
        "name" => "IREN",
        "role" => "iren",
        "username" => "iren", 
        "password" => "ee11cbb19052e40b07aac0ca060c23ee"
    ],

    [
        "name" => "MELANI",
        "role" => "melani",
        "username" => "melani", 
        "password" => "ee11cbb19052e40b07aac0ca060c23ee"
    ],

    [
        "name" => "FADIL AI",
        "role" => "fadil",
        "username" => "fadil", 
        "password" => "ee11cbb19052e40b07aac0ca060c23ee"
    ]
];

    $pdo = open_connection();
    $a = @$_GET["a"];
    $id = @$_GET["id"];
    $sql = @$_POST["sql"];
    switch ($sql) {
        case "create":
            create_prodi();
            break;
        case "update":
            update_prodi();
            break;
        case "delete":
            delete_prodi();
            break;
    }
    switch ($a) {
        case "list":
            read_data();
            break;
        case "input":
            input_data();
            break;
        case "edit":
            edit_data($id);
            break;
        case "hapus";
            hapus_data($id);
            break;
        case "logout":
            logout();
            break;
        default:
            login();
            break;
    }
    ?>

<?php
    function login() {
        
        ?>

<section class="h-100">
		<div class="container h-100">
			<div class="row justify-content-sm-center h-100">
				<div class="col-xxl-4 col-xl-5 col-lg-5 col-md-7 col-sm-9">
					<div class="text-center my-5">
						<img src="gambar.png" alt="logo">
					</div>
					<div class="card shadow-lg">
						<div class="card-body p-5">
							<h1 class="fs-4 card-title fw-bold mb-4">Login</h1>
							<form method="POST" class="needs-validation" novalidate="" autocomplete="off" name="latihan" onsubmit="return validate()">
								<div class="mb-3">
									<label class="mb-2 text-muted" for="email">Username</label>
									<input id="email" type="text" class="form-control" name="username" value="" required autofocus>
									<div class="invalid-feedback">
										Username Yang Valid
									</div>
								</div>

								<div class="mb-3">
									<div class="mb-2 w-100">
										<label class="text-muted" for="password">Password</label>
									</div>
									<input id="password" type="password" class="form-control" name="password" required>
								    <div class="invalid-feedback">
								    	Password is required
							    	</div>
								</div>

								<div class="d-flex align-items-center">
									<button type="submit" name="action" class="btn btn-primary ms-auto">
										Login
									</button>
								</div>
							</form>
						</div>
						<div class="card-footer py-3 border-0">
						</div>
					</div>
					<div class="text-center mt-5 text-muted">
						Copyright &copy; 2022 &mdash; Kelompok 5
					</div>
				</div>
			</div>
		</div>
	</section>
        
    <?php 
        global $users;
        if (isset($_POST['action'])) {
            $username = $_POST['username'];
            $password = md5($_POST['password']);

            $user = $users[array_search($username, array_column($users, 'username'))];
            if ($user['password'] == $password && $user['username'] == $username) {
                $_SESSION['user'] = $user;
                echo '<meta http-equiv="refresh" content="0;?a=list">';
            }else {
                echo ' <script> alert("Username/Password salah") </script>';
            }
        }
    } ?>

    <?php
    function read_data() {
        if (!isset($_SESSION['user'])) {
            header('location:?a=');
        }

        global $pdo;
        $query = $pdo->prepare ("select * from dt_prodi");
        $query->execute()?>

    <div class="container p-5">
    <h2>Selamat datang, <?= $_SESSION['user']['name']; ?></h2>
    <?php if($_SESSION['user']['role'] == 'admin') { ?><a href="index.php?a=input"class="btn btn-secondary mb-1">INPUT</a><?php } ?> <a href="?a=logout"class="btn btn-danger mb-1">LOG-OUT</a>

        <div class="card">
                <div class="card-header bg-dark text-white">
                    <h4 class="card-title">Read Data Program Studi</h4>            
                
                </div>
            <div class="card-body"> 
                <div class="table-responsive auto">
                    <table class="table table-bordered table-striped ">
                    <table class="table table-dark table-striped">
                    <div style="overflow-x:auto;">
                    <table id="table_id" class="table table-striped table-dark mydatatable" width="100%">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">KODE PRODI</th>
                            <th scope="col">NAMA PRODI</th>
                            <th scope="col">AKREDITASI</th>
                            <th scope="col">AKSI</th>
                        </tr>
                    </thead>        
        
                    <tbody>
                        <?php $no=1; ?>
                        <?php while($row = $query->fetch()) { ?>
                        <tr>
                            <td><?=$no++; ?></td>
                            <td><?php echo $row['kdprodi']; ?></td>
                            <td><?php echo $row['nmprodi']; ?></td>
                            <td><?php echo $row['akreditasi']; ?></td>
                            <td class="btn-class">
                                <a href="index.php?a=edit&id=<?php echo $row['idprodi']; ?>" 
                                    onclick="javascript:return confirm('Apakah ingin mengedit data ini ?')"
                                    class="btn btn-primary">
                                    Edit
                                </a>
                            
                                <a value="Hapus" href="index.php?a=hapus&id=<?php echo $row['idprodi'];?>" 
                                    onclick="javascript:return confirm('Apakah ingin menghapus data ini ?')"
                                    class="btn btn-danger">
                                    Hapus
                                </a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                    </table>
                </table>
                
                </br>
                    <footer class="bg-dark text-center text-white">               
                        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
                            © 2022 Copyright:
                            <a class="text-white" href="https://www.linkedin.com/in/fadil-ainuddin-aa8677156">Kelompok || 5</a>
                        </div>
                    </footer>
            </div>
                
    <?php } ?>

    <?php
    function input_data() {
        $row = array(
            "kdprodi" => "",
            "nmprodi" => "",
            "akreditasi" => "-"

        );  
        
    ?>

        <div class="container p-5">
            <a href="index.php?a=list"class="btn btn-secondary mb-1">Kembali</a>
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h4 class="card-title">Input Data Program Studi</h4>
                </div>

                <div class="card-body">
                    <form  name="latihan"  method="POST" action="index.php?a=list" onsubmit="return validate()">
                        <input type="hidden" name="sql" value="create">
                        <div class="form-group justify-center">
                            <label for=""><b>Kode Prodi</b></label>
                            <input type="text" name="kdprodi" class="form-control" maxlength="6" size="6" placeholder="Masukkan Kode Prodi" value="<?php echo trim($row['kdprodi']) ?>">
                        </div>
                                                
                        <div class="form-group justify-center">
                            <label for=""><b>Nama Prodi</b></label>
                            <input type="text" name="nmprodi" class="form-control" maxlength="70" size="70" placeholder="Masukkan Nama Prodi" value="<?php echo trim($row['nmprodi']) ?>" />
                        </div>

                        <div class="form-group justify-center">
                            <label for=""><b>Akreditasi</b></label>
                            <input type="radio" name="akreditasi" value="-" <?php if ($row["akreditasi"]=='-' || $row["akreditasi"]=='') { echo 
                            "checked=\"checked\"";} else {echo ""; } ?>> -
                            <input type="radio" name="akreditasi" value="A" <?php if ($row["akreditasi"]=='A') {echo "checked=\"checked\""; } 
                            else {echo ""; } ?>> A
                            <input type="radio" name="akreditasi" value="B" <?php if ($row["akreditasi"]=='B') {echo "checked=\"checked\""; } 
                            else {echo ""; } ?>> B
                            <input type="radio" name="akreditasi" value="C" <?php if ($row["akreditasi"]=='C') {echo "checked=\"checked\""; } 
                            else {echo ""; } ?>> C
                        </div>
                        </div>
                        
                        <button class="btn btn-success" type="submit" name="action" value="Simpan">Tambah Data</button>
                    </form>
                    </br>
                    
                    <footer class="bg-dark text-center text-white">
                        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
                            © 2022 Copyright:
                            <a class="text-white" href="https://www.linkedin.com/in/fadil-ainuddin-aa8677156">Kelompok || 5</a>
                        </div>
                    </footer>
                    
                </div>
            </div>
        </div>
    <?php } ?>

    <?php
    function edit_data($id) {
        admin_only();
        if ($_SESSION['user']['role'] !== 'admin') {
            echo '<script> alert("permission denied") </script>';
            header('location:?a=list');
        }
        global $pdo;

        $query = $pdo->prepare ("select * from dt_prodi where idprodi = $id");
        $query->execute();
        $row = $query->fetch()?>

    <div class="container p-5">
            <a href="index.php?a=list"class="btn btn-secondary mb-1">Batal</a>
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h4 class="card-title">Edit Data Program Studi</h4>
                </div>

                <div class="card-body">
                    <form method="POST" action="index.php?a=list">
                        <input type="hidden" name="sql" value="update">
                        <input type="hidden" name="idprodi" value="<?php echo trim ($id)?>">
                        <div class="form-group justify-center">
                            <label for=""><b>Kode Prodi</b></label>
                            <input type="text" name="kdprodi" class="form-control"  value="<?php echo trim($row['kdprodi']) ?>">
                        </div>
                                                
                        <div class="form-group justify-center">
                            <label for=""><b>Nama Prodi</b></label>
                            <input type="text" name="nmprodi" class="form-control" value="<?php echo trim($row['nmprodi']) ?>" />
                        </div>

                        <div class="form-group justify-center">
                            <label for=""><b>Akreditasi</b></label>
                            <input type="radio" name="akreditasi" value="-" <?php if ($row["akreditasi"]=='-' || $row["akreditasi"]=='') { echo 
                            "checked=\"checked\"";} else {echo ""; } ?>> -
                            <input type="radio" name="akreditasi" value="A" <?php if ($row["akreditasi"]=='A') {echo "checked=\"checked\""; } 
                            else {echo ""; } ?>> A
                            <input type="radio" name="akreditasi" value="B" <?php if ($row["akreditasi"]=='B') {echo "checked=\"checked\""; } 
                            else {echo ""; } ?>> B
                            <input type="radio" name="akreditasi" value="C" <?php if ($row["akreditasi"]=='C') {echo "checked=\"checked\""; } 
                            else {echo ""; } ?>> C
                        </div>
                        </div>
                    
                        <button class="btn btn-success" type="submit" name="action" value="Simpan">Simpan Perubahan</button>
                    </form>
                    </br>
                    <footer class="bg-dark text-center text-white">
                        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
                            © 2022 Copyright:
                            <a class="text-white" href="https://www.linkedin.com/in/fadil-ainuddin-aa8677156">Kelompok || 5</a>
                        </div>
                    </footer>
                </div>
            </div>
        </div>
    <?php } ?>

    <?php
    function hapus_data($id) {
        admin_only();
        global $pdo;
        $query = $pdo->prepare(" select * from dt_prodi where idprodi = $id");
        $query->execute();
        $row = $query->fetch()?>

    <div class="container p-5">
            <a href="index.php?a=list"class="btn btn-secondary mb-1">Batal</a>
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h4 class="card-title">Hapus Data Program Studi</h4>
                </div>

                <div class="card-body">
                    <form method="POST" action="index.php?a=list">
                        <input type="hidden" name="sql" value="delete">
                        <input type="hidden" name="idprodi" value="<?php echo trim ($id)?>">
                        <div class="table-responsive auto">
                        <table class="table table-bordered table-striped ">
                        <div style="overflow-x:auto;">
                            <table id="table_id" class="table table-striped table-dark mydatatable" width="100%">
                                <tr>
                                    <td>KODE PRODI</td>
                                    <td><?php echo trim($row["kdprodi"]) ?></td>
                                </tr>
                                <tr>
                                    <td>NAMA PRODI</td>
                                    <td><fm-1><?php echo trim($row["nmprodi"]) ?></fm-1></td>
                                </tr>
                                <tr>
                                    <td>AKREDITASI</td>
                                    <td><?php echo trim($row["akreditasi"]) ?></td>
                                </tr>
                            </table>
                        </div>
                        </div>
                    
                        <button class="btn btn-danger" type="submit" name="action" value="Hapus"  
                                onclick="javascript:return confirm('Apakah ingin menghapus data ini ?')">Hapus Data</button>
                    </form>
                    </br>
                    <footer class="bg-dark text-center text-white">
                        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
                            © 2022 Copyright:
                            <a class="text-white" href="https://www.linkedin.com/in/fadil-ainuddin-aa8677156">Kelompok || 5</a>
                        </div>
                    </footer>

    </main>
                </div>
            </div>
        </div>
    <?php } ?>

    <?php
        function create_prodi() {
            admin_only();
            global $pdo;
            global $_POST;

           $query = $pdo->prepare("INSERT INTO dt_prodi(kdprodi, nmprodi, akreditasi) VALUES (:kdprodi, :nmprodi, :akreditasi)");

           $row =[
            'kdprodi' => $_POST["kdprodi"],
            'nmprodi' => $_POST["nmprodi"],
            'akreditasi' => $_POST["akreditasi"],
           ];

           $query->execute($row);
           return;

        }

        function update_prodi() {
            admin_only();
            global $pdo;
            global $_POST;


            $query =$pdo->prepare("UPDATE dt_prodi set kdprodi = :kdprodi, nmprodi = :nmprodi, akreditasi = :akreditasi WHERE idprodi= :id");

            $row =[
                'kdprodi' => $_POST["kdprodi"],
                'nmprodi' => $_POST["nmprodi"],
                'akreditasi' => $_POST["akreditasi"],
                'id' => $_POST["idprodi"],

               ];

               $query->execute($row);
               return;
            
        }
        
        function delete_prodi() {
            admin_only();
            global $pdo;
            global $_POST;

            $query = $pdo->prepare("DELETE FROM dt_prodi WHERE idprodi = :idprodi");
           
            $row =[
                ':idprodi' => $_POST["idprodi"]
            ];
           
            $query->execute($row);
               return;
        }

        function logout()
        {
            session_destroy();
            session_unset();
            header('Location:?a=');
        }
    
        function admin_only() {
            if ($_SESSION['user']['role'] !== 'admin') {
                echo '<script> alert("permission denied") </script>';
                header('location:?a=list');
            }
        }
    ?>

</body>
<script type="text/javascript">
    function validate() {
        if (document.forms["latihan"]["kdprodi"].value == "") {
            alert("Kode Prodi Tidak Boleh Kosong");
            document.forms["latihan"]["kdprodi"].focus();
            return false;
        }
        if (document.forms["latihan"]["nmprodi"].value == "") {
            alert("Nama Prodi Tidak Boleh Kosong");
            document.forms["latihan"]["nmprodi"].focus();
            return false;
        }
        if (document.forms["latihan"]["akreditasi"].selectedIndex < 1) {
            alert("Pilih akreditasi");
            document.forms["latihan"]["akreditasi"].focus();
            return false;
        }
    }
</script>




<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" 
    rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">



</html>