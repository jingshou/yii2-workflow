<?php
/**
 *
 * @link http://www.anlewo.com/
 * @copyright Copyright (c) 2015-2016 Anlewo Ltd
 * @license 广东安乐窝网络科技有限公司
 * @author liufujingshou@anlewo.com
 * @date 17/12/7
 */

namespace anlewo\workflow\controllers;

use anlewo\workflow\models\search\WorkflowSubSearch;
use anlewo\workflow\models\WorkflowSub;
use kartik\form\ActiveForm;
use Yii;
use yii\web\Controller;
use yii\web\Response;

class WorkflowSubController extends Controller
{
    /**
     * 审批列表
     * @return string
     */
    public function actionList()
    {
        $workflowId = Yii::$app->request->post('expandRowKey');
        $data = Yii::$app->request->queryParams;

        $data = array_merge($data, ['workflowId' => $workflowId]);

        $search = new WorkflowSubSearch();
        $search->scenario = 'add';
        $search->load($data, '');
        $dataProvider = $search->search();

        return $this->renderAjax('/workflow-sub/list', [
            'dataProvider' => $dataProvider,
            'search' => $search
        ]);
    }

    /**
     * 添加审批
     * @return array|string
     */
    public function actionAdd()
    {
        $workflowId = Yii::$app->request->get('workflowId');
        $search = new WorkflowSubSearch();
        $search->scenario = 'add';
        $search->workflowId = $workflowId;

        if (Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $data = Yii::$app->request->post();
            $search->load($data);

            if (!$search->validate()) {
                return [
                    'success' => false,
                    'validation' => ActiveForm::validate($search),
                ];
            }

            try {

                $data = array_merge($search->toArray(), [
                    'approvalr' => $search->getUserInfo($data['approvalr']),
                    'copyGive' => $search->getUserInfo($data['copyGive']),
                    'creater' => Yii::$app->getUser()->identity->name,
                    'created' => time(),
                ]);

                $res = WorkflowSub::addSub($data);

                return [
                    'success' => true,
                    'msg' => '保存成功',
                ];
            } catch (\Exception $e) {
                return [
                    'success' => false,
                    'msg' => $e->getMessage(),
                ];
            }
        }

        return $this->renderAjax('/workflow-sub/add-sub', [
            'model' => $search,
        ]);
    }

    /**
     * 编辑明细
     * @param $id
     * @return array|string
     */
    public function actionEdit($id)
    {

        $model = WorkflowSubSearch::findOne($id);
        $model->scenario = 'edit';

        if (Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $data = Yii::$app->request->post('WorkflowSubSearch');

            $model->load($data, '');
            if (!$model->validate()) {
                return [
                    'success' => false,
                    'validation' => ActiveForm::validate($model),
                ];
            }

            try {

                $data = array_merge($model->toArray(), [
                    'approvalr' => $model->getUserInfo($data['approvalr']),
                    'copyGive' => $model->getUserInfo($data['copyGive']),
                    'modifier' => Yii::$app->getUser()->identity->name,
                    'modified' => time(),
                ]);

                $res = WorkflowSub::editSub($data);

                return [
                    'success' => true,
                    'msg' => '保存成功',
                ];

            } catch (\Exception $e) {
                return [
                    'success' => false,
                    'msg' => $e->getMessage(),
                ];
            }
        }


        return $this->renderAjax('/workflow-sub/add-sub', [
            'model' => $model,
        ]);
    }
}