<?php
    class MonitorErkCommand extends CConsoleCommand
    {
        public function actionIndex() 
        { 
            $erkSuite = new AErkSuite();
            $erkSuite->runSuite();
        }
    }
