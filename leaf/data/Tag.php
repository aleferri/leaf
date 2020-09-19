<?php

namespace leaf\data;

/**
 *
 * @author Alessio
 */
interface Tag {

    public const PRIMARY = "ID";
    public const INDEX_KEY = "INDEX";
    public const UNIQUE_KEY = "UNIQUE";

    public function name(): string;

    public function value();

    public function compare(Tag $b): bool;

}
