<form id="registerForm" class=" card-body p-4" style="max-width: 500px; margin: auto;">
  <h3 class="card-title mb-3">Đăng ký tài khoản</h3>

  <div class="mb-3">
    <label class="form-label">Tên đăng nhập</label>
    <input class="form-control" type="text" name="username" required>
  </div>

  <div class="mb-3">
    <label class="form-label">Họ và tên</label>
    <input class="form-control" type="text" name="fullname" required>
  </div>

  <div class="mb-3">
    <label class="form-label">Email</label>
    <input class="form-control" type="email" name="email" required>
  </div>

  <div class="mb-3">
    <label class="form-label">Mật khẩu</label>
    <input class="form-control" type="password" name="password" required>
  </div>

  <div class="mb-3">
    <label class="form-label">Số điện thoại (không bắt buộc)</label>
    <input class="form-control" type="text" name="phone">
  </div>

  <div class="mb-3">
    <label class="form-label">Địa chỉ (không bắt buộc)</label>
    <input class="form-control" type="text" name="address">
  </div>

  <div class="mt-2">
    <button type="submit" class="btn btn-primary w-100">Đăng ký</button>
  </div>

  <p id="registerError" class="text-danger mt-2"></p>
</form>


<script>
$("#registerForm").on("submit", function (e) {
  e.preventDefault();
  $.ajax({
    url: "/laptop_store/public/api/auth/register_action.php",
    type: "POST",
    data: $(this).serialize(),
    dataType: "json",
    success: function (res) {
      console.log(res);
      if (res.status === "ok") {
        alert("Đăng ký thành công, vui lòng đăng nhập.");
        location.reload();
      } else {
        $("#registerError").text(res.message);
      }
    },
    error: function (xhr) {
      $("#registerError").text("Lỗi khi gửi dữ liệu: " + xhr.responseText);
    }
  });
});
</script>
