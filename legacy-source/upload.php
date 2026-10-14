<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['galleryImage'])) {
    $targetDir = "uploads/";
    $fileName = basename($_FILES["galleryImage"]["name"]);
    $targetFilePath = $targetDir . $fileName;

    // Check if image file is a real image
    $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

    if (in_array($fileType, $allowedTypes)) {
        if (move_uploaded_file($_FILES["galleryImage"]["tmp_name"], $targetFilePath)) {
            echo "<script>alert('Image uploaded successfully!'); window.location.href='admin.html';</script>";
        } else {
            echo "<script>alert('Error uploading image.'); window.location.href='admin.html';</script>";
        }
    } else {
        echo "<script>alert('Only JPG, JPEG, PNG, GIF allowed.'); window.location.href='admin.html';</script>";
    }
}
?>
