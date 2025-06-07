# CMS PDO System

CMS PDO System is a small content management example built with PHP. It uses PDO for database access and Bootstrap 5 for the interface. Users can register, log in and manage articles with image uploads.

## Tech Stack

- **PHP** with PDO
- **MySQL** database
- **Bootstrap 5** for styling

## Running Locally

1. Install PHP and MySQL on your machine.
2. Clone this repository into your web server root.
3. Create a database named `cms_pdo_db` and update `config/config.php` with your database credentials.
4. Ensure the `uploads/` directory is writable by the web server.
5. From the project directory start the built-in PHP server:

   ```bash
   php -S localhost:8000
   ```

6. Visit `http://localhost:8000` in your browser. If you use a different directory name, update the `PROJECT_DIR` constant in `init.php`.

Once running, register a new account and start creating articles from the admin section.
