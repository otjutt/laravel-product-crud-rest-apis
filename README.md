# Laravel Product CRUD REST APIs

## Requirements

- PHP 8.2
- MySQL

# Installation

Step 1: Clone code repository.
```
git clone git@github.com:otjutt/laravel-product-crud-rest-apis.git
```

Step 2: Switch directory.
```
cd laravel-product-crud-rest-apis;
```

Step 3: Create environment files.
```
cp .env.example .env.testing; cp .env.example .env;
```

Step 4: Composer install
```
composer install --ignore-platform-reqs --profile --prefer-dist -vvv
```
Step 5: Laravel Sail up.
```
./vendor/bin/sail up -d
```

Step 6: Run tests.
```
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
