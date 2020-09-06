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
interface Router {

    /**
     * Route della Request sui match disponibili
     * @param \leaf\http\Request $r richiesta corrente
     * @param \leaf\http\RouteCollection $collection pattern e callback disponibili
     */
    public function route(Request $request, RouteCollection $collection): Response;

}
