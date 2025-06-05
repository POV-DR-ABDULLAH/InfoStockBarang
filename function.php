<?php 
    session_start();

    // Koneksi ke database
    $conn = mysqli_connect("localhost", "root", "", "stockbarang");

    // Membuat barang baru
    if (isset($_POST['addnewbarang'])) {
        $namabarang = $_POST['namabarang'];
        $deskripsi = $_POST['deskripsi'];
        $stock = $_POST['stock'];

        $addtotable = mysqli_query($conn, "INSERT INTO stock (namabarang, deskripsi, stock) VALUES ('$namabarang', '$deskripsi', '$stock')");

        if ($addtotable) {
            header('Location: index.php');
        } else {
            echo "Gagal menambahkan barang";
            header('Location: index.php');
        }
    };


    // menambahkan barang masuk 
    if(isset($_POST['barangmasuk'])) {
        $barangnya = $_POST['barangnya'];
        $penerima = $_POST['penerima'];
        $qty = $_POST['qty'];

        $cekstocksekarang = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang = '$barangnya'");
        $ambildatanya = mysqli_fetch_array($cekstocksekarang);

        $stocksekarang = $ambildatanya['stock'];
        $tambahkanstocksekarangdenganqty = $stocksekarang + $qty;

        $addtomasuk = mysqli_query($conn, "INSERT INTO masuk (idbarang, keterangan, qty) VALUES('$barangnya', '$penerima', '$qty')");
        $updatestockmasuk = mysqli_query($conn, "UPDATE stock SET stock = '$tambahkanstocksekarangdenganqty' WHERE idbarang = '$barangnya'");
        if ($addtomasuk && $updatestockmasuk) { 
            header('Location: masuk.php');
        } else {
            echo "Gagal menambahkan barang masuk";
            header('Location: masuk.php');
        }
    };
    
    
    // menambahkan barang keluar
    if(isset($_POST['addbarangkeluar'])) {
        $barangnya = $_POST['barangnya'];
        $penerima = $_POST['penerima'];
        $qty = $_POST['qty'];

        $cekstocksekarang = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang = '$barangnya'");
        $ambildatanya = mysqli_fetch_array($cekstocksekarang);

        $stocksekarang = $ambildatanya['stock'];
        $tambahkanstocksekarangdenganqty = $stocksekarang - $qty;

        $addtokeluar = mysqli_query($conn, "INSERT INTO keluar (idbarang, penerima, qty) VALUES('$barangnya', '$penerima', '$qty')");
        $updatestockmasuk = mysqli_query($conn, "UPDATE stock SET stock = '$tambahkanstocksekarangdenganqty' WHERE idbarang = '$barangnya'");
        if ($addtokeluar && $updatestockmasuk) { 
            header('Location: keluar.php');
        } else {
            echo "Gagal menambahkan barang masuk";
            header('Location: keluar.php');
        }
    };
?> 
