<?php include __DIR__ . '/../../layouts/header.php'; ?>
<div class="page-wrapper">
    <div class="container-xl">
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">Quản lý sản phẩm</h2>
                </div>
                </div>
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="card-body border-bottom py-3">
                    <div class="d-flex justify-content-between">
                        <form method="get" action="index.php" class="d-flex gap-2">
                            <input type="hidden" name="page" value="admin_products">
                            <input type="text" class="form-control w-auto" name="q" value="<?= htmlspecialchars($keyword) ?>" placeholder="Tìm kiếm...">
                            <button type="submit" class="btn btn-secondary">Tìm</button>
                        </form>

                        <a href="index.php?page=admin_product_create" class="btn btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                            Thêm mới
                        </a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table card-table table-vcenter text-nowrap datatable">
                        <thead>
                            <tr>
                                <th class="w-1">ID</th>
                                <th>Ảnh</th>
                                <th>Tên sản phẩm</th>
                                <th>Hãng</th>
                                <th>Giá</th>
                                <th>Kho</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($products as $p): ?>
                            <tr>
                                <td><span class="text-muted"><?= $p['id'] ?></span></td>
                                <td>
                                    <img src="images/products_img/<?= htmlspecialchars($p['image']) ?>" 
                                         style="width: 40px; height: 40px; object-fit: cover;" class="rounded">
                                </td>
                                <td>
                                    <span class="d-block text-truncate" style="max-width: 250px;">
                                        <?= htmlspecialchars($p['name']) ?>
                                    </span>
                                </td>
                                <td><?= htmlspecialchars($p['brand_name'] ?? 'N/A') ?></td>
                                <td><?= number_format($p['price']) ?> đ</td>
                                <td>
                                    <?php if($p['stock'] > 0): ?>
                                        <span class="badge bg-success">Còn <?= $p['stock'] ?></span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Hết hàng</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="index.php?page=admin_product_edit&id=<?= $p['id'] ?>" class="btn btn-sm btn-primary">Sửa</a>
                                    <a href="index.php?page=admin_product_delete&id=<?= $p['id'] ?>" 
                                       class="btn btn-sm btn-danger"
                                       onclick="return confirm('Bạn có chắc chắn muốn xóa không?');">Xóa</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                
                <div class="card-footer d-flex align-items-center">
                    <p class="m-0 text-muted">Trang <?= $page ?> / <?= $total_pages ?></p>
                    <ul class="pagination m-0 ms-auto">
                        <?php for($i=1; $i<=$total_pages; $i++): ?>
                            <li class="page-item <?= ($i==$page)?'active':'' ?>">
                                <a class="page-link" href="index.php?page=admin_products&p=<?= $i ?>&q=<?= $keyword ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include __DIR__ . '/../../layouts/footer.php'; ?>