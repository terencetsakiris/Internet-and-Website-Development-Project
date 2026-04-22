<?php
// ============================================================
// RimCity — database helper
//
// - Opens a PDO connection (MySQL).
// - On first run, if the `rimcity` database or the Category/Product
//   tables do not exist, it imports database/rimcity.sql automatically.
//   This means a marker can either:
//     (a) import the SQL file manually via phpMyAdmin, OR
//     (b) just open the site — it installs itself.
// ============================================================

require_once __DIR__ . '/config.php';

function rimcity_connect_server(): PDO {
    global $DB_HOST, $DB_PORT, $DB_USER, $DB_PASS;
    $dsn = "mysql:host={$DB_HOST};port={$DB_PORT};charset=utf8mb4";
    return new PDO($dsn, $DB_USER, $DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
}

function rimcity_connect_db(): PDO {
    global $DB_HOST, $DB_PORT, $DB_USER, $DB_PASS, $DB_NAME;
    $dsn = "mysql:host={$DB_HOST};port={$DB_PORT};dbname={$DB_NAME};charset=utf8mb4";
    return new PDO($dsn, $DB_USER, $DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
}

function rimcity_run_sql_file(PDO $pdo, string $path): void {
    $sql = file_get_contents($path);
    if ($sql === false) {
        throw new RuntimeException("Could not read SQL file: {$path}");
    }
    // PDO::exec handles a multi-statement string fine for CREATE/INSERT
    // when the driver is mysqlnd (default in PHP 7+).
    $pdo->exec($sql);
}

function rimcity_ensure_installed(): void {
    global $DB_NAME, $SQL_FILE;

    try {
        $pdo = rimcity_connect_db();
        // DB exists — check the tables.
        $stmt = $pdo->query(
            "SELECT COUNT(*) AS n FROM information_schema.tables
             WHERE table_schema = DATABASE()
               AND table_name IN ('Category', 'Product')"
        );
        $row = $stmt->fetch();
        if ((int)$row['n'] < 2) {
            rimcity_run_sql_file($pdo, $SQL_FILE);
        }
    } catch (PDOException $e) {
        // Unknown database (1049) → create it from the SQL file.
        if ($e->getCode() === 1049 || str_contains($e->getMessage(), 'Unknown database')) {
            $server = rimcity_connect_server();
            rimcity_run_sql_file($server, $SQL_FILE);
        } else {
            throw $e;
        }
    }
}

function db(): PDO {
    static $pdo = null;
    if ($pdo === null) {
        rimcity_ensure_installed();
        $pdo = rimcity_connect_db();
    }
    return $pdo;
}

function get_categories(): array {
    return db()->query(
        "SELECT CategoryId, CategoryName
         FROM Category
         ORDER BY CategoryId"
    )->fetchAll();
}

function get_products(?int $category_id = null): array {
    if ($category_id === null) {
        $stmt = db()->query(
            "SELECT p.ProductId, p.ProductName, p.ProductDescription,
                    p.ImageFile, p.Price, p.CategoryId, c.CategoryName
             FROM Product p
             JOIN Category c ON c.CategoryId = p.CategoryId
             ORDER BY p.CategoryId, p.ProductId"
        );
        return $stmt->fetchAll();
    }
    $stmt = db()->prepare(
        "SELECT p.ProductId, p.ProductName, p.ProductDescription,
                p.ImageFile, p.Price, p.CategoryId, c.CategoryName
         FROM Product p
         JOIN Category c ON c.CategoryId = p.CategoryId
         WHERE p.CategoryId = :cid
         ORDER BY p.ProductId"
    );
    $stmt->execute([':cid' => $category_id]);
    return $stmt->fetchAll();
}

function get_product(int $id): ?array {
    $stmt = db()->prepare(
        "SELECT p.ProductId, p.ProductName, p.ProductDescription,
                p.ImageFile, p.Price, p.CategoryId, c.CategoryName
         FROM Product p
         JOIN Category c ON c.CategoryId = p.CategoryId
         WHERE p.ProductId = :id"
    );
    $stmt->execute([':id' => $id]);
    $row = $stmt->fetch();
    return $row ?: null;
}
