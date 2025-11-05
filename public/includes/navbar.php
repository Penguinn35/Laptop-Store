<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <title>Laptop Store Việt Nam</title>
  <link rel="stylesheet" href="css/style.css">
</head>

<body>
  <?php
  session_start();
  $isLoggedIn = isset($_SESSION['user']);
  $user = $_SESSION['user'] ?? null;
  ?>


  <!-- NAVBAR -->

  <nav class="navbar">
    <div class="logo">LaptopStore</div>

    <input type="checkbox" id="menu-toggle" />
    <label for="menu-toggle" class="menu-icon">&#9776;</label>

    <ul class="nav-links">
      <li><a href="index.php">Trang chủ</a></li>
      <li><a href="products.php">Sản phẩm</a></li>
      <li><a href="news.php">Tin tức</a></li>
      <li><a href="contact.php">Liên hệ</a></li>
    </ul>

    <div class="user">
      <?php if (!$isLoggedIn): ?>
        <button id="loginBtn" class="btn">Đăng nhập</button>
        <button id="registerBtn" class="btn btn-outline">Đăng ký</button>
      <?php else: ?>
        <div class="user-menu">
          <img src="assets/user.png" alt="User" class="user-icon" id="userDropdown">
          <div class="dropdown" id="dropdownMenu">
            <a href="profile.php">Thay đổi thông tin</a>
            <a href="logout.php">Đăng xuất</a>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </nav>

  <div style="height:70px"></div>

  <!-- Popup -->
  <div id="popupOverlay" class="overlay">
    <div class="popup">
      <span class="close">&times;</span>
      <div id="popupContent"></div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    const overlay = $("#popupOverlay");
    const popupContent = $("#popupContent");

    $("#loginBtn").on("click", () => {
      $.get("ajax/login_form.php", html => {
        popupContent.html(html);
        overlay.addClass("show");
      });
    });

    $("#registerBtn").on("click", () => {
      $.get("ajax/register_form.php", html => {
        popupContent.html(html);
        overlay.addClass("show");
      });
    });

    $(".close").on("click", () => overlay.removeClass("show"));
    $(window).on("click", e => {
      if ($(e.target).is("#popupOverlay")) overlay.removeClass("show");
    });

    // user dropdown
    const userIcon = document.getElementById('userDropdown');
    const dropdown = document.getElementById('dropdownMenu');
    if (userIcon) {
      userIcon.addEventListener('click', () => dropdown.classList.toggle('show'));
      window.addEventListener('click', e => {
        if (!e.target.closest('.user-menu')) dropdown.classList.remove('show');
      });
    }
  </script>