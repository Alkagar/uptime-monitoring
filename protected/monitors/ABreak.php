<?php
    class ABreak extends CComponent implements AMonitorInterface
    {

        /** Monitor parameters */
        private $_isPageOnBreak;

        /** Monitor specification */
        private $_breakUrl;

        public  $resultInfo;
        public  $specification;
        public  $parameters;


        public function __construct($breakUrl)
        {
            $this->_breakUrl = $breakUrl;

            $this->attachBehavior('ALog', 'ALogBehavior');
        }

        public function monitor()
        {
            $isPageOnBreak = $this->_break($this->_breakUrl);
            $this->_isPageOnBreak = $isPageOnBreak;
            $this->prepareToLogToDb();
        }

        public function prepareLogData()
        {
            $this->specification = array(
                'breakUrl'              => $this->_breakUrl,
            );
            // TODO: add information about ping time for this monitor ??
            $this->resultInfo = array(
                'isPageOnBreak'   => $this->_isPageOnBreak,
            );
            $this->parameters = array( );
        }

        public function getMonitorResult()
        {
            return $this->_isPageOnBreak ? AMonitorsCodes::RESULT_ERROR : AMonitorsCodes::RESULT_OK;
        }

        public function getMonitorCode()
        {
            return AMonitorsCodes::MONITOR_BREAK;
        }

        private function _break($breakUrl) 
        {
            $breakFile = implode(PHP_EOL, file($breakUrl));
            return strpos($breakFile, 'Maintenance break') !== FALSE; 
        }
    }
