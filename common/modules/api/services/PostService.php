<?php
namespace common\modules\api\services;

use api\modules\myapi\forms\GetPostsForm;
use common\modules\api\forms\CreatePostForm;
use common\modules\api\models\Post;
use yii\helpers\ArrayHelper;

/**
 * class PostService
 * @package common\modules\api\services
*/
class PostService
{
    /**
     * @param CreatePostForm $form
     * @return array|Post|null
     */
    public function createNewPost($form)
    {
        return Post::createNewPost($form);
    }

    /**
     * @return Post[]
    */
    public function getAllPostsId()
    {
        $posts = Post::find()->select('id')->all();
        return ArrayHelper::getColumn($posts, 'id');
    }

    /**
     * @param GetPostsForm $form
     * @param $asArray
     * @return array|Post[]|\yii\db\ActiveRecord[]
     */
    public function getPostsByRating($form, $asArray = true)
    {
        return Post::getPostsByRating($form);
    }

    /**
     * @return array
    */
    public function getUsersWithDiffIp()
    {
        return Post::getUsersWithDiffIp();
    }
}
