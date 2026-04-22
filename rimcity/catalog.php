<?php
require_once __DIR__ . '/includes/db.php';
$page_title = 'Catalog — RimCity';
$active_nav = 'catalog';

$categories = get_categories();

// ?cat=<CategoryId> filters; anything else (or missing) = all products.
$active_cat = null;
if (isset($_GET['cat']) && ctype_digit((string)$_GET['cat'])) {
    $active_cat = (int)$_GET['cat'];
    $valid_ids = array_map(fn($c) => (int)$c['CategoryId'], $categories);
    if (!in_array($active_cat, $valid_ids, true)) {
        $active_cat = null;
    }
}
$products = get_products($active_cat);

include __DIR__ . '/includes/header.php';
?>

    <section class="section">
      <div class="container">
        <div class="section__head">
          <h1 class="section__title">Shop the Range</h1>
          <p class="section__link">
            <?= count($products) ?> <?= count($products) === 1 ? 'product' : 'products' ?>
          </p>
        </div>

        <div class="filters" role="group" aria-label="Filter by category">
          <a href="catalog.php"
             class="filter-btn <?= $active_cat === null ? 'active' : '' ?>"
             aria-pressed="<?= $active_cat === null ? 'true' : 'false' ?>">All</a>
          <?php foreach ($categories as $c): ?>
            <a href="catalog.php?cat=<?= (int)$c['CategoryId'] ?>"
               class="filter-btn <?= $active_cat === (int)$c['CategoryId'] ? 'active' : '' ?>"
               aria-pressed="<?= $active_cat === (int)$c['CategoryId'] ? 'true' : 'false' ?>">
              <?= htmlspecialchars($c['CategoryName']) ?>
            </a>
          <?php endforeach; ?>
        </div>

        <?php if (empty($products)): ?>
          <p>No products in this category yet — check back soon.</p>
        <?php else: ?>
          <div class="product-grid">
            <?php foreach ($products as $p): ?>
              <article class="product-card">
                <a href="product.php?id=<?= (int)$p['ProductId'] ?>" class="product-card__img" aria-label="View <?= htmlspecialchars($p['ProductName']) ?>">
                  <img src="images/<?= htmlspecialchars($p['ImageFile']) ?>"
                       alt="<?= htmlspecialchars($p['ProductName']) ?> — product image"
                       loading="lazy">
                </a>
                <div class="product-card__body">
                  <span class="badge"><?= htmlspecialchars($p['CategoryName']) ?></span>
                  <h3 class="product-card__name"><?= htmlspecialchars($p['ProductName']) ?></h3>
                  <p class="product-card__price">$<?= number_format($p['Price'], 2) ?></p>
                  <div class="product-card__actions">
                    <a class="btn btn-outline" href="product.php?id=<?= (int)$p['ProductId'] ?>">View</a>
                  </div>
                </div>
              </article>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>
    </section>

<?php include __DIR__ . '/includes/footer.php'; ?>
