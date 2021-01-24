<?php

declare(strict_types=1);
/**
 * @author Alessio Ferri
 * @copyright Alessio Ferri
 * @license Apache-2.0
 */

namespace leaf\auth;

interface Grant {

    /**
     * Compose two Grants in the one merged grant
     */
    public function compose(Grant $g): Grant;

    /**
     * Check if a Grant includes another Grant
     */
    public function includes(Grant $g): bool;
    
    /**
     * 
     * @return mixed
     */
    public function serialize();

}
