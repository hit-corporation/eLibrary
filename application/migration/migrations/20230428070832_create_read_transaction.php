<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateReadTransaction extends AbstractMigration
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
        $table = $this->table('read_log');
        $table->addColumn('trans_code', 'string', ['limit' => 100]);
        $table->addColumn('member_id', 'integer');
        $table->addColumn('book_id', 'integer');
        $table->addColumn('start_time', 'timestamp');
        $table->addColumn('end_time', 'timestamp');
        $table->addColumn('last_page', 'integer');
        
        $table->addIndex('trans_code', ['unique' => true]);
        $table->addForeignKey('member_id', 'members', 'id', ['update' => 'CASCADE', 'delete' => 'CASCADE']);
        $table->addForeignKey('book_id', 'books', 'id', ['update' => 'CASCADE', 'delete' => 'CASCADE']);

        $table->create();
    }
}
