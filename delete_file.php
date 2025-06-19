<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    die("สิทธิ์ไม่เพียงพอ");
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['folder'], $_POST['file'])) {
    $folder = basename($_POST['folder']);
    $file = basename($_POST['file']);
    $path = "upload/$folder/$file";
    if (file_exists($path)) {
        unlink($path);
        header("Location: view_folder.php?folder=" . urlencode($folder));
        exit;
    } else {
        die("ไม่พบไฟล์");
    }
} else {
    die("ข้อมูลไม่ครบหรือวิธีส่งผิด");
}
?>