<?php

namespace Core\Db;

class Configuration
{
    private $dsn;
    private $username;
    private $password;
    private $options;

    public function __construct($dsn, $username, $password, $options)
    {
        $this->dsn = $dsn;
        $this->username = $username;
        $this->password = $password;
        $this->options  = $options;
    }

    public function getDSN(): string
    {
        return $this->dsn;
    }
    public function getUsername(): string
    {
        return $this->username;
    }
    public function getPassword(): string
    {
        return $this->password;
    }
    public function getOptions(): array
    {
        return $this->options;
    }
}