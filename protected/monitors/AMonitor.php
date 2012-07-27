<?php
    /**
    * AName 
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
            $this->_logEntry = $this->prepareToLogToDb();
            $tA = microtime(true); 
            $this->_timePassed  = round((($tA - $tB) * 1000), 2); 
            if($this->getMonitorResult() === AMonitorsCodes::RESULT_ERROR) {
                echo 'wysylamy mail';
                $this->notifyByMail($this->_logEntry);
            }
            return $result;
        }

        protected function _monitor() { throw new Exception('Not yet implemented!'); }
    }
