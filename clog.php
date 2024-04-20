<?php
echo "first here then ";

$danger =  urldecode(trim($_REQUEST['c']));

if ( strlen($danger) > 1024 ) {
   exit();
}

if ( mb_detect_encoding($danger, 'ASCII', true) ) {
   $log = $danger;

   if ( ! $_REQUEST['part'] || $_REQUEST['part'] == "0" ) {
      $log = "\n" . time() . "\t" . $log;
   }
   
   file_put_contents("remote.log", $log, FILE_APPEND);
}
echo "here";
?>
