<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "database_kelas";

$koneksi = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) {
    die("Database tidak terhubung");
}

$username = "";
$password = "";
$sukses ="";
$error ="";

if (isset($_GET['op'])) {
    $op = $_GET['op'];
}else{
    $op = "";
}

if($op == 'delete'){
    $id = $_GET['id'];
    $sql1 = "delete from datakelas23b where id = '$id'";
    $q1 = mysqli_query($koneksi, $sql1);
    if($q1){
        $sukses = "Data berhasil dihapus";
    }else{
        $error = "Data gagal dihapus";
    }
}

if($op == 'edit'){
    $id = $_GET['id'];
    $sql1 = "select * from datakelas23b where id = '$id'";
    $q1 = mysqli_query($koneksi , $sql1);
    $r1 = mysqli_fetch_array($q1);
    $username = $r1['username'];
    $password = $r1['password'];

    if($username == ''){
        $error = "Data tidak valid";
    }
}

if (isset($_POST['save'])) { //creat data
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username && $password) {
        if($op == 'edit'){ //update data
            $sql1 = "update datakelas23b set username = '$username', password = '$password' where id = '$id'";
            $q1 = mysqli_query($koneksi , $sql1);
            if($q1){
                $sukses = "Data berhasil diperbarui";
            }else{
                $error = "Data gagal diperbarui";
            }
        }else{ //memasukkan data
            $sql1 = "insert into datakelas23b (username, password) values ('$username','$password')";
            $q1 = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses = "Data berhasil dimasukkan";
            } else {
                $error = "Input data gagal";
            }
        }

    }else{
        $error = "Silahkan masukkan semua data";
    }
}
?>

<!-- website html -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kelas TE-23B</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <style>
        .mx-auto {
            width: 800px;
        }

        .card {
            margin-top: 10px;
        }
    </style>
</head>

<body class="bg-dark">
    <div class="mx-auto text-center" >
        <!-- memasukan Data -->
        <div class="card center">
            <div class="card-header center">
                Buat / Edit
            </div>
            <div class="card-body">
                <?php
                if($error){
                ?>
                    <div class="alert alert-danger" role="alert">
                        <?php  echo $error; ?>
                    </div>
                    <?php 
                    header("refresh:4;url=index.php"); //refresh web 2 detik   
                }
                ?>
                <?php
                if($sukses){
                ?>
                    <div class="alert alert-success" role="alert">
                        <?php  echo $sukses; ?>
                    </div>
                    <?php
                    header("refresh:2;url=index.php"); //refresh web 2 detik
                }
                ?>

                <form action="" method="POST">
                    <div class="mb-3 row">
                        <label for="username" class="col-sm-2 col-form-label">username</label>
                        <div class="col-sm-10">
                            <input type="numeric" class="form-control" id="username" name="username" value="<?php echo $username ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="password" class="col-sm-2 col-form-label">password</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" id="password" name="password" value="<?php echo $password ?>">
                        </div>
                    </div>
                    <div class="col-12">
                        <input  type="submit" name="save" value="simpan Data" class="btn btn-primary" />
                    </div>
                </form>
            </div>
        </div>
        <!-- mengeluarkan Data -->
        <div class="card">
            <div class="card-header text-white bg-secondary">
                Data Kelas
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">USERNAME</th>
                            <th scope="col">PASSWORD</th>
                            <th scope="col">AKSI</th>
                        </tr>
                        <tbody>
                            <?php
                            $sql2 = "select * from datakelas23b order by id desc";
                            $q2 = mysqli_query($koneksi , $sql2);
                            $urut = 1;
                            while($r2 = mysqli_fetch_array($q2)){
                                $id = $r2['id'];
                                $username = $r2['username'];
                                $password = $r2['password'];

                                ?>

                                <tr>
                                    <th scope="row"><?php echo $urut++ ?></th>
                                    <td scope="row"><?php echo $username ?></td>
                                    <td scope="row"><?php echo $password ?></td>
                                    <td scope="row">
                                        <a href="index.php?op=edit&id=<?php echo $id?>"><button type="button" class="btn btn-warning">Edit</button></a>
                                        <a href="index.php?op=delete&id=<?php echo $id?>" onclick="return confirm('Apakah anda yakin untuk menghapus data tersebut?')"><button type="button" class="btn btn-danger">Delete</button></a>
                                        <!-- <button type="button" class="btn btn-danger">Delate</button> -->
                                    </td>
                                </tr>

                                <?php
                            }
                            ?>
                        </tbody>
                    </thead>
                </table>
                <form action="" method="POST">

                </form>
            </div>
        </div>
    </div>

</body>

</html>