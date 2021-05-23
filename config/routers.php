<?php

return [
    'api/<controller>/<action>/<id:\d+>' => 'api/<controller>/<action>',

    'rbac/<slug:[A-Za-z-]+>/<action:(index|create)>'         => 'rbac/<action>',
    'rbac/<slug:[A-Za-z-]+>/<action:(view|update)>/<id:\d+>' => 'rbac/<action>',
];