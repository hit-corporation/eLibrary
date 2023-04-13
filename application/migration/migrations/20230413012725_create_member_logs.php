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
        $table->addColumn('member_name', 'string', ['limit' => 200]);
        $table->addColumn('member_email', 'string', ['limit' => 200]);
        $table->addColumn('login_time', 'timestamp');
        $table->addColumn('logout_time', 'timestamp');
        $table->addColumn('login_duration', 'string', ['limit' => 200, 'null' => true]);
        
        $table->addTimestamps();
        $table->create();
    }
}
