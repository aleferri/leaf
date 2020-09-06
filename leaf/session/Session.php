<?php

declare(strict_types=1);
/**
 * @author Alessio Ferri
 * @copyright Alessio Ferri
 * @license Apache-2.0
 */

namespace leaf\session;

interface Session {

    /**
     * @param mixed $value
     */
    public function store(string $key, $value): void;

    /**
     * @return mixed
     */
    public function load(string $key);

}
