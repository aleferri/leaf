<?php

declare(strict_types=1);
/**
 * @author Alessio Ferri
 * @copyright Alessio Ferri
 * @license Apache-2.0
 */

namespace leaf\template;

function display(string $view, array $args): void {
    $view = $view . '.php';

    if ( \file_exists ( $view ) ) {
        include $view;
    } else {
        throw new \RuntimeException ( 'No such view: ' . $view );
    }
}

function generate(string $view, array $args): string {
    $view = $view . '.php';

    if ( \file_exists ( $view ) ) {
        \ob_start ();
        include $view;
        $contents = \ob_get_contents ();
        \ob_end_clean ();

        return $contents;
    }

    throw new \RuntimeException ( 'No such view: ' . $view );
}
