# eBay SDK for PHP

## Description

The eBay SDK for PHP allows developers to programmatically interact with eBay’s marketplace services. It provides comprehensive access to various features such as products, retrieving sales orders.

### Features
* Store details
* Orders and Transaction
* Feedbacks

### Initialization

```
define('CLIENT_ID', 'YOUR_CLIENT_ID');
define('DEV_ID', 'YOUR_DEV_ID');
define('OAUTH_TOKEN', 'YOUR_OAUTH_TOKEN');
define('CLIENT_SECRET', 'YOUR_SECRET_KEY');
```

### Store

Get store details

```
$sdk->store()->getAll();
```

### Orders

Get all order (limit to latest 100), retrieve more orders by defining the offset

```
$sdk->order()->getAll(int $numberOfDays = 30, int $limit = 100, int $offset = 0);
$sdk->order()->getById('OrderID');
```

### Feedbacks

Get all feedback

```
$sdk->feedback()->getAll(int $limit = 100, int $offset = 0);
$sdk->feedback()->getById('FeedbackID');
```

