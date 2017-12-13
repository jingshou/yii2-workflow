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
        $search = new WorkflowSubSearch();
        $search->scenario = 'add';

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
            'model' => $search
        ]);
    }
}