<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\Tasks;

/* @var $this yii\web\View */
/* @var $model app\models\Tasks */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tasks-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descr')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'status')->dropDownList(
        Tasks::getStatuses(),
        ['prompt'=> '']    // options
    ) ?>

    <?= $form->field($model, 'priority')->dropDownList(
        Tasks::getPriorities(),
        ['prompt'=> '']    // options
    ) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
