<link href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta19/dist/css/tabler.min.css" rel="stylesheet" />
<div class="contact-manage-wrap">
  <h1>Quản lý liên hệ</h1>

  <table class="table table-striped" id="contactsTable">
    <thead>
      <tr>
        <th class="w-20">Họ tên</th>
        <th class="w-10">Email</th>
        <th class="w-20">Tiêu đề</th>
        <th class="w-30">Tin nhắn</th>
        <th class="w-8">Trạng thái</th>
        <th class="w-8">Hành động</th>
      </tr>
    </thead>

    <tbody>
      <?php foreach ($contacts as $c): ?>
        <?php
        $isRead = ($c['status'] === 'read');
        ?>
        <tr data-id="<?= $c['id'] ?>">
          <td><?= htmlspecialchars($c['name']) ?></td>
          <td class="email"><?= htmlspecialchars($c['email']) ?></td>
          <td><?= htmlspecialchars($c['subject']) ?></td>
          <td><?= htmlspecialchars($c['message']) ?></td>

          <td class="status-cell">
            <?php if ($isRead): ?>
              <span class="badge bg-success">Đã đọc</span>
            <?php else: ?>
              <span class="badge bg-warning">Chưa đọc</span>
            <?php endif; ?>
          </td>

          <td>
            <button
              class="btn btn-sm btn-primary mark-read"
              <?= $isRead ? 'disabled' : '' ?>>
              Đã đọc
            </button>

            <button class="btn btn-sm btn-danger delete-contact">Xoá</button>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>


  <div class="d-flex justify-content-center mt-4">
    <ul class="pagination">

      <!-- Previous -->
      <?php if ($page > 1): ?>
        <li class="page-item">
          <a class="page-link" href="/laptop_store/public/index.php?page=admin_contacts&p=<?= $page - 1 ?>">
            <i class="ti ti-chevron-left"></i>
            Trước
          </a>
        </li>
      <?php else: ?>
        <li class="page-item disabled">
          <span class="page-link">
            <i class="ti ti-chevron-left"></i>
            Trước
          </span>
        </li>
      <?php endif; ?>


      <!-- Page numbers -->
      <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <li class="page-item <?= $i == $page ? 'active' : '' ?>">
          <a class="page-link" href="/laptop_store/public/index.php?page=admin_contacts&p=<?= $i ?>">
            <?= $i ?>
          </a>
        </li>
      <?php endfor; ?>


      <!-- Next -->
      <?php if ($page < $totalPages): ?>
        <li class="page-item">
          <a class="page-link" href="/laptop_store/public/index.php?page=admin_contacts&p=<?= $page + 1 ?>">
            Sau
            <i class="ti ti-chevron-right"></i>
          </a>
        </li>
      <?php else: ?>
        <li class="page-item disabled">
          <span class="page-link">
            Sau
            <i class="ti ti-chevron-right"></i>
          </span>
        </li>
      <?php endif; ?>

    </ul>
  </div>
</div>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    const table = document.getElementById("contactsTable");

    // MARK AS READ
    table.addEventListener("click", async function(e) {
      if (e.target.classList.contains("mark-read")) {

        if (e.target.disabled) return;

        const row = e.target.closest("tr");
        const id = row.dataset.id;

        const res = await fetch(`/laptop_store/public/index.php?page=contact_mark_ajax`, {
          method: "POST",
          headers: {
            "Content-Type": "application/json"
          },
          body: JSON.stringify({
            id: id,
            status: "read"
          })
        });

        const data = await res.json();

        if (data.success) {
          row.querySelector(".status-cell").innerHTML =
            '<span class="badge bg-success">Đã đọc</span>';

          e.target.disabled = true;


        }
      }
    });

    // DELETE CONTACT
    table.addEventListener("click", async function(e) {
      if (e.target.classList.contains("delete-contact")) {

        const row = e.target.closest("tr");
        const id = row.dataset.id;

        if (!confirm("Bạn có chắc muốn xoá liên hệ này?")) return;

        const res = await fetch(`/laptop_store/public/index.php?page=contact_delete_ajax`, {
          method: "POST",
          headers: {
            "Content-Type": "application/json"
          },
          body: JSON.stringify({
            id: id
          })
        });

        const data = await res.json();

        if (data.success) {
          row.remove();
        }
      }
    });
  });
</script>