<?php
   class ALogEntry extends CComponent
   {
      private $_datetime;
      private $_specification;
      private $_parameters;
      private $_resultInfo;
      public  $resultCode;
      public  $monitorType;
      public  $sendMessage = '';

      public function getDatetime()
      {
         if(!isset($this->_datetime)) {
            $this->_datetime = time();
         }
         return $this->_datetime;
      }

      public function getResultInfo()
      {
         print_r($this->_resultInfo);
         return CJSON::decode($this->_resultInfo);
      }

      public function setResultInfo($value)
      {
         $this->_resultInfo = CJSON::encode($value);
      }

      public function getSpecification()
      {
         print_r($this->_specification);
         return CJSON::decode($this->_specification);
      }

      public function setSpecification($value)
      {
         $this->_specification = CJSON::encode($value);
      }

      public function getParameters()
      {
         print_r($this->_parameters);
         return CJSON::decode($this->_parameters);
      }

      public function setParameters($value)
      {
         $this->_parameters = CJSON::encode($value);
      }

      public function getJson($fieldName)
      {
         $field = '_' . $fieldName;
         return $this->$field;
      }

      public function __toString() 
      {
         return  PHP_EOL .  
         "message: \n\t" . $this->sendMessage . PHP_EOL .
         "time: \n\t " . date("Y-m-d H:i:s", $this->datetime) . PHP_EOL . 
         sprintf("monitor type: \n\t %-20s", AMonitorsCodes::$MONITOR_NAMES[$this->monitorType]) . PHP_EOL . 
         "result code: \n\t " . $this->resultCode . PHP_EOL . 
         sprintf("result info: \n\t %-30s", $this->_resultInfo) . PHP_EOL .
         sprintf("paremeters: \n\t %-30s", $this->_parameters) . PHP_EOL . 
         sprintf("specification: \n\t %-30s", $this->_specification) . PHP_EOL;
      }

   }

