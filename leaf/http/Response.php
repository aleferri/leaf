<?php

declare(strict_types=1);
/**
 * @author Alessio Ferri
 * @copyright Alessio Ferri
 * @license Apache-2.0
 */

namespace leaf\http;

/**
 *
 * @author Alessio
 */
interface Response {

    public function with_body(string $body): Response;

    public function with_status(int $http_code): Response;

    public function with_headers(array $headers): Response;

    public function body(): string;

    public function status(): int;

    public function headers(): array;

}
