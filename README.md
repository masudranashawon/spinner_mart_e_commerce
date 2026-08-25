# Spinner Mart (E-Commerce Platform)

Spinner Mart is a single-vendor e-commerce platform built with Laravel. It supports a complete shopping workflow—from browsing products and managing carts to checkout and order tracking—alongside a comprehensive admin dashboard for store management. 

This is a personal Laravel learning and pet project. It is being developed to practice structured and maintainable Laravel development approaches, applying concepts like the Repository Pattern, modular organization, and role-based access control.

## Features

### Public & Shopping Features
* **Product Catalog:** Browse products by categories, sub-categories, and brands.
* **Product Details:** View product images, variations (sizes/colors), and stock status.
* **Search:** Ajax-based product search functionality.
* **sorting&filtering:** Ajax-based Sort and filter products by price, brand, category, subcategory, more.


### Customer Features
* **Authentication:** Secure registration and login.
* **Profile Management:** Update personal information and manage passwords.
* **Recent Views:** Keep track of recently viewed products.
* **Cart:** Add items to cart and update quantities.
* **Coupons:** Apply and validate discount codes during checkout.
* **Checkout:** Complete order placement with billing and shipping addresses.
* **Wishlist:** Save favorite products for later.
* **Order History:** View past orders and current order statuses.
* **Invoice:** Download order invoices.
* **Order Cancellation:** Cancel orders that are still pending.
* **Return Requests:** Request returns for eligible delivered orders.

### Admin Panel
* **Dashboard:** Overview of store activities.
* **Catalog Management:** Create and manage categories, sub-categories, brands, colors, sizes, and tags.
* **Product Management:** Manage products, image galleries, variants, and inventory/stock levels.
* **Order Management:** View order details, update statuses, and process cancellations or returns.
* **Customer Management:** View and manage registered customers.
* **Marketing & Content:** Manage discount coupons, homepage sliders, dynamic pages (Privacy Policy, Terms), FAQs, and customer reviews.
* **Store Settings:** Manage global store configurations, newsletter subscribers, and contact messages.

## Technology Stack

