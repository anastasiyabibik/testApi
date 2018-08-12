<?php
namespace common\modules\api\forms;

use common\modules\api\models\Post;
use yii\base\Model;

/**
 * class CreateAssessmentForm
 * @package common\modules\api\forms
 *
 * @var integer $post_id
 * @var integer $value
*/
class CreateAssessmentForm extends Model
{
    public $post_id;
    public $value;

    /**
     * @inheritdoc
    */
    public function rules()
    {
        return [
            [['post_id', 'value'], 'required'],
            [['post_id', 'value'], 'integer'],
            [['value'], 'in', 'range' => [1, 2, 3, 4, 5]],
            [['post_id'], 'exist', 'skipOnError' => true, 'targetClass' => Post::class,
                'targetAttribute' => ['post_id' => 'id']],
        ];
    }
}
