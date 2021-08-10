<?php

namespace Great\Url;

interface ParserInterface {

    /**
     * @param string $url
     *
     * @return array
     */
    public function parse(string $url): array;

}
