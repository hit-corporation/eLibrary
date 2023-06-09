<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateMembersTable extends AbstractMigration
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
		$table = $this->table('members');
		$table->addColumn('member_name', 'string', ['limit' => 100])
					->addColumn('username', 'string', ['limit' => 120])
					->addColumn('password', 'string', ['limit' => 225])
					->addColumn('jenis_kelamin', 'string', ['limit' => 15])
			    ->addColumn('no_induk', 'string', ['limit' => 100])
			    ->addColumn('card_number', 'string', ['limit' => 100])
          ->addColumn('kelas', 'string', ['limit' => 100])
			    ->addColumn('email', 'string', ['limit' => 100, 'null' => true])
			    ->addColumn('address', 'text', ['null' => true])
			    ->addColumn('phone', 'string', ['limit' => 100, 'null' => true])
          ->addColumn('status', 'string', ['default' => 'active'])
          ->addTimestamps()
			    ->addColumn('deleted_at', 'datetime', ['null' => true])
					->addColumn('profile_img', 'string', ['limit' => 225, 'null' => true])

			    ->addIndex(['no_induk', 'deleted_at'], ['unique' => true])
			    ->create();
    }
}
