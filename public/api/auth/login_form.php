<form id="loginForm" autocomplete="on" class=" card-body p-4" style=" max-width: 500px; margin: auto;">
  <h3 class="card-title mb-3">Đăng nhập</h3>

  <div class="mb-3">
    <label class="form-label">Tên đăng nhập hoặc Email</label>
    <input 
      class="form-control"
      type="text"
      name="login"
      placeholder="Nhập tên đăng nhập hoặc email"
      required
      autocomplete="username"
    >
  </div>

  <div class="mb-3">
    <label class="form-label">Mật khẩu</label>
    <input 
      class="form-control"
      type="password"
      name="password"
      placeholder="Nhập mật khẩu"
      required
      autocomplete="current-password"
    >
  </div>

  <div class="mt-2">
    <button type="submit" class="btn btn-primary w-100">Đăng nhập</button>
  </div>

  <p id="loginError" class="text-danger mt-2"></p>
</form>
