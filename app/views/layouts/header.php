<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Laptop Store Việt Nam</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@1.4.0/dist/css/tabler.min.css" />
    <link rel="stylesheet" href="/laptop_store/public/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

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