<?php

declare(strict_types=1);
/**
 * @author Alessio Ferri
 * @copyright Alessio Ferri
 * @license Apache-2.0
 */

namespace leaf\loader;

class Loader {

    private $routes;

    public function __construct(\leaf\http\RouteCollection $routes) {
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

    public function routes(): \leaf\http\RouteCollection {
        return $this->routes;
    }

}
