<?php

namespace Core;

use Core\Db\Builder\Builder;
use Core\Db\Builder\QueryBuilder;

abstract class Model
{
    protected $table;

    public function getTable()
    {
        return $this->table;
    }

    protected function getBuilder(): Builder
    {
        return new QueryBuilder();
    }
}