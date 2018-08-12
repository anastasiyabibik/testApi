<?php
namespace common\modules\api\models;

use common\modules\api\forms\CreateUserForm;
use Yii;
use yii\db\Exception;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $login
 *
 * @property Post[] $posts
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['login'], 'string', 'max' => 255],
            [['login'], 'unique']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'login' => 'Login',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(Post::class, ['user_id' => 'id']);
    }

    /**
     * @param CreateUserForm $form
     * @return array|User|null
     */
    public static function createNewUser($form)
    {
        $user = new self();
        $user->login = $form->login;

        try {
            $user->save(false);
            return $user;
        } catch (Exception $exception) {}

        return null;
    }
}
