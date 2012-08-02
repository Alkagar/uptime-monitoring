<?php
    class MonitorErkLogCommand extends CConsoleCommand
    {
        public function actionIndex() 
        { 
            $erkSuite = new AErkLogSuite();
            $erkSuite->runSuite();
        }
    }
