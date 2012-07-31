<?php
   class AErkSuite extends ASuite
   {
      public function init()
      {
         $this->addLogEmail('konrad.sacala@uj.edu.pl');
         $this->addLogEmail('jakub.mrowiec@uj.edu.pl');

         $host = 'erk.uj.edu.pl';
         $this->addMonitor(new APing($host, 80, 30));

         $host = 'https://' . $host;
         $this->addMonitor(new APdf($host . '/uptime/pdf'));
         $this->addMonitor(new ABreak($host . '/uptime/errors'));
         $this->addMonitor(new AOverload($host . '/uptime/errors'));
         $this->addMonitor(new ASpace($host . '/uptime/space', 1 * 1024 * 1024));
         $this->addMonitor(new ADb($host . '/uptime/db'));
         $this->addMonitor(new ALogs($host . '/uptime/logs', 443));
         $this->addMonitor(new ALogs($host . '/uptime/logs', 843));
      }
   }
