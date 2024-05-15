<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CriaTabelaFolders extends AbstractMigration
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
        $table = $this->table('folders');

        $table
            ->addColumn('title', 'string', ['null' => false])
            ->addColumn('project_id', 'integer', ['null' => false, 'signed' => false])
            ->addColumn('folder_id', 'integer', ['null' => true, 'signed' => false])
            ->addColumn('is_test_suite', 'integer', ['null' => false, 'default' => 0])
            ->addForeignKey('project_id', 'projects', 'id')
            ->addForeignKey('folder_id', 'folders', 'id')
            ->create();
    }
}
