<?php

use yii\db\Migration;

class m180715_082355_about_table extends Migration
{
    public function safeUp()
    {
	    $this->createTable('about', [
		    'id' => $this->primaryKey(),
		    'content' => $this->text(),
	    ]);
    }

    public function safeDown()
    {
        echo "m180715_082355_about_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180715_082355_about_table cannot be reverted.\n";

        return false;
    }
    */
}
