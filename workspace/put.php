<?php
 
  // Set default timezone
  date_default_timezone_set('UTC');
  $lat = $_GET['lat'];
  $long = $_GET['long'];
  $license = $_GET['l'];
  $general = $_GET['g'];
  $mapase = $_GET['m'];
  class MyDB extends SQLite3
   {
      function __construct()
      {
         $this->open('test.db');
      }
   }
   $db = new MyDB();
   if(!$db){
      echo $db->lastErrorMsg();
   } else {
      echo "Opened database successfully\n";
   }

   $sql =<<<EOF
      INSERT INTO main (lat, long, mapase, license, general)
      VALUES ('$lat', '$long', '$mapase', '$license', '$general');

EOF;

   $ret = $db->exec($sql);
   if(!$ret){
      echo $db->lastErrorMsg();
   } else {
      echo "Records created successfully\n";
   }
   $db->close();
?>