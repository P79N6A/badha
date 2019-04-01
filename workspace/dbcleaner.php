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
      SELECT Timestamp, ID FROM main;

EOF;
      
   
      $ret = $db->query($sql);
   $ids = array();   
   while($row = $ret->fetchArray(SQLITE3_ASSOC) ){
      $time = $row['Timestamp'] . "\n";
      $time = (explode(" ",$time));
      
      
      $record_time = $time[1];
   
      
      $record = strtotime($record_time);
      $present = strtotime(date("Y-m-d H:i:s"));

      //echo ((int)$present - (int)$record);
      //echo round(abs($record - $present) / 60,2). " minute";
      $idx = $row['ID'] . "\n";
      if(round(abs($record - $present) / 60,2)>4){
         echo "Time to go!";
         
         
         array_push($ids, $idx);
            
      }else{
           echo "Not yet!";
      }
   }
   
   
      

foreach ($ids as $id){
  
   
   $sql =<<<EOF
      DELETE FROM main WHERE ID = '$id';

EOF;
      
   
      $ret = $db->query($sql);
      
      
}
$db->close();
?>      

