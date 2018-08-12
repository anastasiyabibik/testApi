<?php
namespace api\modules\myapi\forms;

use yii\base\Model;

/**
 * class GetPostsForm
 * @package api\modules\myapi\forms
 *
 * @var integer $quantity
*/
class GetPostsForm extends Model
{
    public $quantity;

    /**
     * @inheritdoc
    */
    public function rules()
    {
        return [
            [['quantity'], 'required'],
            [['quantity'], 'integer']
        ];
    }
}
