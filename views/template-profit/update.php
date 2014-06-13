<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var app\models\TemplateProfit $model
 */

$this->title = 'Update Template Profit: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Template Profits', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="template-profit-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
