# eBay API for PHP

## Description

The eBay API for PHP allows developers to programmatically interact with eBay’s marketplace services. It provides comprehensive access to various features such as listing products, retrieving sales orders, managing inventories, and tracking payments.

### Features
* Order and Transaction Management: Fetch sales orders and transaction details for order processing and reporting.

### To get refresh token

* Login in to your eBay developer account
* Go to user tokens page
* Copy the Sign in (OAuth) full URL and paste it in your browser
* Enter the developer account username and password
* Once signed in, the next sign in will be your actual eBay account
* On successful login, the URL will be generated. Copy the URL and paste it in your program as below
```
$ebayApi = new EbayApi('CLIENT-ID', 'CLIENT-SECRET', 'REDIRECT-URI', '', 'sandbox or production');
$ebayApi->getAccessAndRefreshToken('PASTE THE FULL URL');
```
* Note: The above URL will be valid only for 5 minutes. The refres token need to be generated again after 5 minutes.
* Note: The refresh token is valid for 1 year. If you want to use it for longer, you need to generate a new token.
