<?php
   
           
   if(isset($_POST['get_option']))
   {
     $host = 'localhost';
     $user = 'root';
     $pass = '';
           
     mysql_connect($host, $user, $pass);

     mysql_select_db('stockmanagement');
      

     $labName = $_POST['get_option'];
	 $labName = mysql_real_escape_string($labName);
     $find=mysql_query("select locationName,departmentName from location where labName='$labName'");
	
     while($row=mysql_fetch_array($find))
     {
       echo json_encode("Lab ID : " .$row['locationName']. " | Dept Name : ".$row['departmentName']);
     }
   
     exit;
   }

?>