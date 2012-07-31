<?php
   class APdf extends AMonitor 
   {
      protected $_testFailedMessage = 'Daemon PDF nie działa poprawnie. Należy go uruchomić.';
      protected $_testOkMessage = 'PDF\'y generują się już poprawnie.';

      /** Monitor parameters */
      private $_isPdfDaemonRunning;

      /** Monitor specification */
      private $_pdfUrl;

      public function __construct($pdfUrl)
      {
         parent::__construct();
         $this->_pdfUrl = $pdfUrl;
      }

      protected function _monitor()
      {
         $isPdfDaemonRunning = $this->_pdf($this->_pdfUrl);
         $this->_isPdfDaemonRunning = $isPdfDaemonRunning;
      }

      public function prepareLogData()
      {
         $this->specification = array(
            'pdfUrl'              => $this->_pdfUrl,
         );
         $this->resultInfo = array(
            'isPdfDaemonRunning'    => $this->_isPdfDaemonRunning,
            'timePassed'            => $this->_timePassed,
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

      protected function _pdf($pdfUrl) 
      {
         $pdfFile = file($pdfUrl);
         return strpos($pdfFile[0], '%PDF-') === 0; 
      }
   }
