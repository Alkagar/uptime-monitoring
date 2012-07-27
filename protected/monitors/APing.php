<?php
    class APing extends AMonitor
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
            //$ms = $this->runMonitorWithTimer('AUtil::ping', array($this->_host, $this->_port));
            $ms = AUtil::ping($this->_host, $this->_port);
            $this->_pingResult = $ms;
            $this->prepareToLogToDb();
        }

        public function prepareLogData()
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
    }
