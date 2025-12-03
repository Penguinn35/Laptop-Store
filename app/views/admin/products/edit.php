<?php include __DIR__ . '/../../layouts/header.php'; ?>
<div class="page-wrapper">
    <div class="container-xl">
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">Chỉnh sửa sản phẩm: <?= htmlspecialchars($product['name'] ?? '') ?></h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <form action="index.php?page=admin_product_edit&id=<?= $product['id'] ?>" method="POST" enctype="multipart/form-data" class="card">
                <div class="card-body">
                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger"><?= $error ?></div>
                    <?php endif; ?>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label required">Tên sản phẩm</label>
                                <input type="text" class="form-control" name="name" value="<?= htmlspecialchars($product['name'] ?? '') ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label required">Thương hiệu</label>
                                <select class="form-select" name="brand_id" required>
                                    <option value="">-- Chọn hãng --</option>
                                    <?php foreach ($brands as $b): ?>
                                        <option value="<?= $b['id'] ?>" <?= ($b['id'] == ($product['brand_id'] ?? 0)) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($b['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label required">Giá bán (VNĐ)</label>
                                <input type="number" class="form-control" name="price" value="<?= $product['price'] ?? 0 ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Số lượng tồn kho</label>
                                <input type="number" class="form-control" name="stock" value="<?= $product['stock'] ?? 0 ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">CPU</label>
                                <input type="text" class="form-control" name="cpu" value="<?= htmlspecialchars($product['cpu'] ?? '') ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">RAM</label>
                                <input type="text" class="form-control" name="ram" value="<?= htmlspecialchars($product['ram'] ?? '') ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Ổ cứng</label>
                                <input type="text" class="form-control" name="storage" value="<?= htmlspecialchars($product['storage'] ?? '') ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">GPU</label>
                                <input type="text" class="form-control" name="gpu" value="<?= htmlspecialchars($product['gpu'] ?? '') ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Màn hình</label>
                                <input type="text" class="form-control" name="screen" value="<?= htmlspecialchars($product['screen'] ?? '') ?>">
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Hình ảnh hiện tại</label>
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <?php if (!empty($product['image'])): ?>
                                    <img src="images/products_img/<?= htmlspecialchars($product['image']) ?>" class="avatar avatar-xl" style="object-fit: contain; width: 100px; height: 100px;">
                                <?php else: ?>
                                    <span class="avatar avatar-xl">No Image</span>
                                <?php endif; ?>
                            </div>
                            <div class="col">
                                <input type="file" class="form-control" name="image" accept="image/*">
                                <small class="form-hint">Chỉ chọn nếu muốn thay đổi ảnh.</small>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Mô tả chi tiết</label>
                        <textarea class="form-control" name="description" rows="5"><?= htmlspecialchars($product['description'] ?? '') ?></textarea>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <a href="index.php?page=admin_products" class="btn btn-link link-secondary">Hủy</a>
                    <button type="submit" class="btn btn-primary ms-auto">Cập nhật</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include __DIR__ . '/../../layouts/footer.php'; ?>