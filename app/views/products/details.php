<?php include __DIR__ . '/../layouts/header.php'; ?>
<?php include __DIR__ . '/../layouts/navbar.php'; ?>

<div class="bg-light py-3 mb-4" style="margin-top: 120px;">
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
        <div class="col-md-5 mb-4 text-center border bg-white p-3 rounded">
             <div class="position-relative">
                <img src="images/products_img/<?= htmlspecialchars($product['image'] ?? 'no-image.jpg') ?>" 
                     class="img-fluid" 
                     alt="<?= htmlspecialchars($product['name']) ?>"
                     style="max-height: 400px; object-fit: contain;">
                
                <?php if ($product['stock'] <= 0): ?>
                    <div class="position-absolute top-50 start-50 translate-middle bg-dark text-white px-4 py-2 rounded opacity-75 fs-4 fw-bold">
                        HẾT HÀNG
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="col-md-7">
            <h1 class="fw-bold"><?= htmlspecialchars($product['name']) ?></h1>
            
            <div class="mb-3">
                <?php if ($product['stock'] > 0): ?>
                    <span class="badge bg-success">Còn hàng: <?= $product['stock'] ?></span>
                <?php else: ?>
                    <span class="badge bg-danger">Hết hàng</span>
                <?php endif; ?>
                <span class="badge bg-info text-dark">Bảo hành chính hãng</span>
            </div>

            <?php if ($product['stock'] > 0): ?>
                <h2 class="text-danger fw-bold mb-4"><?= number_format($product['price']) ?> ₫</h2>
            <?php else: ?>
                <h2 class="text-muted text-decoration-line-through mb-1"><?= number_format($product['price']) ?> ₫</h2>
                <h4 class="text-danger fw-bold mb-4">Sản phẩm đang tạm hết hàng</h4>
            <?php endif; ?>

            <div class="card mb-4">
                <div class="card-header fw-bold bg-white">Cấu hình nổi bật</div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between"><span>CPU:</span> <strong><?= $product['cpu'] ?></strong></li>
                    <li class="list-group-item d-flex justify-content-between"><span>RAM:</span> <strong><?= $product['ram'] ?></strong></li>
                    <li class="list-group-item d-flex justify-content-between"><span>Ổ cứng:</span> <strong><?= $product['storage'] ?></strong></li>
                    <li class="list-group-item d-flex justify-content-between"><span>Màn hình:</span> <strong><?= $product['screen'] ?></strong></li>
                    <li class="list-group-item d-flex justify-content-between"><span>VGA:</span> <strong><?= $product['gpu'] ?></strong></li>
                </ul>
            </div>

            <?php if ($product['stock'] > 0): ?>
                <form id="addToCartForm" action="index.php?page=cart_add" method="post" class="d-flex align-items-center gap-3">
                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                    
                    <div class="input-group" style="width: 140px;">
                        <span class="input-group-text">SL</span>
                        <input type="number" name="quantity" class="form-control text-center" value="1" min="1" max="<?= $product['stock'] ?>">
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg flex-grow-1">
                        <i class="fas fa-cart-plus me-2"></i> Thêm vào giỏ hàng
                    </button>
                </form>
            <?php else: ?>
                <button class="btn btn-secondary btn-lg w-100" disabled>
                    <i class="fas fa-ban me-2"></i> Tạm hết hàng
                </button>
            <?php endif; ?>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-12">
            <h3 class="border-bottom pb-2">Mô tả sản phẩm</h3>
            <div class="py-3"><?= nl2br($product['description'] ?? '') ?></div>
        </div>
    </div>

    <?php if (!empty($relatedProducts)): ?>
    <div class="row mt-5">
        <h3 class="mb-4">Sản phẩm khác có thể bạn thích</h3>
        <?php foreach ($relatedProducts as $rp): ?>
            <div class="col-md-3 col-6 mb-4">
                <div class="card h-100">
                    <div class="p-3" style="height: 180px; display: flex; align-items: center; justify-content: center;">
                        <img src="images/products_img/<?= htmlspecialchars($rp['image']) ?>" 
                            alt="<?= htmlspecialchars($rp['name']) ?>"
                            style="max-width: 100%; max-height: 100%; object-fit: contain;">
                    </div>
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