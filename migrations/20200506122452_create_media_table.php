<?php

use Phinx\Migration\AbstractMigration;

class CreateMediaTable extends AbstractMigration
{
    public function up()
    {
		$table = $this->table('media');

		$table->addColumn('product_id', 'integer', ['null' => false])
			  ->addIndex('product_id')
			  ->addColumn('name', 'string', ['limit' => 255])
			  ->save();

		$table->addForeignKey('product_id', 'product')
			  ->save();
    }

    public function down()
    {
		$table = $this->table('media');

		$table->dropForeignKey('product_id')
			  ->removeIndex('product_id')
			  ->save();

		$table->drop()->save();
    }
}
