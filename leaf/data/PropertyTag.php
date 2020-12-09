<?php

namespace leaf\data;

class Property implements Tag {

    private $name;
    private $value;

    public function __construct(string $name, $value) {
        $this->name = $name;
        $this->value = $value;
    }

    public function name(): string {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function value() {
        return $this->value;
    }

    public function compare(Tag $b): bool {
        if ( $b->name () !== $this->name ) {
            return false;
        }
        if ( $b->value () !== $this->value ) {
            return false;
        }
        return true;
    }

}
