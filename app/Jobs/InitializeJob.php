<?php

namespace App\Jobs;

use Core\Application;

class InitializeJob implements Job
{
    private $tableExists = false;

    public function handle()
    {
        /**
         * @var $app Application
         */
        $pdo = Application::getDb()->getPdo();
        try {
            $pdo->query('CREATE TABLE `promo` (
                `id` INT AUTO_INCREMENT NOT NULL,
                `name` varchar(255) NOT NULL,
                `start_date` INTEGER,
                `end_date` DATETIME,
                `status` BOOLEAN,
                PRIMARY KEY (`id`)) 
                CHARACTER SET utf8 COLLATE utf8_general_ci'
            );
        } catch (\PDOException $ex) {
            $this->tableExists = true;
        }


        return ['tableExists' => $this->tableExists];

    }
}