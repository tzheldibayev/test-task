<?php

namespace App\Jobs;

use Core\Application;

class InitializeJob implements Job
{
    private $tableExists = false;

    public function handle()
    {
        $pdo = Application::getDb()->getPdo();

        if ($this->tableExists()) {
            $this->tableExists = true;
        } else {
            $pdo->query('CREATE TABLE `promo` (
                `id` INT AUTO_INCREMENT NOT NULL,
                `name` varchar(255) NOT NULL,
                `start_date` INTEGER,
                `end_date` DATETIME,
                `status` BOOLEAN,
                PRIMARY KEY (`id`)) 
                CHARACTER SET utf8 COLLATE utf8_general_ci'
            );
        }

        return ['tableExists' => $this->tableExists];

    }

    public function tableExists()
    {
        try {
            $result = Application::getDb()->getPdo()->query("SELECT 1 FROM promo LIMIT 1");
        } catch (\Exception $e) {
            // We got an exception == table not found
            return FALSE;
        }

        return $result !== FALSE;
    }
}