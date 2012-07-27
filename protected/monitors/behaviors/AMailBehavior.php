<?php
    class AMailBehavior extends CBehavior
    {
        public function notifyByMail(ALogEntry $logEntry)
        {
            Yii::app()->email->send('Erk Uptime','alkagar@gmail.com','Subject','Body');
        }
    }
