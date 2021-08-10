<?php

namespace Url;

use ArrayIterator;

class URLSearchParams {

    private $data;

    public function __construct(string $queryString) {
        $this->parseQuery($queryString);
    }

    protected function parseQuery(string $queryString): void {
        if ($queryString === '') {
            $this->data = [];
        } else {
            $queryList = explode('&', $queryString);
            foreach ($queryList as $item) {
                $exploded = explode('=', $item);
                if (!isset($this->data[$exploded[0]])) {
                    $this->data[$exploded[0]] = [];
                }
                array_push($this->data[$exploded[0]], $exploded[1] ?? '');
            }
        }
    }

    public function append(string $key, $value): void {
        if ($this->has($key)) {
            if (!in_array($value, $this->data[$key])) {
                array_push($this->data[$key], $value);
            }
            return;
        }
        array_push($this->data, [$key => $value]);
    }

    public function delete(string $key): void {
        if (!$this->has($key)) {
            return;
        }
        unset($this->data[$key]);
    }

    public function get(string $key): ?string {
        if (!$this->has($key)) {
            return null;
        }
        return $this->data[$key][0];
    }

    public function set(string $key, $value): void {
        $this->data[$key] = [$value];
    }

    public function getAll(string $key): array {
        if (!$this->has($key)) {
            return [];
        }
        return $this->data[$key];
    }

    public function each(callable $callback): void {
        foreach ($this->data as $key => $values) {
            foreach ($values as $value) {
                $callback($key, $value);
            }
        }
    }

    public function has(string $key): bool {
        return array_key_exists($key, $this->data);
    }

    public function sort() {
        foreach ($this->data as &$value) {
            sort($value, SORT_STRING);
        }
        ksort($this->data, SORT_STRING);
    }

    public function keys(): ArrayIterator {
        return new ArrayIterator(array_keys($this->data));
    }

    public function entries(): ArrayIterator {
        $data = [];
        $this->each(function ($key, $value) use (&$data) {
            array_push($data, [$key, $value]);
        });
        return new ArrayIterator($data);
    }

    public function values(): ArrayIterator {
        return new ArrayIterator(array_merge(...array_values($this->data)));
    }

    public function __toString(): string {
        $queries = [];
        $this->each(function ($key, $value) use (&$queries) {
            array_push($queries, "$key=$value");
        });
        return join("&", $queries);
    }
}
