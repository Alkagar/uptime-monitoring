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
         $this->_logEntry = $this->prepareToLogToDb();
         if($this->getMonitorResult() === AMonitorsCodes::RESULT_ERROR) {
            Yii::log((string)$this->_logEntry, 'profile', 'monitors.information');
         }
         return $result;
      }

      protected function _monitor() { throw new Exception('Not yet implemented!'); }
   }
