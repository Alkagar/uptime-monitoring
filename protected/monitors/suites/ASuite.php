<?php 
   class ASuite implements ASuiteInterface, Iterator
   {
      public static $routes = array();

      protected $_emails = array('erk@uj.edu.pl');
      protected $_logEmailConfig = array(
         'class'      => 'CEmailLogRoute',
         'subject'    => 'Wiedz że coś się dzieje! - Uptime Monitoring by ERK',
         'sentFrom'   => 'erk@uj.edu.pl',
         'levels'     => 'profile',
         'categories' => 'monitors.information',
      );

      private $_position = 0;
      private $_monitors = array();  

      public function __construct() 
      {
         $this->_position = 0;
         $this->init();
         $this->_createLogEmailRoute();
      }

      public function runSuite()
      { 
         foreach($this as $monitor) {
            $monitor->monitor();
         } 
      }

      public function addMonitor(AMonitorInterface $monitor)
      { 
         $this->_monitors[] = $monitor; 
      }

      public function rewind() 
      {
         $this->_position = 0;
      }

      public function current() 
      {
         return $this->_monitors[$this->_position];
      }

      public function key() 
      {
         return $this->_position;
      }

      public function next() 
      {
         ++$this->_position;
      }

      public function valid() 
      {
         return isset($this->_monitors[$this->_position]);
      }

      protected function _createLogEmailRoute() 
      {
         $configArray = $this->_logEmailConfig;
         $emailLogRoute = new CEmailLogRoute();
         $emailLogRoute->subject = $configArray['subject'];
         $emailLogRoute->sentFrom = $configArray['sentFrom'];
         $emailLogRoute->levels = $configArray['levels'];
         $emailLogRoute->categories = $configArray['categories'];
         $emailLogRoute->emails = $this->_emails;

         $log = Yii::app()->getComponent('log');
         $routes = $log->getRoutes();
         $routes[] = $emailLogRoute;
         $log->setRoutes($routes);
      }
   }
