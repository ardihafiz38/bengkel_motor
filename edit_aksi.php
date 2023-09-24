<?php
include '../koneksi.php';

$id_wisata = $_POST['id_wisata'];
$nama_wisata = $_POST['nama_wisata'];
$alamat = $_POST['alamat'];
$deskripsi = $_POST['deskripsi'];
$Jadwal = $_POST['Jadwal'];
$latitude = $_POST['latitude'];
$longitude = $_POST['longitude'];
$no_handphone = $_POST['no_handphone'];

// Check if a new image is uploaded
if ($_FILES['gambar']['name'] != '') {
    $gambar = $_FILES['gambar']['name'];
    $tmp = $_FILES['gambar']['tmp_name'];
    $path = "../uploads/" . $gambar;
    move_uploaded_file($tmp, $path);
} else {
    // No new image uploaded, keep the existing image
    $query_select_image = mysqli_query($koneksi, "SELECT gambar FROM wisata WHERE id_wisata='$id_wisata'");
    $data_image = mysqli_fetch_assoc($query_select_image);
    $gambar = $data_image['gambar'];
}

$query = "UPDATE wisata SET 
            nama_wisata='$nama_wisata', 
            alamat='$alamat', 
            deskripsi='$deskripsi', 
            Jadwal='$Jadwal', 
            latitude='$latitude', 
            longitude='$longitude', 
            no_handphone='$no_handphone', 
            gambar='$gambar'
          WHERE id_wisata='$id_wisata'";

if (mysqli_query($koneksi, $query)) {
    header("location:detail_data.php?id_wisata=$id_wisata");
} else {
    echo "Error updating record: " . mysqli_error($koneksi);
}
?>
