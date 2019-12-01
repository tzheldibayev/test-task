<?php

namespace App\Jobs;

use Core\Application;

class InitializeJob implements Job
{
    /**
     * @var $pdo \PDO
     */
    private $pdo;
    private $tableExists = false;

    public function handle()
    {
        $this->pdo = Application::getDb()->getPdo();

        if ($this->tableExists()) {
            $this->tableExists = true;
        } else {
            $this->pdo->query('CREATE TABLE `promo` (
                `id` INT AUTO_INCREMENT NOT NULL,
                `name` varchar(255) NOT NULL,
                `start_date` INTEGER,
                `end_date` DATETIME,
                `status` BOOLEAN,
                PRIMARY KEY (`id`)) 
                CHARACTER SET utf8 COLLATE utf8_general_ci'
            );
        }

        $this->exportData();

        return ['tableExists' => $this->tableExists];

    }

    public function tableExists()
    {
        try {
            $result = $this->pdo->query('SELECT 1 FROM promo LIMIT 1');
        } catch (\Exception $e) {
            return FALSE;
        }

        return $result !== FALSE;
    }

    public function exportData()
    {
        $this->pdo->query('TRUNCATE TABLE promo');

        $csvfile = __DIR__.'/../../data.csv';
        if(!file_exists($csvfile)) {
            die('File not found.');
        }

        foreach ($this->csvToArray($csvfile) as $data) {
            $dataToIns = [
                'id' => (int) $data['ID акции'],
                'name' => $data['Название акции'],
                'start_date' => strtotime($data['Дата начала акции']),
                'end_date' => date('Y-m-d', strtotime($data['Дата начала акции'])),
                'status' => $data['Статус'] == 'Off' ? 0 : 1,
            ];
            $sql = $this->pdo->prepare("INSERT INTO promo
            (id, name, start_date, end_date, status)
            VALUES
            (:id, :name, :start_date, :end_date, :status)");

            $sql->bindParam(':id', $dataToIns['id']);
            $sql->bindParam(':name', $dataToIns['name']);
            $sql->bindParam(':start_date', $dataToIns['start_date']);
            $sql->bindParam(':end_date', $dataToIns['end_date']);
            $sql->bindParam(':status', $dataToIns['status']);
            $sql->execute();
        }

    }

    public function csvToArray($filename = '', $delimiter = ';')
    {
        if (!file_exists($filename) || !is_readable($filename)) {
            return false;
        }

        $header = NULL;
        $result = array();
        if (($handle = fopen($filename, 'r')) !== FALSE) {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE) {
                if (!$header)
                    $header = $row;
                else
                    $result[] = array_combine($header, $row);
            }
            fclose($handle);
        }

        return $result;
    }
}