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

use Anlewo\SDK\Gateway\UserTable;
use anlewo\workflow\models\WorkflowSub;
use yii\data\ActiveDataProvider;

class WorkflowSubSearch extends WorkflowSub
{
    const PAGE_SIZE = 1000;

    public function rules()
    {
        return [
            [['levalName', 'setting'], 'string'],
            [['levalName', 'approvalr'], 'required'],
            [['workflowId', 'level'], 'integer'],
            [['approvalr', 'copyGive'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return parent::attributeLabels(); // TODO: Change the autogenerated stub
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

        $query = self::find()->where(['workflowId' => $this->workflowId]);

        return $query;
    }

    /**
     * 审批人信息
     * @return string
     */
    public function getApprovalMsg()
    {
        $approval = json_decode($this->approvalr, true);
        $userIds = array_column($approval, 'id');
        return $this->_userMsg($userIds);
    }

    private function _userMsg($ids)
    {
        $msg = '';
        $userList = array_column($this->userList, 'user_name', 'user_id');
        foreach ($ids as $key => $val) {
            $type = $key != count($ids) - 1 ? ',&nbsp' : '';
            $msg .= isset($userList[$val]) ? $userList[$val] . $type : '';
        }
        return !empty($msg) ? $msg : '--';
    }

    /**
     * 抄送人
     * @return string
     */
    public function getCopyGiveMsg()
    {
        $copyGive = json_encode($this->copyGive, true);

        if(empty($copyGive)){
            return '--';
        }

        var_dump(empty($copyGive));
            exit;
        $userIds = array_column($copyGive, 'id');
        return $this->_userMsg($userIds);
    }

    /**
     * @param $userIds
     * @return bool|string
     */
    public function getUserInfo($userIds)
    {
        if (empty($userIds)) {
            return '';
        }

        $res = [];
        $userList = UserTable::find()->where(['in', 'id', $userIds])->all();

        foreach ($userList as $key => $val) {
            $res[] = [
                'id' => $val->id,
                'name' => $val->name,
            ];
        }

        return json_encode($res);
    }
}