<?php

declare(strict_types=1);
/**
 * @author Alessio Ferri
 * @copyright Alessio Ferri
 * @license Apache-2.0
 */

namespace leaf\lambda;

/**
 * Any element of the iterable is true for the condition
 */
function any(iterable $iter, callable $condition): bool {
    foreach ( $iter as $elem ) {
        if ( $condition ( $elem ) ) {
            return true;
        }
    }

    return false;
}

/**
 * All elements of the iterable are true for the condition
 */
function all(iterable $iter, callable $condition): bool {
    foreach ( $iter as $elem ) {
        if ( ! $condition ( $elem ) ) {
            return false;
        }
    }

    return true;
}

/**
 * Filter an array and return the filtered elements
 */
function filter(iterable $iter, callable $filter): array {
    $filtered = [];

    foreach ( $iter as $k => $elem ) {
        if ( $filter ( $elem ) ) {
            $filtered[ $k ] = $elem;
        }
    }

    return $filtered;
}

/**
 * Apply a function to each element of the array
 */
function map(iterable $iter, callable $apply): array {
    $applied = [];

    foreach ( $iter as $k => $elem ) {
        $applied[ $k ] = $apply ( $elem );
    }

    return $applied;
}
