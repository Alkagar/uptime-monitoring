<?php
    interface AMonitorInterface
    {
        public function getMonitorResult();
        public function monitor();
        public function getMonitorCode();
        public function logToDb();
    }
