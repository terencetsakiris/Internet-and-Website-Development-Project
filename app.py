"""HoopSwap — a tiny Flask marketplace for basketball gear.

Routes:
    GET  /              -> homepage (list of categories)
    GET  /category/<id> -> products in a category
    GET  /product/<id>  -> single product detail

The app uses sqlite3 directly (no ORM) so it's easy to follow as a
student learning project.

Run with:  python app.py
Then open: http://localhost:5000
"""

import os
import sqlite3

from flask import Flask, abort, g, render_template

# ---------------------------------------------------------------------------
# Configuration
# ---------------------------------------------------------------------------

HERE = os.path.dirname(os.path.abspath(__file__))
DB_PATH = os.path.join(HERE, "hoopswap.db")
IMAGE_DIR = os.path.join(HERE, "static", "images")

app = Flask(__name__)


# ---------------------------------------------------------------------------
# Database helpers
# ---------------------------------------------------------------------------

def get_db():
    """Return a per-request sqlite3 connection with Row access."""
    db = getattr(g, "_database", None)
    if db is None:
        db = g._database = sqlite3.connect(DB_PATH)
        # Row factory lets us access columns by name, e.g. row["name"].
        db.row_factory = sqlite3.Row
    return db


@app.teardown_appcontext
def close_connection(exception):
    """Close the DB connection at the end of each request."""
    db = getattr(g, "_database", None)
    if db is not None:
        db.close()


# ---------------------------------------------------------------------------
# Template helpers
# ---------------------------------------------------------------------------

def image_exists(image_name):
    """Check if a product image file is present in static/images/."""
    if not image_name:
        return False
    return os.path.isfile(os.path.join(IMAGE_DIR, image_name))


# Expose the helper to all Jinja templates so they can fall back to a
# placeholder image when the real file is missing.
app.jinja_env.globals["image_exists"] = image_exists


# ---------------------------------------------------------------------------
# Routes
# ---------------------------------------------------------------------------

@app.route("/")
def index():
    """Homepage: list all categories with a product count for each."""
    db = get_db()
    categories = db.execute(
        """
        SELECT c.id, c.name, c.description,
               COUNT(p.id) AS product_count
        FROM categories c
        LEFT JOIN products p ON p.category_id = c.id
        GROUP BY c.id
        ORDER BY c.id
        """
    ).fetchall()
    return render_template("index.html", categories=categories)


@app.route("/category/<int:category_id>")
def category(category_id):
    """Show all products in a single category."""
    db = get_db()

    category_row = db.execute(
        "SELECT id, name, description FROM categories WHERE id = ?",
        (category_id,),
    ).fetchone()
    if category_row is None:
        abort(404)

    products = db.execute(
        """
        SELECT id, name, description, price, image_name
        FROM products
        WHERE category_id = ?
        ORDER BY id
        """,
        (category_id,),
    ).fetchall()

    return render_template(
        "category.html", category=category_row, products=products
    )


@app.route("/product/<int:product_id>")
def product(product_id):
    """Show the full detail page for a single product."""
    db = get_db()
    row = db.execute(
        """
        SELECT p.id, p.name, p.description, p.price, p.image_name,
               c.id AS category_id, c.name AS category_name
        FROM products p
        JOIN categories c ON c.id = p.category_id
        WHERE p.id = ?
        """,
        (product_id,),
    ).fetchone()
    if row is None:
        abort(404)
    return render_template("product.html", product=row)


# ---------------------------------------------------------------------------
# Entry point
# ---------------------------------------------------------------------------

if __name__ == "__main__":
    # debug=True gives auto-reload and helpful tracebacks while learning.
    app.run(host="0.0.0.0", port=5000, debug=True)
