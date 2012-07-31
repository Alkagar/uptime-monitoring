<?php
   class ALogs extends AMonitor
   {
      protected $_testFailedMessage = 'Zainteresuj się logami znajdującymi się na serwerze.';
      protected $_testOkMessage = 'Nie ma nowych logów na serwerze.';

      /** Monitor parameters */
      private $_isNewLog;

      /** Monitor specification */
      private $_pageUrl;
      private $_port;

      public  $resultInfo;
      public  $specification;
      public  $parameters;

      public function __construct($pageUrl, $port)
      {
         parent::__construct();
         $this->_pageUrl = $pageUrl;
         $this->_port = $port;
      }

      protected function _monitor()
      {
         $isNewLog = $this->_page($this->_pageUrl, $this->_port);
         $this->_isNewLog = $isNewLog;
      }

      public function prepareLogData()
      {
         $this->specification = array(
            'pageUrl'               => $this->_pageUrl,
            'port'                  => $this->_port,
         );
         $this->resultInfo = array(
            'isNewLog'              => $this->_isNewLog,
            'timePassed'            => $this->_timePassed,
         );
         $this->parameters = array( );
      }

      public function getMonitorResult()
      {
         return $this->_isNewLog ? AMonitorsCodes::RESULT_ERROR : AMonitorsCodes::RESULT_OK;
      }

      public function getMonitorCode()
      {
         return AMonitorsCodes::MONITOR_LOGEXISTS;
      }

      protected function _page($pageUrl, $port) 
      {
         $pageUrl = $pageUrl . '/port/' . $port;
         $pageFile = implode(PHP_EOL, file($pageUrl));
         return strpos($pageFile, trim('1')) !== FALSE; 
      }
   }
