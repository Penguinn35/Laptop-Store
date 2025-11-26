<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Laptop Store Việt Nam</title>
    <link rel="stylesheet" href="/laptop_store/public/css/style.css">

    <!-- CSS riêng cho từng trang -->
    <?php if (!empty($pageCss)): ?>
        <link rel="stylesheet" href="/laptop_store/public/css/<?= $pageCss ?>.css">
    <?php endif; ?>

 

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>

<body>

    <?php include __DIR__ . "/navbar.php"; ?>
       <?php if (!empty($pageJs)): ?>
        <script src="/laptop_store/public/js/<?= $pageJs ?>.js"></script>
    <?php endif; ?>