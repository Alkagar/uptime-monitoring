<?php
    class ADb extends CComponent implements AMonitorInterface
    {

        /** Monitor parameters */
        private $_isDbWorking;

        /** Monitor specification */
        private $_dbUrl;

        public  $resultInfo;
        public  $specification;
        public  $parameters;


        public function __construct($dbUrl)
        {
            $this->_dbUrl = $dbUrl;

            $this->attachBehavior('ALog', 'ALogBehavior');
        }

        public function monitor()
        {
            $isDbWorking = $this->_db($this->_dbUrl);
            $this->_isDbWorking = $isDbWorking;
            $this->prepareToLogToDb();
        }

        public function prepareLogData()
        {
            $this->specification = array(
                'dbUrl'              => $this->_dbUrl,
            );
            // TODO: add information about ping time for this monitor ??
            $this->resultInfo = array(
                'isDbWorking'   => $this->_isDbWorking,
            );
            $this->parameters = array( );
        }

        public function getMonitorResult()
        {
            return $this->_isDbWorking ? AMonitorsCodes::RESULT_OK : AMonitorsCodes::RESULT_ERROR;
        }

        public function getMonitorCode()
        {
            return AMonitorsCodes::MONITOR_DB;
        }

        /**
         * _db 
         * expects to get 'nazwisko' from first record of uzytkownicy table. It should be erk user.
         * 
         * @param string $dbUrl url to db test page
         * @return bool
         */
        private function _db($dbUrl) 
        {
            $dbTest = file($dbUrl);
            return strpos($dbTest[0], 'erk') === 0;
        }
    }
