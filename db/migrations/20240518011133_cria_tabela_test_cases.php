<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CriaTabelaTestCases extends AbstractMigration
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
        $table = $this->table('test_cases');

        $table
            ->addColumn('title', 'string', ['null' => false])
            ->addColumn('summary', 'string', ['null' => false])
            ->addColumn('preconditions', 'string', ['null' => true])
            ->addColumn('test_suite_id', 'integer', ['null' => false, 'signed' => false])
            ->addForeignKey('test_suite_id', 'folders', 'id')
            ->create();
    }
}
