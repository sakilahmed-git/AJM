<?php
if (isset($_POST['filepath'])) {
    $filepath = $_POST['filepath'];
    $safeName = basename($filepath); // For displaying the filename safely
    $realPath = realpath($filepath);
    $uploadsDir = realpath('uploads');

    if ($realPath && strpos($realPath, $uploadsDir) === 0 && file_exists($realPath)) {
        if (unlink($realPath)) {
            header("Location: admin.php?status=deleted&file=" . urlencode($safeName));
            exit();
        } else {
            header("Location: admin.php?status=error&msg=" . urlencode("Failed to delete $safeName"));
            exit();
        }
    } else {
        header("Location: admin.php?status=invalid&msg=" . urlencode("Invalid file path"));
        exit();
    }
} else {
    header("Location: admin.php?status=invalid&msg=" . urlencode("Invalid request"));
    exit();
}
