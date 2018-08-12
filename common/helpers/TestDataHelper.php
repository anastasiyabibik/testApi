<?php
namespace common\helpers;

/**
 * class TestDataHelper
 * @package common\helpers
*/
class TestDataHelper
{
    /**
     * @param array $arrayValues
     * @param integer $countResValue
     * @param integer $countRemember
     * @return array
    */
    public static function getRandomNumbersFromArray($arrayValues, $countResValue ,$countRemember)
    {
        $res = [];

        for ($i = 0; $i <= $countResValue; $i++) {
            $value = $arrayValues[array_rand($arrayValues)];
            $count = array_count_values($res)[$value];

            if (empty($count) || $count < $countRemember) {
                $res[] = $value;
            } else {
                $i--;
                continue;
            }
        }

        return $res;
    }
}