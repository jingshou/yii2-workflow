<?php
/**
 *
 * @link http://www.anlewo.com/
 * @copyright Copyright (c) 2015-2016 Anlewo Ltd
 * @license 广东安乐窝网络科技有限公司
 * @author liufujingshou@anlewo.com
 * @date 17/12/7
 */

namespace anlewo\workflow\models;

use yii\web\Model;

class WorkflowSub extends Model
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%workflow_sub}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'level', 'workflowId', 'created', 'modified'], 'integer'],
            [['approvalr', 'copyGive', 'setting'], 'string'],
            [['levalName'], 'string', 'max' => 64],
            [['creater', 'modifier'], 'string', 'max' => 24],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '工作流程明细Id',
            'level' => '级别',
            'levalName' => '级别名称',
            'workflowId' => '工作流程Id',
            'approvalr' => '审批人',
            'copyGive' => '抄送人',
            'created' => '创建时间',
            'creater' => '创建人',
            'modified' => '更新时间',
            'modifier' => '更新人',
            'setting' => '数据设置',
        ];
    }
}