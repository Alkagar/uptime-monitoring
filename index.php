<?php
/**         ## configuration instrution ##

to have local configs and yii path you need to define variables in .htaccess:
YII_PATH            - path to yii framework
YII_LOCAL_CONFIG    - path to local config file 

can be done with:

SetEnv YII_PATH /your/yii/path

*/

/** define consts  */
defined('YII_DEBUG') or define('YII_DEBUG',true);
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

/** read local yii path  */
if(isset($_SERVER['YII_PATH'])) {
    $pathToYii = $_SERVER['YII_PATH'];
} else {
   $pathToYii = '/home/alkagar/repos/yii';
}
$yii = $pathToYii . '/framework/yii.php';

/** create local and base configs */
$localConfigPath    = isset($_SERVER['YII_LOCAL_CONFIG']) ? $_SERVER['YII_LOCAL_CONFIG'] : '';
$localConfig        = empty($localConfigPath) ? array() : require($localConfigPath);
$configPath         = dirname(__FILE__).'/protected/config/main.php';
$baseConfig         = require($configPath);

/** load config and start application  */
require_once($yii);
$config=CMap::mergeArray($baseConfig, $localConfig);
Yii::createWebApplication($config)->run();