* [Laravel 12](https://laravel.com)
* [PHP 8.2+](https://www.php.net)
* [MySQL](https://www.mysql.com)
* [Blade Templates](https://laravel.com/docs/blade)
* [Spatie Laravel Permission](https://spatie.be/docs/laravel-permission)
* [Laravel Repository (arafat69)](https://github.com/arafat69/laravel-repository)
* [Vite](https://vitejs.dev)
* Vanilla JavaScrip & [jQuery](https://jquery.com)
* Vanila CSS & [Bootstrap](https://getbootstrap.com)

## Requirements

* PHP 8.2 or higher
* Composer
* Node.js
* npm
* MySQL / MariaDB

## Installation

1. **Clone the repository:**
   ```bash
   git clone https://github.com/masudranashawon/spinner_mart_e_commerce.git
   ```
2. **Enter the project directory:**
   ```bash
   cd spinner_mart_e_commerce
   ```
3. **Create the MySQL database:**
   Create a new local database (e.g., `spinner_mart_e_commerce`).
4. **Run the project setup command:**
   This custom composer script will install PHP dependencies, copy `.env.example` to `.env`, generate the app key, run initial migrations, and build frontend assets.
   ```bash
   composer run setup
   ```
5. **Configure environment:**
   Update your `.env` file with your specific database credentials if they differ from the defaults.
6. **Create the storage symlink:**
   Link the public storage directory to make uploaded images visible.
   ```bash
   php artisan storage:link
   ```
7. **Start the development environment:**
   ```bash
   composer run dev
   ```

## Environment Configuration

The application requires basic environment configuration in the `.env` file for local development. Important variables include:

* `APP_URL`: The local URL of your application (e.g., `http://localhost`).
* `DB_DATABASE`: The default database name is `spinner_mart_e_commerce`. You can update this to match your local setup.
* `DB_USERNAME` & `DB_PASSWORD`: Your local database credentials.
* `FILESYSTEM_DISK`: Configured to `public` by default for local storage.
* `MAIL_MAILER`: Local mail configuration currently uses Laravel's `log` mailer by default.

*Note: Never commit your actual `.env` file containing real API keys, passwords, or secure tokens.*

## Database & Demo Data

The project includes database seeders that generate essential roles, settings, and demo data (users, categories, products, etc.) for testing the application.

To run migrations and seed the database with demo data initially:
```bash
php artisan migrate --seed
```

To completely reset the database and re-seed all demo data:
```bash
php artisan migrate:fresh --seed
```

> **Warning:** `migrate:fresh --seed` is intended for local/development environments. It will delete existing database tables and data before recreating the database with the seeded demo data.

### Demo / Local Development Credentials

If you have seeded the database, you can log in using the following default accounts.

**Admin**
* **Email:** `admin@gmail.com`
* **Password:** `password`

**Customer**
* **Email:** `user@gmail.com`
* **Password:** `password`

*Note: These credentials are for local development and demonstration purposes only. Do not use them in a real production environment.*

## Running Locally

To start the local development server, use the included composer script:

```bash
composer run dev
```

This command uses `concurrently` to automatically start three processes simultaneously:
1. The Laravel development server (`php artisan serve`)
2. A local queue listener (`php artisan queue:listen`)
3. The Vite development server for hot-reloading frontend assets (`npm run dev`)

## Project Structure

* `app/` - Core application code.
* `app/Http/` - Contains Controllers, Middleware, and Requests.
* `app/Models/` - Eloquent database models.
* `app/Repositories/` - Data access logic separating DB queries from controllers.
* `database/` - Migrations, factories, and seeders.
* `resources/views/` - Laravel Blade templates organized by admin, frontend, and components.
* `routes/` - Web and Admin route definitions.
* `public/` - Publicly accessible assets and the `index.php` entry point.
* `storage/` - Logs, compiled views, and user-uploaded public files.
* `config/` - Application configuration files.

## Architecture

### Repository Pattern
The project uses the Repository Pattern in selected areas. It is used mainly for code organization and separation of data-access responsibilities. This helps keep certain controllers cleaner by abstracting database logic. It is also part of the project's learning and practice of structured Laravel development.

### Authentication & Role Management
The project uses Laravel's built-in authentication system. It uses `spatie/laravel-permission` for role and permission management. 

The application currently defines two primary roles:
* `admin`: Has access to the backend admin panel to manage the store.
* `user`: The default role for registered customers to manage their profile and orders.

## Business Rules

* Order cancellation is allowed only for `pending` orders.
* Return requests are allowed only for eligible `delivered` orders.
* Return eligibility depends on the configured return policy period.
* The default return period is 7 days from the delivery date.

## Useful Commands

```bash
# Run pending database migrations
php artisan migrate

# Run migrations and seed the database with demo data
php artisan migrate --seed

# Drop all tables, re-run migrations, and seed demo data
php artisan migrate:fresh --seed

# Create a symbolic link for public storage
php artisan storage:link

# Clear all cached configurations and views
php artisan optimize:clear

# View all registered application routes
php artisan route:list

# Start the local development servers (Laravel + Vite + Queue)
composer run dev
```

## Future Development

The following features are NOT currently implemented and represent planned future improvements.

### Planned Improvements
* Online payment gateway integration
* Transactional email configuration and email integration
* Application-specific background job processing where required
* Task scheduling and automation where useful
* Other improvements as the application evolves

*(Note: While a queue listener and log mailer are configured by default for local development convenience, no major application-specific background job workflow or real email sending is currently required or implemented.)*

## Development Context

Spinner Mart is a personal Laravel learning and pet project created to gain practical experience by building a complete e-commerce application. The project focuses on practicing:

* Laravel conventions and best practices
* Repository Pattern
* Role and permission management
* Database relationships
* Authentication and authorization
* Structured application organization
* E-commerce business logic
* Maintainable code organization

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).