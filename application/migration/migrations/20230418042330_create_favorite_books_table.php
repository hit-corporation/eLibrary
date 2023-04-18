<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateFavoriteBooksTable extends AbstractMigration
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
		$table = $this->table('favorite_books');
		$table->addColumn('member_id', 'integer');
		$table->addColumn('book_id', 'integer');
		$table->addTimestamps();
		$table->addForeignKey('member_id', 'users', ['id'], ['delete' => 'CASCADE']);
		$table->addForeignKey('book_id', 'books', ['id'], ['delete' => 'CASCADE']);
		$table->addIndex(['member_id', 'book_id'], ['unique' => true]);
		$table->create();
    }
}
