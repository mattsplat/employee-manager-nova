## Employee Manager

clone repository
``` git clone git@github.com:mattsplat/employee-manager.git ```

copy .env.example to .env
``` cp .env.example .env```

setup database config in env

generate key
```php artisan key:generate```

run migrations and seed database
```php artisan migrate --seed```

