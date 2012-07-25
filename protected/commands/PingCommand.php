<?php
   class PingCommand extends CConsoleCommand
   {
      public function actionIndex($host) 
      { 
         $ms = $this->_ping($host);
         echo ' - ' . $host . ' ping time: ' . $ms . ' ms.' . PHP_EOL;
         $this->_logResult($ms, ADictionary::TASK_PING);
      }

      private function _logResult($time, $logType) 
      {
         $log = new Logs();
         $log->log_type = $logType;
         $log->time = time();
         $log->code = $logType;
         $log->data = serialize(array('czas' => $time));
         $log->insert();
      }

      private function _ping($host, $port = 80, $timeout = 1) { 
         $tB = microtime(true); 
         $fP = fSockOpen($host, $port, $errno, $errstr, $timeout); 
         if (!$fP) { return "down"; } 
         $tA = microtime(true); 
         return round((($tA - $tB) * 1000), 2); 
      }
   }
