### CRUD-API
### Hello my name is YOEUNG YENG
### CRUD API WITH LARAVAL BY SECURE JWT
#### STEP1: Set up new project
  ```composer create-project laravel/laravel new-project```
  ##### then we use this comment to folder new-project
  ```cd new-project```
#### Step 2: Install JWT Package
  ```composer require tymon/jwt-auth```
  ##### Then publish the config:
  ```php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"```
  ##### Generate JWT secret:
  ```php artisan jwt:secret```
#### Step 3: Install api
  ```php artisan install:api```
####  Step 4: Set up Auth Controller
  ```php artisan make:controller Api/AuthController```
#### Step 5: Set API Routes
#### Step 6: Configure JWT Guard
#### Step 7: Create Products Model & Controller
```php artisan make:model Product -m```
```php artisan make:controller Api/ProductsController --api```
#### The last use Comment to generat to database
```Run migration:```
## note: I use sqlite database
