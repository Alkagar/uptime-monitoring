<?php
   /**
   * AMonitor
   * 
   * @copyright 
   * @author Jakub Mrowiec Alkagar <alkagar@gmail.com> 
   */
   abstract class AMonitor extends CComponent implements AMonitorInterface
   { 
      protected $_testFailedMessage = 'Human readable message not defined.';
      protected $_testOkMessage = 'Human readable message not defined.';

      public  $resultInfo;
      public  $specification;
      public  $parameters = 0;
      protected $_logEntry;

      protected $_timePassed;

      public function __construct()
      {
         $this->attachBehavior('ALog', 'ALogBehavior');
         $this->attachBehavior('AMail', 'AMailBehavior');
      }

      public function monitor() 
      {
         $tB = microtime(true); 
         $result = $this->_monitor();
         $tA = microtime(true); 
         $this->_timePassed = round((($tA - $tB) * 1000), 2); 
         $this->_logEntry = $this->logToDb();

         if(! $this->isSuccessiveStatus()) {
            $this->_logEntry->sendMessage = $this->getMonitorResult() === AMonitorsCodes::RESULT_ERROR ?
            $this->_testFailedMessage : $this->_testOkMessage;
            echo('monitors.' . ASuite::$actualSuite . '<br />');
            Yii::log((string)$this->_logEntry, 'profile', 'monitors.' . ASuite::$actualSuite);
         }
         return $result;
      }

      /**
      * isSuccessiveError 
      * check if actual error is successive. Return true only when 
      * last error is the same as actual one. Return false when error
      * status has changed till last tests.
      * 
      * @return bool 
      */
      public function isSuccessiveStatus()
      { 
         $monitorCode = $this->getMonitorCode();
         $monitorName = $this->getMonitorName();
         $logEntrySpecification = $this->_logEntry->getJson('specification');
         $criteria = Logs::getLogsByTypeCriteria($monitorCode, 2);
         // get only two last entries
         $criteria->limit = 2;
         // and order by id to get most recent entries
         $criteria->order = 'id DESC';
         // merge with criteria to specify logs for this system only
         $criteria->mergeWith(Logs::getLogsBySpecification($logEntrySpecification));
         $logs = Logs::model()->findAll($criteria);
         if(count($logs) < 2) {
            return true;
         }
         $actualLogResultCode   = $logs[0]->result_code;
         $previousLogResultCode = $logs[1]->result_code;
         Yii::trace($actualLogResultCode, 'monitors.results.' . $monitorName);
         Yii::trace($previousLogResultCode, 'monitors.results.' . $monitorName);
         // if codes are the same it means that it's successive status
         return $actualLogResultCode == $previousLogResultCode;
      }

      public function getMonitorName()
      {
         return AMonitorsCodes::$MONITOR_NAMES[$this->getMonitorCode()];
      }

      protected function _monitor() { throw new Exception('Not yet implemented!'); }
   }
