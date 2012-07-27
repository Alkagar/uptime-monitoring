<?php
    /**
    * AName 
    * 
    * @copyright 
    * @author Jakub Mrowiec Alkagar <alkagar@gmail.com> 
    */
    class AMonitor extends CComponent implements AMonitorInterface
    { 
        public  $resultInfo;
        public  $specification;
        public  $parameters = 0;

        protected $_timePassed;

        public function __construct()
        {
            $this->attachBehavior('ALog', 'ALogBehavior');
        }

        public function runMonitorWithTimer($callback, array $parameters = array()) 
        {
            if(!is_callable($callback)) {
                throw new Exception('$callback is not callable');
            }
            $tB = microtime(true); 
            $result = call_user_func_array($callback, $parameters); 
            $tA = microtime(true); 
            $this->_timePassed  = round((($tA - $tB) * 1000), 2); 
            return $result;
        }

        public function monitor() { throw new Exception('Not yet implemented!'); }
        public function getMonitorResult() { throw new Exception('Not yet implemented!'); }
        public function getMonitorCode() { throw new Exception('Not yet implemented!'); }
    }
