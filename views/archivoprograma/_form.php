<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Archivoprograma */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="archivoprograma-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'programa_id')->textInput() ?>

    <?= $form->field($model, 'usuario_id')->textInput() ?>

    <?= $form->field($model, 'estado_id')->textInput() ?>

    <?= $form->field($model, 'archivo')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>