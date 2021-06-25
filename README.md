## Laravel API Movies CRUD con AUTH JWT

## Requisitos

-   [Composer](https://getcomposer.org/)
-   [PHP 7.3.4ˆ](https://secure.php.net/)
-   [Node](https://nodejs.org)

## Correr el Proyecto Localmente

-   1 - Instalar Dependencias de Composer PHP

```sh
$ composer install
```

-   3 - Hacer una copia de .env.example y renombrar como .env:

```sh
$ cp .env.example .env
```

-   3 - Generar Llave de Laravel:

```sh
$ php artisan key:generate
```

-   4 - Publicat Config JWT AUTH y Generar Llave de AUTH JWT:

```sh
$ php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"
$ php artisan jwt:secret
```

-   5 - Correr Migraciones

```sh
$ php artisan migrate
```

-   6 - Correr Servidor Web ARTISAN de Laravel:

```sh
$ php artisan serve
```

-   6 - Abrir en el navegador[http://127.0.0.1:8000](http://127.0.0.1:8000)
