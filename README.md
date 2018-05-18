# Prepaid Card

## Set up
To run this application, follow the steps below

Run Docker compose command

```shell
docker-compose up -d
```

Navigate to the following URL
http://localhost:8000/

### Import the Database schema into the database
The schema file is in the root directory `pre-paid-card.sql`

Connect to the Docker Database service
DB_HOST=lumen-db
DB_PORT=3308
DB_DATABASE=lumen
DB_USERNAME=app
DB_PASSWORD=password

Import the schema

## Interacting with the API
Below are the available endpoints

```php
$router->get('/card/all', 'CardController@all');
$router->get('/card/{id}/available-balance', 'CardController@availableBalance');
$router->get('/card/{id}/activity', 'CardController@getActivity');

$router->post('/card/add', 'CardController@add');
$router->post('/card/{id}/top-up', 'CardController@topUp');
$router->post('/card/{id}/authorize', 'CardController@requestPayment');

$router->get('/merchant/{id}/transactions', 'MerchantController@getTransactions');
$router->post('/merchant/add', 'MerchantController@add');
$router->post('/merchant/{id}/refund', 'MerchantController@refund');
$router->put('/merchant/{id}/capture-transaction', 'MerchantController@capture');

```