<?php
namespace common\modules\api\services;

use common\modules\api\forms\CreateUserForm;
use common\modules\api\models\User;
use yii\db\ActiveRecord;

/**
 * class UserService
*/
class UserService
{
    /**
     * @param CreateUserForm $form
     * @return array|User|null
     */
    public function createNewUser($form)
    {
        return User::createNewUser($form);
    }

    /**
     * @return User[]
    */
    public function getAllUsers()
    {
        return User::find()->all();
    }

    /**
     * @param string $login
     * @return User|ActiveRecord|array
     */
    public function getUser($login)
    {
        $user = $this->getUserByLogin($login);

        if (!empty($user->id)) {
            return $user;
        }

        $formUser = new CreateUserForm();
        $formUser->login = $login;

        if ($formUser->validate()) {
            return $this->createNewUser($formUser);
        }

        return $formUser->errors;
    }

    /**
     * @param string $login
     * @return User|ActiveRecord|null
     */
    public function getUserByLogin($login)
    {
        return User::find()->select('id')->where(['login' => $login])->one();
    }
}
