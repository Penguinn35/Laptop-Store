<?php
session_start();
$isLoggedIn = isset($_SESSION['user']);
$user = $_SESSION['user'] ?? null;
?>


<!-- NAVBAR -->

<div class="navbar-wrap">
  <nav class="site-navbar">

    <!-- Logo -->
    <a class="logo" href="/laptop_store/public/index.php?page=home">LaptopStore</a>

    <!-- Hamburger icon (mobile only) -->
    <div class="hamburger" id="hamburgerBtn">
      <span></span><span></span><span></span>
    </div>

    <!-- Nav links -->
    <ul class="nav-links" id="navLinks">
      <li><a href="/laptop_store/public/index.php?page=home">Trang chủ</a></li>
      <li><a href="/laptop_store/public/index.php?page=products">Sản phẩm</a></li>
      <li><a href="/laptop_store/public/index.php?page=news">Tin tức</a></li>
      <li><a href="/laptop_store/public/index.php?page=contact">Liên hệ</a></li>
      <li><a href="/laptop_store/public/index.php?page=about">Về chúng tôi</a></li>
      <li><a href="/laptop_store/public/index.php?page=faq">FAQ</a></li>
      <li class="mobile-user">
        <?php if (!$isLoggedIn): ?>
          <button id="loginBtn_mobile" class="btn-small">Đăng nhập</button>
          <button id="registerBtn_mobile" class="btn-small">Đăng ký</button>
        <?php else: ?>
          <a href="profile.php">Thay đổi thông tin</a>
          <a href="/laptop_store/public/index.php?page=logout">Đăng xuất</a>
        <?php endif; ?>
      </li>
    </ul>


    <!-- User section -->
    <div class="user">
      <?php if ($isLoggedIn): ?>
        <?php if ($user['role'] === 'admin'): ?>
          <a href="/laptop_store/public/index.php?page=admin" class="btn-small admin-btn">Dashboard</a>
        <?php endif; ?>

        <div class="user-menu">
          <img src="/laptop_store/public/assets/user.png" alt="User" class="user-icon" id="userDropdown">
          <div class="dropdown" id="dropdownMenu">
            <a href="profile.php">Thay đổi thông tin</a>
            <a href="/laptop_store/public/index.php?page=logout">Đăng xuất</a>
          </div>
        </div>

      <?php else: ?>
        <button id="loginBtn" class="btn-small">Đăng nhập</button>
        <button id="registerBtn" class="btn-small">Đăng ký</button>
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
    $.get("/laptop_store/public/api/auth/login_form.php", html => {
      popupContent.html(html);
      overlay.addClass("show");


      $("#loginForm").on("submit", e => {
        console.log("in");

        e.preventDefault();
        $.post("/laptop_store/public/api/auth/login_action.php",
          $("#loginForm").serialize(),
          res => {
            if (res.status === "ok" | res.status === "admin") {
              location.reload();
            } else {
              $("#loginError").text(res.message);
            }
          },
          "json"
        );
      });
    });
  });






  $("#registerBtn").on("click", () => {
    $.get("/laptop_store/public/api/auth/register_form.php", html => {
      popupContent.html(html);
      overlay.addClass("show");
    });
  });

  $("#loginBtn_mobile").on("click", () => {
    $.get("/laptop_store/public/api/auth/login_form.php", html => {
      popupContent.html(html);
      overlay.addClass("show");


      $("#loginForm").on("submit", e => {
        console.log("in");

        e.preventDefault();
        $.post("/laptop_store/public/api/auth/login_action.php",
          $("#loginForm").serialize(),
          res => {
            if (res.status === "ok") {
              location.reload();
            } else {
              $("#loginError").text(res.message);
            }
          },
          "json"
        );
      });
    });
  });

  $("#registerBtn_mobile").on("click", () => {
    $.get("/laptop_store/public/api/auth/register_form.php", html => {
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

  window.addEventListener("click", (e) => {
    if (!e.target.closest(".site-navbar")) {
      document.getElementById("navLinks").classList.remove("show");
    }
  });

  const userIcon = document.getElementById('userDropdown');
  const dropdown = document.getElementById('dropdownMenu');
  if (userIcon) {
    userIcon.addEventListener('click', () => dropdown.classList.toggle('show'));
    window.addEventListener('click', e => {
      if (!e.target.closest('.user-menu')) dropdown.classList.remove('show');
    });
  }
</script>