# Laravel Product CRUD REST APIs

## Requirements

```
PHP 8.2
MySQL
```

# Installation

```
# Clone code repository.
git clone git@github.com:otjutt/laravel-product-crud-rest-apis.git

# Switch directory.
cd laravel-product-crud-rest-apis;

# Create environment files.
cp .env.example .env.testing;
cp .env.example .env;

# Composer install
composer install --ignore-platform-reqs -vvv --profile --prefer-dist

# Laravel Sail up.
./vendor/bin/sail up -d

# Run tests.
./vendor/bin/sail artisan test
```

## API Endpoints

```
Index:  GET /api/v1/product
Create: POST /api/v1/product
Read:   GET /api/v1/product/:id
Update: POST /api/v1/product/:id
Delete: DELETE /api/v1/product/:id
```
