<?php
require_once __DIR__ . '/includes/db.php';

$id = (isset($_GET['id']) && ctype_digit((string)$_GET['id']))
    ? (int)$_GET['id']
    : 0;

$product = $id > 0 ? get_product($id) : null;

if ($product) {
    $page_title = $product['ProductName'] . ' — RimCity';
} else {
    $page_title = 'Product not found — RimCity';
}
$active_nav = 'catalog';

include __DIR__ . '/includes/header.php';
?>

    <section class="section">
      <div class="container">
        <?php if ($product): ?>
          <article class="product-detail">
            <div class="product-detail__image">
              <img src="images/<?= htmlspecialchars($product['ImageFile']) ?>"
                   alt="<?= htmlspecialchars($product['ProductName']) ?> — full product image">
            </div>
            <div class="product-detail__meta">
              <span class="badge"><?= htmlspecialchars($product['CategoryName']) ?></span>
              <h1><?= htmlspecialchars($product['ProductName']) ?></h1>
              <p class="product-detail__price">$<?= number_format($product['Price'], 2) ?></p>
              <p class="product-detail__desc"><?= nl2br(htmlspecialchars($product['ProductDescription'])) ?></p>
              <a class="btn btn-primary" href="catalog.php">&larr; Back to Catalog</a>
            </div>
          </article>
        <?php else: ?>
          <div class="not-found">
            <h1>Product not found</h1>
            <p>Sorry — we couldn't find that one on the shelf.</p>
            <a class="btn btn-primary" href="catalog.php">Back to Catalog</a>
          </div>
        <?php endif; ?>
      </div>
    </section>

<?php include __DIR__ . '/includes/footer.php'; ?>
