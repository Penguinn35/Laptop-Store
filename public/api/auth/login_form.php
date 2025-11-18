<form id="loginForm" autocomplete="on">
  <h3>Đăng nhập</h3>

  <input 
    type="text" 
    name="login" 
    placeholder="Tên đăng nhập hoặc Email" 
    required
    autocomplete="username"
  >

  <input 
    type="password" 
    name="password" 
    placeholder="Mật khẩu" 
    required
    autocomplete="current-password"
  >

  <button type="submit">Đăng nhập</button>
  <p id="loginError" style="color:red;"></p>
</form>

