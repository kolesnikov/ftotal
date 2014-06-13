<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var app\models\TemplateProfit $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="template-profit-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'total')->textInput() ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 200]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
