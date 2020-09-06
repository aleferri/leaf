<?php

declare(strict_types=1);
/**
 * @author Alessio Ferri
 * @copyright Alessio Ferri
 * @license Apache-2.0
 */

namespace leaf\auth;

interface Login {

    public const ANONYMOUS = '__unknown__';

    /**
     * @return array<Grant>
     * Grants given to the current Login
     */
    public function grants(): array;

    /**
     * Username of the current login, not empty, it can be the api key
     */
    public function username(): string;

    /**
     * User id of the current login, allowed negative value to identify anonymous users or api keys
     */
    public function user_id(): int;

}
