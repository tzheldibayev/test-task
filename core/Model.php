<?php

namespace Core;

use Core\Db\Builder\Builder;
use Core\Db\Builder\QueryBuilder;

abstract class Model
{
    /**
     * @var $table string
     */
    protected $table;

    /**
     * @return Builder
     */
    public function getBuilder(): Builder
    {
        return new QueryBuilder($this->table);
    }

    /**
     * @return string
     */
    public function getTable(): string
    {
        return $this->table;
    }
}