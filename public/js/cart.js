document.addEventListener('DOMContentLoaded', function() {

    // --- HÀM KIỂM TRA ĐĂNG NHẬP ---
    function requireLoginIfNeeded() {
        // Biến window.isLoggedIn được định nghĩa ở navbar.php
        if (typeof window.isLoggedIn !== 'undefined' && window.isLoggedIn) {
            return true; // Đã login -> Cho phép chạy tiếp
        }
        
        // Chưa login -> Mở popup
        // Hàm openLoginPopup được định nghĩa ở navbar.php
        if (typeof window.openLoginPopup === 'function') {
            window.openLoginPopup();
        } else {
            alert('Vui lòng đăng nhập để thực hiện chức năng này.');
        }
        return false; // Chặn hành động
    }

    // --- HÀM GỬI AJAX THÊM GIỎ HÀNG ---
    function sendAddToCart(productId, quantity, buttonElement) {
        const originalContent = buttonElement.innerHTML;
        buttonElement.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        buttonElement.disabled = true;

        fetch('index.php?page=cart_add&ajax=1', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                product_id: productId,
                quantity: quantity
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                const badge = document.getElementById('cart-badge');
                if (badge) {
                    badge.innerText = data.total_qty;
                    badge.style.display = 'inline-block';
                }
                alert('✅ Đã thêm sản phẩm vào giỏ hàng!');
            } else {
                alert('❌ Lỗi: ' + data.message);
            }
        })
        .catch(err => {
            console.error(err);
            alert('Có lỗi xảy ra khi kết nối server.');
        })
        .finally(() => {
            buttonElement.innerHTML = originalContent;
            buttonElement.disabled = false;
        });
    }

    // ============================================================
    // 1. XỬ LÝ NÚT "THÊM" Ở TRANG DANH SÁCH (Event Delegation)
    // ============================================================
    document.body.addEventListener('click', function(e) {
        // Tìm nút được click
        const btn = e.target.closest('.add-to-cart-btn');
        
        if (btn) {
            e.preventDefault();

            // QUAN TRỌNG: Kiểm tra login trước
            if (!requireLoginIfNeeded()) {
                return; // Dừng lại nếu chưa login
            }

            const productId = btn.getAttribute('data-id');
            sendAddToCart(productId, 1, btn);
        }
    });

    // ============================================================
    // 2. XỬ LÝ FORM "THÊM" Ở TRANG CHI TIẾT
    // ============================================================
    const detailForm = document.getElementById('addToCartForm');
    if (detailForm) {
        detailForm.addEventListener('submit', function(e) {
            e.preventDefault();

            // QUAN TRỌNG: Kiểm tra login trước
            if (!requireLoginIfNeeded()) {
                return; // Dừng lại nếu chưa login
            }

            const formData = new FormData(detailForm);
            const productId = formData.get('product_id');
            const quantity = formData.get('quantity');
            const btn = detailForm.querySelector('button[type="submit"]');

            sendAddToCart(productId, quantity, btn);
        });
    }
});