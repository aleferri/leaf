<?php

namespace leaf\auth\schemas;

use leaf\data\Property;
use leaf\data;

/**
 * Description of AccessListSchema
 *
 * @author Alessio
 */
class AccessListSchema implements \leaf\data\Schema {

    private $properties;

    public function __construct() {
        $this->properties = [
            data\progressive ( 'rule_id' ),
            data\text ( 'match', 255 ),
            data\text ( 'users', 255 ),
            data\text ( 'grants', 255 ),
            data\flag ( 'permission', false )
        ];
    }

    public function clone(): \leaf\data\Schema {
        return new self();
    }

    public function getIterator(): \Traversable {
        return $this->properties;
    }

    public function indexes(): array {
        return [ "rule_id" ];
    }

    public function name(): string {
        return "sec_access_lists";
    }

    public function progressive_key(): string {
        return "rule_id";
    }

    public function properties(): array {
        return $this->properties;
    }

    public function property(string $name): ?Property {
        foreach ( $this->properties as $prop ) {
            if ( $prop->name () == $name ) {
                return $prop;
            }
        }
        return null;
    }

}
