<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <script src="node_modules/sweetalert2/dist/sweetalert2.all.js"></script>
</body>
</html>
<?php
    include 'koneksi.php';

    echo "<script src='node_modules/sweetalert2/dist/sweetalert2.all.js'></script>";

    //Membuat ID Pelanggan Otomatis
    $queryKode = "SELECT max(id_film) as newKode from film";
    $hasil = mysqli_query($conn, $queryKode);
    $data = mysqli_fetch_array($hasil);

    $newKode = $data['newKode'];
    $kodeUrut = (int) substr($newKode, 2, 3);

    $kodeUrut++;
    $char = 'MV';
    $kodeId = $char . sprintf("%03s", $kodeUrut);
    //--Membuat ID Selesai

    //PROSES MENAMBAH DATA ---------------------------------------------------------
    if (isset($_POST['aksi'])) {
        if($_POST['aksi']=="add"){

            $namaFilm = $_POST['nama'];
            $genre = $_POST['genre'];
            $tahunRilis = $_POST['tahun'];
            $cekNama = mysqli_query($conn,"SELECT nama_film FROM film WHERE nama_film = '$namaFilm'");
            $cek = mysqli_num_rows($cekNama);
            // $query = "INSERT INTO film (id_film,nama_film,genre,tahun_rilis) SELECT * FROM (SELECT '$kodeId','$namaFilm', '$genre', '$tahunRilis') AS temp WHERE NOT EXISTS (SELECT nama_film FROM film WHERE nama_film = '$namaFilm') LIMIT 1;";
            // $sql = mysqli_query($conn,"INSERT INTO film VALUES ('$kodeId','$namaFilm', '$genre', '$tahunRilis')");
            //$sql = mysqli_query($conn, $query);
            if($cek>0){?>
                <script>
                    Swal.fire({
                        title: 'Data Telah Tersedia',
                        text: 'Data yang dimasukkan telah tersedia',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    }).then((result)=>{
                        if(result.value){
                            window.location='data_film.php';
                        }
                    })
                </script>
                
            <?php
                //echo "data berhasil ditambahkan <a href='data_film.php'>[Home]</a>";
            }else {
                $sql = mysqli_query($conn,"INSERT INTO film VALUES ('$kodeId','$namaFilm', '$genre', '$tahunRilis')");
                if($sql){
                    header ("location: data_film.php?pesan=input");
                }
            }

        //PROSES MENGUPDATE DATA ------------------------------------------------------   
        } else if($_POST['aksi']=="edit"){
            
            $id_film = $_POST['id_film'];
            $namaFilm = $_POST['nama'];
            $genre = $_POST['genre'];
            $tahunRilis = $_POST['tahun'];

            $query = "UPDATE film SET nama_film='$namaFilm', genre='$genre', tahun='$tahunRilis' WHERE id_film='$id_film';";
            $sql = mysqli_query($conn, $query);

            if($sql){
                //echo "<script>window.location='data_film.php'</>";
                header("Location: data_film.php?pesan=update");
                //echo "data berhasil ditambahkan <a href='pelanggan.php'>[Home]</a>";
            }else {
                echo $query;
            }
        }
    }

    //MENGHAPUS DATA ----------------------------------------------------------------       
    if (isset($_GET['hapus'])) {
        $id_film = $_GET['hapus'];
        $query = "DELETE FROM film WHERE id_film = '$id_film';";
        $sql= mysqli_query($conn, $query);
        if($sql){
            header("Location: data_film.php?pesan=hapus");
        }else {
            echo $query;
        }
    }
