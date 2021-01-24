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
        $input = file_get_contents( 'php://input' );
        $method_id = self::METHOD_TABLE[ $_SERVER[ 'REQUEST_METHOD' ] ];
        
        return new SimpleRequest (
            $method_id,
            $_SERVER[ 'REQUEST_URI' ], 
            $_GET,
            apache_request_headers (),
            new RequestContent ( $input, $_POST )
        );
    }

    public static function response(Response $r): void {
        http_response_code ( $r->status () );
        foreach ( $r->headers () as $k => $v ) {
            header ( "{$k}: $v", true );
        }
        echo $r->body ();
    }

    /**
     * JSON response
     * @param array $body content of json
     * @param int $http_code code to send
     * @param array $headers additional headers
     * @return Response resulting response
     */
    public static function json(array $body, int $http_code = 200, array $headers = []): Response {
        $headers[ 'Content-Type' ] = 'application/json';

        return new SimpleResponse ( $http_code, $headers, \json_encode ( $body ) );
    }

    /**
     * HTML response
     * @param string $body body of the html
     * @param int $http_code http code to send
     * @param array $headers additional headers
     * @return Response resulting response to send
     */
    public static function html(string $body, int $http_code = 200, array $headers = []): Response {
        $headers[ 'Content-Type' ] = 'text/html';

        return new SimpleResponse ( $http_code, $headers, $body );
    }
    
    /**
     * XML response
     * @param string $body body of the html
     * @param int $http_code http code to send
     * @param array $headers additional headers
     * @return Response resulting response to send
     */
    public static function xml(string $body, int $http_code, array $headers = []): Response {
        $headers[ 'Content-Type' ] = 'application/xml';

        return new SimpleResponse ( $http_code, $headers, $body );
    }
    
    /**
     * Return file as a response
     * @param string $body body of the file
     * @param string $mime mime of the file
     * @param string $filename filename to present for the user
     * @param array $headers base headers, default empty, all required header will be overwritten
     * @return Response resulting response to send
     */
    public static function file(string $body, string $mime, string $filename = 'document', array $headers = []): Response {
        $headers[ 'Content-Control' ] = 'public';
        $headers[ 'Content-Type' ] = "{$mime};";
        $headers[ 'Content-Transfer-Encoding' ] = 'Binary';
        $headers[ 'Content-Length' ] = strlen( $body );
        $headers[ 'Content-Disposition' ] = "attachment; filename='{$filename}'";
        return new SimpleResponse( 200, $headers, $body );
    }
    
    /**
     * Static file serve
     * @param string $filename filename of the static file full path included
     * @return Response resulting response to send
     */
    public static function static_file(string $filename): Response {
        $basename = basename( $filename );
        $mime = mime_content_type($filename);
        $headers[ 'Content-Control' ] = 'public';
        $headers[ 'Content-Type' ] = "{$mime};";
        $headers[ 'Content-Transfer-Encoding' ] = 'Binary';
        $headers[ 'Content-Length' ] = filesize( $filename );
        $headers[ 'Content-Disposition' ] = "attachment; filename='{$basename}'";
        return new LazyResponse( 200, $headers, function() use ($filename): string {
            return file_get_contents($filename);
        } );
    }
    
    /**
     * Redirect browser to another location
     * @param string $location new location
     * @return Response resulting response
     */
    public static function redirect(string $location): Response {
        return new SimpleResponse ( 301, [ 'Location' => $location ], '' );
    }

}
