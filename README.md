# Simple Blog Application with Laravel
This is a simple blog application built using Laravel, as part of the Mid-Level Phase One Assessment.

## Project Overview
The objective of this project is to develop a basic blog application that allows users to create, edit, and delete blog posts, comment on posts, and view post details. The application includes user authentication and implements CRUD (Create, Read, Update, Delete) operations for blog posts, comments and a dashboard.

## Getting Started
### Prerequisites
PHP >= 8.2
Composer installed globally
MySQL or any other database supported by Laravel

### Installation
Clone the repository:

```sh
git clone https://github.com/WilliamsScripts/blog-app.git
```

Install dependencies:

```sh
composer install
```

Copy .env.example to .env and configure your database credentials:

```sh
cp .env.example .env
```

Update .env file with your database details:

```sh
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password
```

Generate application key:

```sh
php artisan key:generate
```

Run migrations and seeders to create and populate the database:

```sh
php artisan migrate --seed
```

Serve the application:

```sh
php artisan serve
```

Access the application in your web browser at http://localhost:8000.

Testing
To run unit tests:

```sh
php artisan test
```

To login to the admin, use the credential below: 
```sh
email: admin@mail.com
password: password
```

Here is a link to the postman documentation for the API module: https://documenter.getpostman.com/view/26924827/2sA3XQiNH5
