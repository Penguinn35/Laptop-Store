<form id="registerForm">
  <h3>Đăng ký tài khoản</h3>
  <input type="text" name="username" placeholder="Tên đăng nhập" required>
  <input type="text" name="fullname" placeholder="Họ và tên" required>
  <input type="email" name="email" placeholder="Email" required>
  <input type="password" name="password" placeholder="Mật khẩu" required>
  <input type="text" name="phone" placeholder="Số điện thoại (không bắt buộc)">
  <input type="text" name="address" placeholder="Địa chỉ (không bắt buộc)">
  <button type="submit">Đăng ký</button>
  <p id="registerError" style="color:red;"></p>
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
