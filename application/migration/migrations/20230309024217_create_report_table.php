<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateReportTable extends AbstractMigration
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
        
        $table = $this->table('reports');
        $table->addColumn('trans_code', 'string');
        $table->addColumn('member_name', 'string', ['limit' => 244]);
        $table->addColumn('book_code', 'string', ['limit' => 244]);
        $table->addColumn('book_title', 'string', ['limit' => 245]);
        $table->addColumn('loan_date', 'timestamp');
        $table->addColumn('return_date', 'timestamp');
        $table->addColumn('actual_return', 'timestamp', ['null' => true]);
        $table->addColumn('late_days', 'string', ['limit' => 245, 'null' => true]);
        $table->addColumn('fines_amount', 'integer', ['null' => true]);
        $table->addColumn('fines_period', 'string', ['limit' => 245, 'null' => true]);
        $table->addColumn('fines_total', 'integer', ['null' => true]);
        $table->addColumn('fines_payment', 'integer', ['null' => true]);
        $table->addColumn('notes', 'text', ['null' => true]);

        $table->addTimestamps();
        $table->create();
    }
}
