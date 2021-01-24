<?php

use PHPUnit\Framework\TestCase;
use \leaf\http\SimpleRouter;
use \leaf\http\SimpleRequest;
use \leaf\http\RequestContent;
use \leaf\http\Response;
use \leaf\http\SimpleResponse;
use \leaf\http\RouteCollection;
use \leaf\http\HTTP;

final class RoutingTest extends TestCase {

    public function testNotFound(): void {
        $default = new SimpleResponse ( 404 );

        $router = new SimpleRouter ( $default );
        $collection = new RouteCollection();

        $empty_query = [];

        $request = new SimpleRequest ( HTTP::METHOD_GET, '/404', $empty_query, [], new RequestContent () );

        $response = $router->route ( $request, $collection );

        $this->assertEquals ( $response, $default );
    }

    public function testMatch(): void {
        $default = new SimpleResponse ( 404 );

        $self = $this;

        $route = function(string $name) use($self) {
            $self->assertEquals ( $name, 'anything' );

            return new SimpleResponse ( 200, [], $name );
        };

        $router = new SimpleRouter ( $default );
        $collection = new RouteCollection();
        $collection->get ( '/@name', $route );

        $request = new SimpleRequest ( HTTP::METHOD_GET, '/anything', [], [], new RequestContent () );

        $response = $router->route ( $request, $collection );

        $this->assertEquals ( $response->status (), 200 );
        $this->assertEquals ( $response->headers (), [] );
        $this->assertEquals ( $response->body (), 'anything' );
    }

    public function testMultiRoute(): void {
        $default = new SimpleResponse ( 404 );

        $request = new SimpleRequest ( HTTP::METHOD_GET, '/api/protected/v1/ok', [], [], new RequestContent () );

        $router = new SimpleRouter ( $default );
        $collection = new RouteCollection();


        $protected = function() use($router, $request): Response {
            $bottomRoutes = new RouteCollection();
            $bottomRoutes->get ( '/api/protected/v1/@name', function(string $name): Response {
                return new SimpleResponse ( 200, [], "OK {$name}" );
            } );

            $response = $router->route ( $request, $bottomRoutes );
            $this->assertEquals ( $response->body (), "OK ok" );
            return $response;
        };

        $collection->get ( '/api/protected/*', $protected );

        $response = $router->route ( $request, $collection );
        $this->assertEquals ( $response->body (), "OK ok" );
        $this->assertEquals ( $response->status (), 200 );
    }

}
