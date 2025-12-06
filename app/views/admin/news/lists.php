<div class="content-wrapper" style="padding: 30px; padding-top: 120px;">
    <div class="page-header d-print-none">
        <div class="row align-items-center">
            <div class="col">
                <h2 class="page-title"><?= $pageTitle ?></h2>
            </div>
            <div class="col-auto ms-auto">
                <div class="btn-list">
                    <a href="?page=admin_news_detail" class="btn btn-primary d-none d-sm-inline-block">
                        <span class="ti ti-plus me-2"></span> 
                        Thêm Bài viết Mới
                    </a>
                </div>
            </div>
        </div>
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
                        <th>Ảnh</th>
                        <th>Tiêu đề</th>
                        <th>Slug</th>
                        <th>Ngày tạo</th>
                        <th class="w-1">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($posts)): ?>
                        <tr><td colspan="6" class="text-center text-muted">Chưa có bài viết nào.</td></tr>
                    <?php endif; ?>
                    <?php foreach ($posts as $post): ?>
                    <tr>
                        <td class="text-muted"><?= $post['id'] ?></td>
                        <td>
                            <?php if (!empty($post['thumbnail'])): ?>
                                <img src="/laptop_store/public/images/posts_img/<?= $post['thumbnail'] ?>" alt="Thumbnail" style="width: 60px; height: 40px; object-fit: cover; border-radius: 4px;">
                            <?php else: ?>
                                <span class="text-muted">Không có ảnh</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="?page=news_detail&slug=<?= $post['slug'] ?>" 
                               target="_blank" 
                               class="text-decoration-none">
                               <?= htmlspecialchars($post['title']) ?>
                            </a>
                        </td>
                        <td><?= htmlspecialchars($post['slug']) ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($post['created_at'])) ?></td>
                        <td>
                            <div class="btn-list flex-nowrap">
                                <a href="?page=admin_news_detail&id=<?= $post['id'] ?>" class="btn btn-sm btn-outline-primary">Sửa</a>
                                <a href="?page=admin_news&action=delete&id=<?= $post['id'] ?>" class="btn btn-sm btn-outline-danger"
                                   onclick="return confirm('Bạn có chắc chắn muốn xóa bài viết này không?')"
                                   >Xóa</a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- Phân trang -->
    <div class="pagination">
      
      <div style="margin-top: 20px;">

      <?php if ($page > 1): ?>
        <a href="/laptop_store/public/index.php?page=admin_news&count=<?= $page - 1 ?>">« Trước</a>
      <?php endif; ?>

      <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <?php if ($i == $page): ?>
          <strong><?= $i ?></strong>
        <?php else: ?>
          <a href="/laptop_store/public/index.php?page=admin_news&count=<?= $i ?>"><?= $i ?></a>
        <?php endif; ?>
      <?php endfor; ?>

      <?php if ($page < $totalPages): ?>
        <a href="/laptop_store/public/index.php?page=admin_news&count=<?= $page + 1 ?>">Sau »</a>
      <?php endif; ?>
      </div>
    </div>
</div>