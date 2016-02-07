<?php
   
           
   if(isset($_POST['get_option']))
   {
     $host = 'localhost';
     $user = 'root';
     $pass = '';
           
     mysql_connect($host, $user, $pass);

     mysql_select_db('stockmanagement');
      

     $itemName = $_POST['get_option'];
	 $itemName = mysql_real_escape_string($itemName);
     $find=mysql_query("select itemCode,unitOfItem,itemAbbr from uniqueitemlist where itemName='$itemName'");
	
     while($row=mysql_fetch_array($find))
     {
       echo json_encode("Item Code : " .$row['itemCode']. " | Unit Of Item : ".$row['unitOfItem']." | Item Abbreviation : ".$row['itemAbbr']);
     }
   
     exit;
   }

?>