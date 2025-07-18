# Laravel Modules Project

A modular Laravel application built with the `nwidart/laravel-modules` package for better code organization and maintainability.

## Prerequisites

- PHP 12.0 or higher
- Composer
- MySQL/MariaDB
- Node.js & NPM
- Git

## Project Setup

### 1. Clone the Repository

```bash
git clone https://github.com/pavanraj92/laravel-modules.git
cd laravel-modules
```

### 2. Install Dependencies

Install PHP dependencies:
```bash
composer install
```

### 3. Environment Configuration

Copy the environment file:
```bash
cp .env.example .env
```

Update the `.env` file with your database credentials:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_modules
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 4. Generate Application Key

```bash
php artisan key:generate
```

### 5. Create Storage Directories

```bash
mkdir -p storage/framework/cache/data
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/app/public
```

### 6. Create Database

Create a new MySQL database named `laravel_modules` (or whatever you specified in your `.env` file).

### 7. Run Migrations

```bash
php artisan migrate
```

### 8. Seed Database

Run the following seeders in order to populate your database with initial data:

#### Admin Role & Permission Seeder
```bash
php artisan db:seed --class="Modules\AdminRolePermission\Database\Seeders\AdminRolePermissionDatabaseSeeder"
```

#### User Roles Seeder
```bash
php artisan db:seed --class="Modules\User\Database\Seeders\SeedUserRolesSeeder"
```

#### Settings Seeder
```bash
php artisan db:seed --class="Modules\Setting\Database\Seeders\SettingDatabaseSeeder"
```

#### Admin Super User Seeder (Optional)
```bash
php artisan db:seed --class="Modules\Admin\Database\Seeders\AdminDatabaseSeeder"
```

### 9. Create Storage Link

```bash
php artisan storage:link
```

## Running the Application

Start the development server:
```bash
php artisan serve --port=8000
```

Or use the convenient development script:
```bash
composer run dev
```

This will start:
- Laravel development server
- Queue worker
- Laravel Pail (logs)
- Vite development server

Visit `http://localhost:8000` to access the application.

## Default Credentials

After running the seeders, you can login with:

**Super Admin:**
- Email: `admin@yopmail.com`
- Password: `Dots@123`

## Module Structure

This project uses the following modules:

- **Admin** - Admin user management
- **AdminManager** - Admin management functionality
- **AdminRolePermission** - Role and permission management
- **Banner** - Banner management
- **Category** - Category management
- **Email** - Email functionality
- **Faq** - FAQ management
- **Page** - CMS page management
- **Setting** - Application settings
- **User** - User management
- **UserRole** - User role management

## Available Commands

### Module Management
```bash
# Create a new module
php artisan module:make ModuleName

# List all modules
php artisan module:list

# Enable a module
php artisan module:enable ModuleName

# Disable a module
php artisan module:disable ModuleName
```

### Cache Management
```bash
# Clear all caches
php artisan optimize:clear

# Cache configuration
php artisan config:cache

# Cache routes
php artisan route:cache
```

### Testing
```bash
# Run tests
composer test

# Or
php artisan test
```

## Troubleshooting

### Port Already in Use
If port 8000 is already in use, try a different port:
```bash
php artisan serve --port=8001
```

### Permission Issues
If you encounter permission issues, make sure the storage and bootstrap/cache directories are writable:
```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

### Cache Issues
If you encounter any caching issues, clear all caches:
```bash
php artisan optimize:clear
```

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Run tests
5. Submit a pull request

## License

This project is licensed under the MIT License.