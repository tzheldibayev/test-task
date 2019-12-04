<?php

namespace App\Models;

use App\Adapters\CsvToArray;
use App\Helpers\Slugger;

/**
 * Class Promo
 * @package App\Models
 */
class Promo extends \Core\Model
{
    protected $table = 'promo';
    protected $csv = __DIR__.'/../../data.csv';

    /**
     * @return array
     */
    public function getAttributes(): array
    {
        return [
            'id',
            'name',
            'start_date',
            'end_date',
            'status',
            'slug',
        ];
    }

    /**
     * Insert data to database from csv
     */
    public function exportDataFromCsv(): void
    {
        if(!file_exists($this->csv)) {
            die('File not found.');
        }

        foreach (CsvToArray::handle($this->csv) as $row) {
            $values = [
                'id' => (int) $row['ID акции'],
                'name' => $row['Название акции'],
                'start_date' => strtotime($row['Дата начала акции']),
                'end_date' => date('Y-m-d', strtotime($row['Дата окончания'])),
                'status' => $row['Статус'] == 'Off' ? 0 : 1,
                'slug' => Slugger::generate($row['ID акции'], $row['Название акции']),
            ];

            $this->getBuilder()->insert($values);
        }
    }

    /**
     * @return array
     */
    public function getRandomModel(): array
    {
        $builder = $this->getBuilder();

        $ids = $builder
            ->select($this->getTable(), $this->getAttributes())
            ->getColumns('id');

        $index =  array_rand($ids, 1);
        $id = $ids[$index];

        $builder->raw("UPDATE `promo` SET `status` = CASE
            WHEN status=1 THEN 0
            WHEN status=0 THEN 1
            END
            where id={$id}");

        $stmt = $builder->raw("SELECT * FROM `promo` WHERE id=$id;");
        $data = $stmt->fetch();
        $data['status'] = $data['status'] === 1 ? 1 : 0;

        return $data;
    }

    /**
     * Create new table.
     */
    public function createTable()
    {
        $sql = "CREATE TABLE `{$this->getTable()}` (
                `id` INT AUTO_INCREMENT NOT NULL,
                `name` varchar(255) NOT NULL,
                `start_date` INTEGER,
                `end_date` DATETIME,
                `status` BOOLEAN,
                `slug` varchar(255),
                PRIMARY KEY (`id`))
                CHARACTER SET utf8 COLLATE utf8_general_ci";

        $this->getBuilder()->raw($sql);
    }
}