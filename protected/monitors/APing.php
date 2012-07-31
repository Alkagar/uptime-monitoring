<?php
   class APing extends AMonitor
   {
      protected $_testFailedMessage = 'Możliwe przeciążenie serwera. Czas odpowiedzi jest zbyt długi.';
      protected $_testOkMessage = 'Serwer już działa poprawnie. Czas odpowiedzi znacząco się skrócił.';

      private $_pingResult;
      private $_maxAcceptablePing = 20;

      public  $resultInfo;
      public  $specification;
      public  $parameters;

      private $_host;
      private $_port;
      const AVERAGE_ITEMS = 5;

      public function __construct($host, $port = 80, $maxAcceptablePing = 20)
      {
         parent::__construct();
         $this->_port = $port;
         $this->_host = $host;
         $this->_maxAcceptablePing = $maxAcceptablePing; 
      }

      protected function _monitor()
      {
         $ms = $this->_getCalculatedPing();
         $this->_pingResult = $ms;
      }

      public function prepareLogData()
      {
         $this->specification = array(
            'host'              => $this->_host,
            'port'              => $this->_port,
            'averageFromItems'  => self::AVERAGE_ITEMS,
         );
         $this->resultInfo = array(
            'pingTimeInMs'   => $this->_pingResult, 
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

      private function _getCalculatedPing()
      {
         $averagePingArray = array();
         for($i = 0; $i < self::AVERAGE_ITEMS; $i++) {
            $averagePingArray[] = AUtil::ping($this->_host, $this->_port);
         }
         sort($averagePingArray);
         array_pop($averagePingArray);
         array_shift($averagePingArray);
         return round(array_sum($averagePingArray) / count($averagePingArray), 2);
      }
   }
