<div class="page">
  <div class="page">
    <div class="about-container">

      <div class="card my-4 about-hero" style="background-image: url('/laptop_store/public/images/about_banner.jpg'); background-size: cover; background-position: center;">
        <div class="card-body p-0">
          <div class="hero-content">
            <div class="text-center text-white">
              <h1 class="display-4 mb-2"><?= htmlspecialchars($settings['about_title'] ?? 'Về chúng tôi') ?></h1>
              <p class="mb-0"><?= htmlspecialchars($settings['about_subtitle'] ?? 'Khám phá câu chuyện và giá trị cốt lõi của ' . htmlspecialchars($settings['company_name'])) ?></p>
            </div>
          </div>
        </div>
      </div>

      <div class="row gx-4 gy-4 mb-4 align-items-stretch">
        <div class="col-md-7">
          <div class="card about-card h-100">
            <div class="card-body">
              <h3 class="card-title">Sứ mệnh của chúng tôi</h3>
              <div class="card-text"><?= $settings['about_mission'] ?? 'Tại ' . htmlspecialchars($settings['company_name']) . ', sứ mệnh của chúng tôi là cung cấp những sản phẩm laptop chất lượng cao với giá cả hợp lý, đồng thời mang đến dịch vụ khách hàng xuất sắc. Chúng tôi cam kết không ngừng cải tiến và đổi mới để đáp ứng nhu cầu ngày càng cao của khách hàng.<br><br>Chúng tôi tin rằng công nghệ có thể thay đổi cuộc sống và chúng tôi muốn là cầu nối giúp khách hàng tiếp cận với những sản phẩm tốt nhất trên thị trường. Sự hài lòng của khách hàng luôn là ưu tiên hàng đầu của chúng tôi.' ?></div>
            </div>
          </div>
        </div>
        <div class="col-md-5">
          <div class="card about-card h-100">
            <div class="card-body d-flex flex-column">
              <h4 class="card-title">Giá trị cốt lõi</h4>
              <div class="about-values-list">
                <?= $settings['about_values'] ?? '<ul class="list-group list-group-flush"><li class="list-group-item"><strong>Chất Lượng:</strong> Chỉ cung cấp sản phẩm đạt tiêu chuẩn cao nhất.</li><li class="list-group-item"><strong>Đổi Mới:</strong> Luôn cập nhật công nghệ mới nhất.</li><li class="list-group-item"><strong>Dịch Vụ:</strong> Hỗ trợ và phục vụ khách hàng tận tâm.</li><li class="list-group-item"><strong>Trách Nhiệm:</strong> Đóng góp tích cực cho cộng đồng.</li></ul>' ?>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="mb-5 about-page-creators">
        <h4 class="card-title">Đội ngũ sáng lập</h4>
        <div class="creators-grid">
          <?php foreach ($creators as $creator): ?>
            <div class="creator-card">
              <?php
                $imgPath = __DIR__ . '/../../public/images/creator' . $creator['id'] . '.jpg';
                $ver = file_exists($imgPath) ? filemtime($imgPath) : time();
              ?>
              <img src="/laptop_store/public/images/creator<?= $creator['id'] ?>.jpg?v=<?= $ver ?>" alt="<?= htmlspecialchars($creator['name']) ?>" class="avatar avatar-xl mb-3 rounded-circle">
              <h5 class="mb-1"><?= htmlspecialchars($creator['name']) ?></h5>
              <div class="text-muted mb-2"><?= htmlspecialchars($creator['role']) ?></div>
              <p class="small text-muted"><?= htmlspecialchars($creator['bio']) ?></p>
            </div>
          <?php endforeach; ?>
        </div>
      </div>

    </div>
  </div>