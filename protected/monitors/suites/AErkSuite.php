<?php
    class AErkSuite extends ASuite
    {
        public function init()
        {
            $this->addMonitor(new APing('erk.uj.edu.pl', 80));
            $this->addMonitor(new APdf('http://erk.kibeth:23480/uptime/pdf'));
            $this->addMonitor(new ABreak('http://erk.kibeth:23480/uptime/errors'));
            $this->addMonitor(new AOverload('http://erk.kibeth:23480/uptime/errors'));
            $this->addMonitor(new ASpace('http://erk.kibeth:23480/uptime/space', 512000));
            $this->addMonitor(new ADb('http://erk.kibeth:23480/uptime/db'));
        }
    }
