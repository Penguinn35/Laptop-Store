<?php include __DIR__ . '/../layouts/header.php'; ?>
<?php include __DIR__ . '/../layouts/navbar.php'; ?>

<div class="container py-4">
    <h1>Giỏ hàng</h1>

    <?php if (empty($cart_items)): ?>
        <p>Giỏ hàng đang trống.</p>
        <a href="index.php?page=products" class="btn btn-primary">Tiếp tục mua sắm</a>
    <?php else: ?>
        <form method="post" action="index.php?page=cart>
            <input type="hidden" name="action" value="update">

            <table class="table table-bordered align-middle">
                <thead>
                <tr>
                    <th>Sản phẩm</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th>Thành tiền</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($cart_items as $item): ?>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="/images/<?=
                                    htmlspecialchars($item['image'] ?? 'no-image.jpg', ENT_QUOTES, 'UTF-8'); ?>"
                                    alt=""
                                    style="width:60px;height:60px;object-fit:cover;" class="me-2">
                                <?php echo htmlspecialchars($item['name']); ?>
                            </div>
                        </td>
                        <td><?php echo number_format($item['price']); ?> đ</td>
                        <td style="width:120px;">
                            <input type="number" name="qty[<?php echo $item['id']; ?>]"
                                   min="0" value="<?php echo $item['qty']; ?>"
                                   class="form-control">
                        </td>
                        <td><?php echo number_format($item['subtotal']); ?> đ</td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>

            <div class="d-flex justify-content-between">
                <div>
                    <button type="submit" class="btn btn-secondary">Cập nhật giỏ</button>
                    <button type="submit" name="action" value="clear"
                            class="btn btn-outline-danger ms-2">
                        Xóa giỏ hàng
                    </button>
                </div>
                <h4>Tổng: <?php echo number_format($total); ?> đ</h4>
            </div>
        </form>

        <div class="mt-3 text-end">
            <a href="index.php?page=checkout" class="btn btn-success">Thanh toán</a>
        </div>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
