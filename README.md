# Front-and-Backend-Tutorial-Project

A book-meets-museum walkthrough for frontend and backend skills from **Basic → Intermediate → Advanced → Master**. Built for XAMPP (PHP + MySQL) so you can explore locally.

## Stack
- PHP 8 + MySQL (via XAMPP)
- Vanilla CSS/JS for the interactive exhibit filters

## Quickstart
1) Import the database
	- Open phpMyAdmin and create or select a database named `dev_museum`.
	- Import `database/dev_museum.sql`.
2) Configure environment
	- Copy `.env.example` to `.env` and adjust credentials if your MySQL user/password differ.
3) Run locally
	- Place this folder inside your XAMPP `htdocs` directory.
	- Visit `http://localhost/Front-and-Backend-Tutorial-Project/` in your browser.
	- If the database is not reachable you will still see the built-in sample exhibits.

## Project map
- `index.php` — renders the museum, loads exhibits from MySQL or fallback data.
- `config.php` / `db.php` — environment parsing and PDO helper.
- `assets/css/style.css` — layout, gradients, and card styling.
- `assets/js/app.js` — area filters and entrance animations.
- `data/sample_data.php` — fallback exhibits when the database is offline.
- `database/dev_museum.sql` — schema + seed data for phpMyAdmin import.

## Git push hints
From the project root:
```powershell
git init
git add .
git commit -m "Add fullstack museum starter"
git branch -M main
git remote add origin https://github.com/<your-user>/<your-repo>.git
git push -u origin main
```

## Next ideas
- Add CRUD endpoints to let visitors add their own exhibit cards.
- Track filter usage with a small analytics log table.
- Expand each stage with live code examples and downloadable snippets.
