<h2>Cài đặt trang Home</h2>

<form method="post" action="/laptop_store/public/index.php?page=save_settings">
  <label>Tiêu đề giới thiệu:</label>
  <input type="text" name="home_intro_title" value="<?= $settings['home_intro_title'] ?>">

  <label>Mô tả giới thiệu:</label>
  <textarea name="home_intro_desc"><?= $settings['home_intro_desc'] ?></textarea>

  <label>Số điện thoại:</label>
  <input type="text" name="company_phone" value="<?= $settings['company_phone'] ?>">

  <button type="submit">Lưu</button>
</form>
