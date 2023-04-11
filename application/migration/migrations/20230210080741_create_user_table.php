<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateUserTable extends AbstractMigration
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
        $table = $this->table('users');
        $table->addColumn('user_name', 'string', ['limit' => 200]);
        $table->addColumn('full_name', 'string', ['limit' => 100]);
        $table->addColumn('email', 'string', ['limit' => 100]);
        $table->addColumn('user_pass', 'string');
        $table->addColumn('status', 'string');
        $table->addColumn('role_id', 'integer', ['default' => 1]);
        $table->addColumn('deleted_at', 'datetime', ['default' => NULL, 'null' => TRUE]);

        $table->addTimestamps();
        $table->addForeignKey('role_id', 'userrole', ['id'], ['delete' => 'NO ACTION', 'update' => 'CASCADE']);

        $table->addIndex(['user_name', 'deleted_at'], ['unique' => true]);
        $table->create();
    }
}
