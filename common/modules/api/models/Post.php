<?php
namespace common\modules\api\models;

use api\modules\myapi\forms\GetPostsForm;
use common\modules\api\forms\CreatePostForm;
use Yii;
use yii\db\Exception;

/**
 * This is the model class for table "post".
 *
 * @property int $id
 * @property string $title Название
 * @property string $description Описание
 * @property int $user_id Идентификатор пользователя
 * @property string $user_ip IP пользователя
 *
 * @property Assessment[] $assessments
 * @property User $user
 */
class Post extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'post';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description'], 'string'],
            [['user_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['user_ip'], 'string', 'max' => 100],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class,
                'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'description' => 'Описание',
            'user_id' => 'Идентификатор пользователя',
            'user_ip' => 'IP пользователя',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssessments()
    {
        return $this->hasMany(Assessment::class, ['post_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * @param CreatePostForm $form
     * @return array|Post|null
     */
    public static function createNewPost($form)
    {
        $post = new self();
        $post->title = $form->title;
        $post->description = $form->description;
        $post->user_id = $form->user_id;
        $post->user_ip = $form->user_ip;

        try {
            if ($post->save(false)) {
                return $post;
            } else {
                return $post->errors;
            }
        } catch (Exception $exception) {}

        return null;
    }

    /**
     * @param GetPostsForm $form
     * @return array|Post[]|\yii\db\ActiveRecord[]
     */
    public static function getPostsByRating($form)
    {
        return Assessment::find()
            ->select(['avg(assessment.value) as avg_value', 'post.title', 'post.description'])
            ->leftJoin('post', 'assessment.post_id = post.id')
            ->groupBy(['assessment.post_id', 'post.id'])
            ->orderBy(['avg_value' => SORT_DESC])
            ->limit($form->quantity)
            ->asArray()
            ->all();
    }

    /**
     * @return array
    */
    public static function getUsersWithDiffIp()
    {
        $result = [];
        $allPostsArray = [];

        $postsBD = Post::find()
            ->select(['post.user_ip', 'user.login'])
            ->leftJoin('user', '"post"."user_id" = "user"."id"')
            ->asArray()
            ->all();

        foreach ($postsBD as $post) {
            $allPostsArray[$post['user_ip']][] = $post['login'];
        }

        $listIP = Yii::$app->db->createCommand(
            'SELECT user_ip, max(rg) FROM
                    (SELECT user_ip, user_id, rank() OVER(PARTITION BY user_ip ORDER BY user_id) AS rg FROM post) AS res
                  GROUP BY user_ip HAVING max(rg) > 1')
            ->queryAll();

        foreach ($listIP as $item) {

            $result[$item['user_ip']][] = $allPostsArray[$item['user_ip']];
        }

        return $result;
    }
}
