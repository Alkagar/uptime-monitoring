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

        protected $_timePassed;

        public function __construct()
        {
            $this->attachBehavior('ALog', 'ALogBehavior');
        }

        public function monitor() 
        {
            $tB = microtime(true); 
            $result = $this->_monitor();
            $tA = microtime(true); 
            $this->_timePassed  = round((($tA - $tB) * 1000), 2); 
            return $result;
        }

        protected function _monitor() { throw new Exception('Not yet implemented!'); }
    }
