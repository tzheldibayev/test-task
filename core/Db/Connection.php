<?php

namespace Core\Db;

use PDO;

class Connection
{
    private $configuration;

    public function __construct(Configuration $config)
    {
        $this->configuration = $config;
    }

    public function getPdo()
    {
        return new PDO(
            $this->configuration->getDSN(),
            $this->configuration->getUsername(),
            $this->configuration->getPassword(),
            $this->configuration->getOptions()
        );
    }
}