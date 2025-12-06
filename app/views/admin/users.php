<div class="content-wrapper" style="padding: 30px; padding-top: 120px;">
    <div class="page-header d-print-none">
        <h2 class="page-title"><?= $pageTitle ?></h2>
    </div>

    <?php if (isset($_SESSION['admin_message'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $_SESSION['admin_message'] ?>
        </div>
        <?php unset($_SESSION['admin_message']); ?>
    <?php endif; ?>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-vcenter card-table table-striped">
                <thead>
                    <tr>
                        <th class="w-1">ID</th>
                        <th>Tên đầy đủ</th>
                        <th>Email/Phone</th>
                        <th>Tên đăng nhập</th>
                        <th>Vai trò (Click đổi)</th>
                        <th>Trạng thái (Click đổi)</th>
                        <th class="w-1">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($users)): ?>
                        <tr><td colspan="7" class="text-center text-muted">Chưa có người dùng nào (trừ Admin).</td></tr>
                    <?php endif; ?>
                    <?php foreach ($users as $user): ?>
                    <tr>
                        <td class="text-muted align-middle"><?= $user['id'] ?></td>
                        <td class="align-middle"><?= htmlspecialchars($user['fullname'] ?? 'N/A') ?></td>
                        
                        <td class="align-middle">
                            <?= htmlspecialchars($user['email']) ?><br>
                            <span class="text-muted small"><?= htmlspecialchars($user['phone'] ?? '-') ?></span>
                        </td>
                        
                        <td class="align-middle"><?= htmlspecialchars($user['username']) ?></td>

                        <td class="align-middle">
                            <?php if ($user['role'] === 'admin'): ?>
                                <a href="?page=admin_manage&action=set_customer&id=<?= $user['id'] ?>" 
                                   onclick="return confirm('Giáng quyền Admin xuống Customer?')" 
                                   class="badge bg-red-lt text-decoration-none">Quản trị viên</a>
                            <?php else: ?>
                                <a href="?page=admin_manage&action=set_admin&id=<?= $user['id'] ?>" 
                                   onclick="return confirm('Cấp quyền Admin cho người này?')" 
                                   class="badge bg-blue-lt text-decoration-none">Khách hàng</a>
                            <?php endif; ?>
                        </td>

                        <td class="align-middle">
                            <?php if ($user['status'] == 1): ?>
                                <a href="?page=admin_manage&action=lock&id=<?= $user['id'] ?>" 
                                   onclick="return confirm('Xác nhận khóa người dùng <?= $user['fullname'] ?>?')" 
                                   class="badge bg-green-lt text-decoration-none">Hoạt động</a>
                            <?php else: ?>
                                <a href="?page=admin_manage&action=unlock&id=<?= $user['id'] ?>" 
                                   onclick="return confirm('Xác nhận mở khóa người dùng <?= $user['fullname'] ?>?')" 
                                   class="badge bg-red-lt text-decoration-none">Đã khóa</a>
                            <?php endif; ?>
                        </td>

                        <td class="align-middle text-center">
                            <a href="?page=admin_manage&action=reset_password&id=<?= $user['id'] ?>" class="btn btn-sm btn-outline-warning"
                               onclick="return confirm('Xác nhận Reset mật khẩu?')">
                                Reset
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.4.0/dist/js/tabler.min.js"></script>