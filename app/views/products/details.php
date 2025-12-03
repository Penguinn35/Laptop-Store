<?php include __DIR__ . '/../layouts/header.php'; ?>
<?php include __DIR__ . '/../layouts/navbar.php'; ?>

<div class="bg-light py-3 mb-4">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="index.php">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="index.php?page=products">Sản phẩm</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars($product['name']) ?></li>
            </ol>
        </nav>
    </div>
</div>

<div class="container pb-5">
    <div class="row">
        <div class="col-md-5 mb-4">
            <div class="card border-0 shadow-sm">
                <img src="images/products_img/<?= htmlspecialchars($product['image'] ?? 'no-image.jpg') ?>" 
                     class="card-img-top img-fluid" 
                     alt="<?= htmlspecialchars($product['name']) ?>"
                     style="object-fit: contain; max-height: 400px;">
            </div>
        </div>

        <div class="col-md-7">
            <h1 class="fw-bold"><?= htmlspecialchars($product['name']) ?></h1>
            
            <div class="mb-3">
                <span class="badge bg-success">Còn hàng: <?= $product['stock'] ?></span>
                <span class="badge bg-info text-dark">Bảo hành chính hãng</span>
            </div>

            <h2 class="text-danger fw-bold mb-4">
                <?= number_format($product['price']) ?> ₫
            </h2>

            <div class="card mb-4">
                <div class="card-header fw-bold bg-white">
                    Cấu hình nổi bật
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between">
                        <span><i class="fas fa-microchip me-2"></i>CPU:</span>
                        <span class="fw-bold"><?= htmlspecialchars($product['cpu'] ?? 'N/A') ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span><i class="fas fa-memory me-2"></i>RAM:</span>
                        <span class="fw-bold"><?= htmlspecialchars($product['ram'] ?? 'N/A') ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span><i class="fas fa-hdd me-2"></i>Ổ cứng:</span>
                        <span class="fw-bold"><?= htmlspecialchars($product['storage'] ?? 'N/A') ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span><i class="fas fa-tv me-2"></i>Màn hình:</span>
                        <span class="fw-bold"><?= htmlspecialchars($product['screen'] ?? 'N/A') ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span><i class="fas fa-gamepad me-2"></i>VGA:</span>
                        <span class="fw-bold"><?= htmlspecialchars($product['gpu'] ?? 'N/A') ?></span>
                    </li>
                </ul>
            </div>

            <form method="post" action="index.php?page=cart_add" class="d-flex align-items-center gap-3">
                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                
                <div class="input-group" style="width: 140px;">
                    <span class="input-group-text">SL</span>
                    <input type="number" name="quantity" class="form-control text-center" value="1" min="1" max="<?= $product['stock'] ?>">
                </div>

                <button type="submit" class="btn btn-primary btn-lg flex-grow-1">
                    <i class="fas fa-shopping-cart me-2"></i> Thêm vào giỏ
                </button>
            </form>
            
            <div class="mt-3">
                 <p class="text-muted"><small>* Giao hàng miễn phí toàn quốc cho đơn hàng trên 5 triệu.</small></p>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-12">
            <h3 class="border-bottom pb-2">Mô tả sản phẩm</h3>
            <div class="py-3">
                <?= nl2br($product['description'] ?? '') ?> 
                </div>
        </div>
    </div>

    <?php if (!empty($relatedProducts)): ?>
    <div class="row mt-5">
        <h3 class="mb-4">Sản phẩm khác có thể bạn thích</h3>
        <?php foreach ($relatedProducts as $rp): ?>
            <div class="col-md-3 col-6 mb-4">
                <div class="card h-100">
                    <img src="images/products_img/<?= htmlspecialchars($rp['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($rp['name']) ?>">
                    <div class="card-body">
                        <h6 class="card-title text-truncate"><?= htmlspecialchars($rp['name']) ?></h6>
                        <p class="text-danger fw-bold mb-2"><?= number_format($rp['price']) ?> ₫</p>
                        <a href="index.php?page=product_detail&id=<?= $rp['id'] ?>" class="btn btn-outline-primary btn-sm w-100">Xem chi tiết</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>