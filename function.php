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


    // update info barang
    if(isset($_POST['updatebarang'])) {
        $idb = $_POST['idb'];
        $namabarang = $_POST['namabarang'];
        $deskripsi = $_POST['deskripsi'];

        $update = mysqli_query($conn, "UPDATE stock SET namabarang='$namabarang', deskripsi='$deskripsi' WHERE idbarang='$idb'");

        if ($update) {
            header('Location: index.php');
        } else {
            echo "Gagal memperbarui barang";
            header('Location: index.php');
        }
    };

    // menghapus barang dari stock
    if(isset($_POST['hapusbarang'])) {
        $idb = $_POST['idb'];

        $delete = mysqli_query($conn, "DELETE FROM stock WHERE idbarang='$idb'");

        if ($delete) {
            header('Location: index.php');
        } else {
            echo "Gagal menghapus barang";
            header('Location: index.php');
        }
    };  
    
    // mengubah data barang masuk
    if(isset($_POST['updatebarangmasuk'])) {
        $idb = $_POST['idb'];
        $idm = $_POST['idm'];
        $keterangan = $_POST['keterangan'];
        $qty = $_POST['qty'];

        $lihatstock = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang='$idb'");
        $stocknya = mysqli_fetch_array($lihatstock);
        $stocksekarang = $stocknya['stock'];

        $qtysekarang = mysqli_query($conn, "SELECT * FROM masuk WHERE idmasuk='$idm'");
        $qtynya = mysqli_fetch_array($qtysekarang);
        $qtysekarang = $qtynya['qty'];

        if ($qty > $qtysekarang) {
            $selisih = $qty - $qtysekarang;
            $kurangin = $stocksekarang - $selisih;
            $kurangistoknya = mysqli_query($conn, "UPDATE stock SET stock='$kurangin' WHERE idbarang='$idb'");
            $updatenya = mysqli_query($conn, "UPDATE masuk SET qty='$qty', keterangan='$keterangan' WHERE idmasuk='$idm'");
            
            if ($kurangistoknya && $updatenya) {
                header('Location: masuk.php');
            } else {
                echo "Gagal memperbarui barang masuk";
                header('Location: masuk.php');
            }
        } else {
            $selisih = $qtysekarang - $qty;
            $kurangin = $stocksekarang + $selisih;
            $kurangistoknya = mysqli_query($conn, "UPDATE stock SET stock='$kurangin' WHERE idbarang='$idb'");
            $updatenya = mysqli_query($conn, "UPDATE masuk SET qty='$qty', keterangan='$keterangan' WHERE idmasuk='$idm'");

            if ($kurangistoknya && $updatenya) {
                header('Location: masuk.php');
            } else {
                echo "Gagal memperbarui barang masuk";
                header('Location: masuk.php');
            }
        }
    };


    // menghapus barang masuk
    if(isset($_POST['hapusbarangmasuk'])) {
        $idb = $_POST['idb'];
        $qty = $_POST['kty'];
        $idm = $_POST['idm'];

        $getdatastock = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang='$idb'");
        $ambildatanya = mysqli_fetch_array($getdatastock);
        $stocksekarang = $ambildatanya['stock'];

        $selisih = $stocksekarang - $qty;

        $update = mysqli_query($conn, "UPDATE stock SET stock='$selisih' WHERE idbarang='$idb'");
        $delete = mysqli_query($conn, "DELETE FROM masuk WHERE idmasuk='$idm'");
        if ($update && $delete) {
            header('Location: masuk.php');
        } else {
            echo "Gagal menghapus barang masuk";
            header('Location: masuk.php');
        }

    }

?> 

