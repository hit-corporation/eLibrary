<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateUserroleTable extends AbstractMigration
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
        $table = $this->table('userrole');
        $table->addColumn('rolename', 'string', ['limit' => 220]);
        $table->addColumn('deleted_at', 'datetime', ['default' => NULL, 'null' => TRUE]);

        $table->addTimestamps();
        $table->addIndex(['rolename', 'deleted_at'], ['unique' => true]);
        $table->create();
    }
}
