<?php

declare(strict_types=1);
/**
 * @author Alessio Ferri
 * @copyright Alessio Ferri
 * @license Apache-2.0
 */

namespace leaf\loader;

use \leaf\http\RouteCollection;

class Loader {

    private $routes;

    public function __construct(RouteCollection $routes) {
        $this->routes = $routes;
    }

    public function load(string $file): void {
        $fn = include ($file);

        $fn ( $this->routes );
    }

    public function load_all(string $dir): void {
        $list = glob ( "{$dir}/*/routes.php", GLOB_NOSORT );

        foreach ( $list as $file ) {
            $this->load ( $file );
        }
    }

    public function routes(): RouteCollection {
        return $this->routes;
    }

}
