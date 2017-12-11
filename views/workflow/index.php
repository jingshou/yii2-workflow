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
use yii\helpers\Url;
$this->title = '审批流程'
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
                'before' => false,
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
                    'detailUrl' => Url::to(['detail/list']),
                    'enableRowClick' => false,
                ],
                [
                    'attribute' => 'name',
                    'header' => '审批类型名称',
                    'width' => '260px',
                ],
                [
                    'attribute' => 'type',
                    'header' => '审批类型',
                    'width' => '260px',
                ],
                [
                    'attribute' => 'created',
                    'header' => '创建时间',
                    'width' => '260px',
                ],
            ]
        ]);
        ?>
    </div>
</section>
