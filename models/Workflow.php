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
            [['id'], 'required'],
            [['id', 'type', 'created', 'modifier', 'isDel'], 'integer'],
            [['name'], 'string', 'max' => 64],
            [['creater', 'modified'], 'string', 'max' => 24],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '工作流程Id',
            'name' => '审批类型名称',
            'type' => '审批类型：1：采购单审批 2：入库单审批 3：集采审批 4：对账单审批 5：wms入库调整 6：退款审批',
            'created' => '创建时间',
            'creater' => '创建人',
            'modifier' => '更新时间',
            'modified' => '更新人',
            'isDel' => '删除 0：未删除 1：删除',
        ];
    }
}