<?php
    class ALogBehavior extends CBehavior
    {
        public function logDB(ALogEntry $logEntry)
        {
            $log = new Logs();

            $log->datetime = $logEntry->datetime;
            $log->monitor_type = $logEntry->monitorType;
            $log->result_code = $logEntry->resultCode;

            $log->specification = $logEntry->getJson('specification');
            $log->result_info = $logEntry->getJson('resultInfo');
            $log->parameters = $logEntry->getJson('parameters');
            return $log->insert();
        }

        public function prepareLogEntry()
        {
            $logEntry = new ALogEntry();

            $logEntry->resultCode       = $this->owner->getMonitorResult();
            $logEntry->monitorType      = $this->owner->getMonitorCode(); 

            $logEntry->resultInfo       = $this->owner->resultInfo;
            $logEntry->parameters       = $this->owner->parameters;
            $logEntry->specification    = $this->owner->specification;

            return $logEntry;
        }

        public function prepareToLogToDb() 
        {
            $this->owner->prepareLogData();
            $logEntry = $this->owner->prepareLogEntry();
            $this->owner->logDB($logEntry);
            return $logEntry;
        }

    }
