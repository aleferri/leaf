<?php

declare(strict_types=1);
/**
 * @author Alessio Ferri
 * @copyright Alessio Ferri
 * @license Apache-2.0
 */

namespace leaf\http;

class SimpleRequest implements Request {

    /**
     * @var string $uri
     */
    private $uri;

    /**
     * @var int $uri
     */
    private $method;

    /**
     * @var \leaf\collections\HashMap $uri
     */
    private $query;

    /**
     * @var array $headers
     */
    private $headers;

    /**
     * @var RequestContent $content
     */
    private $content;

    public function __construct(int $method, string $uri, array $query, array $headers, RequestContent $content) {
        $this->method = $method;
        $this->uri = $uri;
        $this->query = new \leaf\collections\HashMap ( $query );
        $this->headers = $headers;
        $this->content = $content;
    }

    public function uri(): string {
        return $this->uri;
    }

    public function method(): int {
        return $this->method;
    }

    public function query(): \ArrayAccess {
        return $this->query;
    }

    public function headers(): array {
        return $this->headers;
    }

    public function content(): RequestContent {
        return $this->content;
    }

}
