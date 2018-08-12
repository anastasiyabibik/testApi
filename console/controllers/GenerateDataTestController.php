<?php
namespace console\controllers;

use common\helpers\TestDataHelper;
use common\modules\api\forms\CreateAssessmentForm;
use common\modules\api\forms\CreatePostForm;
use common\modules\api\forms\CreateUserForm;
use common\modules\api\services\AssessmentService;
use common\modules\api\services\PostService;
use common\modules\api\services\UserService;
use Faker\Factory;
use yii\base\Module;
use yii\console\Controller;
use yii\helpers\ArrayHelper;

/**
 * class GenerateDataTestController
 * @package yii\console\controllers
*/
class GenerateDataTestController extends Controller
{
    public $faker;
    public $userService;
    public $postService;
    public $assessmentService;

    /**
     * @inheritdoc
    */
    public function __construct(
        $id,
        Module $module,
        array $config = [],
        UserService $userService,
        PostService $postService,
        AssessmentService $assessmentService
    )
    {
        $this->faker = Factory::create();
        $this->userService = $userService;
        $this->postService = $postService;
        $this->assessmentService = $assessmentService;

        parent::__construct($id, $module, $config);
    }

    public function actionGenerateUsers()
    {
        for ($i = 0; $i <= 100; $i++) {
            $formUser = new CreateUserForm();
            $formUser->login = $this->faker->name;

            if ($formUser->validate()) {
                $this->userService->createNewUser($formUser);
            }
        }
    }

    public function actionGeneratePost()
    {
        $ips = [];
        $users = ArrayHelper::getColumn($this->userService->getAllUsers(), 'id');

        for ($i = 0; $i <= 70; $i++) {
            $ips[] = $this->faker->ipv4;
        }

        $ips = TestDataHelper::getRandomNumbersFromArray($ips, 200, 4);
        $users = TestDataHelper::getRandomNumbersFromArray($users, 200, 3);

        for ($i = 0; $i <= 200; $i++) {
            $formPost = new CreatePostForm();
            $formPost->title = $this->faker->text(255);
            $formPost->description = $this->faker->text(1000);
            $formPost->user_ip = $ips[$i];
            $formPost->user_id = $users[$i];

            if ($formPost->validate()) {
                $this->postService->createNewPost($formPost);
            }
        }
    }

    public function actionGenerateAssessment()
    {
        $postsIds = $this->postService->getAllPostsId();

        for ($i = 0; $i < 300; $i++) {
            $formAssessment = new CreateAssessmentForm();
            $formAssessment->post_id = $postsIds[array_rand($postsIds)];
            $formAssessment->value = rand(1, 5);

            if ($formAssessment->validate()) {
                $this->assessmentService->createNewAssessment($formAssessment);
            }
        }
    }
}