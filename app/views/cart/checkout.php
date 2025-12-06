<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="container py-5">
    <div class="row">
        <div class="col-md-7">
            <h2 class="mb-4">Thông tin giao hàng</h2>
            <form action="index.php?page=checkout_process" method="POST" id="checkoutForm">
                <div class="mb-3">
                    <label class="form-label">Họ và tên <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="fullname" required 
                           value="<?= htmlspecialchars($user['fullname'] ?? '') ?>">
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" name="email" required
                               value="<?= htmlspecialchars($user['email'] ?? '') ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="phone" required
                               value="<?= htmlspecialchars($user['phone'] ?? '') ?>">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Địa chỉ nhận hàng <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="address" required
                           value="<?= htmlspecialchars($user['address'] ?? '') ?>"
                           placeholder="Số nhà, tên đường, phường/xã, quận/huyện...">
                </div>

                <div class="mb-3">
                    <label class="form-label">Ghi chú đơn hàng (Tùy chọn)</label>
                    <textarea class="form-control" name="note" rows="3" placeholder="Ví dụ: Giao hàng giờ hành chính..."></textarea>
                </div>
            </form>
        </div>

        <div class="col-md-5">
            <div class="card bg-light border-0">
                <div class="card-body">
                    <h4 class="card-title mb-4">Đơn hàng của bạn</h4>
                    
                    <ul class="list-group mb-3">
                        <?php foreach ($cart_items as $item): ?>
                        <li class="list-group-item d-flex justify-content-between lh-sm">
                            <div>
                                <h6 class="my-0"><?= htmlspecialchars($item['name']) ?></h6>
                                <small class="text-muted">SL: <?= $item['qty'] ?> x <?= number_format($item['price']) ?></small>
                            </div>
                            <span class="text-muted"><?= number_format($item['subtotal']) ?> ₫</span>
                        </li>
                        <?php endforeach; ?>
                        
                        <li class="list-group-item d-flex justify-content-between bg-white">
                            <span>Tổng tiền (VNĐ)</span>
                            <strong class="text-danger fs-5"><?= number_format($total) ?> ₫</strong>
                        </li>
                    </ul>

                    <button type="submit" form="checkoutForm" class="btn btn-primary w-100 btn-lg">
                        ĐẶT HÀNG NGAY
                    </button>
                    
                    <a href="index.php?page=cart" class="btn btn-outline-secondary w-100 mt-2">
                        Quay lại giỏ hàng
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>