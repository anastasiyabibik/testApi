<?php
namespace console\controllers;

use console\services\TestService;
use Faker\Factory;
use yii\base\Module;
use yii\console\Controller;

/**
 * class TestApiController
 * @package console\controllers
*/
class TestApiController extends Controller
{
    public $testService;
    public $faker;

    public function __construct($id, Module $module, array $config = [], TestService $testService)
    {
        $this->testService = $testService;
        $this->faker = Factory::create();
        parent::__construct($id, $module, $config);
    }

    public function actionMeasureTime()
    {
        $this->stdout('Post: ' . $this->actionTestPost(true) . "\n");
        $this->stdout('Assessment: ' . $this->actionTestAssessment(true) . "\n");
        $this->stdout('Posts: ' . $this->actionTestPosts(true) . "\n");
        $this->stdout('Ips: ' . $this->actionTestIps(true) . "\n");
    }

    public function actionTestPost($measureTime = false)
    {
        $params = [
            'title' => $this->faker->text(255),
            'description' => $this->faker->text(1000),
            'login' => $this->faker->name,
            'user_ip' => $this->faker->ipv4
        ];

        $res = $this->testService->getParamsQuery('myapi/post', 'post', $params, $measureTime);

        if ($measureTime) {
            return $res;
        }

        $this->stdout($res);
    }

    public function actionTestAssessment($measureTime = false)
    {
        $params = [
            'post_id' => $this->faker->numberBetween(0, 300),
            'value' => $this->faker->numberBetween(1, 7)
        ];

        $res = $this->testService->getParamsQuery('myapi/assessment','get', $params, $measureTime);

        if ($measureTime) {
            return $res;
        }

        $this->stdout($res);
    }

    public function actionTestPosts($measureTime = false)
    {
        $params = [
            'quantity' => $this->faker->numberBetween(0, 10),
        ];

        $res = $this->testService->getParamsQuery('myapi/posts','get', $params, $measureTime);

        if ($measureTime) {
            return $res;
        }

        $this->stdout($res);
    }


    public function actionTestIps($measureTime = false)
    {
        $res = $this->testService->getParamsQuery('myapi/ips','get', [], $measureTime);

        if ($measureTime) {
            return $res;
        }

        $this->stdout($res);
    }
}
