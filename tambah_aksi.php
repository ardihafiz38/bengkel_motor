<?php
include '../koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Extracting data from the form
    $nama = $_POST['nama_wisata'];
    $alamat = $_POST['alamat'];
    $deskripsi = $_POST['deskripsi'];
    $jadwal = $_POST['jadwal'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $no_handphone = $_POST['no_handphone'];

    // Handling file upload for the image
    $gambar = $_FILES['gambar']['name'];
    $target_dir = "../uploads/";  // Adjust this path as needed
    $target_file = $target_dir . basename($_FILES['gambar']['name']);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES['gambar']['tmp_name']);
    if ($check !== false) {
        echo "File is an image - " . $check['mime'] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES['gambar']['size'] > 5000000) { // 5MB limit
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "jpeg"
        && $imageFileType != "png" && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        // if everything is ok, try to upload file
        if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target_file)) {
            echo "The file " . basename($_FILES['gambar']['name']) . " has been uploaded to: " . $target_file;
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

    // SQL query to insert data
    $sql = "INSERT INTO wisata (nama_wisata, alamat, deskripsi, jadwal, latitude, longitude, no_handphone, gambar) 
            VALUES ('$nama', '$alamat', '$deskripsi', '$jadwal', '$latitude', '$longitude', '$no_handphone', '$gambar')";

    if (mysqli_query($koneksi, $sql)) {
        // If the query is successful
        echo "Data added successfully. Redirecting...";
        header("location:tampil_data.php");  // Redirect to the display page
        exit();
    } else {
        // If there's an error
        echo "Error: " . $sql . "<br>" . mysqli_error($koneksi);
    }
}

// Close the database connection
mysqli_close($koneksi);
?>
