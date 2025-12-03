<?php include __DIR__ . '/../../layouts/header.php'; ?>
<div class="page-wrapper">
    <div class="container-xl">
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">Chi tiết đơn hàng #<?= $order['id'] ?></h2>
                </div>
                <div class="col-auto ms-auto">
                    <a href="index.php?page=admin_orders" class="btn btn-secondary">Quay lại</a>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-cards">
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-header"><h3 class="card-title">Thông tin đơn hàng</h3></div>
                        <div class="card-body">
                            <p><strong>Ngày đặt:</strong> <?= date('d/m/Y H:i', strtotime($order['created_at'])) ?></p>
                            <p><strong>Khách hàng:</strong> <?= htmlspecialchars($order['full_name'] ?? '') ?></p>
                            <p><strong>Email:</strong> <?= htmlspecialchars($order['email'] ?? '') ?></p>
                            <p><strong>Số điện thoại:</strong> <?= htmlspecialchars($order['phone'] ?? 'Chưa cập nhật') ?></p>
                            <p><strong>Địa chỉ:</strong> <?= htmlspecialchars($order['address'] ?? 'Chưa cập nhật') ?></p>
                            <p><strong>Ghi chú:</strong> <?= htmlspecialchars($order['note'] ?? 'Không') ?></p>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header"><h3 class="card-title">Cập nhật trạng thái</h3></div>
                        <div class="card-body">
                            <form action="index.php?page=admin_order_view&id=<?= $order['id'] ?>" method="POST">
                                <div class="mb-3">
                                    <select name="status" class="form-select">
                                        <option value="pending" <?= $order['status']=='pending'?'selected':'' ?>>Chờ xử lý</option>
                                        <option value="confirmed" <?= $order['status']=='confirmed'?'selected':'' ?>>Đã xác nhận</option>
                                        <option value="shipped" <?= $order['status']=='shipped'?'selected':'' ?>>Đang giao hàng</option>
                                        <option value="done" <?= $order['status']=='done'?'selected':'' ?>>Hoàn thành</option>
                                        <option value="cancelled" <?= $order['status']=='cancelled'?'selected':'' ?>>Hủy đơn</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">Cập nhật</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="card">
                        <div class="table-responsive">
                            <table class="table table-vcenter card-table">
                                <thead>
                                    <tr>
                                        <th>Sản phẩm</th>
                                        <th>Đơn giá</th>
                                        <th>Số lượng</th>
                                        <th class="text-end">Thành tiền</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    if (!empty($order['items'])): 
                                        foreach ($order['items'] as $item):
                                    ?>
                                    <tr>
                                        <td><?= htmlspecialchars($item['name']) ?></td>
                                        <td><?= number_format($item['unit_price']) ?> đ</td>
                                        <td>x<?= $item['quantity'] ?></td>
                                        <td class="text-end"><?= number_format($item['unit_price'] * $item['quantity']) ?> đ</td>
                                    </tr>
                                    <?php endforeach; endif; ?>
                                    
                                    <tr>
                                        <td colspan="3" class="text-end fw-bold">Tổng cộng:</td>
                                        <td class="text-end text-danger fw-bold fs-3"><?= number_format($order['total_amount']) ?> đ</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include __DIR__ . '/../../layouts/footer.php'; ?>