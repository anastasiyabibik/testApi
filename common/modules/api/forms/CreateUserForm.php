<?php
namespace common\modules\api\forms;

use common\modules\api\models\User;

/**
 * class UserService
 * @package common\modules\api\forms
 *
 * @var string login
*/
class CreateUserForm extends User
{
    const SCENARIO_ADD_POST = 'addPost';

    public $login;

    /**
     * @inheritdoc
    */
    public function rules()
    {
        return [
            [['login'], 'required'],
            [['login'], 'string', 'max' => 255],
            [['login'], 'unique', 'on' => self::SCENARIO_DEFAULT]
        ];
    }

    /**
     * @inheritdoc
    */
    public function scenarios()
    {
        return array_merge(parent::scenarios(), [
            self::SCENARIO_ADD_POST => ['login']
        ]);
    }
}
