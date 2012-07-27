<?php 
    class ASuite implements ASuiteInterface, Iterator
    {
        private $_position = 0;
        private $_monitors = array();  

        public function __construct() 
        {
            $this->_position = 0;
            $this->init();
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
    }
