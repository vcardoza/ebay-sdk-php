# eBay SDK for PHP

## Description

The eBay SDK for PHP allows developers to programmatically interact with eBay’s marketplace services. It provides comprehensive access to various features such as listing products, retrieving sales orders, managing inventories, and tracking payments.

### Features
Orders and Transaction: Fetch sales orders and transaction details for order processing and reporting.

### To get refresh token

* Login in to your eBay developer account
* Go to user tokens page
* Copy the Sign in (OAuth) full URL and paste it in your browser
* Enter the developer account username and password
* Once signed in, the next sign in will be your actual eBay account
* On successful login, the URL will be generated. Copy the URL and paste it in your program as below
```
define('CLIENT_ID', 'YOUR_CLIENT_ID');
define('CLIENT_SECRET', 'YOUR_SECRET_KEY');
define('REDIRECT_URL_NAME', 'REDIRECT_URL_NAME');
define('REFRESH_TOKEN', '');
define('ENVIRONMENT', 'production');
$sdk = new Sdk();
$sdk = new Sdk();
$token = $sdk->token()->getAccessAndRefreshToken('PASTE_THE_FULL_URL');
print '<pre>';
print_r($token);
print '</pre>';
```
* Copy the refresh token and paste it in the REFRESH_TOKEN variable
* Note: The above URL will be valid only for 5 minutes. The refres token need to be generated again after 5 minutes.
* Note: The refresh token is valid for 1 year. If you want to use it for longer, you need to generate a new token.

### Orders

Get all order (limit to latest 100), retrieve more orders by defining the offset

getAll(int $limit = 100, int $offset = 0)

```
$orders = $sdk->orders()->getAll();
$orders = $sdk->orders()->getAll(100, 1);
```

getById(string $id)

```
$order = $sdk->orders()->getById('ORDER_ID');
```