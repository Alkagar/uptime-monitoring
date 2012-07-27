<?php
    class APing extends CComponent implements AMonitorInterface
    {
        private $_pingResult;
        private $_maxAcceptablePing = 20;

        public  $resultInfo;
        public  $specification;
        public  $parameters;

        private $_host;
        private $_port;

        public function __construct($host, $port = 80)
        {
            $this->_port = $port;
            $this->_host = $host;

            $this->attachBehavior('ALog', 'ALogBehavior');
        }

        public function monitor()
        {
            $ms = $this->_ping($this->_host, $this->_port);
            $this->_pingResult = $ms;
            $this->logToDb();
        }

        public function logToDb() 
        {
            $this->_prepareLogData();
            $logEntry = $this->prepareLogEntry();
            $this->logDB($logEntry);
        }

        private function _prepareLogData()
        {
            $this->specification = array(
                'host'              => $this->_host,
                'port'              => $this->_port,
            );
            $this->resultInfo = array(
                'ping_time_in_ms'   => $this->_pingResult, 
            );
            $this->parameters = array(
                'maxAcceptablePing' => $this->_maxAcceptablePing,

            );
        }

        public function getMonitorResult()
        {
            return $this->_pingResult > $this->_maxAcceptablePing ? AMonitorsCodes::RESULT_ERROR : AMonitorsCodes::RESULT_OK;
        }

        public function getMonitorCode()
        {
            return AMonitorsCodes::MONITOR_PING;
        }

        private function _ping($host, $port = 80, $timeout = 1) 
        { 
            $tB = microtime(true); 
            $fP = fSockOpen($host, $port, $errno, $errstr, $timeout); 
            if (!$fP) { return "down"; } 
            $tA = microtime(true); 
            return round((($tA - $tB) * 1000), 2); 
        }
    }
