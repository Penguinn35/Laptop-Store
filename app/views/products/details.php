<?php include __DIR__ . '/../layouts/header.php'; ?>
<?php include __DIR__ . '/../layouts/navbar.php'; ?>

<div class="container py-4">
    <div class="row">
        <div class="col-md-5">
            <img src="/images/<?= htmlspecialchars($product['image'] ?? 'no-image.jpg', ENT_QUOTES, 'UTF-8') ?>"
                 class="img-fluid"
                 alt="<?= htmlspecialchars($product['name'] ?? 'Laptop', ENT_QUOTES, 'UTF-8') ?>">
        </div>

        <div class="col-md-7">
            <h1><?= htmlspecialchars($product['name'] ?? '', ENT_QUOTES, 'UTF-8') ?></h1>

            <p class="text-danger fs-4 fw-bold">
                <?= number_format($product['price'] ?? 0) ?> đ
            </p>

            <p>
                <?= nl2br(htmlspecialchars($product['description'] ?? '', ENT_QUOTES, 'UTF-8')) ?>
            </p>

            <form method="post" action="index.php?page=cart_add" class="mt-3">
                <input type="hidden" name="product_id" value="<?= (int)($product['id'] ?? 0) ?>">
                <div class="mb-3">
                    <label for="qty" class="form-label">Số lượng</label>
                    <input type="number" name="quantity" id="qty" value="1" min="1" class="form-control w-25">
                </div>
                <button type="submit" class="btn btn-primary">
                    Thêm vào giỏ hàng
                </button>
            </form>

            <a href="index.php?page=products" class="btn btn-link mt-2">
                ← Quay lại danh sách
            </a>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
