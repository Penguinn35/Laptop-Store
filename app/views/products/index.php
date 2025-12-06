<?php include __DIR__ . '/../layouts/header.php'; ?>
<?php include __DIR__ . '/../layouts/navbar.php'; ?>

<div class="container py-4" style="margin-top: 120px;">
    <h1 class="mb-3">Laptop</h1>

    <h1 class="mb-4 text-center fw-bold text-uppercase">Danh sách Laptop</h1>

    <form class="row justify-content-center g-2 mb-5" method="get" action="index.php">
        <input type="hidden" name="page" value="products">
        <div class="col-md-6 col-8">
            <input type="text" name="q" class="form-control"
                   placeholder="Nhập tên laptop, hãng sản xuất..."
                   value="<?php echo htmlspecialchars($keyword); ?>">
        </div>
        <div class="col-md-2 col-4">
            <button type="submit" class="btn btn-primary w-100"><i class="fas fa-search"></i> Tìm kiếm</button>
        </div>
    </form>

    <?php if (empty($products)): ?>
        <div class="alert alert-info text-center">Không tìm thấy sản phẩm nào phù hợp.</div>
    <?php else: ?>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
            <?php foreach ($products as $p): ?>
                <div class="col">
                    <div class="card h-100 shadow-sm border-0 product-card">
                        
                        <div class="position-relative overflow-hidden p-3" style="height: 200px; background: #fff;">
                            <a href="index.php?page=product_detail&id=<?= $p['id'] ?>">
                                <img src="images/products_img/<?= htmlspecialchars($p['image'] ?? 'no-image.jpg') ?>"
                                     alt="<?= htmlspecialchars($p['name']) ?>"
                                     style="width: 100%; height: 100%; object-fit: contain;">
                            </a>
                            <?php if ($p['stock'] <= 0): ?>
                                <div class="position-absolute top-50 start-50 translate-middle bg-dark text-white px-3 py-1 rounded opacity-75 fw-bold">
                                    HẾT HÀNG
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="card-body d-flex flex-column">
                            <h6 class="card-title text-truncate mb-2">
                                <a href="index.php?page=product_detail&id=<?= $p['id'] ?>" class="text-decoration-none text-dark fw-bold" title="<?= htmlspecialchars($p['name']) ?>">
                                    <?= htmlspecialchars($p['name']) ?>
                                </a>
                            </h6>

                            <div class="small text-muted mb-3">
                                <div class="d-flex align-items-center mb-1">
                                    <i class="fas fa-microchip me-2" style="width: 16px;"></i> 
                                    <span class="text-truncate"><?= htmlspecialchars($p['cpu'] ?? '') ?></span>
                                </div>
                                <div class="d-flex align-items-center mb-1">
                                    <i class="fas fa-memory me-2" style="width: 16px;"></i>
                                    <span><?= htmlspecialchars($p['ram'] ?? '') ?></span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-hdd me-2" style="width: 16px;"></i>
                                    <span><?= htmlspecialchars($p['storage'] ?? '') ?></span>
                                </div>
                            </div>

                            <div class="mt-auto">
                                <p class="card-text mb-2">
                                    <?php if ($p['stock'] > 0): ?>
                                        <span class="text-danger fw-bold fs-5"><?= number_format($p['price']) ?> đ</span>
                                    <?php else: ?>
                                        <span class="text-muted text-decoration-line-through"><?= number_format($p['price']) ?> đ</span>
                                        <span class="text-danger fw-bold ms-2">Liên hệ</span>
                                    <?php endif; ?>
                                </p>
                                
                                <div class="d-grid gap-2">
                                    <a href="index.php?page=product_detail&id=<?= $p['id'] ?>" class="btn btn-outline-secondary btn-sm">
                                        Xem chi tiết
                                    </a>

                                    <?php if ($p['stock'] > 0): ?>
                                        <button type="button" class="btn btn-primary btn-sm add-to-cart-btn" data-id="<?= $p['id'] ?>">
                                            <i class="fas fa-cart-plus"></i> Thêm vào giỏ
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <?php if ($total_pages > 1): ?>
            <nav class="mt-5">
                <ul class="pagination justify-content-center">
                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                            <a class="page-link" href="index.php?page=products&p=<?= $i ?>&q=<?= urlencode($keyword) ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>
                </ul>
            </nav>
        <?php endif; ?>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>