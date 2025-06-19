<?php
session_start();
require 'db.php';
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: account.php?error=invalidid");
    exit;
}
$id = intval($_GET['id']);
$error = '';
$success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newpass = trim($_POST['newpass']);
    if (strlen($newpass) < 6) {
        $error = "รหัสผ่านต้องมีอย่างน้อย 6 ตัวอักษร";
    } else {
        $hash = password_hash($newpass, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET password=? WHERE id=?");
        $stmt->bind_param("si", $hash, $id);
        $stmt->execute();
        $stmt->close();
        $success = "เปลี่ยนรหัสผ่านสำเร็จ";
    }
}
$stmt = $conn->prepare("SELECT username FROM users WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($username);
$stmt->fetch();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>เปลี่ยนรหัสผ่าน: <?= htmlspecialchars($username) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container main-container">
    <div class="content-card">
        <h2 class="page-title"><i class="fas fa-key me-2"></i>เปลี่ยนรหัสผ่าน: <?= htmlspecialchars($username) ?></h2>
        <?php if ($error): ?>
            <div class="alert alert-danger-custom alert-custom"><?= $error ?></div>
        <?php elseif ($success): ?>
            <div class="alert alert-success-custom alert-custom"><?= $success ?></div>
        <?php endif; ?>
        <form method="post">
            <div class="mb-3">
                <label class="form-label">รหัสผ่านใหม่</label>
                <input type="password" name="newpass" class="form-control" required minlength="6">
            </div>
            <button type="submit" class="btn btn-success-custom btn-custom">
                <i class="fas fa-save"></i> บันทึก
            </button>
            <a href="account.php" class="btn btn-secondary-custom btn-custom">ย้อนกลับ</a>
        </form>
    </div>
</div>
</body>
</html>