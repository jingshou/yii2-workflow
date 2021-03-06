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

    public function rules()
    {
        return [
            [['name'], 'string'],
            [['type', 'created'], 'integer'],
            [['name', 'type'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => '审批名称',
            'type' => '审批类型',
            'created' => '创建时间',
        ];
    }

    public function search()
    {
        $query = $this->setCondition();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => self::PAGE_SIZE,
            ],
        ]);
        $dataProvider->setSort(false);

        return $dataProvider;
    }

    public function setCondition()
    {
        $query = self::find()->where(['isDel' => 0]);
        return $query;
    }
}