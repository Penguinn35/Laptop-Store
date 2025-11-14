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

  <div class="navbar-wrap">
    <nav class="navbar">

      <!-- Logo -->
      <a class="logo" href="index.php">LaptopStore</a>

      <!-- Hamburger icon (mobile only) -->
      <div class="hamburger" id="hamburgerBtn">
        <span></span><span></span><span></span>
      </div>

      <!-- Nav links -->
      <ul class="nav-links" id="navLinks">
        <li><a href="index.php">Trang chủ</a></li>
        <li><a href="products.php">Sản phẩm</a></li>
        <li><a href="news.php">Tin tức</a></li>
        <li><a href="contact.php">Liên hệ</a></li>
        <li class="mobile-user">
          <?php if (!$isLoggedIn): ?>
            <button id="loginBtn_mobile" class="btn-small">Đăng nhập</button>
            <button id="registerBtn_mobile" class="btn-small">Đăng ký</button>
          <?php else: ?>
            <a href="profile.php">Thay đổi thông tin</a>
            <a href="logout.php">Đăng xuất</a>
          <?php endif; ?>
        </li>
      </ul>


      <!-- User section -->
      <div class="user">
        <?php if (!$isLoggedIn): ?>
          <button id="loginBtn" class="btn-small">Đăng nhập</button>
          <button id="registerBtn" class="btn-small">Đăng ký</button>
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
  </div>


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

    $("#loginBtn_mobile").on("click", () => {
      $.get("ajax/login_form.php", html => {
        popupContent.html(html);
        overlay.addClass("show");
      });
    });

    $("#registerBtn_mobile").on("click", () => {
      $.get("ajax/register_form.php", html => {
        popupContent.html(html);
        overlay.addClass("show");
      });
    });


    $(".close").on("click", () => overlay.removeClass("show"));
    $(window).on("click", e => {
      if ($(e.target).is("#popupOverlay")) overlay.removeClass("show");
    });

    document.getElementById("hamburgerBtn").addEventListener("click", () => {
      document.getElementById("navLinks").classList.toggle("show");
    });

    // Close mobile menu when clicking outside
    window.addEventListener("click", (e) => {
      if (!e.target.closest(".navbar")) {
        document.getElementById("navLinks").classList.remove("show");
      }
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