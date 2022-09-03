<?php

return [
    'class' => 'yii\web\UrlManager',
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'rules' => [
        ['pattern' => 'api/retrieve/<id>', 'route' => 'api/retrieve'],
    ]
];
