<?php
   class AErkLogSuite extends ASuite
   {
      public function init()
      {
         $this->addLogEmail('konrad.sacala@uj.edu.pl');
         $this->addLogEmail('jakub.mrowiec@uj.edu.pl');

         $host = 'erk.uj.edu.pl';

         $host = 'https://' . $host;
         $this->addMonitor(new ALogs($host . '/uptime/apache', 443));
         $this->addMonitor(new ALogs($host . '/uptime/apache', 843));
      }
   }
