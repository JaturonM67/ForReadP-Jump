<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $topic  = trim($_POST['topic']);
    $round  = trim($_POST['round']);
    $date   = trim($_POST['date']);
    $folder_name = "{$topic} ครั้งที่ {$round} ณ {$date}";
    $folder_name = preg_replace('/[\\\\\/\?\%\*\:\|\"<>\.]/u', '', $folder_name);
    $uploadDir = 'upload/';
    if (!is_dir($uploadDir . $folder_name)) {
        mkdir($uploadDir . $folder_name, 0777, true);
        header("Location: index.php");
        exit;
    } else {
        $error = "โฟลเดอร์นี้มีอยู่แล้ว";
    }
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>สร้างโฟลเดอร์ใหม่</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        .form-label-custom {
            font-weight: 600;
            color: #2196F3;
            margin-bottom: 0.5rem;
        }
        .field-row {
            display: flex;
            align-items: center;
            gap: 0.8em;
            margin-bottom: 1.25rem;
        }
        .field-row .input-icon {
            color: #1976D2;
            font-size: 1.15rem;
            min-width: 1.6em;
            text-align: center;
        }
        .field-row input {
            border: 2px solid #2196F3;
            border-radius: 12px;
            padding: 0.7em 1em;
            font-size: 1.07rem;
            width: 100%;
            background: #f8fafd;
            transition: border-color 0.3s, box-shadow 0.3s;
        }
        .field-row input:focus {
            border-color: #1976D2;
            background: #fff;
            box-shadow: 0 2px 8px rgba(33,150,243,0.08);
        }
        .content-card {
            max-width: 550px;
            margin: auto;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="container main-container">
        <div class="content-card">
            <h2 class="page-title mb-4"><i class="fas fa-folder-plus me-2"></i>สร้างโฟลเดอร์ใหม่</h2>
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger-custom alert-custom"><?= $error ?></div>
            <?php endif; ?>
            <form method="post" autocomplete="off">
                <div class="field-row">
                    <span class="input-icon"><i class="fas fa-folder"></i></span>
                    <div style="flex:1">
                        <label class="form-label form-label-custom mb-1">ชื่อโฟลเดอร์</label>
                        <input type="text" name="topic" class="form-control-custom" required>
                    </div>
                </div>
                <div class="field-row">
                    <span class="input-icon"><i class="fas fa-hashtag"></i></span>
                    <div style="flex:1">
                        <label class="form-label form-label-custom mb-1">ครั้งที่</label>
                        <input type="text" name="round" class="form-control-custom" required>
                    </div>
                </div>
                <div class="field-row">
                    <span class="input-icon"><i class="fas fa-calendar-alt"></i></span>
                    <div style="flex:1">
                        <label class="form-label form-label-custom mb-1">เดือน/ปี (เช่น 06/2568)</label>
                        <input type="text" name="date" class="form-control-custom" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-success-custom btn-custom">
                    <i class="fas fa-folder-plus"></i> สร้างโฟลเดอร์
                </button>
                <a href="index.php" class="btn btn-secondary-custom btn-custom">
                    <i class="fas fa-arrow-left"></i> กลับ
                </a>
            </form>
        </div>
    </div>
</body>
</html>