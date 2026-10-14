<?php
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES['dataFile']) && isset($_POST['type'])) {
    $type = $_POST['type'];

    $allowedTypes = ['exam', 'results', 'fees'];
    if (!in_array($type, $allowedTypes)) {
        die("Invalid type.");
    }

    $folderMap = [
        'exam' => 'exam_data/',
        'results' => 'results_data/',
        'fees' => 'fees_data/',
    ];

    $uploadDir = $folderMap[$type];
    $fileTmpPath = $_FILES['dataFile']['tmp_name'];
    $fileName = $type . '.csv'; // Always overwrite the same file
    $destPath = $uploadDir . $fileName;

    if (move_uploaded_file($fileTmpPath, $destPath)) {
        echo "<script>alert('File uploaded successfully!'); window.location.href='admin.php';</script>";
    } else {
        echo "<script>alert('File upload failed.'); window.location.href='admin.php';</script>";
    }
}
?>
