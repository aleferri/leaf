<?php

declare(strict_types=1);
/**
 * @author Alessio Ferri
 * @copyright Alessio Ferri
 * @license Apache-2.0
 */

namespace leaf\http;

class SimpleResponse implements Response {

    private $status;
    private $headers;
    private $body;

    public function __construct(int $status = 200, array $headers = [], string $body = '') {
        $this->status = $status;
        $this->headers = $headers;
        $this->body = $body;
    }

    public function with_status(int $status): Response {
        $this->status = $status;

        return $this;
    }

    public function with_headers(array $headers, bool $add = true): Response {
        $this->headers = $headers;

        return $this;
    }

    public function with_body(string $body): Response {
        $this->body = $body;

        return $this;
    }

    public function body(): string {
        return $this->body;
    }

    public function status(): int {
        return $this->status;
    }

    public function headers(): array {
        return $this->headers;
    }

}
