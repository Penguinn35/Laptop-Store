<div style="margin: 0px auto; margin-top: 120px;  width: 98%; max-width:1200px ">

  <h2 class="mb-4 ">Cài đặt trang</h2>

  <form method="post"
    action="/laptop_store/public/index.php?page=save_settings"
    enctype="multipart/form-data">

    <!-- ===== HOME SECTION ===== -->
    <h3 class="mb-3">Home Page</h3>

    <div class="mb-3">
      <label class="form-label">Tiêu đề giới thiệu</label>
      <input
        type="text"
        class="form-control"
        name="home_intro_title"
        value="<?= $settings['home_intro_title'] ?>">
    </div>

    <div class="mb-3">
      <label class="form-label">Mô tả giới thiệu</label>
      <textarea
        class="form-control"
        name="home_intro_desc"
        rows="3"><?= $settings['home_intro_desc'] ?></textarea>
    </div>

    <div class="mb-3">
      <label class="form-label">Số điện thoại</label>
      <input
        type="text"
        class="form-control"
        name="company_phone"
        value="<?= $settings['company_phone'] ?>">
    </div>

    <hr class="my-4">

    <!-- ===== ABOUT SECTION ===== -->
    <h3 class="mb-3">About Page</h3>

    <div class="mb-3">
      <label class="form-label">About Title</label>
      <input
        type="text"
        class="form-control"
        name="about_title"
        value="<?= $settings['about_title'] ?>">
    </div>

    <div class="mb-3">
      <label class="form-label">About Subtitle</label>
      <input
        type="text"
        class="form-control"
        name="about_subtitle"
        value="<?= $settings['about_subtitle'] ?>">
    </div>

    <div class="mb-3">
      <label class="form-label">Sứ mệnh (About Mission)</label>
      <textarea
        class="form-control"
        name="about_mission"
        rows="3"><?= $settings['about_mission'] ?></textarea>
    </div>

    <div class="mb-3">
      <label class="form-label">Giá trị cốt lõi (About Values)</label>
      <textarea
        class="form-control"
        name="about_val"
        rows="3"><?= $settings['about_values'] ?></textarea>
    </div>


    <div class="mb-3">
      <label class="form-label">Banner trang chủ (banner.jpg)</label>
      <input
        class="form-control"
        type="file"
        id="bannerInput"
        name="banner_image"
        accept="image/*">
      <small class="form-hint">Chọn ảnh mới để thay thế banner hiện tại.</small>
    </div>

    <div class="row">
      <div class="col-md-6 mb-3">
        <label class="form-label">Ảnh hiện tại</label>
        <div style="max-width: 100%;">
          <img
            id="currentBanner"
            src="/laptop_store/public/images/banner.jpg"
            style="width: 100%; border:1px solid #ccc; border-radius:4px;"
            alt="Banner hiện tại">
        </div>
      </div>

      <div class="col-md-6 mb-3">
        <label class="form-label">Ảnh mới (preview)</label>
        <div style="max-width: 100%;">
          <img
            id="newBannerPreview"
            src=""
            style="width: 100%; border:1px solid #ccc; border-radius:4px;"
            alt="Preview banner mới">
        </div>
      </div>
    </div>
    <div class="mt-4">
      <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
    </div>
  </form>
</div>



<script>
  const bannerInput = document.getElementById('bannerInput');
  const newBannerPreview = document.getElementById('newBannerPreview');

  bannerInput.addEventListener('change', (e) => {
    const file = e.target.files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = function(event) {
      newBannerPreview.src = event.target.result;
    };
    reader.readAsDataURL(file);
  });
</script>