<?php
   class ALogBehavior extends CBehavior
   {
      public function logDB(ALogEntry $logEntry)
      {
         $log = new Logs();
         $log->datetime = $logEntry->datetime;
         $log->code = $logEntry->code;
         $log->data = $logEntry->getJsonData();
         $log->result = $logEntry->result;
         return $log->insert();
      }
   }
