<?php
   
           
   if(isset($_POST['get_option1']) && isset($_POST['get_option2']))
   {
     $host = 'localhost';
     $user = 'root';
     $pass = '';
           
     mysql_connect($host, $user, $pass);

     mysql_select_db('stockmanagement');
      

     $itemcode = $_POST['get_option1'];
	 $labID = $_POST['get_option2'];
   
	 $itemcode = mysql_real_escape_string($itemcode);
	 $labID = mysql_real_escape_string($labID);
	 
     $find=mysql_query(" select sum(receivedQuantity) - sum(issuedQuantity) as C from transaction where itemID in( 
                             select itemID from itemreceived where location in( 
                            select locationID as loc from location where locationName = '$labID')
                             and itemName = '$itemcode' );");
							 
	
     while($row=mysql_fetch_array($find))
     {
       echo json_encode($row['C']);
     }
   
     exit;
   }

?>