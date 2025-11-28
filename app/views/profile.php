<?php
$user = $_SESSION['user'] ?? null;
if (is_array($user)) {
  $user = array_merge([
    'id' => null,
    'username' => '',
    'role' => '',
    'fullname' => '',
    'email' => '',
    'phone' => '',
    'address' => '',
    'avatar' => ''
  ], $user);
}
if (!$user) {
  echo '<div class="alert alert-danger">Bạn cần đăng nhập.</div>';
  return;
}
$errors = $_SESSION['profile_errors'] ?? [];
$old    = $_SESSION['profile_old'] ?? [];
unset($_SESSION['profile_errors'], $_SESSION['profile_old']);
$avatarUrl = !empty($user['avatar']) ? '/laptop_store/public/avatars/' . htmlspecialchars($user['avatar']) : 'https://placehold.co/160x160?text=Avatar';
?>
<div class="container my-4" style="max-width: 800px;">
  <h2 class="mb-3">Thông tin cá nhân</h2>

  <div class="card mb-4">
    <div class="card-body d-flex flex-column align-items-center position-relative" style="padding:24px;">
      <div class="position-relative" style="width:160px;height:160px;">
        <img src="<?= $avatarUrl ?>" alt="Avatar" class="rounded-circle" style="width:160px;height:160px;object-fit:cover;">
        <button type="button" class="btn btn-sm btn-primary position-absolute" style="right:6px;bottom:6px;border-radius:999px;padding:6px 10px;" data-bs-toggle="modal" data-bs-target="#avatarModal" aria-label="Đổi ảnh">
          <i class="fa-solid fa-pen"></i>
        </button>
      </div>
      <div class="mt-3 text-center">
        <div><strong>Tài khoản:</strong> <?= htmlspecialchars($user['username']) ?></div>
        <div><strong>Vai trò:</strong> <?= htmlspecialchars($user['role']) ?></div>
      </div>
    </div>
  </div>

  <form id="profileForm" action="/laptop_store/public/index.php?page=profile_update" method="post" class="card" novalidate>
    <div class="card-body">
      <div class="row g-3 mb-3">
        <div class="col-md-6">
          <label class="form-label">Tài khoản</label>
          <input type="text" class="form-control" value="<?= htmlspecialchars($user['username']) ?>" disabled>
        </div>
        <div class="col-md-6">
          <label class="form-label">Vai trò</label>
          <input type="text" class="form-control" value="<?= htmlspecialchars($user['role']) ?>" disabled>
        </div>
      </div>
      <div class="mb-3">
        <label class="form-label">Họ và tên</label>
        <input type="text" name="fullname" class="form-control<?= isset($errors['fullname']) ? ' is-invalid' : '' ?>" value="<?= htmlspecialchars(($old['fullname'] ?? $user['fullname']) ?? '') ?>" required>
        <div class="invalid-feedback"><?= isset($errors['fullname']) ? htmlspecialchars($errors['fullname']) : 'Vui lòng nhập họ và tên.' ?></div>
      </div>
      <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control<?= isset($errors['email']) ? ' is-invalid' : '' ?>" value="<?= htmlspecialchars(($old['email'] ?? $user['email']) ?? '') ?>">
        <div class="invalid-feedback"><?= isset($errors['email']) ? htmlspecialchars($errors['email']) : 'Email không hợp lệ.' ?></div>
      </div>
      <div class="mb-3">
        <label class="form-label">Số điện thoại</label>
        <input type="text" name="phone" class="form-control<?= isset($errors['phone']) ? ' is-invalid' : '' ?>" value="<?= htmlspecialchars(($old['phone'] ?? $user['phone']) ?? '') ?>" pattern="^\+?[0-9\s\-]{8,15}$">
        <div class="invalid-feedback"><?= isset($errors['phone']) ? htmlspecialchars($errors['phone']) : 'Số điện thoại không hợp lệ.' ?></div>
      </div>
      <div class="mb-3">
        <label class="form-label">Địa chỉ</label>
        <input type="text" name="address" class="form-control<?= isset($errors['address']) ? ' is-invalid' : '' ?>" value="<?= htmlspecialchars(($old['address'] ?? $user['address']) ?? '') ?>">
        <div class="invalid-feedback"><?= isset($errors['address']) ? htmlspecialchars($errors['address']) : '' ?></div>
      </div>
    </div>
    <div class="card-footer text-end">
      <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
      <button type="button" class="btn btn-outline-secondary ms-2" data-bs-toggle="modal" data-bs-target="#passwordModal">Đổi mật khẩu</button>
    </div>
  </form>

  <!-- Avatar Modal -->
  <div class="modal modal-blur fade" id="avatarModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Cập nhật ảnh đại diện</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="/laptop_store/public/index.php?page=profile_update" method="post" enctype="multipart/form-data">
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label">Chọn ảnh (PNG/JPG/WEBP)</label>
              <input type="file" name="avatar" class="form-control" accept="image/png,image/jpeg,image/webp" required>
              <div class="form-text">Dung lượng tối đa đề nghị 2MB.</div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn" data-bs-dismiss="modal">Hủy</button>
            <button type="submit" class="btn btn-primary">Tải lên</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- Password Change Modal -->
  <div class="modal modal-blur fade" id="passwordModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Đổi mật khẩu</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="passwordForm" action="/laptop_store/public/index.php?page=profile_update" method="post" novalidate>
          <div class="modal-body">
            <p class="text-muted" style="font-size:0.85rem;">Nhập đầy đủ các trường để thay đổi mật khẩu. Để trống nếu không muốn đổi.</p>
            <div class="mb-3">
              <label class="form-label">Mật khẩu hiện tại</label>
              <div class="input-group">
                <input type="password" name="current_password" class="form-control<?= isset($errors['current_password']) ? ' is-invalid' : '' ?>" autocomplete="current-password">
                <button type="button" class="btn btn-outline-secondary toggle-visibility" tabindex="-1">Hiện</button>
              </div>
              <div class="invalid-feedback"><?= isset($errors['current_password']) ? htmlspecialchars($errors['current_password']) : 'Nhập mật khẩu hiện tại.' ?></div>
            </div>
            <div class="mb-3">
              <label class="form-label">Mật khẩu mới</label>
              <div class="input-group">
                <input type="password" name="new_password" class="form-control<?= isset($errors['new_password']) ? ' is-invalid' : '' ?>" autocomplete="new-password">
                <button type="button" class="btn btn-outline-secondary toggle-visibility" tabindex="-1">Hiện</button>
              </div>
              <div class="form-text">Có thể để trống nếu không đổi.</div>
              <div class="invalid-feedback"><?= isset($errors['new_password']) ? htmlspecialchars($errors['new_password']) : 'Mật khẩu mới không hợp lệ.' ?></div>
            </div>
            <div class="mb-3">
              <label class="form-label">Xác nhận mật khẩu mới</label>
              <div class="input-group">
                <input type="password" name="confirm_password" class="form-control<?= isset($errors['confirm_password']) ? ' is-invalid' : '' ?>" autocomplete="new-password">
                <button type="button" class="btn btn-outline-secondary toggle-visibility" tabindex="-1">Hiện</button>
              </div>
              <div class="invalid-feedback"><?= isset($errors['confirm_password']) ? htmlspecialchars($errors['confirm_password']) : 'Không khớp mật khẩu.' ?></div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn" data-bs-dismiss="modal">Hủy</button>
            <button type="submit" class="btn btn-primary">Cập nhật mật khẩu</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
