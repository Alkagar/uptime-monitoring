<?php

    class Logs extends CActiveRecord
    {
        public static function model($className=__CLASS__)
        {
            return parent::model($className);
        }

        public function tableName()
        {
            return 'logs';
        }

        public function search()
        {
            $criteria=new CDbCriteria;

            return new CActiveDataProvider('Logs', array(
                'criteria'=>$criteria,
            ));
        }

        public function __toString() 
        {
            return '<pre>' . 
                $this->datetime . ' | ' . 
                $this->monitor_type . ' | ' . 
                $this->result_code . ' | ' . 
                $this->result_info . ' | ' .
                $this->parameters . ' | ' . 
                $this->specification . '</pre>';
        }

        public static function getLastXCriteria($limit = 5)
        {
            $criteria = new CDbCriteria();
            $criteria->limit = $limit;
            $criteria->order = 'datetime DESC';
            return $criteria;
        }
    }
