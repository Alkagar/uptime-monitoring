<?php
    class APdf extends CComponent implements AMonitorInterface
    {

        /** Monitor parameters */
        private $_isPdfDaemonRunning;

        /** Monitor specification */
        private $_pdfUrl;

        public  $resultInfo;
        public  $specification;
        public  $parameters;


        public function __construct($pdfUrl)
        {
            $this->_pdfUrl = $pdfUrl;

            $this->attachBehavior('ALog', 'ALogBehavior');
        }

        public function monitor()
        {
            $isPdfDaemonRunning = $this->_pdf($this->_pdfUrl);
            $this->_isPdfDaemonRunning = $isPdfDaemonRunning;
            $this->logToDb();
        }

        public function logToDb() 
        {
            $this->_prepareLogData();
            $logEntry = $this->prepareLogEntry();
            $this->logDB($logEntry);
        }

        private function _prepareLogData()
        {
            $this->specification = array(
                'pdfUrl'              => $this->_pdfUrl,
            );
            // TODO: add information about ping time for this monitor ??
            $this->resultInfo = array(
                'isPdfDaemonRunning'   => $this->_isPdfDaemonRunning,
            );
            $this->parameters = array( );
        }

        public function getMonitorResult()
        {
            return $this->_isPdfDaemonRunning ? AMonitorsCodes::RESULT_OK : AMonitorsCodes::RESULT_ERROR;
        }

        public function getMonitorCode()
        {
            return AMonitorsCodes::MONITOR_PDF;
        }

        private function _pdf($pdfUrl) 
        {
            $pdfFile = file($pdfUrl);
            return strpos($pdfFile[0], '%PDF-') === 0; 
        }
    }
