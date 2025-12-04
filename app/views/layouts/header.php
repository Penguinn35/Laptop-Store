<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title><?= isset($pageTitle) ? $pageTitle : 'Laptop Store Việt Nam' ?></title>
    <meta name="description" content="<?= isset($metaDesc) ? $metaDesc : 'Cửa hàng bán laptop uy tín chất lượng.' ?>">
    <?php if (!empty($useTabler)): ?>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@1.4.0/dist/css/tabler.min.css" />
    <?php endif; ?>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- CSS riêng cho từng trang -->
    <?php if (!empty($pageCss)): ?>
        <link rel="stylesheet" href="css/<?= $pageCss ?>.css">
    <?php endif; ?>



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta19/dist/css/tabler.min.css" rel="stylesheet"/>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/lang/summernote-vi-VN.js"></script>

    <script src="js/cart.js"></script>
</head>

<body>

    <?php include __DIR__ . "/navbar.php"; ?>
    <?php if (!empty($pageJs)): ?>
        <script src="/js/<?= $pageJs ?>.js"></script>
    <?php endif; ?>