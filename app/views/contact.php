<div class="contact-wrap">
  <h1>Liên hệ với chúng tôi</h1>

  <div id="contactContainer">
    <form id="contactForm">
      <input type="text" name="name" placeholder="Họ và tên" required>
      <input type="email" name="email" placeholder="Email" required>
      <input type="text" name="subject" placeholder="Tiêu đề" required>
      <textarea name="message" placeholder="Nội dung" required></textarea>
      <button type="submit"><i class="fa-solid fa-paper-plane"></i> Gửi liên hệ</button>
    </form>
  </div>
</div>


<script>
  $("#contactForm").on("submit", function(e) {
    e.preventDefault();

    $.post(
      "/laptop_store/public/api/contact/send.php",
      $("#contactForm").serialize(),
      res => {
        if (res.status === true) {
          $("#contactContainer").fadeOut(300, () => {
            $("#contactContainer").html(`
            <div class="contact-success">
              <i class="fa-solid fa-circle-check"></i>
              <p>${res.message}</p>
            </div>
          `).fadeIn(300);
          });
        } else {
          $("#contactContainer").append(`
          <p class="contact-error">${res.message}</p>
        `);
        }
      },
      "json"
    );
  });
</script>