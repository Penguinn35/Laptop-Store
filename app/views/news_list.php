<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Tin tức | Laptop Store</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #eef1f5;
            padding: 30px;
        }

        .container {
            max-width: 900px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 6px;
            margin-top: 100px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .search-box input {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        .post {
            display: flex;
            gap: 20px;
            margin-bottom: 25px;
            border-bottom: 1px solid #eee;
            padding-bottom: 15px;
        }

        .post img {
            width: 160px;
            height: 110px;
            object-fit: cover;
            border-radius: 6px;
        }

        .post h3 {
            margin: 0;
            font-size: 20px;
        }

        .pagination {
            text-align: center;
            margin-top: 30px;
        }

        .pagination a {
            display: inline-block;
            padding: 10px 14px;
            margin: 0 3px;
            background: #eee;
            text-decoration: none;
            border-radius: 4px;
        }

        .pagination .active {
            background: #333;
            color: white;
        }
    </style>
</head>
<body>

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
