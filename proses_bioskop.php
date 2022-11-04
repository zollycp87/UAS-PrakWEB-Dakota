<?php
    include 'koneksi.php';

    //Membuat ID Pelanggan Otomatis
    $queryKode = "SELECT max(id_bioskop) as newKode from bioskop";
    $hasil = mysqli_query($conn, $queryKode);
    $data = mysqli_fetch_array($hasil);

    $newKode = $data['newKode'];
    $kodeUrut = (int) substr($newKode, 2, 3);

    $kodeUrut++;
    $char = 'C';
    $kodeId = $char . sprintf("%03s", $kodeUrut);
    //--Membuat ID Selesai

    //PROSES MENAMBAH DATA ---------------------------------------------------------
    if (isset($_POST['aksi'])) {
        if($_POST['aksi']=="add"){

            $namaCabang = $_POST['nama'];
            $alamat = $_POST['alamat'];
            $noHp = $_POST['nohp'];

            $query = "INSERT INTO bioskop (id_bioskop,nama_cabang,alamat,nohp)
            SELECT * FROM (SELECT '$kodeId','$namaCabang', '$alamat', '$noHp') AS temp
            WHERE NOT EXISTS (
                SELECT nama_cabang FROM bioskop WHERE nama_cabang = '$namaCabang'
            ) LIMIT 1;";
            // $query = "INSERT INTO film VALUES ('$kodeId','$namaFilm', '$genre', '$tahunRilis')";
            $sql = mysqli_query($conn, $query);
            if($sql){
                header("Location: data_bioskop.php");
                //echo "data berhasil ditambahkan <a href='data_film.php'>[Home]</a>";
            }else {
                echo $query;
            }

        //PROSES MENGUPDATE DATA ------------------------------------------------------   
        } else if($_POST['aksi']=="edit"){
            
            $id_bioskop = $_POST['id_bioskop'];
            $namaCabang = $_POST['nama'];
            $alamat = $_POST['alamat'];
            $noHp = $_POST['nohp'];

            $query = "UPDATE bioskop SET nama_cabang='$namaCabang', alamat='$alamat', nohp='$noHp' WHERE id_bioskop='$id_bioskop';";
            $sql = mysqli_query($conn, $query);

            if($sql){
                header("Location: data_bioskop.php");
                //echo "data berhasil ditambahkan <a href='pelanggan.php'>[Home]</a>";
            }else {
                echo $query;
            }
        }
    }

    //MENGHAPUS DATA ----------------------------------------------------------------       
    if (isset($_GET['hapus'])) {
        $id_bioskop = $_GET['hapus'];
        $query = "DELETE FROM bioskop WHERE id_bioskop = '$id_bioskop';";
        $sql= mysqli_query($conn, $query);
        if($sql){
            header("Location: data_bioskop.php");
            //echo "data berhasil dihapus <a href='data_film.php'>[Home]</a>";
        }else {
            echo $query;
        }
    }
?>