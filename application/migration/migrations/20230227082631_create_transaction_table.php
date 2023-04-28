<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;


final class CreateTransactionTable extends AbstractMigration
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
        $table = $this->table('transactions');
        $table->addColumn('trans_code', 'string', ['limit' => 225, 'default' => bin2hex(random_bytes(8))]);
        $table->addColumn('trans_timestamp', 'timestamp', ['default' => 'CURRENT_TIMESTAMP']);
        $table->addColumn('member_id', 'integer', ['null' => true]);
        $table->addColumn('book_id', 'integer');
        $table->addColumn('start_time', 'timestamp');
        $table->addColumn('end_time', 'timestamp');
        $table->addColumn('actual_return', 'timestamp');
        $table->addColumn('config_idle', 'string', ['limit' => 160]);
        $table->addColumn('config_borrow_limit', 'string', ['limit' => 160]);
        $table->addColumn('note', 'text', ['null' => true]);
        // non column
        $table->addIndex('trans_code', ['unique' => true]);
        $table->addForeignKey('member_id', 'members', 'id', ['update' => 'CASCADE', 'delete' => 'CASCADE']);
        $table->addForeignKey('book_id', 'books', 'id', ['update' => 'CASCADE', 'delete' => 'CASCADE']);

        $table->addTimestamps();
        $table->create();
    }
}
