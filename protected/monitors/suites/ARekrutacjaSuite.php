<?php
   class ARekrutacjaSuite extends ASuite
   {
      public function init()
      {
         $this->addLogEmail('konrad.sacala@gmail.com');
         $this->addLogEmail('jakub@mrowiec.org');

         $host = 'rekrutacja.uj.edu.pl';
         $this->addMonitor(new APing($host));
         $host = 'http://www.' . $host;
         $this->addMonitor(new ATextExists($host, 'Rekrutacja na studia'));
      }
   }
