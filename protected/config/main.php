<?php
   return array(
      'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
      'name'=>'My Web Application',

      // preloading 'log' component
      'preload'=>array('log'),

      // autoloading model and component classes
      'import'=>array(
         'application.models.*',
         'application.components.*',
      ),
      // application components
      'components'=>array(
         'user'=>array(
            'allowAutoLogin'=>true,
         ),
         'urlManager'=>array(
            'urlFormat'=>'path',
            'rules'=>array(
               '<controller:\w+>/<id:\d+>'=>'<controller>/view',
               '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
               '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
            ),
         ),
         'db'=>array(
            'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/uptime.db',
         ),
         'errorHandler'=>array(
            'errorAction'=>'site/error',
         ),
         'log'=>array(
            'class'=>'CLogRouter',
            /*
            'routes'=>array(
               array(
                  'class'=>'CFileLogRoute',
                  'levels'=>'error, warning',
               ),
               array(
                  'class'=>'CWebLogRoute',
               ),
               array(
                  'class'      => 'CEmailLogRoute',
                  'subject'    => 'email subject',
                  'sentFrom'   => 'sent@from.email',
                  'levels'     => 'profile',
                  'emails'     => array('sent@to.email'),
                  'categories' => 'categories.*',
               ),
            ),
            */
         ),
      ),
      // application-level parameters that can be accessed
      // using Yii::app()->params['paramName']
      'params'=>array(
         // this is used in contact page
         'adminEmail'=>'webmaster@example.com',
      ),
   );
