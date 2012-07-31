<?php
   class ADb extends AMonitor
   {
      protected $_testFailedMessage = 'Występują problemy z bazą danych.';
      protected $_testOkMessage = 'Problemy z bazą danych przestały wystepować.';

      /** Monitor parameters */
      private $_isDbWorking;

      /** Monitor specification */
      private $_dbUrl;

      public  $resultInfo;
      public  $specification;
      public  $parameters;


      public function __construct($dbUrl)
      {
         parent::__construct();
         $this->_dbUrl = $dbUrl;
      }

      protected function _monitor()
      {
         $isDbWorking = $this->_db($this->_dbUrl);
         $this->_isDbWorking = $isDbWorking;
      }

      public function prepareLogData()
      {
         $this->specification = array(
            'dbUrl'              => $this->_dbUrl,
         );
         $this->resultInfo = array(
            'isDbWorking'   => $this->_isDbWorking,
            'timePassed'            => $this->_timePassed,
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
      protected function _db($dbUrl) 
      {
         $dbTest = file($dbUrl);
         return strpos($dbTest[0], 'erk') === 0;
      }
   }
