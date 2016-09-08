<?php
return [
        [
            'class' => 'yii\rest\UrlRule',
            'controller' => 'v1/country' ,  // our country api rule,
            'tokens' => [
                '{id}' => '<id:\\w+>'
            ]
        ]
];
