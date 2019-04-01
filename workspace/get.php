<?php
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
      } //else {
         //Success
      //}
   
   $sql =<<<EOF
      SELECT * FROM main;

EOF;
      
   $cod = array();
   $type = array();
      $ret = $db->query($sql);
   while($row = $ret->fetchArray(SQLITE3_ASSOC) ){
      $lat = $row['lat'] . "\n";
      $long = $row['long'] ."\n";
      $type0 = $row['mapase'];
      if(!empty($type0)){
         $is_mapase = "M";
      }
      $type1 = $row['license'];
      if(!empty($type1)){
         $is_license = "L";
      }
      $type2 = $row['general'];
      if(!empty($type2)){
         $is_general = "G";
      }
      
      $pattern = (string)$lat . '' . ',' .'' . (string)$long .'' . ',' .'' . (string)$is_mapase .'' . ',' .'' . (string)$is_license .'' . ',' . '' .(string)$is_general ; 
      array_push($cod, $pattern);

      
   }
   //echo json_encode('lo');
   //return "lo";
   
      $db->close();
?>