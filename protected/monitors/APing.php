<?php
   class APing extends CComponent implements AMonitorInterface
   {
      private $_pingResult;
      private $_monitorCode;
      private $_host;
      private $_port;

      public function __construct($host, $port = 80)
      {
         $this->_port = $port;
         $this->_host = $host;
         $this->attachBehavior('ALog', 'ALogBehavior');

         $this->_monitorCode = AMonitorsCodes::MONITOR_PING;
      }

      public function monitor()
      {
         $ms = $this->_ping($this->_host, $this->_port);
         $this->_pingResult = $ms;
         $data = array(
            'ping_time_in_ms'   => $ms, 
            'host'              => $host,
            'port'              => $port,
         );
         $logEntry = new ALogEntry();
         $logEntry->code = $this->_monitorCode;
         $logEntry->data = $data;
         $logEntry->result = $this->monitorResult();
         $this->logDB($logEntry);
      }

      public function monitorResult()
      {
         return $this->_pingResult > 20 ? AMonitorsCodes::RESULT_ERROR : AMonitorsCodes::RESULT_OK;
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
