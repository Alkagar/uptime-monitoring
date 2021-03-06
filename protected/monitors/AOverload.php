<?php
   class AOverload extends AMonitor
   {
      protected $_testFailedMessage = 'Strona jest przeciążona. Zwraca komunikat o przeciążeniu (nginx).';
      protected $_testOkMessage = 'Strona odpowiada już normalnie.';

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

      protected function _overload($url) 
      {
         $f = @file($url);
         $file = implode(PHP_EOL, $f ? $f : array());
         return strpos($file, 'The page is overloaded') !== FALSE; 
      }
   }
