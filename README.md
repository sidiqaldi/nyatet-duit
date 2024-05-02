# NyatetDuit

NyatetDuit is an open-source finance management application built with Laravel PHP framework. It provides users with tools for budgeting, expense tracking, and insightful reports and analytics, all in a simple and intuitive interface.

## Installation

To get started with NyatetDuid, follow these steps:

1. Clone the repository to your local machine:
```bash
git clone https://github.com/sidiqaldi/nyatet-duit
```

2. Navigate to the project directory:
```bash
cd nyatet-duit
```
3. Install composer dependencies:
```bash
composer install --no-dev
```
4. Copy the `.env.example` file and rename it to `.env`:
```bash
cp .env.example .env
```
5. Generate an application key:
```bash
php artisan key:generate
```
6. Generate an application key:
```bash
php artisan storage:link
```
7. Update the `.env` file with your database connection details. Set the `DB_CONNECTION` to `sqlite` and update the `DB_DATABASE` path to point to your SQLite database file:
```env
DB_CONNECTION=sqlite
DB_DATABASE=/path/to/database.sqlite
```
8. Create an empty SQLite database file:
```bash
touch database/database.sqlite
```
9. Run the database migrations and seed the database:
```bash
php artisan migrate
```
10. Install NPM dependency and Build asset
```bash
npm ci && npm run build
```
11. Serve the application:
```bash
php artisan serve
```
11. Access the application in your web browser at `http://localhost:8000`.



## Requirements

- PHP 8.2
- Composer
- SQLite
- Node.js >= 20

## Contributing

Contributions are welcome! If you find any issues or have suggestions for improvements, please open an issue or submit a pull request on GitHub.

## License

This is open-source software licensed under the [MIT license](LICENSE).
