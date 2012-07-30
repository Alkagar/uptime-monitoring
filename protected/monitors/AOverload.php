<?php
   class AOverload extends AMonitor
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
         parent::__construct();
         $this->_overloadUrl = $overloadUrl;
      }

      protected function _monitor()
      {
         $isPageOverloaded = $this->_overload($this->_overloadUrl);
         $this->_isPageOverloaded = $isPageOverloaded;
      }

      public function prepareLogData()
      {
         $this->specification = array(
            'overloadUrl'              => $this->_overloadUrl,
         );
         $this->resultInfo = array(
            'isPageOverloaded'   => $this->_isPageOverloaded,
            'timePassed'            => $this->_timePassed,
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

      protected function _overload($overloadUrl) 
      {
         $overloadFile = implode(PHP_EOL, file($overloadUrl));
         return strpos($overloadFile, 'The page is overloaded') !== FALSE; 
      }
   }
