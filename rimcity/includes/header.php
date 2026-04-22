<?php
// Shared top-of-page: DOCTYPE, <head>, site header, and opening <main>.
// Each page sets $page_title and (optionally) $active_nav before including this.
$page_title = $page_title ?? 'RimCity — Own the Court';
$active_nav = $active_nav ?? '';

function nav_class(string $name, string $active): string {
    return $name === $active ? 'active' : '';
}
?><!DOCTYPE html>
<html lang="en-AU">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($page_title) ?></title>
  <meta name="description" content="RimCity — an Australian basketball brand. Sneakers, jerseys, balls and accessories engineered for players who own the court.">
  <link rel="icon" type="image/png" sizes="32x32" href="images/favicon-32.png">
  <link rel="icon" type="image/png" sizes="128x128" href="images/favicon.png">
  <link rel="apple-touch-icon" href="images/favicon.png">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <header class="site-header">
    <div class="container">
      <a class="logo-link" href="index.php" aria-label="RimCity — home">
        <svg class="logo-svg" width="168" height="40" viewBox="0 0 168 40" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="RimCity">
          <rect x="2" y="4" width="16" height="14" rx="1.5" fill="#1A1A1A"/>
          <rect x="9" y="18" width="2" height="14" fill="#1A1A1A"/>
          <ellipse cx="22" cy="18" rx="9" ry="2.5" fill="none" stroke="#E85D24" stroke-width="2.5"/>
          <path d="M14 19 L16 28 M18 19.5 L19 30 M22 20 L22 31 M26 19.5 L25 30 M30 19 L28 28"
                stroke="#1A1A1A" stroke-width="1.2" fill="none" stroke-linecap="round"/>
          <text x="40" y="27" font-family="'Archivo Black', sans-serif" font-size="20" fill="#1A1A1A" letter-spacing="-0.3">Rim<tspan fill="#E85D24">City</tspan></text>
        </svg>
      </a>
      <nav class="main-nav" aria-label="Primary">
        <ul>
          <li><a href="index.php" class="<?= nav_class('home', $active_nav) ?>">Home</a></li>
          <li><a href="catalog.php" class="<?= nav_class('catalog', $active_nav) ?>">Catalog</a></li>
          <li><a href="about.php" class="<?= nav_class('about', $active_nav) ?>">About</a></li>
        </ul>
      </nav>
    </div>
  </header>
  <main>
