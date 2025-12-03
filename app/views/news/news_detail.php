<div class="container">
    <a href="?page=news" style="text-decoration: none; color: #007bff; margin-bottom: 20px; display: block;">&larr; Quay lại danh sách tin tức</a>

    <div class="post-header">
        <h1><?= htmlspecialchars($post['title']) ?></h1>
        <div class="post-meta">
            <span>Ngày đăng: <?= date('d/m/Y', strtotime($post['created_at'])) ?></span>
            </div>
    </div>
    
    <?php if (!empty($post['thumbnail'])): ?>
        <img src="/laptop_store/public/images/posts_img/<?= $post['thumbnail'] ?>" 
             alt="<?= htmlspecialchars($post['title']) ?>" 
             class="post-thumbnail">
    <?php endif; ?>

    <div class="post-content">
        <?= $post['content'] ?>
    </div>

    <div class="comments-section" id="comments">
        <h3>Bình luận (<?= count($comments) ?>)</h3>
    
    <?php if ($userId): ?>
        
        <h4>Viết bình luận của bạn:</h4>
        
        <?php if (isset($commentError)): ?>
            <p style="color: red;"><?= $commentError ?></p>
        <?php endif; ?>

        <form method="POST">
            <input type="hidden" name="submit_comment" value="1">
            <textarea name="comment_content" rows="4" style="width: 100%; padding: 10px; box-sizing: border-box;"
                      placeholder="Nội dung bình luận..."></textarea>
            
            <button type="submit" style="padding: 10px 15px; background: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer;">Gửi Bình Luận</button>
        </form>
    
    <?php else: ?>
        <p>Vui lòng <a href="#" id="popupLoginLink">Đăng nhập</a> để gửi bình luận.</p>
    <?php endif; ?>

    <hr style="margin: 30px 0;">

    <div class="comment-list">
        <?php if (!empty($comments)): ?>
            <?php foreach ($comments as $comment): ?>
                <?php if ($comment['status'] == 1): ?>
                <div class="comment-item" style="border: 1px solid #eee; padding: 15px; margin-bottom: 15px; border-radius: 4px;">
                    <p style="font-weight: bold; margin: 0 0 5px 0; color: #333;">
                        <?= htmlspecialchars($comment['fullname']) ?> 
                        <small style="font-weight: normal; color: #999;">
                            (<?= date('H:i, d/m/Y', strtotime($comment['created_at'])) ?>)
                        </small>
                    </p>
                    <p style="margin: 0;"><?= nl2br(htmlspecialchars($comment['content'])) ?></p>
                </div>
                
                <?php else: ?>
                <div class="comment-item comment-removed" style="border: 1px dashed #f8d7da; background-color: #f8d7da33; padding: 15px; margin-bottom: 15px; border-radius: 4px;">
                    <p style="color: #721c24; font-style: italic; margin: 0;">
                        Bình luận này đã bị Admin gỡ vì lý do vi phạm.
                    </p>
                </div>
                
                <?php endif; ?>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Chưa có bình luận nào cho bài viết này.</p>
        <?php endif; ?>
    </div>

</div>

</body>
</html>