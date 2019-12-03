<?php

namespace Core;

use Core\Db\Builder\Builder;
use Core\Db\Builder\QueryBuilder;

abstract class Model
{
    protected $table;

    public function getBuilder(): Builder
    {
        return new QueryBuilder($this->table);
    }

    public function getTable()
    {
        return $this->table;
    }
}