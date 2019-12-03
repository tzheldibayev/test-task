<?php

namespace Core\Db\Builder;

use Core\Application;

class QueryBuilder implements Builder
{
    /**
     * @var $query string
     */
    protected $query;
    /**
     * @var $connection \Core\Db\Connection
     */
    protected $connection;
    /**
     * @var string
     */
    protected $table;

    /**
     * QueryBuilder constructor.
     * @param string $table
     */
    public function __construct(string $table = '')
    {
        $this->table = $table;
        $this->connection = Application::getDbConnection();
    }

    protected function reset(): void
    {
        $this->query = new \stdClass;
    }

    /**
     * @param string $table
     * @param array $fields
     * @return Builder
     */
    public function select(string $table, array $fields): Builder
    {
        $this->reset();
        $this->query->base = "SELECT " . implode(", ", $fields) . " FROM " . $table;
        $this->query->type = 'select';

        return $this;
    }

    /**
     * @param string $field
     * @param string $operator
     * @param string $value
     * @return Builder
     * @throws \Exception
     */
    public function where(string $field, string $operator = '=', string $value): Builder
    {
        if (!in_array($this->query->type, ['select', 'update'])) {
            throw new \Exception('WHERE can only be added to SELECT OR UPDATE');
        }
        $this->query->where[] = "$field $operator '$value'";

        return $this;
    }

    /**
     * @return false|\PDOStatement
     */
    public function get()
    {
        $query = $this->query;
        $sql = $query->base;
        if (!empty($query->where)) {
            $sql .= 'WHERE ' . $query->where;
        }
        return $this->connection->getPdo()->query($sql);
    }

    /**
     * @param $field
     * @return array
     */
    public function getColumns($field)
    {
        $query = $this->query;
        $sql = $query->base;
        if (!empty($query->where)) {
            $sql .= 'WHERE ' . $query->where;
        }
        return $this->connection->getPdo()->query($sql)->fetchAll(\PDO::FETCH_COLUMN, $field);
    }

    /**
     * @param $values
     */
    public function update($values)
    {
        $sql = "UPDATE `promo` WHERE {$this->query->where} SET VALUES $values";
        $this->connection->getPdo()->prepare($sql)->execute($values);
    }

    /**
     * @param $values
     */
    public function insert($values)
    {
        $sql = sprintf(
            'INSERT INTO %s (%s) VALUES (%s)',
            $this->table,
            implode(', ', array_keys($values)),
            ':' . implode(', :', array_keys($values))
        );
        $this->connection
            ->getPdo()
            ->prepare($sql)
            ->execute($values);
        $this->connection->getPdo()->lastInsertId();
    }

    /**
     * @param $table
     * @return bool
     */
    public function tableExists($table): bool
    {
        $t = $this->table ?: $table;

        try {
            $result = $this->connection->getPdo()->query("SELECT 1 FROM {$t} LIMIT 1");
        } catch (\Exception $ex) {
            return false;
        }

        return $result !== false;
    }

    /**
     * @param $sql
     * @return false|\PDOStatement
     */
    public function raw($sql)
    {
        return $this->connection->getPdo()->query($sql);
    }

    /**
     * @param $table
     */
    public function truncate($table)
    {
        $this->connection->getPdo()->query("truncate $table");
    }

    /**
     * @param string $table
     * @return static
     */
    public static function query($table = '')
    {
        return new static($table);
    }
}