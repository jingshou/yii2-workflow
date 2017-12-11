<?php
/**
 *
 * @link http://www.anlewo.com/
 * @copyright Copyright (c) 2015-2016 Anlewo Ltd
 * @license 广东安乐窝网络科技有限公司
 * @author liufujingshou@anlewo.com
 * @date 17/12/8
 */

namespace anlewo\workflow\models\search;

use anlewo\workflow\models\Workflow;
use yii\data\ActiveDataProvider;

class WorkflowSearch extends Workflow
{

    const PAGE_SIZE = 1000;

    public function search()
    {
        $query = $this->setCondition();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => self::PAGE_SIZE,
            ],
        ]);

        return $dataProvider;
    }

    public function setCondition()
    {
        $query = self::find()->where(['isDel' => 0]);
        return $query;
    }
}