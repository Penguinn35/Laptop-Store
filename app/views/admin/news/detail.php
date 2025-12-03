<script src="/laptop_store/public/js/libs/tinymce/tinymce.min.js"></script>
<div class="content-wrapper" style="padding: 30px; padding-top: 30px;"> 
    
    <div class="page-header d-print-none">
        <h2 class="page-title"><?= $pageTitle ?></h2>
    </div>

    <?php if (!empty($postErrors)): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <h4 class="alert-title">Lỗi</h4>
            <ul>
                <?php foreach ($postErrors as $error): ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['admin_message'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $_SESSION['admin_message'] ?>
        </div>
        <?php unset($_SESSION['admin_message']); ?>
    <?php endif; ?>

    <div class="card">
        <form method="POST" enctype="multipart/form-data" class="card-body"> 
            
            <div class="row">
                <div class="col-md-9">
                    <div class="mb-3">
                        <label class="form-label required">Tiêu đề Bài viết</label>
                        <input type="text" name="title" class="form-control" placeholder="Tiêu đề..." required
                               value="<?= htmlspecialchars($post['title'] ?? $data['title'] ?? '') ?>">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label required">Slug (URL)</label>
                        <input type="text" name="slug" class="form-control" placeholder="slug-bai-viet-moi" required
                               value="<?= htmlspecialchars($post['slug'] ?? $data['slug'] ?? '') ?>">
                        <small class="form-hint">URL thân thiện, không dấu, không khoảng trắng.</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nội dung chi tiết</label>
                        <textarea name="content" class="form-control" rows="15" placeholder="Nội dung bài viết..."><?= htmlspecialchars($post['content'] ?? $data['content'] ?? '') ?></textarea>
                    </div>
                </div>
                
                <div class="col-md-3">
                    
                    <div class="mb-3">
                        <label class="form-label">Ảnh đại diện</label>
                        <?php if (!empty($post['thumbnail'])): ?>
                            <img src="/laptop_store/public/images/posts_img/<?= $post['thumbnail'] ?>" class="card-img-top mb-2" style="max-width: 100%; height: auto; border-radius: 4px; object-fit: cover;">
                            <p class="text-muted small">Ảnh hiện tại: <?= $post['thumbnail'] ?></p>
                        <?php endif; ?>
                        <input type="file" name="thumbnail" class="form-control" <?= $id ? '' : '' ?>> 
                        <small class="form-hint text-muted">Chỉ chấp nhận file ảnh. Cần thiết khi thêm mới.</small>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Mô tả ngắn (SEO)</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Mô tả SEO..."><?= htmlspecialchars($post['description'] ?? $data['description'] ?? '') ?></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Từ khóa (Keywords)</label>
                        <input type="text" name="keywords" class="form-control" placeholder="laptop, gaming, văn phòng"
                               value="<?= htmlspecialchars($post['keywords'] ?? $data['keywords'] ?? '') ?>">
                    </div>
                </div>
            </div>

            <div class="card-footer text-end">
                <a href="?page=admin_news" class="btn btn-link">Hủy</a>
                <button type="submit" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M7 11v8a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1v-8a1 1 0 0 1 1 -1h2a1 1 0 0 1 1 1z"></path><path d="M14 11v8a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1v-8a1 1 0 0 1 1 -1h2a1 1 0 0 1 1 1z"></path><path d="M21 11v8a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1v-8a1 1 0 0 1 1 -1h2a1 1 0 0 1 1 1z"></path><path d="M4 7h16"></path><path d="M10 17v-8l2 2l2 -2v8"></path></svg>
                    <?= $id ? 'Cập nhật Bài viết' : 'Thêm Bài viết' ?>
                </button>
            </div>
        </form>
    </div>

    <?php if ($id): ?>
    <div class="card" id="comment-list" style="margin-top: 20px;">
        <div class="card-header">
            <h3 class="card-title">Quản lý Bình luận của Bài viết này (<?= count($comments) ?>)</h3>
        </div>
        
        <div class="card-body p-0">
            <?php if (empty($comments)): ?>
                <p class="text-muted p-3">Bài viết này chưa có bình luận nào.</p>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-vcenter card-table table-striped"> 
                        <thead>
                            <tr>
                                <th class="w-1">ID</th>
                                <th>Người đăng</th>
                                <th>Nội dung</th>
                                <th>Ngày tạo</th>
                                <th>Trạng thái</th>
                                <th class="w-1">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($comments as $comment): ?>
                            <tr>
                                <td class="text-muted"><?= $comment['id'] ?></td>
                                <td><?= htmlspecialchars($comment['fullname']) ?></td>
                                <td style="max-width: 350px;">
                                    <?php if ($comment['status'] == 0): ?>
                                        <span class="text-danger small fst-italic">Bình luận đã bị gỡ.</span>
                                    <?php else: ?>
                                        <?= htmlspecialchars(substr($comment['content'], 0, 100)) . (strlen($comment['content']) > 100 ? '...' : '') ?>
                                    <?php endif; ?>
                                </td>
                                <td><?= date('d/m/Y H:i', strtotime($comment['created_at'])) ?></td>
                                <td>
                                    <?php if ($comment['status'] == 1): ?>
                                        <span class="badge bg-green-lt">Đã duyệt</span>
                                    <?php else: ?>
                                        <span class="badge bg-red-lt">Đã gỡ</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="btn-list flex-nowrap">
                                        <?php if ($comment['status'] == 1): ?>
                                            <a href="?page=admin_news_detail&id=<?= $id ?>&comment_action=remove&comment_id=<?= $comment['id'] ?>" 
                                            onclick="return confirm('Gỡ bình luận này?')"
                                            class="btn btn-sm btn-outline-danger">Gỡ</a>
                                        <?php else: ?>
                                            <a href="?page=admin_news_detail&id=<?= $id ?>&comment_action=approve&comment_id=<?= $comment['id'] ?>" 
                                            onclick="return confirm('Phục hồi bình luận này?')"
                                            class="btn btn-sm btn-outline-success">Phục hồi</a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        tinymce.init({
            selector: 'textarea[name="content"]',
            license_key: 'gpl', 
            height: 500,
            menubar: false,
            plugins: [
                'advlist autolink lists link image charmap print preview anchor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table paste code help wordcount'
            ],
            toolbar: 'undo redo | formatselect | bold italic backcolor | \
                        alignleft aligncenter alignright alignjustify | \
                        bullist numlist outdent indent | removeformat | help | image link code',
        });
    });
</script>