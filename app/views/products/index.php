<?php include __DIR__ . '/../layouts/header.php'; ?>
<?php include __DIR__ . '/../layouts/navbar.php'; ?>

<div class="container py-4" style="margin-top: 120px;">
    <h1 class="mb-3">Laptop</h1>

    <form class="row g-2 mb-3" method="get" action="index.php">
        <input type="hidden" name="page" value="products"> 
        <div class="col-sm-10">
            <input type="text" name="q" class="form-control"
                   placeholder="Tìm kiếm laptop theo tên, hãng..."
                   value="<?php echo htmlspecialchars($keyword); ?>">
        </div>
        <div class="col-sm-2 d-grid">
            <button type="submit" class="btn btn-primary">Tìm kiếm</button>
        </div>
    </form>

    <?php if (empty($products)): ?>
        <p>Không tìm thấy sản phẩm.</p>
    <?php else: ?>
        <div class="row">
            <?php foreach ($products as $p): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img src="images/products_img/<?php echo htmlspecialchars($p['image'] ?? 'no-image.jpg', ENT_QUOTES, 'UTF-8'); ?>"
                            class="card-img-top"
                            alt="<?php echo htmlspecialchars($p['name'] ?? 'Laptop', ENT_QUOTES, 'UTF-8'); ?>">
                            
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?php echo htmlspecialchars($p['name']); ?></h5>
                            <p class="card-text mb-1">
                                <?php if (!empty($p['sale_price'])): ?>
                                    <span class="text-danger fw-bold">
                                        <?php echo number_format($p['sale_price']); ?> đ
                                    </span>
                                    <small class="text-muted text-decoration-line-through">
                                        <?php echo number_format($p['price']); ?> đ
                                    </small>
                                <?php else: ?>
                                    <span class="fw-bold">
                                        <?php echo number_format($p['price']); ?> đ
                                    </span>
                                <?php endif; ?>
                            </p>
                            <div class="mt-auto d-flex gap-2">
                                <a href="index.php?page=product_detail&id=<?php echo (int)$p['id']; ?>"
                                   class="btn btn-outline-primary btn-sm">
                                    Xem chi tiết
                                </a>
                                
                                <form method="post" action="index.php?page=cart_add" class="d-inline">
                                    <input type="hidden" name="product_id" value="<?php echo $p['id']; ?>">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        Thêm vào giỏ
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <?php if ($total_pages > 1): ?>
            <nav>
                <ul class="pagination">
                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                            <a class="page-link"
                               href="index.php?page=products&p=<?php echo $i; ?>&q=<?php echo urlencode($keyword); ?>">
                                <?php echo $i; ?>
                            </a>
                        </li>
                    <?php endfor; ?>
                </ul>
            </nav>
        <?php endif; ?>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>