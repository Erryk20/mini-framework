<?php

use Phinx\Migration\AbstractMigration;

class CreateProductTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    addCustomColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Any other destructive changes will result in an error when trying to
     * rollback the migration.
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function up()
    {
		$table = $this->table('product');

		$table->addColumn('category_id', 'integer', ['null' => false])
			  ->addIndex('category_id')
			  ->addColumn('name', 'string', ['limit' => 255])
			  ->addColumn('price', 'decimal', ['precision' => 11, 'scale' => 2])
			  ->addColumn('create_at', 'datetime', ['default' => "CURRENT_TIMESTAMP"])
			  ->save();


		$table->addForeignKey('category_id', 'category')
			  ->save();
    }


    public function down()
    {
		$table = $this->table('product');

		$table->dropForeignKey('category_id')
			  ->removeIndex('category_id')
			  ->save();

		$table->drop()->save();
    }
}
