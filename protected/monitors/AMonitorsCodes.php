<?php
   class AMonitorsCodes
   {
      const MONITOR_PING       = 1001;
      const MONITOR_PDF        = 1002;
      const MONITOR_DB         = 1003;
      const MONITOR_SPACE      = 1004;
      const MONITOR_OVERLOAD   = 1005;
      const MONITOR_BREAK      = 1006;
      const MONITOR_TEXTEXISTS = 1007;
      const MONITOR_LOGEXISTS  = 1008;

      const RESULT_OK          = 100;
      const RESULT_ERROR       = 150;

      public static $MONITOR_NAMES = array(
         self::MONITOR_PING       => 'ping',
         self::MONITOR_PDF        => 'pdf daemon',
         self::MONITOR_DB         => 'mysql',
         self::MONITOR_SPACE      => 'free space',
         self::MONITOR_OVERLOAD   => 'overload',
         self::MONITOR_BREAK      => 'maintenance break',
         self::MONITOR_TEXTEXISTS => 'text exists',
         self::MONITOR_LOGEXISTS  => 'log exists',
      );
   }
