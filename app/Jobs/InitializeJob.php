<?php

namespace App\Jobs;

use App\Adapters\CsvToArray;
use Core\Application;
use Core\Db\Builder\Builder;
use Core\Db\Builder\QueryBuilder;

class InitializeJob implements Job
{
    /**
     * @var $pdo \PDO
     */
    private $pdo;
    private $result = [];

    public function handle()
    {
        $this->pdo = Application::getDbConnection()->getPdo();

        $builder = QueryBuilder::query();
        $tableExists = $builder->tableExists('promo');
        if ($builder->tableExists('promo')) {
            $this->result['tableExists'] = true;
        } else {
            $sql = 'CREATE TABLE `promo` (
                `id` INT AUTO_INCREMENT NOT NULL,
                `name` varchar(255) NOT NULL,
                `start_date` INTEGER,
                `end_date` DATETIME,
                `status` BOOLEAN,
                PRIMARY KEY (`id`))
                CHARACTER SET utf8 COLLATE utf8_general_ci';

            $builder->raw($sql);

            $this->result['tableExists'] = false;
        }

        $builder->truncate('promo');

        $this->exportData();
        $selectedId = $this->changeStatusForRandomRow();
        $this->result['randomRow'] = $this->getSingleRow($selectedId);

        return $this->result;

    }

    private function exportData()
    {
        $this->pdo->query('TRUNCATE TABLE promo');

        $csvfile = __DIR__.'/../../data.csv';
        if(!file_exists($csvfile)) {
            die('File not found.');
        }

        foreach (CsvToArray::handle($csvfile) as $data) {
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

            $this->result['promo'][] = $dataToIns;
        }
    }

    public function changeStatusForRandomRow()
    {
        $stmt = $this->pdo->query('SELECT * FROM `promo`;');
        $ids = $stmt->fetchAll(\PDO::FETCH_COLUMN, 'id');

        $index =  array_rand($ids, 1);
        $id = $ids[$index];

        $this->pdo->query("UPDATE `promo` SET `status` = CASE
            WHEN status=1 THEN 0
            WHEN status=0 THEN 1
            END
            where id={$id}");

        return $id;
    }

    private function getSingleRow($id)
    {
        $stmt = $this->pdo->query("SELECT * FROM `promo` WHERE id=$id;");
        $data = $stmt->fetch();
        $data['status'] = $data['status'] === 1 ? 1 : 0;
        return $data;
    }
}