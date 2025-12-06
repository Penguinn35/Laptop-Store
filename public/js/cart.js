document.addEventListener('DOMContentLoaded', function() {

    function sendAddToCart(productId, quantity, buttonElement) {
        // Lưu text cũ và hiện loading
        const originalContent = buttonElement.innerHTML;
        buttonElement.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang thêm...';
        buttonElement.disabled = true;

        fetch('index.php?page=cart_add&ajax=1', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                product_id: productId,
                quantity: quantity
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                // Cập nhật số trên icon giỏ hàng
                const badge = document.getElementById('cart-badge');
                if (badge) {
                    badge.innerText = data.total_qty;
                    badge.style.display = 'inline-block';
                }
                alert('Đã thêm sản phẩm vào giỏ hàng thành công!');
            } else {
                alert('Lỗi: ' + data.message);
            }
        })
        .catch(err => {
            console.error(err);
            alert('Có lỗi xảy ra khi kết nối server.');
        })
        .finally(() => {
            // Trả lại nút như cũ
            buttonElement.innerHTML = originalContent;
            buttonElement.disabled = false;
        });
    }

    // --- XỬ LÝ 1: Nút "Thêm" ở trang Danh sách (page=products) ---
    // Sử dụng Event Delegation để đảm bảo chạy được ngay cả khi HTML thay đổi
    document.body.addEventListener('click', function(e) {
        // Tìm xem cái được click có phải là nút .add-to-cart-btn hoặc con của nó không
        const btn = e.target.closest('.add-to-cart-btn');
        if (btn) {
            e.preventDefault(); // Chặn hành động mặc định
            const productId = btn.getAttribute('data-id');
            sendAddToCart(productId, 1, btn);
        }
    });

    // --- XỬ LÝ 2: Form "Thêm" ở trang Chi tiết (page=product_detail) ---
    const detailForm = document.getElementById('addToCartForm');
    if (detailForm) {
        detailForm.addEventListener('submit', function(e) {
            e.preventDefault(); // Chặn chuyển trang sang cart_add
            
            const formData = new FormData(detailForm);
            const productId = formData.get('product_id');
            const quantity = formData.get('quantity');
            const btn = detailForm.querySelector('button[type="submit"]');

            sendAddToCart(productId, quantity, btn);
        });
    }

});