<?php
/**
 *
 * @link http://www.anlewo.com/
 * @copyright Copyright (c) 2015-2016 Anlewo Ltd
 * @license 广东安乐窝网络科技有限公司
 * @author liufujingshou@anlewo.com
 * @date 17/12/12
 */

use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\helpers\Url;

$this->registerJs($this->render('js/add.js'));

?>
<style>
    div.required label:after {
        content: " *";
        color: red;
    }
</style>

<div class="modal-dialog modal-form" role="modal">
    <?php $form = ActiveForm::begin([
        'id' => 'frm-create',
        'method' => 'post',
        'action' => Url::to(['add']),
        'type' => ActiveForm::TYPE_HORIZONTAL
    ]); ?>
    <div class="modal-content">
        <div class="modal-header clearfix">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="form-group" style="width:550px">
                <?= $form->field($model, 'name');
                ?>
            </div>
            <div class="form-group" style="width:550px">
                <?= $form->field($model, 'type')
                    ->widget(Select2::className(), [
                        'data' => $model->typeApprovalList,
                        'theme' => Select2::THEME_KRAJEE,
                        'options' => [
                            'placeholder' => $model->getAttributeLabel('type'),
                            'class' => 'form-control select-warp-option',
                        ],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ]);
                ?>
            </div>
        </div>
        <div class="modal-footer">
            <?= Html::submitButton('保存', ['id' => 'btn-submit-create', 'class' => 'btn btn-info', 'data-loading-text' => "<i class='fa fa-spinner fa-spin '></i> 保存中..."]) ?>
            <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
        </div>
    </div>
    <?php ActiveForm::end() ?>
</div>
