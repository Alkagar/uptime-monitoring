<?php
    class AOverload extends CComponent implements AMonitorInterface
    {

        /** Monitor parameters */
        private $_isPageOverloaded;

        /** Monitor specification */
        private $_overloadUrl;

        public  $resultInfo;
        public  $specification;
        public  $parameters;


        public function __construct($overloadUrl)
        {
            $this->_overloadUrl = $overloadUrl;

            $this->attachBehavior('ALog', 'ALogBehavior');
        }

        public function monitor()
        {
            $isPageOverloaded = $this->_overload($this->_overloadUrl);
            $this->_isPageOverloaded = $isPageOverloaded;
            $this->prepareToLogToDb();
        }

        public function prepareLogData()
        {
            $this->specification = array(
                'overloadUrl'              => $this->_overloadUrl,
            );
            // TODO: add information about ping time for this monitor ??
            $this->resultInfo = array(
                'isPageOverloaded'   => $this->_isPageOverloaded,
            );
            $this->parameters = array( );
        }

        public function getMonitorResult()
        {
            return $this->_isPageOverloaded ? AMonitorsCodes::RESULT_ERROR : AMonitorsCodes::RESULT_OK;
        }

        public function getMonitorCode()
        {
            return AMonitorsCodes::MONITOR_OVERLOAD;
        }

        private function _overload($overloadUrl) 
        {
            $overloadFile = implode(PHP_EOL, file($overloadUrl));
            return strpos($overloadFile, 'The page is overloaded') !== FALSE; 
        }
    }
