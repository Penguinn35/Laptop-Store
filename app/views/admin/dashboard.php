<link href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta19/dist/css/tabler.min.css" rel="stylesheet"/>

<div class="page-wrapper admindashboard-grap">
  <div class="container-xl">
    <div class="page-header d-print-none">
      <div class="row align-items-center">
        <div class="col mb-4">
          <h2 class="page-title">Admin Dashboard</h2>
          <div class="text-muted mt-1">
            Welcome, <?= htmlspecialchars($_SESSION['user']['fullname']) ?>!
          </div>
        </div>
      </div>
    </div>

    <div class="row row-cards">

      <div class="col-md-4">
        <a href="/laptop_store/public/index.php?page=admin_settings" class="card admin-card">
          <div class="card-body text-center">
            <i class="fa-solid fa-gear admin-icon"></i>
            <h3 class="card-title mt-2">Cài đặt hệ thống</h3>
          </div>
        </a>
      </div>

      <div class="col-md-4">
        <a href="/laptop_store/public/index.php?page=admin_contacts" class="card admin-card">
          <div class="card-body text-center">
            <i class="fa-solid fa-envelope admin-icon"></i>
            <h3 class="card-title mt-2">Quản lý liên hệ</h3>
          </div>
        </a>
      </div>

      <div class="col-md-4">
        <a href="/laptop_store/public/index.php?page=admin_products" class="card admin-card">
          <div class="card-body text-center">
            <i class="fa-solid fa-laptop admin-icon"></i>
            <h3 class="card-title mt-2">Quản lý sản phẩm</h3>
          </div>
        </a>
      </div>

      <div class="col-md-4">
        <a href="/laptop_store/public/index.php?page=admin_news" class="card admin-card">
          <div class="card-body text-center">
            <i class="fa-solid fa-newspaper admin-icon"></i>
            <h3 class="card-title mt-2">Quản lý bài viết</h3>
          </div>
        </a>
      </div>

      <div class="col-md-4">
        <a href="/laptop_store/public/index.php?page=admin_orders" class="card admin-card">
          <div class="card-body text-center">
            <i class="fa-solid fa-box admin-icon"></i>
            <h3 class="card-title mt-2">Quản lý đơn hàng</h3>
          </div>
        </a>
      </div>

      <div class="col-md-4">
        <a href="/laptop_store/public/index.php?page=admin_faqs" class="card admin-card">
          <div class="card-body text-center">
            <i class="fa-solid fa-question admin-icon"></i>
            <h3 class="card-title mt-2">Quản lý FAQ</h3>
          </div>
        </a>
      </div>

      <div class="col-md-4">
        <a href="/laptop_store/public/index.php?page=admin_about" class="card admin-card">
          <div class="card-body text-center">
            <i class="fa-solid fa-circle-info admin-icon"></i>
            <h3 class="card-title mt-2">Chỉnh sửa trang Về Chúng Tôi</h3>
          </div>
        </a>
      </div>

    </div>
  </div>
</div>