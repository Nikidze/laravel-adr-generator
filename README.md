# Laravel Repositories generator
 
[![Latest Stable Version](https://poser.pugx.org/nikidze/laravel-adr-generator/v/stable)](https://packagist.org/packages/nikidze/laravel-adr-generator)
[![Total Downloads](https://poser.pugx.org/nikidze/laravel-adr-generator/downloads)](https://packagist.org/packages/nikidze/laravel-adr-generator)
[![Monthly Downloads](https://poser.pugx.org/nikidze/laravel-adr-generator/d/monthly)](https://packagist.org/packages/nikidze/laravel-adr-generator)
[![License](https://poser.pugx.org/nikidze/laravel-adr-generator/license)](https://packagist.org/packages/nikidze/laravel-adr-generator)

Laravel Repositories generator is a package for Laravel 8 which is used to generate reposiotries from eloquent models.

## Installation

Run the following command from you terminal:


 ```bash
 composer require "nikidze/laravel-adr-generator"
 ```

## Usage

Generate your actions, responses and requests.
 ```bash
 php artisan make:adr Auth/Login
 ```

```php
<?php

namespace App\Actions\Auth;

use App\Responses\Auth\LoginResponse;
use App\Requests\Auth\LoginRequest;

class LoginAction {

    public function __construct(
        private LoginResponse $response
    ) {}

    public function __invoke(LoginRequest $request)
    {
    }
}
```

```php
<?php

namespace App\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [

        ];
    }
}
```
```php
<?php

<?php

namespace App\Responses\Auth;

class LoginResponse {

    public function respond()
    {

    }
}
```
