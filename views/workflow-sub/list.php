<?php
/**
 *
 * @link http://www.anlewo.com/
 * @copyright Copyright (c) 2015-2016 Anlewo Ltd
 * @license 广东安乐窝网络科技有限公司
 * @author liufujingshou@anlewo.com
 * @date 17/12/12
 */

use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->registerJs($this->render('js/list.js'));
?>
<div class="box box-solid">
    <?= GridView::widget([
        'id' => 'workflow-grid',
        'dataProvider' => $dataProvider,
        'panel' => [
            'type' => 'primary',
            'heading' => false,
            'footer' => false,
            'before' => Html::button('<i class="glyphicon glyphicon-plus"></i> 新增明细',
                ['class' => 'btn btn-success add-WorkflowSub-Button', 'data-url' => Url::toRoute(['add', 'workflowId' => $search->workflowId])]),
            'after' => false,
        ],
        'export' => false,
        'toggleData' => false,
        'columns' => [
            [
                'attribute' => 'level',
                'width' => '50px'
            ],
            [
                'attribute' => 'levalName',
                'width' => '120px'
            ],
            [
                'attribute' => 'approvalr',
                'width' => '200px',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->approvalMsg;
                },
            ],
            [
                'attribute' => 'copyGive',
                'width' => '200px',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->copyGiveMsg;
                },
            ],
            [
                'attribute' => 'setting',
                'width' => '200px'
            ],
            [
                'attribute' => 'created',
                'width' => '120px',
                'format' => 'date',
            ],
            [
                'class' => 'kartik\grid\ActionColumn',
                'header' => '操作',
                'headerOptions' => ['class' => 'kartik-sheet-style'],
                'width' => '100px',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return '';
                    },
                    'update' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>编辑',
                            Url::toRoute(['edit', 'id' => $model->id]),
                            ['class' => 'btn-xs btn-primary workflow-sub-edit']);
                    },
                    'delete' => function ($url, $model) {
                        return Html::a('<i class="glyphicon glyphicon-remove"></i>删除', $url, ['class' => 'btn-xs btn-danger']);
                    },
                ],
            ],
        ]
    ]);
    ?>
</div>

<!-- 新增内容 -->
<div id="add-workflow-sub-con" class="modal order-modal fade" role="dialog"></div>
