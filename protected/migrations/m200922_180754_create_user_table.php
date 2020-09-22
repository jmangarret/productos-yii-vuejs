<?php

class m200922_180754_create_user_table extends CDbMigration
{
	public function up()
	{
		$this->createTable('user',[
			'id' => 'pk',
			'name' => 'VARCHAR(30) NOT NULL',
			'pass' => 'VARCHAR(30) NOT NULL',
		]);
	}

	public function down()
	{
		$this->dropTable('user');
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