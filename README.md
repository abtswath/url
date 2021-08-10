# abtwiath/url
A PHP library to parse URL, support parameters with the same name.
## Installation
```bash
composer require abtswiath/url
```
```php
require 'vendor/autoload.php';
use Url\URL;
$url = new URL('https://www.test.com');
$url->setProtocol('http');
$url->getSearchParams()->set('a', 'b');
echo $url;
```
