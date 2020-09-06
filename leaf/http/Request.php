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
 * @author Alessio Ferri
 * @copyright 2020
 */
interface Request {

    /**
     * URI della richiesta, senza la query
     * @return string stringa contenente l'uri della request
     */
    public function uri(): string;

    /**
     * Metodo utilizzato per l'invio
     * @return int una delle costanti dichiarate in alto
     */
    public function method(): int;

    /**
     * Query HTTP nell'url
     * @return \ArrayAccess query con i dati presenti nell'url
     */
    public function query(): \ArrayAccess;

    /**
     * Lista di header inviati con la richiesta
     * @return array lista degli header
     */
    public function headers(): array;

    /**
     * Contenuto della Request
     * @return RequestContent
     */
    public function content(): RequestContent;

}
