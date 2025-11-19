<h1>Quản lý liên hệ</h1>

<table border="1" cellpadding="6">
<tr>
  <th>Họ tên</th>
  <th>Email</th>
  <th>Tiêu đề</th>
  <th>Tin nhắn</th>
  <th>Trạng thái</th>
  <th>Hành động</th>
</tr>

<?php foreach($contacts as $c): ?>
<tr>
  <td><?= $c['name'] ?></td>
  <td><?= $c['email'] ?></td>
  <td><?= $c['subject'] ?></td>
  <td><?= $c['message'] ?></td>
  <td><?= $c['status'] ?></td>
  <td>
    <a href="/laptop_store/public/index.php?page=contact_mark&id=<?= $c['id'] ?>&status=read">Đã đọc</a> |
    <a href="/laptop_store/public/index.php?page=contact_delete&id=<?= $c['id'] ?>">Xoá</a>
  </td>
</tr>
<?php endforeach; ?>

</table>

<!-- Pagination -->
<div style="margin-top: 20px;">

<?php if ($page > 1): ?>
  <a href="/laptop_store/public/index.php?page=admin_contacts&p=<?= $page - 1 ?>">« Trước</a>
<?php endif; ?>

<?php for ($i = 1; $i <= $totalPages; $i++): ?>
  <?php if ($i == $page): ?>
    <strong><?= $i ?></strong>
  <?php else: ?>
    <a href="/laptop_store/public/index.php?page=admin_contacts&p=<?= $i ?>"><?= $i ?></a>
  <?php endif; ?>
<?php endfor; ?>

<?php if ($page < $totalPages): ?>
  <a href="/laptop_store/public/index.php?page=admin_contacts&p=<?= $page + 1 ?>">Sau »</a>
<?php endif; ?>

</div>
