# Install
```bash
composer require abtswiath/url
```
# Use
A library to parse URL, support parameters with the same name.
```php
$url = new \Url\URL('https://www.test.com');
$url->setProtocol('http');
$url->getSearchParams()->set('a', 'b');
echo $url;
```
