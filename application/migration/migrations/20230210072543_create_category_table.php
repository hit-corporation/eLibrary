<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateCategoryTable extends AbstractMigration
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
        $table = $this->table('categories');
        $table->addColumn('category_name', 'string', ['limit' => 240]);
        $table->addColumn('parent_category', 'integer', ['null' => TRUE, 'default' => NULL]);
        $table->addColumn('deleted_at', 'datetime', ['default' => NULL, 'null' => TRUE]);

        $table->addTimestamps();
        $table->addIndex(['category_name', 'parent_category', 'deleted_at'], ['unique' => true]);
        $table->addForeignKey('parent_category', 'categories', ['id'], ['update' => 'CASCADE', 'delete' => 'CASCADE']);
        $table->create();
    }
}
