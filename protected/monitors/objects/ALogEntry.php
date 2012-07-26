<?php
   class ALogEntry extends CComponent
   {
      private $_datetime;
      public $monitor_type;
      private $_specification;
      private $_parameters;
      private $_
      public $result_code;






      public function getDatetime()
      {
         if(!isset($this->_datetime)) {
            $this->_datetime = time();
         }
         return $this->_datetime;
      }

      public function getData()
      {
         print_r($this->_data);
         return CJSON::decode($this->_data);
      }

      public function getJsonData()
      {
         return $this->_data;
      }

      public function setData($value)
      {
         $this->_data = CJSON::encode($value);
      }
   }

