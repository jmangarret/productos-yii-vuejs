<?php

class m200922_181358_create_product_table extends CDbMigration
{
	public function up()
	{
		$this->createTable('product',[
			'id' => 'pk',
			'description' => 'VARCHAR(248) NOT NULL',
			'reference' => 'VARCHAR(30) NOT NULL',
			'stock' => 'int(11) NOT NULL',
			'currency' => 'ENUM("USD","COP") NOT NULL',
			'price' => 'DOUBLE(15,2) NOT NULL',
			'image' => 'VARCHAR(100)',
			'status' => 'boolean DEFAULT 1',
		]);
	}

	public function down()
	{
		$this->dropTable('product');
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}