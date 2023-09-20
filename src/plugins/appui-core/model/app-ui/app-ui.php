<?php

use bbn\Mvc;
/** @var bbn\Mvc\Model $model The current model */

return [
  'status' => [
    'content' => Mvc::getInstance()->subpluginView('app-ui/button', 'html', [], 'appui-chat', 'appui-core'),
    'script' => Mvc::getInstance()->subpluginView('app-ui/button', 'js', [], 'appui-chat', 'appui-core'),
  ]
];


