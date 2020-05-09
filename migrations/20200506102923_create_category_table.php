<?php

use Phinx\Migration\AbstractMigration;

class CreateCategoryTable extends AbstractMigration
{
    public function up()
    {
		$table = $this->table('category');

		$table->addColumn('parent_id', 'integer', ['null' => true])
			->addIndex('parent_id')
		 	->addColumn('name', 'string', ['limit' => 100])
		  	->save();

		$table->addForeignKey('parent_id', 'category', 'id', ['delete'=>'CASCADE', 'update'=>'NO ACTION'])
			  ->save();
    }

    public function down()
	{
		$table = $this->table('category');

		$table->dropForeignKey('parent_id')
			  ->removeIndex('parent_id')
			  ->save();

		$table->drop()->save();
	}
}
