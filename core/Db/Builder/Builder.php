<?php

namespace Core\Db\Builder;

/**
 * Interface Builder
 * @package Core\Db\Builder
 */
interface Builder
{
    public function select(string $table, array $fields): Builder;

    public function where(string $field, string $operator, string $value): Builder;

    public function get();
}