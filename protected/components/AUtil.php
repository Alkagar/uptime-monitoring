<?php
   class AUtil
   {
      public static function ping($host, $port = 80, $timeout = 1) 
      { 
         $tB = microtime(true); 
         try{
            $fP = @fSockOpen($host, $port, $errno, $errstr, $timeout); 
         } catch(Exception $ex) {
            return 10000;
         }
         if (!$fP) { return 10000; } 
         $tA = microtime(true); 
         return round((($tA - $tB) * 1000), 2); 
      }
   }
