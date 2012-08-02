<?php
   class ARekrutacjaSuite extends ASuite
   {
      public function init()
      {
         $this->addLogEmail('konrad.sacala@gmail.com');
         $this->addLogEmail('jakub.mrowiec@uj.edu.pl');
         $this->addLogEmail('tadeusz.debowski@uj.edu.pl');

         $host = 'rekrutacja.uj.edu.pl';
         $this->addMonitor(new APing($host));
         $host = 'http://www.' . $host;
         $this->addMonitor(new ATextExists($host, 'Rekrutacja na studia'));

         $host = 'erk.uj.edu.pl';
         $host = 'https://' . $host;
         $this->addMonitor(new ABreak($host . '/uptime/errors'));
         $this->addMonitor(new AOverload($host . '/uptime/errors'));
      }
   }
