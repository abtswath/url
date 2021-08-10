# url
A library to parse URL, support parameters with the same name.
```injectablephp
<?php
$url = new \Great\Url\URL('https://www.test.com');
$url->setProtocol('http');
$url->getSearchParams()->set('a', 'b');
echo $url;
```
