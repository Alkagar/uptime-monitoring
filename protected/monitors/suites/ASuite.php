<?php 
   class ASuite implements ASuiteInterface, Iterator
   {
      public static $actualSuite = 'generic';
      protected $_suiteName = '';

      protected $_emails = array('erk@uj.edu.pl');
      protected $_logEmailConfig = array(
         'class'      => 'CEmailLogRoute',
         'subject'    => 'Wiedz że coś się dzieje! - Uptime Monitoring by ERK',
         'sentFrom'   => 'erk@uj.edu.pl',
         'levels'     => 'profile',
         'categories' => 'monitors.generic',
      );

      private $_position = 0;
      private $_monitors = array();  

      public function __construct() 
      {
         $this->setSuiteName(self::$actualSuite);
         
         $this->_createLogEmailRoute(); // create catching all generic route
         $this->_position = 0; 

         $this->setSuiteName(get_class($this));
         $this->init();
         $this->_createLogEmailRoute(); // create catching specific suite route
      }

      public function runSuite()
      { 
         self::$actualSuite = $this->_suiteName;
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
         self::$actualSuite = $this->_suiteName;
         $configArray = $this->_logEmailConfig;
         $emailLogRoute = new CEmailLogRoute();
         $emailLogRoute->subject = $configArray['subject'];
         $emailLogRoute->sentFrom = $configArray['sentFrom'];
         $emailLogRoute->levels = $configArray['levels'];
         $emailLogRoute->categories = 'monitors.' . self::$actualSuite;
         $emailLogRoute->emails = $this->_emails;

         $log = Yii::app()->getComponent('log');
         $routes = $log->getRoutes();
         $routes[] = $emailLogRoute;
         $log->setRoutes($routes);
         $routes = $log->getRoutes();
      }

      protected function addLogEmail($email)
      {
         $this->_emails[] = $email;
      }

      protected function setSuiteName($name)
      {
         $this->_suiteName = $name;
      }
   }
