<?php

use Phinx\Migration\AbstractMigration;

class InsertCategories extends AbstractMigration
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

    	$rows = [
			['id' => 1, 'name' => 'Smartphones'],
			['id' => 2, 'name' => 'Tablets'],
			['id' => 3, 'name' => 'Laptops'],
			['id' => 4, 'name' => 'Smart Watches'],
			['id' => 5, 'name' => 'TV'],
			['id' => 6, 'parent_id' => 1, 'name' => 'iPhone'],
			['id' => 7, 'parent_id' => 1, 'name' => 'Meizu'],
			['id' => 8, 'parent_id' => 1, 'name' => 'Samsung'],
			['id' => 9, 'parent_id' => 1, 'name' => 'Xiaomi'],
			['id' => 10, 'parent_id' => 7, 'name' => 'Accessories'],
			['id' => 11, 'parent_id' => 10, 'name' => 'Covers'],
			['id' => 12, 'parent_id' => 10, 'name' => 'Tripod'],
		];

    	$this->table('category')
			 ->insert($rows)
			 ->save();
    }

    public function down()
    {
		$this->execute('DELETE FROM `category`');
    }
}
