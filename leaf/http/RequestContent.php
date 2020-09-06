<?php

declare(strict_types=1);
/**
 * @author Alessio Ferri
 * @copyright Alessio Ferri
 * @license Apache-2.0
 */

namespace leaf\http;

class RequestContent {

    /**
     * @var \leaf\collections\HashMap $form_data
     */
    private $form_data;

    /**
     * @var array $uri
     */
    private $files;

    /**
     * @var string $body
     */
    private $body;

    public function __construct(string $body = '', array $form_data = [], array $files = []) {
        $this->body = $body;
        $this->form_data = new \leaf\collections\HashMap ( $form_data );
        $this->files = $files;
    }

    public function body(): string {
        return $this->body;
    }

    public function as_json(): array {
        return \json_decode ( $this->body, true );
    }

    public function files(): array {
        return $this->files;
    }

    public function form_data(): \ArrayAccess {
        return $this->form_data;
    }

}
