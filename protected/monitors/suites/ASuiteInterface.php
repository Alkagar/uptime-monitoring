<?php
    interface ASuiteInterface
    {
        public function runSuite();
        public function addMonitor(AMonitorInterface $monitor);
    }
