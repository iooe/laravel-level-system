## Install

`composer require tizis/laravel-level-system`

### Publish Migrations & migrate 

```php
php artisan vendor:publish --provider="tizis\LevelSystem\Providers\ServiceProvider" --tag=migrations
php artisan migrate
```

### Publish Config & configure 

`php artisan vendor:publish --provider="tizis\LevelSystem\Providers\ServiceProvider" --tag=config`

### Example

```php
/config/user-levels.php

return [
    'levels' => [
        1 => 100,
        2 => 200,
        3 => 300,
        4 => 400,
        5 => 500,
        ...
    ]
];
``` 


```php
$user = User::where('id', 1)->first();
$service = new LevelService($user);  
$service->addProgress(500); // now user has 2nd level and 200 points of experience (500 - 100 - 200)
``` 
