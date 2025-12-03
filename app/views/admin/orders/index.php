<?php include __DIR__ . '/../../layouts/header.php'; ?>

<div class="page-wrapper">
    <div class="container-xl">
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">Quản lý đơn hàng</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="card-body border-bottom py-3">
                    <div class="d-flex">
                        <div class="text-muted">
                            Lọc trạng thái:
                            <div class="d-inline-block">
                                <a href="index.php?page=admin_orders" class="badge bg-secondary text-decoration-none">Tất cả</a>
                                <a href="index.php?page=admin_orders&status=pending" class="badge bg-warning text-decoration-none">Chờ xử lý</a>
                                <a href="index.php?page=admin_orders&status=confirmed" class="badge bg-info text-decoration-none">Đã xác nhận</a>
                                <a href="index.php?page=admin_orders&status=done" class="badge bg-success text-decoration-none">Hoàn thành</a>
                                <a href="index.php?page=admin_orders&status=cancelled" class="badge bg-danger text-decoration-none">Đã hủy</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table card-table table-vcenter text-nowrap datatable">
                        <thead>
                            <tr>
                                <th class="w-1">ID</th>
                                <th>Khách hàng</th>
                                <th>Tổng tiền</th>
                                <th>Ngày đặt</th>
                                <th>Trạng thái</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($orders)): ?>
                                <?php foreach ($orders as $order): ?>
                                <tr>
                                    <td><span class="text-muted">#<?= $order['id'] ?></span></td>
                                    <td>
                                        <?= htmlspecialchars($order['full_name'] ?? 'Khách lẻ') ?><br>
                                        <small class="text-muted"><?= htmlspecialchars($order['email'] ?? '') ?></small>
                                    </td>
                                    <td><?= number_format($order['total_amount']) ?> đ</td>
                                    <td><?= date('d/m/Y H:i', strtotime($order['created_at'])) ?></td>
                                    <td>
                                        <?php 
                                        $statusColors = [
                                            'pending' => 'warning',
                                            'confirmed' => 'info',
                                            'shipped' => 'primary',
                                            'done' => 'success',
                                            'cancelled' => 'danger'
                                        ];
                                        $color = $statusColors[$order['status']] ?? 'secondary';
                                        
                                        $statusLabels = [
                                            'pending' => 'Chờ xử lý',
                                            'confirmed' => 'Đã xác nhận',
                                            'shipped' => 'Đang giao',
                                            'done' => 'Hoàn thành',
                                            'cancelled' => 'Đã hủy'
                                        ];
                                        $label = $statusLabels[$order['status']] ?? $order['status'];
                                        ?>
                                        <span class="badge bg-<?= $color ?> me-1"></span> <?= $label ?>
                                    </td>
                                    <td class="text-end">
                                        <a href="index.php?page=admin_order_view&id=<?= $order['id'] ?>" class="btn btn-primary btn-sm">
                                            Xem chi tiết
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="6" class="text-center">Chưa có đơn hàng nào.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include __DIR__ . '/../../layouts/footer.php'; ?>