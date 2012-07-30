<?php
   class AKibethSuite extends ASuite
   {
      public function init()
      {
         $this->_emails[] = 'konrad.sacala@uj.edu.pl';
         $this->_emails[] = 'konrad.sacala@gmail.com';
         $this->_emails[] = 'jakub@mrowiec.org';

         $host = 'pelikan.cusi.uj.edu.pl';
         $this->addMonitor(new APing($host, 23480 ));

         $host = 'http://' . $host . ':23480';
         $this->addMonitor(new APdf($host . '/uptime/pdf'));
         $this->addMonitor(new ABreak($host . '/uptime/errors'));
         $this->addMonitor(new AOverload($host . '/uptime/errors'));
         $this->addMonitor(new ASpace($host . '/uptime/space', 102400));
         $this->addMonitor(new ADb($host . '/uptime/db'));
      }
   }
