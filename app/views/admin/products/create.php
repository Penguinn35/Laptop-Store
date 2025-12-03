<?php include __DIR__ . '/../../layouts/header.php'; ?>
<div class="page-wrapper">
    <div class="container-xl">
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">Thêm sản phẩm mới</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <form action="index.php?page=admin_product_create" method="POST" enctype="multipart/form-data" class="card">
                <div class="card-body">
                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger"><?= $error ?></div>
                    <?php endif; ?>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label required">Tên sản phẩm</label>
                                <input type="text" class="form-control" name="name" required placeholder="Ví dụ: Dell XPS 13">
                            </div>
                            <div class="mb-3">
                                <label class="form-label required">Thương hiệu</label>
                                <select class="form-select" name="brand_id" required>
                                    <option value="">-- Chọn hãng --</option>
                                    <?php foreach ($brands as $b): ?>
                                        <option value="<?= $b['id'] ?>"><?= htmlspecialchars($b['name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label required">Giá bán (VNĐ)</label>
                                <input type="number" class="form-control" name="price" required placeholder="Nhập giá tiền">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Số lượng tồn kho</label>
                                <input type="number" class="form-control" name="stock" value="10">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">CPU</label>
                                <input type="text" class="form-control" name="cpu" placeholder="Ví dụ: Intel Core i7-1165G7">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">RAM</label>
                                <input type="text" class="form-control" name="ram" placeholder="Ví dụ: 16GB">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Ổ cứng (Storage)</label>
                                <input type="text" class="form-control" name="storage" placeholder="Ví dụ: 512GB SSD">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Card màn hình (GPU)</label>
                                <input type="text" class="form-control" name="gpu" placeholder="Ví dụ: Intel Iris Xe">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Màn hình (Screen)</label>
                                <input type="text" class="form-control" name="screen" placeholder='Ví dụ: 13.4" FHD+'>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Hình ảnh sản phẩm</label>
                        <input type="file" class="form-control" name="image" accept="image/*">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Mô tả chi tiết</label>
                        <textarea class="form-control" name="description" rows="5" placeholder="Nhập mô tả sản phẩm..."></textarea>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <a href="index.php?page=admin_products" class="btn btn-link link-secondary">Hủy</a>
                    <button type="submit" class="btn btn-primary ms-auto">Lưu sản phẩm</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include __DIR__ . '/../../layouts/footer.php'; ?>