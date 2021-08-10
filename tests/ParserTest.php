<?php
declare(strict_types=1);

namespace Tests;

use Url\Parser;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class ParserTest extends TestCase {

    private $parser;

    protected function setUp(): void {
        parent::setUp();
        $this->parser = new Parser();
    }

    protected function tearDown(): void {
        $this->parser = null;
        parent::tearDown();
    }

    public function testParseUrl(): void {
        $url = 'https://user:pass@www.test.com/test?key=value&key=value2#hash?key=fake';
        $parsed = $this->parser->parse($url);
        $this->assertEquals([
            'protocol' => 'https',
            'hostname' => 'www.test.com',
            'port' => null,
            'pathname' => '/test',
            'search' => 'key=value&key=value2',
            'hash' => 'hash?key=fake',
            'username' => 'user',
            'password' => 'pass',
        ], $parsed);
    }

    public function testThrowsInvalidArgumentException(): void {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid URL \'http:///path1/path2\'');
        $this->parser->parse('http:///path1/path2');
    }
}
