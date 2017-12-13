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
        'tableOptions' => ['class' => 'table table-striped table-bordered table-center table-fixed'],
        'panel' => [
            'type' => 'primary',
            'heading' => false,
            'footer' => false,
            'before' => Html::button('<i class="glyphicon glyphicon-plus"></i> 新增明细',
                ['class' => 'btn btn-success', 'id' => 'add-WorkflowSub-Button', 'data-url' => Url::toRoute(['add'])]),
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
                'width' => '200px'
            ],
            [
                'attribute' => 'copyGive',
                'width' => '200px'
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
                    'delete' => function ($url, $model) {
                        return Html::a('<i class="glyphicon glyphicon-remove"></i>删除');
                    },
                    'update' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>编辑', $url, ['class' => 'update-button']);
                    },
                ],
            ],
        ]
    ]);
    ?>
</div>

<!-- 新增内容 -->
<div id="add-workflow-sub-con" class="modal order-modal fade" role="dialog"></div>
