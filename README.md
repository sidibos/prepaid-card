# Prepaid Card
This application is writing in Laravel Lumen framework

## Requires
Composer, Docker, PHP and Lumen

## Set up
To run this application, follow the steps below

First clone this repos and go into prepaid-card directory by doing
```shell
cd prepaid-card
```

Run the composer update cmd

```shell
 composer update
```

And Run the Docker compose command

```shell
docker-compose up -d
```

Navigate to the following URL
[http://localhost:8080](http://localhost:8080)

Before you start interacting with the application make sure you import the Database schema as explained below

### Import the Database schema
The schema file is in the root directory `/prepaid-card/pre-paid-card.sql`

Below is the Docker Database service details

DB_HOST=lumen-db

DB_PORT=3308

DB_DATABASE=lumen

DB_USERNAME=app

DB_PASSWORD=password

To import the schema you can either run the following cmd or use an SQL client like `Sequel Pro`

Make sure you are in the root folder `prepaid-card` and run:

```shell
docker exec -i prepaidcard_lumen-db_1 mysql -uapp -ppassword lumen < ./pre-paid-card.sql
```

If you are using `Sequel Pro` set the config as follow

Host: 127.0.0.1

Username: app

Password: password

Port: 3308


## Interacting with the API
Below are the available endpoints, you can use an API client service like `Postman`

```php
$router->get('/card/all', 'CardController@all');
$router->get('/card/{id}/available-balance', 'CardController@availableBalance');
$router->get('/card/{id}/activity', 'CardController@getActivity');

$router->post('/card/add', 'CardController@add');
Request Body example

{
  "name":"test",
  "user_id": 2,
  "currency":"GBP"
}

$router->post('/card/{id}/top-up', 'CardController@topUp');
Request Body example

{
  "amount":20,
}

$router->post('/card/{id}/authorize', 'CardController@requestPayment');
Request Body example

{
  "amount":20,
}


$router->get('/merchant/{id}/transactions', 'MerchantController@getTransactions');
$router->post('/merchant/add', 'MerchantController@add');
Request Body example

{
  "name": "Test Merchant",
}

$router->post('/merchant/{id}/refund', 'MerchantController@refund');
{id} is TransactionID

$router->put('/merchant/{id}/capture-transaction', 'MerchantController@capture');
Request Body example

{
  "amount":20,
}

```