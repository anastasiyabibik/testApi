<?php
namespace common\modules\api\services;

use common\modules\api\forms\CreateAssessmentForm;
use common\modules\api\models\Assessment;

/**
 * class AssessmentService
 * @package common\modules\api\services
*/
class AssessmentService
{
    /**
     * @param CreateAssessmentForm $form
     * @return Assessment
     */
    public function createNewAssessment($form)
    {
        return Assessment::createNewAssessment($form);
    }

    /**
     * @param CreateAssessmentForm $form
     * @return null
     */
    public function appraisePost($form)
    {
        $assessment = $this->createNewAssessment($form);

        if (!empty($assessment->post_id)) {
            return Assessment::getRatingPost($assessment->post_id);
        }

        return null;
    }
}
