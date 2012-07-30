<?php
   /**
   * AMonitor
   * 
   * @copyright 
   * @author Jakub Mrowiec Alkagar <alkagar@gmail.com> 
   */
   abstract class AMonitor extends CComponent implements AMonitorInterface
   { 
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
         if($this->getMonitorResult() === AMonitorsCodes::RESULT_ERROR) {
            if(! $this->isSuccessiveError()) {
               Yii::log((string)$this->_logEntry, 'profile', 'monitors.information');
            }
         }
         return $result;
      }

      public function isSuccessiveError()
      { 
         $monitorCode = $this->getMonitorCode();
         $monitorName = $this->getMonitorName();
         $criteria = Logs::getLogsByTypeCriteria($monitorCode, 2);
         $logs = Logs::model()->findAll($criteria);
         if(count($logs) < 2) {
            return true;
         }
         $actualLogResultCode   = $logs[0]->result_code;
         $previousLogResultCode = $logs[1]->result_code;
         Yii::trace($actualLogResultCode, 'monitors.results.' . $monitorName);
         Yii::trace($previousLogResultCode, 'monitors.results.' . $monitorName);
         return $actualLogResultCode == $previousLogResultCode;
      }

      public function getMonitorName()
      {
         return AMonitorsCodes::$MONITOR_NAMES[$this->getMonitorCode()];
      }

      protected function _monitor() { throw new Exception('Not yet implemented!'); }
   }
