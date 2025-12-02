<div class="container">

    <h2>Danh sách bài viết</h2>

    <!-- Ô tìm kiếm -->
    <form method="GET" class="search-box">
        <input type="hidden" name="page" value="news"> 
        
        <input type="text" name="keyword" placeholder="Tìm bài viết..." 
                value="<?= htmlspecialchars($keyword) ?>">
    </form>

    <!-- Danh sách bài viết -->
    <?php foreach ($posts as $post): ?>
    <div class="post">
        <img src="/laptop_store/public/images/posts_img/<?= $post['thumbnail'] ?>" alt="thumbnail">
        <div>
            <h3><a href="/laptop_store/public/index.php?page=news_detail&slug=<?= $post['slug'] ?>">
                <?= htmlspecialchars($post['title']) ?>
            </a></h3>
            <p><?= htmlspecialchars($post['description']) ?></p>
            <small><?= $post['created_at'] ?></small>
        </div>
    </div>
    <?php endforeach; ?>

    <!-- Phân trang -->
    <div class="pagination">
      
      <div style="margin-top: 20px;">

      <?php
        // BƯỚC 1: Chuẩn bị tham số tìm kiếm để sử dụng lại
        $keyword_param = '';
        // $keyword là biến được truyền từ NewsController.php
        if (!empty($keyword)) { 
            $keyword_param = '&keyword=' . urlencode($keyword);
        }
      ?>

      <?php if ($page > 1): ?>
        <a href="/laptop_store/public/index.php?page=news&count=<?= $page - 1 ?><?= $keyword_param ?>">« Trước</a>
      <?php endif; ?>

      <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <?php if ($i == $page): ?>
          <strong><?= $i ?></strong>
        <?php else: ?>
          <a href="/laptop_store/public/index.php?page=news&count=<?= $i ?><?= $keyword_param ?>"><?= $i ?></a>
        <?php endif; ?>
      <?php endfor; ?>

      <?php if ($page < $totalPages): ?>
        <a href="/laptop_store/public/index.php?page=news&count=<?= $page + 1 ?><?= $keyword_param ?>">Sau »</a>
      <?php endif; ?>
      </div>
    </div>

</div>

</body>
</html>
