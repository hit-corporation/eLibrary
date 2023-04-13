<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateMemberLogs extends AbstractMigration
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
        $table = $this->table('member_logs');
        $table->addColumn('fullname', 'string', ['limit' => 200]);
        $table->addColumn('username', 'string', ['limit' => 200]);
        $table->addColumn('email', 'string', ['limit' => 200]);
        $table->addColumn('login_time', 'timestamp');
        $table->addColumn('logout_time', 'timestamp', ['default' => NULL, 'null' => TRUE]);
        $table->addColumn('ip_address', 'string', ['limit' => 24]);
        
        $table->addTimestamps();
        $table->create();
    }
}
