<?php

namespace Core;

use Core\Db\Configuration;
use Core\Db\Connection;
use Core\Router\RouterInterface;

class Application
{
    /**
     * @var RouterInterface
     */
    private $router;
    /**
     * @var Configuration
     */
    private $dbConfiguration;
    /**
     * @var array
     */
    private $config = [];


    public function __construct(RouterInterface $router, $config)
    {
        $this->router = $router;
        $this->config = $config;
    }

    public function bootstrap()
    {
        // Load configuration from config file.
        $this->dbConfiguration = new Configuration(
            $this->config['dsn'] ?? 'mysql:host=127.0.0.1;dbname=test_task_db;charset=utf8',
            $this->config['user'] ?? 'root',
            $this->config['password'] ?? 'root',
            $this->config['options'] ?? []
        );

        $this->router->run();
    }

    public static function getDb()
    {
        // Load configuration from config file.
        $config = new Configuration(
            $self->config['dsn'] ?? 'mysql:host=127.0.0.1;dbname=test_task;charset=utf8',
            $self->config['user'] ?? 'root',
            $self->config['password'] ?? 'root',
            $self->config['options'] ?? []
        );

        return new Connection($config);
    }

}