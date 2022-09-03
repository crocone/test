<?php

/** @var yii\web\View $this */

$this->title = 'Test for roadgid';
$this->registerJsFile(
    '@web/js/main.js',
    ['depends' => [\yii\web\JqueryAsset::class]]
);
?>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent">
        <div class="row">
            <div class="col-12">
                <button class="btn btn-primary" id="getCode" type="submit">Получить код!</button>
            </div>

            <div class="col-12 mt-3">
                <div class="resultSuccess d-none input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Ваш код:</span>
                    </div>
                    <input type="url" disabled class="form-control codeResult">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary copyCode" type="button">Скопировать</button>
                    </div>
                </div>

                <p class="resultError <?= !$error ? 'd-none' : '' ?> text-danger"><?= $error ?></p
            </div>
        </div>
    </div>
</div>
