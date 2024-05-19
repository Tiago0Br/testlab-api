<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CriaTabelaTestCaseStatus extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {
        $table = $this->table('test_case_status');

        $table
            ->addColumn('test_case_id', 'integer', ['null' => false, 'signed' => false])
            ->addColumn('status', 'string', ['null' => false])
            ->addColumn('note', 'text', ['null' => true])
            ->addColumn('created_at', 'datetime', ['null' => false])
            ->addForeignKey('test_case_id', 'test_cases', 'id')
            ->create();
    }
}
