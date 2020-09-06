<?php

declare(strict_types=1);
/**
 * @author Alessio Ferri
 * @copyright Alessio Ferri
 * @license Apache-2.0
 */

namespace leaf\http;

class HTTP {

    public const METHOD_GET = 0;
    public const METHOD_OPTIONS = 1;
    public const METHOD_POST = 2;
    public const METHOD_PUT = 3;
    public const METHOD_PATCH = 4;
    public const METHOD_DELETE = 5;
    public const METHOD_TABLE = [
        'GET' => self::METHOD_GET, 'OPTIONS' => self::METHOD_OPTIONS,
        'POST' => self::METHOD_POST, 'PUT' => self::METHOD_PUT,
        'PATCH' => self::METHOD_PATCH, 'DELETE' => self::METHOD_DELETE,
    ];

    public static function request(): Request {
        return new SimpleRequest (
            self::METHOD_TABLE[ $_SERVER[ 'REQUEST_METHOD' ] ],
            $_SERVER[ 'REQUEST_URI' ], $_GET,
            apache_request_headers (),
            new RequestContent ()
        );
    }

    public static function response(Response $r): void {
        http_response_code ( $r->status () );
        foreach ( $r->headers () as $k => $v ) {
            header ( "{$k}: $v", true );
        }
        echo $r->body ();
    }

    public static function json(array $body, int $http_code = 200, array $headers = []): Response {
        $headers[ 'Content-Type' ] = 'application/json';

        return new SimpleResponse ( $http_code, $headers, \json_encode ( $body ) );
    }

    public static function html(string $body, int $http_code = 200, array $headers = []): Response {
        $headers[ 'Content-Type' ] = 'text/html';

        return new SimpleResponse ( $http_code, $headers, $body );
    }

}
