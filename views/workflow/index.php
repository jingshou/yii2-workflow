<?php
/**
 *
 * @link http://www.anlewo.com/
 * @copyright Copyright (c) 2015-2016 Anlewo Ltd
 * @license 广东安乐窝网络科技有限公司
 * @author liufujingshou@anlewo.com
 * @date 17/12/7
 */

use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = '审批流程';

$this->registerJs($this->render('js/index.js'));
?>

<section class="content-header">
    <h1><?= $this->title ?></h1>
    <ol class="breadcrumb">
        <li class="active"><?= $this->title ?></li>
    </ol>
</section>

<section class="content">
    <div class="box box-solid">

        <?= GridView::widget([
            'id' => 'workflow-grid',
            'layout' => '{items}<div class="box-footer clearfix pagination-box"><div class="pull-right">{pager}</div></div>',
            'dataProvider' => $dataProvider,
            'tableOptions' => ['class' => 'table table-striped table-bordered table-center table-fixed'],
            'pager' => [
                'class' => '\anlewo\widgets\LinkPager',
                'template' => '<div class="box-footer clearfix pagination-box"><div class="pull-right"><div class="form-inline">{summary}{pageButtons}</div></div></div>'
            ],
            'panel' => [
                'type' => '',
                'heading' => false,
                'footer' => false,
                'before' => Html::button('<i class="glyphicon glyphicon-plus"></i> 新增',
                    ['class' => 'btn btn-success', 'id' => 'add-Workflow-Button', 'data-url' => Url::toRoute(['add'])]),
                'after' => '{pager}',
            ],
            'export' => false,
            'toggleData' => false,
            'columns' => [
                [
                    'class' => 'kartik\grid\ExpandRowColumn',
                    'value' => function ($model, $key, $index, $column) {
                        return GridView::ROW_COLLAPSED;
                    },
                    'detailUrl' => Url::to(['workflow-sub/list']),
                    'enableRowClick' => false,
                ],
                [
                    'attribute' => 'name',
                    'width' => '260px',
                ],
                [
                    'attribute' => 'type',
                    'width' => '260px',
                    'value' => function ($model) {
                        return $model->typeApprovalMsg;
                    }
                ],
                [
                    'attribute' => 'created',
                    'width' => '260px',
                    'format' => 'date',
                ],
                [
                    'class' => 'kartik\grid\ActionColumn',
                    'header' => '操作',
                    'headerOptions' => ['class' => 'kartik-sheet-style'],
                    'width' => '200px',
                    'buttons' => [
                        'view' => function ($url, $model) {
                            return '';
                        },
                        'update' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-pencil"></span> 编辑',
                                Url::toRoute(['edit', 'id' => $model->id]),
                                ['class' => 'btn-xs btn-primary update-button workflow-edit']);
                        },
                        'delete' => function ($url, $model) {
                            return Html::a('<i class="glyphicon glyphicon-trash"></i> 删除', $url,
                                ['class' => 'btn-xs btn-danger update-button workflow-del']);
                        },
                    ],
                ],
            ]
        ]);
        ?>
    </div>
</section>

<!-- 新增内容 -->
<div id="add-workflow-con" class="modal order-modal fade" role="dialog"></div>