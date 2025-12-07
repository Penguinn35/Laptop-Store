<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="container py-5 text-center" style="margin-top:120px; min-height: calc(100vh - 380px)">
    <div class="card shadow-sm border-0 py-5" style="max-width: 600px; margin: auto;">
        <div class="card-body">
            <div class="text-success mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                  <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                </svg>
            </div>
            
            <h2 class="card-title fw-bold text-success">Đặt hàng thành công!</h2>
            <p class="card-text fs-5 mt-3">Mã đơn hàng của bạn là: <strong>#<?= htmlspecialchars($orderId) ?></strong></p>
            <p class="text-muted">Cảm ơn bạn đã mua sắm tại Laptop Store. Chúng tôi sẽ liên hệ sớm nhất để xác nhận đơn hàng.</p>
            
            <div class="mt-4">
                <a href="index.php?page=products" class="btn btn-primary">Tiếp tục mua sắm</a>
                <a href="index.php?page=home" class="btn btn-outline-secondary ms-2">Về trang chủ</a>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>