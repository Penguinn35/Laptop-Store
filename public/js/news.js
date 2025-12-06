document.addEventListener('DOMContentLoaded', () => {
    const loginLink = document.getElementById('popupLoginLink');
    const loginBtn = document.getElementById('loginBtn'); // ID của nút đăng nhập trên Navbar
    
    if (loginLink && loginBtn) {
        loginLink.addEventListener('click', (e) => {
            e.preventDefault();
            // Kích hoạt sự kiện click của nút Đăng nhập trên Navbar, mở modal
            loginBtn.click(); 
        });
    }
});