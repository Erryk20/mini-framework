<?php

use Phinx\Migration\AbstractMigration;

class InsertProducts extends AbstractMigration
{
    public function up()
    {
		$rows = [
			['category_id' => 6, 'name' => 'Apple iPhone 6s', 'price' => 590],
			['category_id' => 6, 'name' => 'Apple iPhone 8 Plus', 'price' => 1037],
			['category_id' => 6, 'name' => 'Apple iPhone SE', 'price' => 450],
			['category_id' => 6, 'name' => 'Apple iPhone X', 'price' => 1999],

			['category_id' => 11, 'name' => 'Meizu M6 Note', 'price' => 9],
			['category_id' => 11, 'name' => 'Meizu M6S', 'price' => 10],
			['category_id' => 11, 'name' => 'Meizu M6T', 'price' => 11],
			['category_id' => 11, 'name' => 'Meizu Pro 7 Plus', 'price' => 0.1],

			['category_id' => 12, 'name' => '3 in 1 phone holder', 'price' => 17],

			['category_id' => 8, 'name' => 'Samsung Galaxy A8', 'price' => 555],
			['category_id' => 8, 'name' => 'Samsung Galaxy S7 Duos', 'price' => 704.25],
			['category_id' => 8, 'name' => 'Samsung Galaxy S9', 'price' => 1040],

			['category_id' => 9, 'name' => 'Xiaomi Mi A1', 'price' => 225],
			['category_id' => 9, 'name' => 'Xiaomi Mi6', 'price' => 480],
			['category_id' => 9, 'name' => 'Xiaomi Redmi 5 Plus', 'price' => 240],

			['category_id' => 2, 'name' => 'Lenovo Tab3 7 Essential 710F Wi-Fi 8Gb', 'price' => 85],
			['category_id' => 2, 'name' => 'Xiaomi Mi Pad 64Gb Wi-Fi', 'price' => 178],
			['category_id' => 2, 'name' => 'Apple iPad mini 2 with retina display 32Gb WiFi', 'price' => 319],
			['category_id' => 2, 'name' => 'Lenovo Yoga Tablet 3-X50 10" 2/16Gb LTE (ZA0K0025UA) Black', 'price' => 296],

			['category_id' => 4, 'name' => 'Alcatel Onetouch GO Watch One Size', 'price' => 180],
			['category_id' => 4, 'name' => 'Apple Watch Series 1407', 'price' => 180],
			['category_id' => 4, 'name' => 'Huawei 42mm Stainless Steel', 'price' => 370],
			['category_id' => 4, 'name' => 'Samsung Gear S2 Classic', 'price' => 296],

			['category_id' => 5, 'name' => 'LG OLED65E6V', 'price' => 6296],
			['category_id' => 5, 'name' => 'Samsung UE65JS9000TXUA', 'price' => 3750],
			['category_id' => 5, 'name' => 'Sony KDL43WD752SR2', 'price' => 685],
			['category_id' => 5, 'name' => 'Xiaomi Mi TV3 60', 'price' => 1296],

			['category_id' => 3, 'name' => 'Lenovo Yoga 3 Pro', 'price' => 1333],
			['category_id' => 3, 'name' => 'Acer Nitro 5 Shale Black1', 'price' => 1000],
			['category_id' => 3, 'name' => 'Apple MacBook', 'price' => 1300],
			['category_id' => 3, 'name' => 'Apple MacBook Air', 'price' => 1300],
			['category_id' => 3, 'name' => 'Asus VivoBook', 'price' => 750],
			['category_id' => 3, 'name' => 'Lenovo Yoga 2 Pro', 'price' => 1296],
			['category_id' => 3, 'name' => 'Lenovo Yoga 3 Pro', 'price' => 1333],
		];

		$this->table('product')
			 ->insert($rows)
			 ->save();
    }


    public function down()
    {
		$this->execute('DELETE FROM `product`');
    }

}
