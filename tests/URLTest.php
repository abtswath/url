<?php

namespace Tests;

use Url\URL;
use Url\URLSearchParams;
use PHPUnit\Framework\TestCase;

class URLTest extends TestCase {

    public function testConstruct() {
        $url = new URL(
            'https://user:pass@www.test.com/test?key=value&key=value2&a=b#hash?key=fake'
        );
        $this->assertEquals(
            'https://user:pass@www.test.com/test?key=value&key=value2&a=b#hash?key=fake',
            (string)$url
        );
        $this->assertEquals('user', $url->getUsername());
        $this->assertEquals('pass', $url->getPassword());
        $this->assertEquals('www.test.com', $url->getHostname());
        $this->assertEquals('www.test.com', $url->getHost());
        $this->assertEquals(null, $url->getPort());
        $this->assertEquals('/test', $url->getPathname());
        $this->assertEquals(new URLSearchParams('key=value&key=value2&a=b'), $url->getSearchParams());
        $this->assertEquals(
            new URLSearchParams('key=value&key=value2&a=b'),
            $url->getSearchParams()
        );
        $this->assertEquals('hash?key=fake', $url->getHash());
    }

    public function testProtocol() {
        $url = new URL(
            'https://www.test.com'
        );
        $this->assertEquals('https', $url->getProtocol());
        $url->setProtocol('http');
        $this->assertEquals('http', $url->getProtocol());
        $this->assertEquals(
            'http://www.test.com',
            (string)$url
        );
    }

    public function testUsername() {
        $url = new URL(
            'https://user:pass@www.test.com'
        );
        $this->assertEquals('user', $url->getUsername());
        $url->setUsername('test');
        $this->assertEquals('test', $url->getUsername());
        $this->assertEquals(
            'https://test:pass@www.test.com',
            (string)$url
        );
    }

    public function testPassword() {
        $url = new URL(
            'https://user:pass@www.test.com'
        );
        $this->assertEquals('pass', $url->getPassword());
        $url->setPassword('123456');
        $this->assertEquals('123456', $url->getPassword());
        $this->assertEquals(
            'https://user:123456@www.test.com',
            (string)$url
        );
    }

    public function testHostname() {
        $url = new URL(
            'https://www.test.com/index?a=1&b=2'
        );
        $this->assertEquals('www.test.com', $url->getHostname());
        $this->assertEquals('www.test.com', $url->getHost());
        $this->assertEquals('https://www.test.com', $url->getOrigin());
        $url->setHostname('www.abc.com');
        $this->assertEquals('www.abc.com', $url->getHostname());
        $this->assertEquals('www.abc.com', $url->getHost());
        $this->assertEquals('https://www.abc.com', $url->getOrigin());
        $this->assertEquals(
            'https://www.abc.com/index?a=1&b=2',
            (string)$url
        );
    }

    public function testPathname() {
        $url = new URL(
            'https://www.test.com/test?a=1&b=2'
        );
        $this->assertEquals('/test', $url->getPathname());
        $url->setPathname('/index');
        $this->assertEquals('/index', $url->getPathname());
        $this->assertEquals(
            'https://www.test.com/index?a=1&b=2',
            (string)$url
        );
    }

    public function testSearchParams() {
        $url = new URL(
            'https://www.test.com/test?a=1&b=2'
        );
        $this->assertEquals(
            new URLSearchParams('a=1&b=2'),
            $url->getSearchParams()
        );
        $url->setSearchParams('key=value1&key=value2&c=3');
        $this->assertEquals(
            new URLSearchParams('key=value1&key=value2&c=3'),
            $url->getSearchParams()
        );
        $this->assertEquals(
            'https://www.test.com/test?key=value1&key=value2&c=3',
            (string)$url
        );
    }

    public function testHash() {
        $url = new URL(
            'https://www.test.com/test#hash?key=value'
        );
        $this->assertEquals('hash?key=value', $url->getHash());
        $url->setHash('anchor');
        $this->assertEquals('anchor', $url->getHash());
        $this->assertEquals(
            'https://www.test.com/test#anchor',
            (string)$url
        );
    }
}
