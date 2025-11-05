<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Laptop Store</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <h1>Danh sách Laptop</h1>
  <div class="grid">
    <?php foreach ($laptops as $lap): ?>
      <div class="item">
        <img src="images/<?= htmlspecialchars($lap['image']) ?>" width="200">
        <h3><?= htmlspecialchars($lap['name']) ?></h3>
        <p>Hãng: <?= htmlspecialchars($lap['brand_name']) ?></p>
        <p><?= number_format($lap['price']) ?> VND</p>
      </div>
    <?php endforeach; ?>
  </div>
</body>
</html>
