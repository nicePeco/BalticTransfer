<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

packages needed:

Spatie's Laravel Permission package. 1. composer require spatie/laravel-permission 2. php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider" 3. sail artisan migrate (https://spatie.be/docs/laravel-permission/v6/introduction)

Hashids package. 1. composer require vinkla/hashids 2. sail artisan vendor:publish --provider="Vinkla\Hashids\HashidsServiceProvider" (https://github.com/vinkla/laravel-hashids)

must do:
need to make admin manually. 1. sail artisan tinker 2. $user = User::where('email', 'admin@example.com')->first(); 3. $user->assignRole('admin'); 4. exit

if you want to remove the admin, than - 1. $user = User::where('email', 'admin@example.com')->first(); $user->removeRole('admin')