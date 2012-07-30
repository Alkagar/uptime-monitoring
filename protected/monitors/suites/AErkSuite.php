<?php
   class AErkSuite extends ASuite
   {
      public function init()
      {
         $host = 'erk.uj.edu.pl';
         $this->addMonitor(new APing($host));

         $host = 'https://' . $host;
         $this->addMonitor(new APdf($host . '/uptime/pdf'));
         $this->addMonitor(new ABreak($host . '/uptime/errors'));
         $this->addMonitor(new AOverload($host . '/uptime/errors'));
         $this->addMonitor(new ASpace($host . '/uptime/space', 102400));
         $this->addMonitor(new ADb($host . '/uptime/db'));
      }
   }
