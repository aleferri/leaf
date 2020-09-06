# Leaf  
Leaf is PHP library for basic HTTP request routing  

# Example of usage  

    //boostrap.php
    use \leaf\http\HTTP;
    use \leaf\http\RouteCollection;
    use \leaf\http\SimpleRouter;
    use \leaf\http\SimpleResponse;
    
    $request = HTTP::request();

    $not_found = new SimpleResponse(404);
    $router = new SimpleRouter( $not_found );

    $routes = new RouteCollection();

    $declare_routes = include( 'routes.php' );
    $declare_routes( $routes );

    $response = $router->route( $request, $routes );

    HTTP::response( $response );
    //EOF

    //routes.php
    use \leaf\http\RouteCollection;
    use \leaf\http\Request;
    use \leaf\http\SimpleResponse;

    return function(RouteCollection $routes) {

        $routes->get( '/api/awesome/v1/@object', function( string $object, Request $r ) {
            if ( $object === 'ok' ) {
                return new SimpleRequest( 200, [ 'Content-Type' => 'application/json' ], json_encode( [ 'success' => true ] ) );
            } else {
                $get_query = $r->query();
                if ( isset( $r[ 'id' ] ) ) {
                    //etc
                }
                return new SimpleRequest( 200, [ 'Content-Type' => 'application/json' ], json_encode( [ 'success' => true, 'data' => [] ] ) );
            }
        };

    };
    //EOF