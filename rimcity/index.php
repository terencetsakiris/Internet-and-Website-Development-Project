<?php
require_once __DIR__ . '/includes/db.php';
$page_title = 'RimCity — Own the Court';
$active_nav = 'home';

// 4 featured products — one per category — for the home page strip.
$featured_stmt = db()->query(
    "SELECT p.ProductId, p.ProductName, p.ImageFile, p.Price, c.CategoryName
     FROM Product p
     JOIN Category c ON c.CategoryId = p.CategoryId
     WHERE p.ProductId IN (1, 6, 11, 16)
     ORDER BY p.CategoryId"
);
$featured = $featured_stmt->fetchAll();

include __DIR__ . '/includes/header.php';
?>

    <section class="hero" aria-label="RimCity brand intro">
      <div class="container hero__content">
        <p class="hero__eyebrow">RimCity · Est. 2025 · Sydney</p>
        <h1>Own the <em>Court.</em></h1>
        <p>Australian-designed basketball gear engineered for players who never cede a possession. Sneakers, jerseys, balls and kit — built to play, not pose.</p>
        <a href="catalog.php" class="btn btn-primary">Shop Now</a>
      </div>
    </section>

    <section class="section" aria-label="This week's promotions">
      <div class="container">
        <div class="section__head">
          <h2 class="section__title">This Week on the Court</h2>
        </div>
        <div class="promos">
          <article class="promo">
            <span class="promo__tag">Save</span>
            <h3>20% Off Sneakers</h3>
            <p>Every high-top and low-top in the range — discount applied at checkout. This weekend only.</p>
          </article>
          <article class="promo">
            <span class="promo__tag">New Drop</span>
            <h3>New Jerseys Dropped</h3>
            <p>Home, Away and the Throwback 95. Three fresh cuts sitting in the locker right now.</p>
          </article>
          <article class="promo">
            <span class="promo__tag">Shipping</span>
            <h3>Free Shipping over $100</h3>
            <p>Spend $100+ anywhere in Australia and we'll send your kit to your door on us.</p>
          </article>
        </div>
      </div>
    </section>

    <section class="section" aria-label="Watch and listen">
      <div class="container">
        <div class="section__head">
          <h2 class="section__title">Watch &amp; Listen</h2>
        </div>

        <div class="video-embed">
          <iframe
            src="https://www.youtube.com/embed/jNQXAC9IVRw"
            title="RimCity featured highlight reel"
            loading="lazy"
            referrerpolicy="strict-origin-when-cross-origin"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
            allowfullscreen></iframe>
        </div>

        <div class="audio-panel">
          <div class="audio-panel__text">
            <h3>Courtside Whistle</h3>
            <p>Click play to hear the start-of-game whistle. Audio plays on demand so nothing interrupts your scroll.</p>
          </div>
          <audio controls preload="auto" class="audio-panel__player">
            <source src="audio/whistle.mp3" type="audio/mpeg">
            Your browser does not support the audio element.
          </audio>
        </div>
      </div>
    </section>

    <section class="section" aria-label="Featured products">
      <div class="container">
        <div class="section__head">
          <h2 class="section__title">Featured</h2>
          <a class="section__link" href="catalog.php">See the Range &rarr;</a>
        </div>
        <div class="featured-strip">
          <?php foreach ($featured as $p): ?>
            <article class="product-card">
              <a href="product.php?id=<?= (int)$p['ProductId'] ?>" class="product-card__img" aria-label="View <?= htmlspecialchars($p['ProductName']) ?>">
                <img src="images/<?= htmlspecialchars($p['ImageFile']) ?>"
                     alt="<?= htmlspecialchars($p['ProductName']) ?>"
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
      </div>
    </section>

    <section class="section" aria-label="Lifestyle gallery">
      <div class="container">
        <div class="section__head">
          <h2 class="section__title">Lifestyle</h2>
        </div>
        <div class="gallery">
          <figure>
            <img src="images/lifestyle_gameday.jpg" alt="Game day — players walking into the arena">
          </figure>
          <figure>
            <img src="images/lifestyle_drill.jpg" alt="Shooting drill at training">
          </figure>
          <figure>
            <img src="images/lifestyle_street.jpg" alt="Outdoor streetball court">
          </figure>
          <figure>
            <img src="images/lifestyle_locker.jpg" alt="Locker with RimCity kit ready for tip-off">
          </figure>
        </div>
      </div>
    </section>

<?php include __DIR__ . '/includes/footer.php'; ?>
