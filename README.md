# E Agriculture

## Payment Credentials:

### Esewa:
    - eSewa ID: 9806800001/2/3/4/5
    - Password: Nepal@123 MPIN: 1122 (for application only)
    - Token:123456

### Khalti:
    - Id: 9800000000/1/2/3/4/5
    - Password: admin123
    - Token: 987654

## Serve
php artisan serve --host=localhost
npx localtunnel --port 8000 --subdomain abhishek 



## Explanation

### Composer
composer create-project laravel/laravel [project_name]
cd [project_name]



### Start of project
- TALL stack
    - Tailwind
    - Alpine
    - Laravel
    - Livewire
- MVC Concept
    - Model
    - View
    - Controller

### Project Structure
- database
    - migrations
    - seeders
- routes
    - web.php
- .env
- config
- app
    - Models
    - Http
        - Controllers
        - Requests
    - Enums
    - Filament
    - Livewire
    - Notifications
    - Payments
        - Esewa
        - Khalti
        - Null
        - Sajilo Pay
- resources
    - views
        - [filename].blade.php
        - livewire
        - components
    - css
    - markdown
- storage
    - logs
    - app
        - public
