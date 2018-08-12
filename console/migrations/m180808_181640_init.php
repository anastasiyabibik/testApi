<?php
use yii\db\Migration;

/**
 * Class m180808_181640_init
 */
class m180808_181640_init extends Migration
{
    const USER_TABLE = 'user';
    const POST_TABLE = 'post';
    const ASSESSMENT_TABLE = 'assessment';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(self::USER_TABLE, [
            'id' => $this->primaryKey(),
            'login' => $this->string(255)
        ]);

        $this->createTable(self::POST_TABLE, [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->comment('Название'),
            'description' => $this->text()->comment('Описание'),
            'user_id' => $this->integer()->comment('Идентификатор пользователя'),
            'user_ip' => $this->string(100)->comment('IP пользователя')
        ]);

        $this->createTable(self::ASSESSMENT_TABLE, [
            'id' => $this->primaryKey(),
            'post_id' => $this->integer()->comment('Идентификатор поста'),
            'value' => $this->smallInteger(1)->comment('Оценка (1-5)')
        ]);

        $this->addForeignKey(
            'post_user_id',
            self::POST_TABLE,
            'user_id',
            self::USER_TABLE,
            'id'
        );

        $this->addForeignKey(
            'assessment_post_id',
            self::ASSESSMENT_TABLE,
            'post_id',
            self::POST_TABLE,
            'id'
        );

        $this->createIndex('user_login', self::USER_TABLE, 'login');
        $this->createIndex('assessment_post_id', self::ASSESSMENT_TABLE, 'post_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(self::ASSESSMENT_TABLE);
        $this->dropTable(self::POST_TABLE);
        $this->dropTable(self::USER_TABLE);
    }
}
