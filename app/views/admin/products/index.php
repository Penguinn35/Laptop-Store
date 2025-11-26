<?php include __DIR__ . '/../layouts/header.php'; ?>  <!-- header Tabler -->
<div class="page">
    <?php include __DIR__ . '/../layouts/navbar.php'; ?> <!-- nếu có sidebar/menu -->
    <div class="page-wrapper">
        <div class="container-xl">

            <div class="page-header d-print-none mt-3">
                <div class="row align-items-center">
                    <div class="col">
                        <h2 class="page-title">Quản lý sản phẩm</h2>
                    </div>
                    <div class="col-auto ms-auto d-print-none">
                        <a href="/admin/products/create" class="btn btn-primary">
                            Thêm sản phẩm
                        </a>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body border-bottom py-3">
                    <form class="row g-2" method="get">
                        <div class="col">
                            <input type="text" name="q" class="form-control"
                                   placeholder="Tìm theo tên, hãng..."
                                   value="<?php echo htmlspecialchars($keyword); ?>">
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-primary" type="submit">Tìm kiếm</button>
                        </div>
                    </form>
                </div>

                <div class="table-responsive">
                    <table class="table card-table table-vcenter text-nowrap datatable">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên</th>
                            <th>Danh mục</th>
                            <th>Giá</th>
                            <th>Tồn</th>
                            <th>Trạng thái</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($products as $p): ?>
                            <tr>
                                <td><?php echo $p['id']; ?></td>
                                <td><?php echo htmlspecialchars($p['name']); ?></td>
                                <td><?php echo htmlspecialchars($p['category_name']); ?></td>
                                <td><?php echo number_format($p['sale_price'] ?? $p['price']); ?> đ</td>
                                <td><?php echo $p['stock']; ?></td>
                                <td>
                                    <?php if ($p['status']): ?>
                                        <span class="badge bg-success">Đang bán</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Ẩn</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end">
                                    <a href="/admin/products/edit?id=<?php echo $p['id']; ?>"
                                       class="btn btn-sm btn-outline-primary">Sửa</a>
                                    <a href="/admin/products/delete?id=<?php echo $p['id']; ?>"
                                       onclick="return confirm('Xóa sản phẩm này?');"
                                       class="btn btn-sm btn-outline-danger">Xóa</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- phân trang -->
                <div class="card-footer d-flex align-items-center">
                    <p class="m-0 text-muted">
                        Hiển thị <span><?php echo count($products); ?></span> / 
                        <span><?php echo $total; ?></span> sản phẩm
                    </p>
                    <ul class="pagination m-0 ms-auto">
                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                            <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                                <a class="page-link" href="/admin/products?page=<?php echo $i; ?>&q=<?php echo urlencode($keyword); ?>">
                                    <?php echo $i; ?>
                                </a>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</div>
<?php include __DIR__ . '/../layouts/footer.php'; ?>
