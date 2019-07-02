# Laravel JWT
![alt tag](https://img.shields.io/badge/Developer-Danang_Nugroho-red.svg)

Example CRUD Rest API Using Auth JWT
 

### How to Install


Documentation: 


A. Clone the project

```sh
	git clone https://github.com/istuu/laravel-jwt

```

B. Setting Database Connection in .env file

```sh
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=[DB_NAME]
    DB_USERNAME=[DB_USERNAME]
    DB_PASSWORD=[DB_PASSWORD]

```

C. Run Composer Install / Update
```sh
    composer install

```
D. Migrate table

```sh
    php artisan migrate

```
    
E. Run DB Seeder

```sh
    php artisan db:seed

```

F. Run Following Command
```sh
    php artisan jwt:secret
	
```

G. Finish


H. Default Authentication

|  Email  |      Password      |
|:--------:|:-------------:|
|officer@demo.com |  password |
