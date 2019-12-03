<?php

namespace Core\Db\Builder;

use Core\Db\Connection;

class QueryBuilder implements Builder
{
    protected $query;
    protected $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    protected function reset(): void
    {
        $this->query = new \stdClass;
    }

    public function select(string $table, array $fields): Builder
    {
        $this->reset();
        $this->query->base = "SELECT " . implode(", ", $fields) . " FROM " . $table;
        $this->query->type = 'select';

        return $this;
    }

    public function where(string $field, string $operator = '=', string $value): Builder
    {
        if (!in_array($this->query->type, ['select', 'update'])) {
            throw new \Exception('WHERE can only be added to SELECT OR UPDATE');
        }
        $this->query->where[] = "$field $operator '$value'";

        return $this;
    }

    public function get(): string
    {
        $query = $this->query;
        $sql = $query->base;
        if (!empty($query->where)) {
            $sql .= 'WHERE ' . $query->where;
        }
        return $this->connection->getPdo()->query($sql);
    }
}