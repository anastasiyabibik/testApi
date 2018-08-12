<?php
namespace common\modules\api\forms;

use common\modules\api\models\User;
use yii\base\Model;

/**
 * class CreatePostForm
 * @package common\modules\api\forms
 *
 * @var string $title
 * @var string $description
 * @var integer $user_id
 * @var string $user_ip
*/
class CreatePostForm extends Model
{
    public $title;
    public $description;
    public $user_id;
    public $user_ip;

    /**
     * @inheritdoc
    */
    public function rules()
    {
        return [
            [['title', 'description'], 'required'],
            [['description'], 'string'],
            [['user_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['user_ip'], 'ip'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class,
                'targetAttribute' => ['user_id' => 'id']],
        ];
    }
}
