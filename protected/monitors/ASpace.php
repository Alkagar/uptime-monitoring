<?php
   class ASpace extends AMonitor
   {
      protected $_testFailedMessage = 'Kończy się miejsce na dysku!!';
      protected $_testOkMessage = 'Nagle przybyło miejsca. Nie masz się już czym przejmować.';

      /** Monitor parameters */
      private $_isEnoughSpace;
      private $_minimumFreeSpace;

      /** Monitor specification */
      private $_spaceUrl;
      private $_freeSpace;

      public  $resultInfo;
      public  $specification;
      public  $parameters;


      public function __construct($spaceUrl, $minimumFreeSpace)
      {
         parent::__construct();

         $this->_spaceUrl = $spaceUrl;
         $this->_minimumFreeSpace = $minimumFreeSpace;
      }

      protected function _monitor()
      {
         $freeSpace = $this->_space($this->_spaceUrl);
         $this->_freeSpace = $freeSpace;
      }

      public function prepareLogData()
      {
         $this->specification = array(
            'spaceUrl'              => $this->_spaceUrl,
         );
         $this->resultInfo = array(
            'freeSpace'             => $this->_freeSpace . 'kb',
         );
         $this->parameters = array(
            'minimumfreespace'      => $this->_minimumFreeSpace . 'KB',
         );
      }

      public function getMonitorResult()
      {
         if($this->_freeSpace == -1) {
            return AMonitorsCodes::RESULT_OK;
         }
         return $this->_minimumFreeSpace < $this->_freeSpace ? AMonitorsCodes::RESULT_OK : AMonitorsCodes::RESULT_ERROR;
      }

      public function getMonitorCode()
      {
         return AMonitorsCodes::MONITOR_SPACE;
      }

      /**
      * _space
      * 
      * @param string $spaceUrl url to space test page
      * @return int $space free space in KB 
      */
      private function _space($url) 
      {
         $f = @file($url);
         $file = implode(PHP_EOL, $f ? $f : array());
         return (int)$file;
      }
   }
