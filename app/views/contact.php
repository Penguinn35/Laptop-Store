<h2>Liên hệ với chúng tôi</h2>

<form id="contactForm">
  <input type="text" name="name" placeholder="Họ và tên" required>
  <input type="email" name="email" placeholder="Email" required>
  <input type="text" name="subject" placeholder="Tiêu đề" required>
  <textarea name="message" placeholder="Nội dung" required></textarea>
  <button type="submit">Gửi liên hệ</button>
</form>

<p id="contactStatus"></p>

<script>
$("#contactForm").on("submit", e => {
  e.preventDefault();

  $.post("/laptop_store/public/api/contact/send.php",
    $("#contactForm").serialize(),
    res => {
      $("#contactStatus").text(res.message);
    },
    "json"
  );
});
</script>
