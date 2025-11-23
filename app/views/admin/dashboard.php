<h1>Admin Dashboard</h1>
<p>Welcome, <?= $_SESSION['user']['fullname'] ?>!</p>

<ul>
  <li><a href="/laptop_store/public/index.php?page=admin_settings">Cài đặt hệ thống</a></li>

  <li><a href="/laptop_store/public/index.php?page=admin_contacts">Quản lý liên hệ</a></li>

  <li><a href="/laptop_store/public/index.php?page=admin_products">Quản lý sản phẩm</a></li>

  <li><a href="/laptop_store/public/index.php?page=admin_news">Quản lý bài viết</a></li>

  <li><a href="/laptop_store/public/index.php?page=admin_orders">Quản lý đơn hàng</a></li>

  <li><a href="/laptop_store/public/index.php?page=admin_faqs">Quản lý FAQ</a></li>

  <li><a href="/laptop_store/public/index.php?page=admin_about">Chỉnh sửa trang Về Chúng Tôi</a></li>
</ul>
