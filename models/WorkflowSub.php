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

use Anlewo\SDK\Gateway\UserTable;
use Yii;
use yii\db\ActiveRecord;

class WorkflowSub extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%workflow_sub}}';
    }

    /**
     * 添加明细
     * @param $data
     * @return bool
     * @throws \Exception
     */
    public static function addSub($data)
    {
        $trans = Yii::$app->db->beginTransaction();
        try {

            $model = new self();
            $model->scenario = 'add';

            if (!$model->load($data, '')) {
                throw new \Exception($model->getErrors());
            }

            $model->level = self::getLevelId($model->workflowId);

            if (!$model->save()) {
                throw new \Exception($model->getErrors());
            }

            $trans->commit();

            return true;

        } catch (\Exception $e) {
            $trans->rollBack();
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * 获取级别
     * @return int|mixed
     */
    private static function getLevelId($workflowId)
    {
        $model = self::find()->where(['workflowId' => $workflowId])->orderBy('id desc')->one();
        return empty($model) ? 1 : $model->level + 1;
    }

    /**
     * 编辑审批明细
     * @param $data
     * @return bool
     * @throws \Exception
     */
    public static function editSub($data)
    {
        $model = self::findOne($data['id']);
        if (empty($model)) {
            throw new \Exception('审批明细不存在');
        }

        $model->scenario = 'edit';
        if (!$model->load($data, '') || !$model->save()) {
            throw new \Exception(print_r($model->getErrors(), true));
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['level', 'workflowId', 'created', 'modified'], 'integer'],
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

    public function scenarios()
    {
        return [
            'add' => ['level', 'levalName', 'workflowId', 'approvalr', 'copyGive', 'created', 'creater', 'setting'],
            'edit' => ['levalName', 'approvalr', 'copyGive', 'modified', 'modifier', 'setting'],
        ];
    }


    /**
     * 获取用户列表
     * @return array
     */
    public function getUserList()
    {
        return UserTable::getUserAndRole();
    }
}