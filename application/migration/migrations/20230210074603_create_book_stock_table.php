<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateBookStockTable extends AbstractMigration
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
        $table = $this->table('stocks');
        $table->addColumn('stock_code', 'string', ['limit' => 120]);
        $table->addColumn('book_id', 'integer');
        $table->addColumn('is_available', 'smallinteger');
        $table->addColumn('rack_no', 'string', ['limit' => 50, 'default' => NULL, 'null' => true]);
        $table->addColumn('deleted_at', 'datetime', ['default' => NULL, 'null' => TRUE]);

        $table->addTimestamps();
        $table->addIndex(['stock_code', 'deleted_at'], ['unique' => true]);
        $table->addForeignKey('book_id', 'books', ['id'], ['update' => 'CASCADE', 'delete' => 'CASCADE']);
        $table->create();
    }
}
