****************************************************************
## Fleetsu Laravel based REST Service Demo - PSR Compliant code
****************************************************************

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.



## Basic Home page:

URL: http://127.0.0.1:8000/

* Display the list of configured API i.e., Company Profile and Quote


## To Get Company Profile:

Method: GET

URL: http://127.0.0.1:8000/api/v1/company/profile/$name

Parameters

* $name mandatory (eg: AAPL)

If no parameter, it will return the error


## To Get Quote:

URL: http://127.0.0.1:8000/api/v1/profile/$name

Method: POST

Parameters

* $name mandatory (eg: AAPL)

If no parameter, it will return the error


## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
