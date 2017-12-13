<?php
/**
 *
 * @link http://www.anlewo.com/
 * @copyright Copyright (c) 2015-2016 Anlewo Ltd
 * @license 广东安乐窝网络科技有限公司
 * @author liufujingshou@anlewo.com
 * @date 17/12/13
 */

use kartik\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

$this->registerJs($this->render('js/add-sub.js'));
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
        'type' => ActiveForm::TYPE_HORIZONTAL
    ]); ?>
    <?= $form->field($model,'id')->hiddenInput()->label(false);?>
    <div class="modal-content">
        <div class="modal-header clearfix">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="form-group" style="width:90%">
                <?= $form->field($model, 'levalName');
                ?>
            </div>
            <div class="form-group" style="width:90%">
                <?= $form->field($model, 'approvalr')
                    ->widget(Select2::className(), [
                        'data' => ArrayHelper::map($model->userList, 'user_id', 'user_name'),
                        'theme' => Select2::THEME_KRAJEE,
                        'options' => [
                            'placeholder' => $model->getAttributeLabel('approvalr'),
                            'class' => 'form-control select-warp-option',
                            'multiple' => true,
                        ],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ]);
                ?>
            </div>
            <div class="form-group" style="width:90%">
                <?= $form->field($model, 'copyGive')
                    ->widget(Select2::className(), [
                        'data' => ArrayHelper::map($model->userList, 'user_id', 'user_name'),
                        'theme' => Select2::THEME_KRAJEE,
                        'options' => [
                            'placeholder' => $model->getAttributeLabel('copyGive'),
                            'class' => 'form-control select-warp-option',
                            'multiple' => true,
                        ],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ]);
                ?>
            </div>
            <div class="form-group" style="width:90%">
                <?= $form->field($model, 'setting');
                ?>
            </div>
        </div>
        <div class="modal-footer">
            <?= Html::submitButton('保存', ['id' => 'btn-submit-sub-create', 'class' => 'btn btn-info', 'data-loading-text' => "<i class='fa fa-spinner fa-spin '></i> 保存中..."]) ?>
            <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
        </div>
    </div>
    <?php ActiveForm::end() ?>
</div>
