<?php

use PHPUnit\Framework\TestCase;
use \leaf\http\SimpleRouter;
use \leaf\http\SimpleRequest;
use \leaf\http\SimpleResponse;

final class RoutingTest extends TestCase {

    public function testNotFound(): void {
        $default = new SimpleResponse ( 404 );

        $router = new SimpleRouter ( $default );
        $collection = new \leaf\http\RouteCollection();

        $empty_query = [];

        $request = new SimpleRequest ( \leaf\http\HTTP::METHOD_GET, '/404', $empty_query, [], new \leaf\http\RequestContent () );

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
        $collection = new \leaf\http\RouteCollection();
        $collection->get ( '/@name', $route );

        $request = new SimpleRequest ( \leaf\http\HTTP::METHOD_GET, '/anything', [], [], new \leaf\http\RequestContent () );

        $response = $router->route ( $request, $collection );

        $this->assertEquals ( $response->status (), 200 );
        $this->assertEquals ( $response->headers (), [] );
        $this->assertEquals ( $response->body (), 'anything' );
    }

    public function testMultiRoute(): void {
        $default = new SimpleResponse ( 404 );

        $request = new SimpleRequest ( \leaf\http\HTTP::METHOD_GET, '/api/protected/v1/ok', [], [], new \leaf\http\RequestContent () );

        $router = new SimpleRouter ( $default );
        $collection = new \leaf\http\RouteCollection();

        $self = $this;

        $protected = function() use($router, $request, $self): \leaf\http\Response {
            $bottomRoutes = new \leaf\http\RouteCollection();
            $bottomRoutes->get ( '/api/protected/v1/@name', function(string $name): \leaf\http\Response {
                return new \leaf\http\SimpleResponse ( 200, [], "OK" );
            } );

            $response = $router->route ( $request, $bottomRoutes );
            $this->assertEquals ( $response->body (), "OK" );
            return $response;
        };

        $collection->get ( '/api/protected/*', $protected );

        $response = $router->route ( $request, $collection );
        $this->assertEquals ( $response->body (), "OK" );
        $this->assertEquals ( $response->status (), 200 );
    }

}
