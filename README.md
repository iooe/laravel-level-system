#Readme coming soon

#Install


composer require tizis/laravel-level-system

##Publish Migrations & migrate 


php artisan vendor:publish --provider="tizis\LevelSystem\Providers\ServiceProvider" --tag=migrations
php artisan migrate


##Publish Config & configure 


php artisan vendor:publish --provider="tizis\LevelSystem\Providers\ServiceProvider" --tag=config 



#Models


```php
use tizis\achievements\Contracts\Achievementable as AchievementableContract;
use tizis\achievements\Traits\Achievementable;

class User extends Authenticatable implements AchievementableContract {
	use Achievementable;
}
```   


#Examples

```php

//config example

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
      $service->addProgress(500); // now user have 2 level and 200 experience (500 - 100 - 200)

      
``` 
