<?php

namespace Great\Url;

/**
 * @property string $protocol
 * @property string $host
 * @property string $username
 * @property string $password
 * @property string $pathname
 * @property int $port
 * @property URLSearchParams $searchParams
 * @property string $hash
 */
class URL {

    private $hash;

    private $hostname;

    private $username;

    private $password;

    private $pathname;

    private $port;

    private $protocol;

    private $searchParams;

    protected $parser;

    public function __construct(string $spec, ?ParserInterface $parser = null) {
        $this->parser = $parser;
        $this->parse($spec);
    }

    protected function parse(string $spec): void {
        $parsed = $this->getParser()
            ->parse($spec);

        $this->setProtocol($parsed['protocol']);
        $this->setHostname($parsed['hostname']);
        $this->setPort($parsed['port']);
        $this->setPathname($parsed['pathname']);
        $this->setSearchParams(new URLSearchParams($parsed['search']));
        $this->setHash($parsed['hash']);
        $this->setUsername($parsed['username']);
        $this->setPassword($parsed['password']);
    }

    public function getParser(): ParserInterface {
        if ($this->parser === null) {
            $this->parser = $this->defaultParser();
        }
        return $this->parser;
    }

    protected function defaultParser(): ParserInterface {
        return new Parser();
    }

    /**
     * @return string
     */
    public function getHash(): string {
        return $this->hash;
    }

    /**
     * @param string $hash
     */
    public function setHash(string $hash): void {
        $this->hash = $hash;
    }

    /**
     * @return string
     */
    public function getHostname(): string {
        return $this->hostname;
    }

    /**
     * @param string $hostname
     */
    public function setHostname(string $hostname): void {
        $this->hostname = $hostname;
    }

    /**
     * @return string
     */
    public function getHost(): string {
        return sprintf(
            '%s%s',
            $this->hostname,
            $this->port === null ? '' : ":{$this->port}"
        );
    }

    /**
     * @return string
     */
    public function getOrigin(): string {
        return sprintf('%s://%s', $this->protocol, $this->getHost());
    }

    /**
     * @return string
     */
    public function getUsername(): string {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username): void {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getPassword(): string {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getPathname(): string {
        return $this->pathname;
    }

    /**
     * @param string $pathname
     */
    public function setPathname(string $pathname): void {
        $this->pathname = $pathname;
    }

    /**
     * @return null|int
     */
    public function getPort(): ?int {
        return $this->port;
    }

    /**
     * @param null|int $port
     */
    public function setPort(?int $port): void {
        $this->port = $port;
    }

    /**
     * @return string
     */
    public function getProtocol(): string {
        return $this->protocol;
    }

    /**
     * @param string $protocol
     */
    public function setProtocol(string $protocol): void {
        $this->protocol = $protocol;
    }

    /**
     * @param string|URLSearchParams $searchParams
     */
    public function setSearchParams($searchParams): void {
        if ($searchParams instanceof URLSearchParams) {
            $this->searchParams = $searchParams;
        } else {
            $this->searchParams = new URLSearchParams($searchParams);
        }
    }

    /**
     * @return URLSearchParams
     */
    public function getSearchParams(): URLSearchParams {
        return $this->searchParams;
    }

    public function __toString(): string {
        $auth = $this->username;
        if ($this->password !== '') {
            $auth .= ":$this->password";
        }
        $auth = $auth === '' ? '' : "$auth@";
        $port = $this->port === null ? '' : ":$this->port";

        $searchParams = (string)$this->searchParams;
        $query = $searchParams === '' ? '' : "?$searchParams";
        $hash = $this->hash === '' ? '' : "#$this->hash";

        return sprintf(
            '%s://%s%s%s%s%s%s',
            $this->protocol,
            $auth,
            $this->hostname,
            $port,
            $this->pathname,
            $query,
            $hash
        );
    }

}
