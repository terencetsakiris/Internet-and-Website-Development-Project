# HoopSwap 🏀

A tiny basketball gear marketplace built as a student project.

HoopSwap lets you browse four categories of basketball gear —
**Sneakers**, **Jerseys**, **Balls** and **Accessories** — and drill down
into individual products. It is intentionally simple: no login, no cart,
no checkout. Just **categories → products → product detail**.

## Stack

- Python 3 + [Flask](https://flask.palletsprojects.com/)
- SQLite (single-file database, `hoopswap.db`)
- Plain HTML, Jinja2 templates, hand-written CSS (no frontend framework)

## Quick start

1. **Install dependencies**
    ```bash
    pip install -r requirements.txt
    ```

2. **Initialise the database**
    ```bash
    python init_db.py
    ```
    This creates `hoopswap.db` with 4 categories and 20 products and prints:
    ```
    Database initialised with 4 categories and 20 products
    ```

3. **Run the app**
    ```bash
    python app.py
    ```

4. **Open it**

    Browse to [http://localhost:5000](http://localhost:5000).

## URLs

| Route                 | Description                         |
|-----------------------|-------------------------------------|
| `/`                   | Homepage — lists the four categories |
| `/category/<id>`      | All products in a category          |
| `/product/<id>`       | Single product detail page          |

## Product images

Real product images are not shipped with the project. If you drop a
matching JPG into `static/images/` (e.g. `lebron_xxi.jpg`) the app will
use it automatically. Otherwise it falls back to a placeholder from
[placehold.co](https://placehold.co/) with the product name rendered on it.

## Screenshots

*Add screenshots here once you've taken them!*

- `docs/screenshot-home.png` — homepage with category cards
- `docs/screenshot-category.png` — category listing
- `docs/screenshot-product.png` — product detail

## Architecture

```
                  +---------------------------+
                  |        Browser            |
                  +-------------+-------------+
                                |
                                | HTTP
                                v
                  +---------------------------+
                  |  Flask app  (app.py)      |
                  |  - / (index)              |
                  |  - /category/<id>         |
                  |  - /product/<id>          |
                  +------+-------------+------+
                         |             |
                  Jinja2 |             | sqlite3
                  templates            |
                         |             v
                         |   +-------------------+
                         |   |   hoopswap.db     |
                         |   |  (SQLite, file)   |
                         |   |                   |
                         |   |  categories       |
                         |   |  products         |
                         |   +-------------------+
                         v
                  +---------------------------+
                  |   templates/              |
                  |   ├─ base.html            |
                  |   ├─ index.html           |
                  |   ├─ category.html        |
                  |   └─ product.html         |
                  +---------------------------+
```

## Project layout

```
hoopswap/
├── app.py                 # Flask routes
├── schema.sql             # Table definitions
├── seed.sql               # 4 categories + 20 products
├── init_db.py             # Re-creates hoopswap.db from schema + seed
├── requirements.txt       # Python dependencies
├── README.md              # This file
├── static/
│   ├── style.css          # Stylesheet
│   └── images/            # (optional) product images
└── templates/
    ├── base.html          # Shared layout
    ├── index.html         # Homepage
    ├── category.html      # Category listing
    └── product.html       # Product detail
```

## Notes for the student

- Database access goes through a `get_db()` helper in `app.py` that uses
  `sqlite3.Row` so you can access columns by name (`row["name"]`).
- Re-run `python init_db.py` any time you want a fresh database —
  it deletes the old one and re-seeds from `seed.sql`.
- `app.run(debug=True)` gives you auto-reload while you edit files.
