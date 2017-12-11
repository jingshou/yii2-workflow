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
use yii\web\Controller;

class WorkflowController extends Controller
{
    public function actionIndex()
    {

        $search = new WorkflowSearch();
        $dataProvider = $search->search();

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }
}