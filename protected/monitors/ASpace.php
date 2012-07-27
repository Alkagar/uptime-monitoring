<?php
    class ASpace extends AMonitor
    {

        /** Monitor parameters */
        private $_isEnoughSpace;
        private $_spaceToUse;

        /** Monitor specification */
        private $_spaceUrl;
        private $_usedSpace;

        public  $resultInfo;
        public  $specification;
        public  $parameters;


        public function __construct($spaceUrl, $spaceToUse)
        {
            parent::__construct();

            $this->_spaceUrl = $spaceUrl;
            $this->_spaceToUse = $spaceToUse;
        }

        protected function _monitor()
        {
            $usedSpace = $this->_space($this->_spaceUrl);
            $this->_usedSpace = $usedSpace;
        }

        public function prepareLogData()
        {
            $this->specification = array(
                'spaceUrl'              => $this->_spaceUrl,
            );
            // TODO: add information about ping time for this monitor ??
            $this->resultInfo = array(
                'usedSpace'   => $this->_usedSpace . 'KB',
            );
            $this->parameters = array( 
                'spaceToUse'         => $this->_spaceToUse . 'KB',
            );
        }

        public function getMonitorResult()
        {
            return $this->_spaceToUse > $this->_usedSpace ? AMonitorsCodes::RESULT_OK : AMonitorsCodes::RESULT_ERROR;
        }

        public function getMonitorCode()
        {
            return AMonitorsCodes::MONITOR_SPACE;
        }

        /**
         * _space
         * 
         * 
         * @param string $dbUrl url to db test page
         * @return int $space used space in KB 
         */
        private function _space($spaceUrl) 
        {
            $spaceTest = file($spaceUrl);
            return (int)$spaceTest[0];
        }
    }
