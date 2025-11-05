<form id="loginForm">
  <h3>Đăng nhập</h3>
  <input type="text" name="login" placeholder="Tên đăng nhập hoặc Email" required>
  <input type="password" name="password" placeholder="Mật khẩu" required>
  <button type="submit">Đăng nhập</button>
  <p id="loginError" style="color:red;"></p>
</form>

<script>
  $("#loginForm").on("submit", e => {
    e.preventDefault();
    $.post("ajax/login_action.php", $("#loginForm").serialize(), res => {
      if (res.status === "ok") location.reload();
      else $("#loginError").text(res.message);
    }, "json");
  });
</script>