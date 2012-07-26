<?php
   class PingCommand extends CConsoleCommand
   {
      public function actionPing($host) { }
      public function actionPdf($host) { }
      public function actionIndex($host) 
      { 
         $ms = $this->_ping($host);
         echo ' - ' . $host . ' ping time: ' . $ms . ' ms.' . PHP_EOL;
         $this->_logResult($ms, ADictionary::TASK_PING);
      }
   }
