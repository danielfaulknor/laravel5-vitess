# Laravel 5 Vitess Database

Add the service provider to your `config/app.php` `providers` array
```
Tjcelaya\Laravel5\Vitess\VitessDatabaseConnectionServiceProvider::class,
```

Create a database config with `'driver' => 'vitess'` and the required `host` and `port` values.

You should be ready to go!

```
php artisan tinker

>>> DB::connection('vt_db')->table('animals')->where('cool', 1)->get();
=> [
     "id" => 5,
     "name" => "Webscale Gopher",
     "cool" => 1
   ]
```
