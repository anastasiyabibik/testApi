<?php
namespace common\modules\api\models;

use common\modules\api\forms\CreateAssessmentForm;
use yii\db\Exception;

/**
 * This is the model class for table "assessment".
 *
 * @property int $id
 * @property int $post_id Идентификатор поста
 * @property int $value Оценка (1-5)
 *
 * @property Post $post
 */
class Assessment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'assessment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'post_id', 'value'], 'integer'],
            [['value'], 'in', 'range' => [1, 2, 3, 4, 5]],
            [['post_id'], 'exist', 'skipOnError' => true, 'targetClass' => Post::class,
                'targetAttribute' => ['post_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'post_id' => 'Идентификатор поста',
            'value' => 'Оценка (1-5)',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPost()
    {
        return $this->hasOne(Post::class, ['id' => 'post_id']);
    }

    /**
     * @param CreateAssessmentForm $form
     * @return Assessment
     */
    public static function createNewAssessment($form)
    {
        $assessment = new self();
        $assessment->post_id = $form->post_id;
        $assessment->value = $form->value;

        try {
            $assessment->save(false);
            return $assessment;
        } catch (Exception $exception) {}

        return null;
    }

    /**
     * @param integer $post_id
     * @return integer
    */
    public static function getRatingPost($post_id)
    {
        return Assessment::find()->where(['post_id' => $post_id])->average('value');
    }
}
