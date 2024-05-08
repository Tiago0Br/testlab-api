<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CriaTabelaProject extends AbstractMigration
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
        $table = $this->table('projects');

        $table
            ->addColumn('name', 'string', ['null' => false])
            ->addColumn('description', 'string', ['null' => false])
            ->addColumn('owner_user_id', 'integer', ['null' => false, 'signed' => false])
            ->addForeignKey('owner_user_id', 'users', 'id')
            ->create();
    }
}
