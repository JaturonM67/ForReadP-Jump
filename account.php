<?php
session_start();
require 'db.php';
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$users = $conn->query("SELECT id, username, role FROM users");
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>จัดการบัญชีผู้ใช้</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
<div class="container main-container">
    <div class="content-card">
        <h2 class="page-title"><i class="fas fa-users-cog me-2"></i>จัดการบัญชีผู้ใช้</h2>
        <table class="table table-custom">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($row = $users->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['username']) ?></td>
                    <td><?= htmlspecialchars($row['role']) ?></td>
                    <td>
                        <a href="change_password.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">
                            <i class="fas fa-key"></i> เปลี่ยนรหัสผ่าน
                        </a>
                        <?php if ($row['username'] !== 'Admin'): ?>
                        <form action="delete_user.php" method="post" style="display:inline;" onsubmit="return confirm('ลบผู้ใช้นี้?')">
                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i> ลบ
                            </button>
                        </form>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
        <a href="index.php" class="btn btn-secondary-custom btn-custom mt-3">
            <i class="fas fa-arrow-left"></i> ย้อนกลับ
        </a>
    </div>
</div>
</body>
</html>