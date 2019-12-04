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
     * @var array
     */
    private $config = [];

    /**
     * Application constructor.
     * @param  RouterInterface  $router
     * @param $config
     */
    public function __construct(RouterInterface $router, $config)
    {
        $this->router = $router;
        $this->config = $config;
    }

    /**
     * Application bootstrap.
     */
    public function bootstrap(): void
    {
        $this->router->run();
    }

    /**
     * @return Connection
     */
    public static function getDbConnection(): Connection
    {
        // Load configuration from config file.
        $config = new Configuration(
            $self->config['db']['dsn'] ?? 'mysql:host=127.0.0.1;dbname=test_task_db;charset=utf8',
            $self->config['db']['user'] ?? 'root',
            $self->config['db']['password'] ?? '',
            $self->config['db']['options'] ?? []
        );

        return new Connection($config);
    }

}