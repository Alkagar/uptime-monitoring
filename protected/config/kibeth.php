<?php
   return array(
      'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
      'name'=>'UptimeMonitoring by ZSERK',

      'preload'=>array('log'),

      'import'=>array(
         'application.models.*',
         'application.components.*',
         'application.monitors.*',
         'application.monitors.behaviors.*',
         'application.monitors.objects.*',
         'application.monitors.suites.*',
      ),
      // application components
      'components'=>array(
         'user'=>array(
            'allowAutoLogin'=>true, // enable cookie-based authentication
         ),
         // uncomment the following to enable URLs in path-format
         'urlManager'=>array(
            'urlFormat'=>'path',
            'rules'=>array(
               '<controller:\w+>/<id:\d+>'              => '<controller>/view',
               '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
               '<controller:\w+>/<action:\w+>'          => '<controller>/<action>',
            ),
         ),
         'db'=>array(
            'connectionString' => 'sqlite:/home/alkagar/repos/uptime/protected/data/uptime.db',
         ),
         'errorHandler'=>array(
            'errorAction'=>'site/error', // use 'site/error' action to display errors
         ),
         'log'=>array(
            'class'=>'CLogRouter',
            'routes'=> array(
               array(
                  'class'      => 'CFileLogRoute',
                  'levels'     => 'error, warning',
               ),
               array(
                  'class'      => 'CWebLogRoute',
                  'categories' => 'monitors.*',
               ),
            ), 
         ),
      ),
      // application-level parameters that can be accessed using Yii::app()->params['paramName']
      'params'=>array(
         'adminEmail'=>'jakub@mrowiec.org',
      ),
   );
