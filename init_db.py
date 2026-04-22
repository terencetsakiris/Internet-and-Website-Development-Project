"""Initialise the HoopSwap SQLite database.

Deletes any existing hoopswap.db, then runs schema.sql followed by seed.sql.
Prints a summary of how many categories and products were loaded.

Run with:  python init_db.py
"""

import os
import sqlite3

# Paths are resolved relative to this file so the script works from anywhere.
HERE = os.path.dirname(os.path.abspath(__file__))
DB_PATH = os.path.join(HERE, "hoopswap.db")
SCHEMA_PATH = os.path.join(HERE, "schema.sql")
SEED_PATH = os.path.join(HERE, "seed.sql")


def read_sql(path):
    """Read a .sql file and return its contents as a string."""
    with open(path, "r", encoding="utf-8") as f:
        return f.read()


def main():
    # Start fresh every time so seeding is idempotent for students.
    if os.path.exists(DB_PATH):
        os.remove(DB_PATH)
        print(f"Removed existing database at {DB_PATH}")

    conn = sqlite3.connect(DB_PATH)
    try:
        # Apply the schema, then insert the seed data.
        conn.executescript(read_sql(SCHEMA_PATH))
        conn.executescript(read_sql(SEED_PATH))
        conn.commit()

        # Report counts so we know seeding actually worked.
        category_count = conn.execute(
            "SELECT COUNT(*) FROM categories"
        ).fetchone()[0]
        product_count = conn.execute(
            "SELECT COUNT(*) FROM products"
        ).fetchone()[0]
        print(
            f"Database initialised with {category_count} categories "
            f"and {product_count} products"
        )
    finally:
        conn.close()


if __name__ == "__main__":
    main()
