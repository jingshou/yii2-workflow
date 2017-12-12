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

use anlewo\workflow\models\search\WorkflowSearch;
use anlewo\workflow\models\search\WorkflowSubSearch;
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
        $data = Yii::$app->request->queryParams;
        $search = new WorkflowSubSearch();
        $search->load($data);
        $dataProvider = $search->search();

        return $this->renderAjax('/workflow-sub/list', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * 添加审批
     * @return array|string
     */
    public function actionAdd()
    {
        $search = new WorkflowSearch();

        if (Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            try {
                $data = Yii::$app->request->post('WorkflowSearch');

                $data = array_merge($data, [
                    'creater' => Yii::$app->getUser()->identity->name,
                    'created' => time(),
                ]);

                $res = Workflow::addWorkflow($data);

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

        return $this->renderAjax('add', [
            'model' => $search
        ]);
    }
}