# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is a Laravel 11 application with Filament admin panel. It uses:

- **Laravel Framework**: 11.31 with PHP 8.2+
- **Filament Admin Panel**: v4.0 - accessible at `/admin` path with login authentication
- **Database**: MySQL
- **Frontend**: Vite + TailwindCSS for asset compilation
- **Testing**: PHPUnit with Feature and Unit test suites

## Development Commands

### Laravel/PHP Commands
```bash
# Start development server (with queue, logs, and vite)
composer run dev

# Individual services
php artisan serve          # Start Laravel server
php artisan queue:listen   # Process queues
php artisan pail          # View logs
php artisan tinker        # REPL

# Database
php artisan migrate       # Run migrations
php artisan migrate:fresh # Fresh migrations

# Clear caches
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

### Frontend Commands
```bash
npm run dev    # Start Vite development server
npm run build  # Build for production
```

### Testing
```bash
vendor/bin/phpunit                    # Run all tests
vendor/bin/phpunit tests/Feature      # Feature tests only
vendor/bin/phpunit tests/Unit         # Unit tests only
```

### Code Quality
```bash
vendor/bin/pint    # PHP code formatting (Laravel Pint)
```

## Architecture

### Core Structure
- **app/Http/Controllers**: Web controllers
- **app/Models**: Eloquent models (User model exists)
- **app/Providers**: Service providers including Filament admin panel config
- **app/Filament/**: Filament admin resources, pages, and widgets (auto-discovered)

### Admin Panel
- **Provider**: `app/Providers/Filament/AdminPanelProvider.php`
- **Path**: `/admin` with login authentication
- **Theme**: Amber primary color
- **Auto-discovery**: Resources, Pages, and Widgets are automatically discovered

### Database
- **Driver**: MySQL
- **Migrations**: `database/migrations/`
- **Factories**: `database/factories/`
- **Seeders**: `database/seeders/`

### Frontend Assets
- **CSS**: `resources/css/app.css` (TailwindCSS)
- **JS**: `resources/js/app.js`
- **Build Tool**: Vite (`vite.config.js`)
- **Public Assets**: `public/` (compiled assets go here)

## Configuration Notes

- Uses MySQL database
- Filament admin panel configured with authentication
- Concurrent development script runs server, queue, logs, and Vite simultaneously
- Standard Laravel 11 directory structure and conventions