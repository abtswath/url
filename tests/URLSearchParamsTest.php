<?php

namespace Tests;

use ArrayIterator;
use Url\URLSearchParams;
use PHPUnit\Framework\TestCase;

class URLSearchParamsTest extends TestCase {

    public function testConstruct() {
        $searchParams = new URLSearchParams(
            'key=value2&key=value1&key=value3&key2=value'
        );
        $this->assertEquals(
            'key=value2&key=value1&key=value3&key2=value',
            (string)$searchParams
        );
    }

    public function testGet() {
        $searchParams = new URLSearchParams(
            'key=value2&key=value1&key=value3&key2=value'
        );
        $this->assertEquals('value2', $searchParams->get('key'));
        $this->assertEquals(
            ['value2', 'value1', 'value3'],
            $searchParams->getAll('key')
        );
    }

    public function testSet() {
        $searchParams = new URLSearchParams(
            'key=value2&key=value1&key=value3&key2=value'
        );
        $searchParams->set('b', 'c');
        $this->assertEquals(
            'key=value2&key=value1&key=value3&key2=value&b=c',
            (string)$searchParams
        );
        $searchParams->set('key', 'value');
        $this->assertEquals(
            'key=value&key2=value&b=c',
            (string)$searchParams
        );
    }

    public function testAppend() {
        $searchParams = new URLSearchParams(
            'key=value2&key=value1&key=value3&key2=value'
        );
        $searchParams->append('key', 'value3');
        $this->assertEquals(
            'key=value2&key=value1&key=value3&key2=value',
            (string)$searchParams
        );
        $searchParams->set('key', 'value4');
        $this->assertEquals(
            'key=value4&key2=value',
            (string)$searchParams
        );
    }

    public function testDelete() {
        $searchParams = new URLSearchParams(
            'a=b&key=value2&key=value1&key=value3&key2=value'
        );
        $searchParams->delete('key2');
        $this->assertEquals(
            'a=b&key=value2&key=value1&key=value3',
            (string)$searchParams
        );
        $searchParams->delete('key');
        $this->assertEquals('a=b', (string)$searchParams);
    }

    public function testHas() {
        $searchParams = new URLSearchParams(
            'a=b&key=value2&key=value1&key=value3&key2=value'
        );
        $this->assertEquals(false, $searchParams->has('c'));
        $this->assertEquals(true, $searchParams->has('key'));
    }

    public function testEach() {
        $searchParams = new URLSearchParams(
            'a=b&key=value2&key=value1&key=value3&key2=value'
        );
        $data = [];
        $searchParams->each(function ($key, $value) use (&$data) {
            array_push($data, "$key=$value");
        });
        $this->assertEquals(
            implode('&', $data),
            (string)$searchParams
        );
    }

    public function testSort() {
        $searchParams = new URLSearchParams(
            'key=value2&key=value1&key=value3&key2=value&a=c'
        );
        $searchParams->sort();
        $this->assertEquals(
            'a=c&key=value1&key=value2&key=value3&key2=value',
            (string)$searchParams
        );
    }

    public function testKeys() {
        $searchParams = new URLSearchParams(
            'key=value2&key=value1&key=value3&key2=value&a=c'
        );
        $this->assertEquals(
            new ArrayIterator(
                ['key', 'key2', 'a']
            ),
            $searchParams->keys()
        );
    }

    public function testEntries() {
        $searchParams = new URLSearchParams(
            'key=value2&key=value1&key=value3&key2=value&a=c'
        );
        $this->assertEquals(
            new ArrayIterator(
                [
                    ['key', 'value2'],
                    ['key', 'value1'],
                    ['key', 'value3'],
                    ['key2', 'value'],
                    ['a', 'c']
                ]
            ),
            $searchParams->entries());
    }

    public function testValues() {
        $searchParams = new URLSearchParams(
            'key=value2&key=value1&key=value3&key2=value&a=c'
        );
        $this->assertEquals(
            new ArrayIterator(
                ['value2', 'value1', 'value3', 'value', 'c']
            ),
            $searchParams->values()
        );
    }

}
