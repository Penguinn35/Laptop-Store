<section class="hero">
  <img src="images/banner.jpg" class="hero-img">

  <div class="hero-text">
    <h1><?= $settings['home_intro_title'] ?></h1>
    <p><?= $settings['home_intro_desc'] ?></p>
    <a href="index.php?page=products" class="btn">Xem sản phẩm</a>
  </div>
</section>

<section class="about">
  <div class="container ">
    <h2>Về <?= $settings['company_name'] ?></h2>
    <p>Địa chỉ: <?= $settings['company_address'] ?></p>
    <p>Hotline: <?= $settings['company_phone'] ?></p>
    <p>Email: <?= $settings['company_email'] ?></p>
  </div>
</section>

<section class="features">
  <div class="container grid-3">
    <div class="feature-box">
      <h3>Bảo hành chính hãng</h3>
      <p>Cam kết bảo hành 12 - 24 tháng cho tất cả sản phẩm.</p>
    </div>
    <div class="feature-box">
      <h3>Giao hàng nhanh</h3>
      <p>Giao hàng miễn phí tại các thành phố lớn.</p>
    </div>
    <div class="feature-box">
      <h3>Hỗ trợ 24/7</h3>
      <p>Luôn có đội ngũ hỗ trợ khi bạn gặp vấn đề.</p>
    </div>
  </div>
</section>
