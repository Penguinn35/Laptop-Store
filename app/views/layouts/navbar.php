<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
$isLoggedIn = isset($_SESSION['user']);
$user = $_SESSION['user'] ?? null;

$cartCount = 0;
if (isset($_SESSION['cart'])) {
  foreach ($_SESSION['cart'] as $qty) {
    $cartCount += $qty;
  }
}
?>

<script>
  // Biến global để JS khác (cart.js) dùng
  window.isLoggedIn = <?= $isLoggedIn ? 'true' : 'false' ?>;
</script>

<!-- NAVBAR -->
<div class="myNavbar-wrap">
  <nav class="myNavbar">

    <!-- Logo -->
    <a class="logo" href="index.php?page=home">LaptopStore</a>

    <!-- Hamburger icon (mobile only) -->
    <div class="hamburger" id="hamburgerBtn">
      <span></span><span></span><span></span>
    </div>

    <!-- Nav links -->
    <ul class="myNav-links" id="navLinks">
      <li><a href="index.php?page=home">Trang chủ</a></li>
      <li><a href="index.php?page=products">Sản phẩm</a></li>
      <li><a href="index.php?page=news">Tin tức</a></li>
      <li><a href="index.php?page=contact">Liên hệ</a></li>
      <li><a href="index.php?page=faq">FAQ</a></li>
      <li><a href="index.php?page=about">Về chúng tôi</a></li>

      <!-- Mobile user section -->
      <li class="mobile-user">
        <?php if (!$isLoggedIn): ?>
          <button id="loginBtn_mobile" class="btn-small">Đăng nhập</button>
          <button id="registerBtn_mobile" class="btn-small">Đăng ký</button>
        <?php else: ?>
          <?php if ($user['role'] === 'admin'): ?>
            <a href="/laptop_store/public/index.php?page=admin" class="admin-btn-mobile">Dashboard</a>
          <?php endif; ?>
          <a href="/laptop_store/public/index.php?page=profile">Thay đổi thông tin</a>
          <a href="/laptop_store/public/index.php?page=logout">Đăng xuất</a>
        <?php endif; ?>
      </li>
    </ul>

    <!-- User + Cart -->
    <div class="user">
      <?php if ($isLoggedIn): ?>
        <?php if ($user['role'] === 'admin'): ?>
          <a href="index.php?page=admin" class="btn-small admin-btn">Dashboard</a>
        <?php endif; ?>

        <div class="user-menu">
          <div class="userGrap">
            <?php
              $avatar = $user['avatar'] ?? '';
              $avatarUrl = $avatar ? "/laptop_store/public/avatars/" . htmlspecialchars($avatar) : '';
            ?>
            <?php if ($avatarUrl): ?>
              <img src="<?= $avatarUrl ?>" alt="Avatar" id="userDropdown" class="rounded-circle" style="width:36px;height:36px;object-fit:cover;">
            <?php else: ?>
              <div class="userRound">
                <i class="fa-regular fa-user" id="userDropdown"></i>
              </div>
            <?php endif; ?>
            <div class="userText">
              <p>Welcome,</p>
              <p><?= htmlspecialchars($user['username']) ?></p>
            </div>
          </div>
          <div class="dropdown" id="dropdownMenu">
            <a href="index.php?page=profile">Thay đổi thông tin</a>
            <a href="index.php?page=logout">Đăng xuất</a>
          </div>
        </div>
      <?php else: ?>
        <button id="loginBtn" class="Btn">Đăng nhập</button>
        <button id="registerBtn" class="Btn">Đăng ký</button>
      <?php endif; ?>

      <!-- GIỎ HÀNG: LUÔN HIỂN THỊ -->
      <div class="nav-item me-3">
        <a href="index.php?page=cart"
           id="cartLink"
           class="btn btn-outline-dark position-relative border-0"
           style="padding: 15px;">
          <i class="fas fa-shopping-cart fa-lg"></i>
          <span id="cart-badge"
                class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                style="<?php echo $cartCount > 0 ? '' : 'display:none'; ?>">
            <?= $cartCount ?>
          </span>
        </a>
      </div>

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

  // Hàm dùng chung để mở form Đăng nhập
  window.openLoginPopup = function() {
    $.get("api/auth/login_form.php", html => {
      popupContent.html(html);
      overlay.addClass("show");

      $("#loginForm").on("submit", e => {
        e.preventDefault();
        $.post(
          "api/auth/login_action.php",
          $("#loginForm").serialize(),
          res => {
            if (res.status === "ok" || res.status === "admin") {
              location.reload();
            } else {
              $("#loginError").text(res.message);
            }
          },
          "json"
        );
      });
    });
  };

  // Đăng nhập / Đăng ký desktop
  $("#loginBtn").on("click", () => {
    openLoginPopup();
  });

  $("#registerBtn").on("click", () => {
    $.get("api/auth/register_form.php", html => {
      popupContent.html(html);
      overlay.addClass("show");
    });
  });

  // Đăng nhập / Đăng ký mobile
  $("#loginBtn_mobile").on("click", () => {
    $("#navLinks").removeClass("show");
    openLoginPopup();
  });

  $("#registerBtn_mobile").on("click", () => {
    $("#navLinks").removeClass("show");
    $.get("api/auth/register_form.php", html => {
      popupContent.html(html);
      overlay.addClass("show");
    });
  });

  // CLICK GIỎ HÀNG: NẾU CHƯA LOGIN THÌ MỞ POPUP
  $("#cartLink").on("click", function(e) {
    if (!window.isLoggedIn) {
      e.preventDefault();
      openLoginPopup();
    }
  });

  // Đóng popup
  $(".close").on("click", () => overlay.removeClass("show"));
  $(window).on("click", e => {
    if ($(e.target).is("#popupOverlay")) overlay.removeClass("show");
  });

  // Menu mobile
  document.getElementById("hamburgerBtn").addEventListener("click", () => {
    document.getElementById("navLinks").classList.toggle("show");
  });

  window.addEventListener("click", (e) => {
    if (!e.target.closest(".myNavbar")) {
      document.getElementById("navLinks").classList.remove("show");
    }
  });

  // Dropdown user
  const userIcon = document.getElementById('userDropdown');
  const dropdown = document.getElementById('dropdownMenu');
  if (userIcon) {
    userIcon.addEventListener('click', () => dropdown.classList.toggle('show'));
    window.addEventListener('click', e => {
      if (!e.target.closest('.user-menu')) dropdown.classList.remove('show');
    });
  }
</script>
