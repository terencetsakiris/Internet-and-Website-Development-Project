-- HoopSwap schema
-- Two tables: categories (e.g. Sneakers, Jerseys) and products that belong to a category.

DROP TABLE IF EXISTS products;
DROP TABLE IF EXISTS categories;

CREATE TABLE categories (
    id          INTEGER PRIMARY KEY AUTOINCREMENT,
    name        TEXT NOT NULL UNIQUE,
    description TEXT
);

CREATE TABLE products (
    id          INTEGER PRIMARY KEY AUTOINCREMENT,
    category_id INTEGER NOT NULL,
    name        TEXT    NOT NULL,
    description TEXT    NOT NULL,
    price       REAL    NOT NULL,
    image_name  TEXT    NOT NULL,
    FOREIGN KEY (category_id) REFERENCES categories (id)
);
