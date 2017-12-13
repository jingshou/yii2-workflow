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

use Yii;
use yii\db\ActiveRecord;

class Workflow extends ActiveRecord
{

    const TYPE_APPROVAL_PURCHASE = 1; // 采购单审批
    const TYPE_APPROVAL_STORAGE = 2;  // 入库单审批
    const TYPE_APPROVAL_JI_CAI = 3;   // 集采单审批
    const TYPE_APPROVAL_ACCOUNT = 4;  // 对账单审批
    const TYPE_APPROVAL_WMS_STORAGE = 5; // WMS入库调整审批
    const TYPE_APPROVAL_REFUND = 6;  // 退款单审批

    /**
     * 审批类型列表
     * @var
     */
    protected static $_typeList;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%workflow}}';
    }

    /**
     * 创建审批类型
     * @param $data
     * @throws \Exception
     * @return boolean
     */
    public static function addWorkflow($data)
    {
        $trans = Yii::$app->db->beginTransaction();
        try {

            self::exitWorkflow($data['type']);

            $model = new self();
            $model->scenario = 'add';
            if (!$model->load($data, '') || !$model->save()) {
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
     * 检测是否存在相同类型审批类型
     * @param $type
     * @param $id
     * @return bool
     * @throws \Exception
     */
    public static function exitWorkflow($type, $id = 0)
    {
        $model = self::find()
            ->where(['type' => $type, 'isDel' => 0])
            ->andFilterWhere(['<>', 'id', $id])
            ->one();

        if (!empty($model)) {
            throw new \Exception('审批类型已经存在，请更新或删除！');
        }
        return true;
    }

    /**
     * 编辑审批流程
     * @param $data
     * @return bool
     * @throws \Exception
     */
    public static function editWorkflow($data)
    {
        $model = self::findOne($data['id']);
        if (empty($model)) {
            throw new \Exception('审批类型不存在');
        }

        self::exitWorkflow($data['type'], $model->id);

        $model->scenario = 'edit';
        if (!$model->load($data, '') || !$model->save()) {
            throw new \Exception(print_r($model->getErrors(), true));
        }

        return true;
    }

    /**
     * 删除审批流程
     * @param $id
     * @return bool
     */
    public static function delWorkflow($id)
    {
        $model = self::findOne($id);
        $model->scenario = 'del';
        $model->isDel = 1;
        if (!$model->save()) {
            return false;
        }
        return true;
    }

    /**
     * 审批类型信息
     * @return mixed|null
     */
    public function getTypeApprovalMsg()
    {
        $list = static::getTypeApprovalList();
        return !empty($list) ? $list[$this->type] : null;
    }

    /**
     * 审批类型列表
     * @return array
     */
    public static function getTypeApprovalList()
    {
        if (self::$_typeList === null) {
            self::$_typeList = [
                self::TYPE_APPROVAL_PURCHASE => '采购单审批',
                self::TYPE_APPROVAL_STORAGE => '入库单审批',
                self::TYPE_APPROVAL_JI_CAI => '集采单审批',
                self::TYPE_APPROVAL_ACCOUNT => '对账单审批',
                self::TYPE_APPROVAL_WMS_STORAGE => 'WMS入库调整审批',
                self::TYPE_APPROVAL_REFUND => '退款单审批',
            ];
        }

        return self::$_typeList;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'type'], 'required'],
            [['type', 'created', 'modified', 'isDel'], 'integer'],
            [['name'], 'string', 'max' => 64],
            [['creater', 'modifier'], 'string', 'max' => 24],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '工作流程Id',
            'name' => '审批名称',
            'type' => '审批类型',
            'created' => '创建时间',
            'creater' => '创建人',
            'modifier' => '更新时间',
            'modified' => '更新人',
            'isDel' => '删除 0：未删除 1：删除',
        ];
    }

    public function scenarios()
    {
        return [
            'add' => ['name', 'type', 'created', 'creater'],
            'del' => ['isDel'],
            'edit' => ['name', 'type', 'modifier', 'modified'],
        ];
    }
}