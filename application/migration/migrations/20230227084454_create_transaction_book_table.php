<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateTransactionBookTable extends AbstractMigration
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
        // UUID EXTENSION
        $this->execute('CREATE EXTENSION IF NOT EXISTS "uuid-ossp"');
        // TABLE
        $table = $this->table('transaction_book');
        $table->addColumn('transaction_id', 'integer');
        //$table->addColumn('stock_id', 'integer');
        $table->addColumn('book_id', 'integer');
        $table->addColumn('qty', 'integer');
        $table->addColumn('amount_penalty', 'integer', ['null' => true, 'default' => 0]);
        $table->addColumn('amount_paid', 'integer',  ['null' => true, 'default' => 0]);
        $table->addColumn('return_date', 'timestamp');
        $table->addColumn('actual_return', 'timestamp', ['null' => true]);
        $table->addColumn('note', 'text', ['null' => true]);
        $table->addTimestamps();

        $table->addForeignKey('transaction_id', 'transactions', 'id', ['update' => 'CASCADE', 'delete' => 'CASCADE']);
        $table->addForeignKey('book_id', 'books', 'id', ['update' => 'CASCADE', 'delete' => 'CASCADE']);
        //$table->addForeignKey('stock_id', 'stocks', 'id', ['update' => 'CASCADE', 'delete' => 'CASCADE']);
        $table->create();
    }
}
