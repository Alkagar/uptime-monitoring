<?php
    class AUtil
    {
        public static function ping($host, $port = 80, $timeout = 1) 
        { 
            $tB = microtime(true); 
            $fP = fSockOpen($host, $port, $errno, $errstr, $timeout); 
            if (!$fP) { return "down"; } 
            $tA = microtime(true); 
            return round((($tA - $tB) * 1000), 2); 
        }
    }
