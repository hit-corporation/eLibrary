<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateBookTable extends AbstractMigration
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
        /*
        judul , cover (image),  penulis, penerbit ,tahun terbit, kategori , nomor rak, deskripsi, qty
        */

        $table = $this->table('books');
        $table->addColumn('book_code', 'string', ['limit' => 239]);
        $table->addColumn('title', 'string', ['limit' => 239]);
        $table->addColumn('cover_img', 'text');
        $table->addColumn('author', 'string', ['limit' => 229]);
        $table->addColumn('isbn', 'string', ['limit' => 229]);
        $table->addColumn('publish_year', 'smallinteger', ['limit' => 4]);
        $table->addColumn('category_id', 'integer');
        $table->addColumn('publisher_id', 'integer', ['null' => true]);
        $table->addColumn('description', 'text', ['null' => true]);
        $table->addColumn('qty', 'integer', ['default' => 0]);
        $table->addColumn('rack_no', 'string', ['limit' => 50]);
        $table->addColumn('deleted_at', 'datetime', ['default' => NULL, 'null' => TRUE]);
        $table->addTimestamps();
        //$table->addIndex(['title', 'category_id', 'deleted_at'], ['unique' => true, 'name' => 'title_category_unq']);
        $table->addIndex('book_code', ['unique' => true]);
        $table->addForeignKey('category_id', 'categories', ['id'], ['delete' => 'SET NULL', 'update' => 'CASCADE']);
        $table->addForeignKey('publisher_id', 'publishers', ['id'], ['delete' => 'SET NULL', 'update' => 'CASCADE']);
        $table->create();

        if($this->isMigratingUp())
            $this->execute("CREATE UNIQUE INDEX \"title_category_unq\" ON books(title, category_id, deleted_at) WHERE books.deleted_at IS NULL ");
    }
}
