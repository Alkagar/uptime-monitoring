<?php
   class ATextExists extends AMonitor
   {
      protected $_testFailedMessage = '';
      protected $_testOkMessage = '';

      /** Monitor parameters */
      private $_isTextExisting;

      /** Monitor specification */
      private $_pageUrl;
      private $_textToSearch;

      public  $resultInfo;
      public  $specification;
      public  $parameters;

      public function __construct($pageUrl, $textToSearch)
      {
         parent::__construct();
         $this->_pageUrl = $pageUrl;
         $this->_textToSearch = $textToSearch;
      }

      protected function _monitor()
      {
         $isTextExisting = $this->_page($this->_pageUrl, $this->_textToSearch);
         $this->_isTextExisting = $isTextExisting;
      }

      public function prepareLogData()
      {
         $this->specification = array(
            'pageUrl'              => $this->_pageUrl,
            'textToSearch'          => $this->_textToSearch,
         );
         $this->resultInfo = array(
            'isTextExisting'   => $this->_isTextExisting,
            'timePassed'            => $this->_timePassed,
         );
         $this->parameters = array( );
      }

      public function getMonitorResult()
      {
         return $this->_isTextExisting ? AMonitorsCodes::RESULT_OK : AMonitorsCodes::RESULT_ERROR;
      }

      public function getMonitorCode()
      {
         return AMonitorsCodes::MONITOR_TEXTEXISTS;
      }

      protected function _page($pageUrl, $textToSearch) 
      {
         $pageFile = implode(PHP_EOL, file($pageUrl));
         return strpos($pageFile, trim($textToSearch)) !== FALSE; 
      }
   }
