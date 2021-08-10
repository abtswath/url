<?php

namespace Url;

use InvalidArgumentException;

class Parser implements ParserInterface {

    public function parse(string $url): array {
        $parsed = $this->parseUrl($url);
        if ($parsed === false) {
            throw new InvalidArgumentException(sprintf('Invalid URL \'%s\'', $url));
        }

        $data['protocol'] = $parsed['scheme'] ?? '';
        $data['hostname'] = $parsed['host'] ?? '';
        $data['port'] = $parsed['port'] ?? null;
        $data['pathname'] = $parsed['path'] ?? '';
        $data['search'] = $parsed['query'] ?? '';
        $data['hash'] = $parsed['fragment'] ?? '';
        $data['username'] = $parsed['user'] ?? '';
        $data['password'] = $parsed['pass'] ?? '';
        return $data;
    }

    protected function parseUrl(string $url) {
        return parse_url($url);
    }

}