$(function(){
  function validateEmail(v){ return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v); }
  function setMark($el, status){
    if (status === undefined) { $el.removeClass('is-valid is-invalid'); }
    else if (status) { $el.addClass('is-valid').removeClass('is-invalid'); }
    else { $el.addClass('is-invalid').removeClass('is-valid'); }
  }
  function validateField($el, type, onlyIfUntouched){
    var touched = $el.data('touched') === true;
    if (onlyIfUntouched && !touched) { setMark($el, undefined); return; }
    var val = ($el.val() || '').trim();
    if (type === 'fullname') setMark($el, val.length <= 100 && val.length>0);
    else if (type === 'email') { if (val.length===0) setMark($el, undefined); else setMark($el, validateEmail(val) && val.length<=100); }
    else if (type === 'phone') { if (val.length===0) setMark($el, undefined); else setMark($el, /^\+?[0-9\s\-]{8,15}$/.test(val) && val.length<=20); }
    else if (type === 'address') { if (val.length===0) setMark($el, undefined); else setMark($el, val.length<=255); }
  }
  var $form = $('#profileForm');
  var $fullname = $form.find('input[name="fullname"]');
  var $email = $form.find('input[name="email"]');
  var $phone = $form.find('input[name="phone"]');
  [$fullname, $email, $phone].forEach(function($el){
    $el.on('input blur change', function(){ if(!$el.data('touched')) $el.data('touched', true); validateField($el, $el.attr('name'), true); });
  });
  $form.on('submit', function(e){ [$fullname,$email,$phone].forEach(function($el){ $el.data('touched', true); validateField($el,$el.attr('name'), false); }); if ($form.find('.is-invalid').length){ e.preventDefault(); }});

  // Password modal
  var $pwForm = $('#passwordForm');
  var $currentPw = $pwForm.find('input[name="current_password"]');
  var $newPw = $pwForm.find('input[name="new_password"]');
  var $confirmPw = $pwForm.find('input[name="confirm_password"]');
  function validatePasswordModal(onlyIfUntouched){
    var mode = ($currentPw.val().trim() || $newPw.val().trim() || $confirmPw.val().trim()) !== '';
    [$currentPw,$newPw,$confirmPw].forEach(function($el){ var touched=$el.data('touched')===true; if(onlyIfUntouched && !touched){ setMark($el, undefined);} });
    if(!mode){ setMark($currentPw,undefined); setMark($newPw,undefined); setMark($confirmPw,undefined); return; }
    setMark($currentPw, $currentPw.val().trim().length>0);
    var np=$newPw.val().trim(); var npValid = np.length>0; setMark($newPw, npValid);
    var cp=$confirmPw.val().trim(); setMark($confirmPw, npValid && cp===np && cp.length>0);
  }
  $pwForm.find('input').on('input blur change', function(){ var $el=$(this); if(!$el.data('touched')) $el.data('touched',true); validatePasswordModal(true); });
  $pwForm.on('submit', function(e){ $pwForm.find('input').each(function(){ $(this).data('touched', true); }); validatePasswordModal(false); if ($pwForm.find('.is-invalid').length){ e.preventDefault(); }});
  $('#passwordModal').on('click','.toggle-visibility', function(){ var $input=$(this).closest('.input-group').find('input'); if($input.attr('type')==='password'){ $input.attr('type','text'); $(this).text('Ẩn'); } else { $input.attr('type','password'); $(this).text('Hiện'); } });
  var passwordErrors = <?= json_encode(array_intersect_key($errors, array_flip(['current_password','new_password','confirm_password']))) ?>; if(Object.keys(passwordErrors).length>0){ var pwdModal=new bootstrap.Modal(document.getElementById('passwordModal')); pwdModal.show(); }
});
</script>
