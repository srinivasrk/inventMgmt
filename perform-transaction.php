<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="initial-scale=1.0">
  <title>perform-transaction</title>
  <link rel="stylesheet" href="css/standardize.css">
  <link rel="stylesheet" href="css/perform-transaction-grid.css">
  <link rel="stylesheet" href="css/perform-transaction.css">
  <script type="text/javascript">
		function pop(div) {
			document.getElementById(div).style.display = 'block';
		}
		function hide(div) {
			document.getElementById(div).style.display = 'none';
		}
		//To detect escape button
		document.onkeydown = function(evt) {
		evt = evt || window.event;
		if (evt.keyCode == 27) {
		var r =confirm("Are you sure you want to stop the current transaction ?");
		if(r==true)
		{
			hide('popDiv');
		}
		}
	};
			
			
		</script>
  <script type="text/javascript">
  var res;
	function itemchanged(val){
		
	$.ajax({
     type: 'post',
     url: 'itemchanged.php',
     data: {
       get_option:val
     },
     success: function (response) {
		response = response.replace(/^"(.*)"$/, '$1');
		res = response.split("|");
       document.getElementById("itemcode").innerHTML=res[0]; 
		document.getElementById("unitofitem").innerHTML = res[1];
		document.getElementById("itemabbr").innerHTML=res[2];
		if(res[2].length == 21) 
		{
			
			document.getElementById("itemabbr").style.visibility ="hidden";
		}
		else
		{
			
			document.getElementById("itemabbr").style.visibility="visible";
		}
		checkavail();
     },
	  error: function(xhr, status, error) {
      // check status && error
	  
   }
   });
}
function checkavail()
{
 if(document.getElementById("selectitem").selectedIndex > 0 && document.getElementById("selectlab").selectedIndex > 0)
	{	
	var temp = res[0];
	temp = temp.split(":");
	
	temp[1] = temp[1].trim();
	 var labIDval = document.getElementById("labID").innerHTML;
	labIDval = labIDval.split(":");
	labIDval[1] = labIDval[1].trim();
	
	 $.ajax({
     type: 'post',
     url: 'stockavail.php',
    data: {get_option1:temp[1],get_option2:labIDval[1]},
     success: function (response) {
		response = response.replace(/^"(.*)"$/, '$1');
		if(response.length > 0)
		{
			var e = document.getElementById("selectitem");
			var item = e.options[e.selectedIndex].text;
			e = document.getElementById("labID").innerHTML;
			e = e.split(":");	
			if(response!="null")
				document.getElementById("stockavail").innerHTML = "The number of " +item + " in " + e[1] +" is "+ response;
			else
				document.getElementById("stockavail").innerHTML = "The number of " +item + " in " + e[1] +" is 0";
		}
		
     },
	  error: function(xhr, status, error) {
		
	  
   }
  });  

	}
}
	
  
  
  function labchanged(val){
	 
	  $.ajax({
     type: 'post',
     url: 'labchanged.php',
     data: {
       get_option:val
     },
     success: function (response) {
		
		response = response.replace(/^"(.*)"$/, '$1');
		var res = response.split("|");
       document.getElementById("labID").innerHTML=res[0]; 
		document.getElementById("deptname").innerHTML = res[1];
		checkavail();
     },
	  error: function(xhr, status, error) {
      // check status && error
	  
   }
   });
		
	
  }
  </script>
</head>
<body class="body page-perform-transaction clearfix">

  <div class="header clearfix">
    <header class="_container clearfix">
      <a class="text" href="#">CMR Institute Of Technology</a>
	 
    </header>
    <img class="image" src="images/final_logo1-116x123-1.jpg" data-rimage data-src="images/final_logo1-116x123-1.jpg">
  </div>
  <a class="text text-2" href="#">Stock Management Suite</a>
  <div class="element _element element-1"></div>
  <a class="uniqueitem uniqueitem-1" href="#">Unique Items</a>
  <a class="uniqueitem uniqueitem-2" href="perform-transaction.php">Perform Transaction</a>
  <a class="uniqueitem uniqueitem-3" href="#">Departments/Lab's</a>
  <a class="uniqueitem uniqueitem-4" href="#">Supplier List</a>
  <a class="uniqueitem uniqueitem-5" href="#">Request for stock</a>
  <div class="container _container clearfix"  >
    <div class="element _container clearfix" >
      <select id="selectitem" onchange="itemchanged(this.options[this.selectedIndex].text)	" class="_select _select-1"
	  name="Select Item" style="width:400px !important;font-size:16px;font-weight:700">
	 
	  <?php
		// Load field datas into List box
		$cn=mysql_connect("localhost",root) or die("Note: " . mysql_error());
		
		$res=mysql_select_db("stockmanagement",$cn) or die("Note: " . mysql_error());
		
		$res_item=mysql_query("select * from uniqueitemlist;") or die("Note: " . mysql_error());
		
		?>
		<option  style="font-size:14px" value="Select Item" > Select Item </option>
		<?php
			while($ri = mysql_fetch_array($res_item))
			{
				echo "<option style=\"font-size:14px\"  value=" .$ri['itemName'] . ">" . $ri['itemName'] . "</option>";
			}
		echo "</select> "
		?>
		<h2 id="itemcode" style="margin-top: 93px;display: block;float: 
		left;width: auto;height: 32px;
		margin-left: 60px;padding-left: 10px;
		font-size: 16px;font-weight: 700;
		;color: rgb(0, 0, 0);"></h2>
		
		<h2 id="unitofitem" style="margin-top: 93px;display: block;float: 
		left;width:auto;height: 32px;margin-left:60px;
		;padding-left: 10px;
		font-size: 16px;font-weight: 700;
		;color: rgb(0, 0, 0);"> </h2>
		
		<h2 id="itemabbr" style="margin-top: 93px;display: block;float: 
		left;width:auto;height: 32px;margin-left:60px;;padding-left: 10px;
		font-size: 16px;font-weight: 700;
		;color: rgb(0, 0, 0);"></h2>
		
		
		
      <select id="selectlab" class="_select _select-2" onchange="labchanged(this.options[this.selectedIndex].text)" name="Select Location" style="width:400px !important;font-size:16px;font-weight:700">
		<?php
		// Load field datas into List box
		$cn=mysql_connect("localhost",root) or die("Note: " . mysql_error());
		
		$res=mysql_select_db("stockmanagement",$cn) or die("Note: " . mysql_error());
		
		$res_dept=mysql_query("select * from location;") or die("Note: " . mysql_error());
			
		?>
		<option  style="font-size:14px"  value="Select Location">Select Location</option>
		<?php
			while($row = mysql_fetch_array($res_dept))
			{
				echo "<option style=\"font-size:14px\"  value=" .$row['labName'] . ">" . $row['labName'] . "</option>";
			}
		echo "</select> "
		?>
			
		<h2 id="labID" style="margin-top: 93px;display: block;float: 
		left;width: auto;height: 32px;
		margin-left: 60px;padding-left: 10px;
		font-size: 16px;font-weight: 700;
		;color: rgb(0, 0, 0);"></h2>
		
		<h2 id="deptname" style="margin-top: 93px;display: block;float: 
		left;width:auto;height: 32px;margin-left:60px;
		;padding-left: 10px;
			font-size: 16px;font-weight: 700;
		;color: rgb(0, 0, 0);">  </h2>
		
		
		
      </select>
	 
	 <h2 id="stockavail" style="width:auto;display:block;margin-top:23%;
		margin-left:90px;font-size: 16px;font-weight: 700;text-align:center;
		;color: rgb(0, 0, 0);">  </h2>
		
      <div class="element _element"></div>
	  
      <p class="text _text">Optional Details :</p>
      <input class="_input _input-1" placeholder="Make" type="text">
      <input class="_input _input-2" placeholder="Model" type="text">
      <input class="_input _input-3" placeholder="Serial Number" type="text">
      <textarea class="_textarea _textarea-1" placeholder="Accessories"></textarea>
      <textarea class="_textarea _textarea-2" placeholder="Item Specification"></textarea>
      <textarea class="_textarea _textarea-3" placeholder="Remarks"></textarea>
	  <div id="popDiv" class="ontop">
			<div style=" border: 1px solid #000; "  id="popup">
				<p  style="text-align:center ! important;color: rgb(22, 119, 248);padding-top:50px;font-size:20px;font-weight: 700;
				letter-spacing: 1px;"  > Complete your transaction </h2>
				<br />
				<br />
				<table align="center" style="margin: 0px auto;">
				<tr>
				<td>
					<textarea style="font-weight:700; height: 100px;width:400px; border: 1px solid rgb(119, 119, 119);background-color: rgb(242, 242, 242);
					box-shadow: 1px -3px 5px rgba(0, 0, 0, .5) inset;font-size: 17px;line-height: 1.38;color: rgb(0, 0, 0);resize: none; margin:30px;padding:10px;" 
					placeholder="Enter Particulars for this transaction"></textarea> 
				</td>
				<td>
					<textarea style="font-weight:700; height: 100px;width:400px; border: 1px solid rgb(119, 119, 119);background-color: rgb(242, 242, 242);
					box-shadow: 1px -3px 5px rgba(0, 0, 0, .5) inset;font-size: 17px;line-height: 1.38;color: rgb(0, 0, 0);resize: none; margin:30px; padding:10px;" 
					placeholder="Enter comments for this transaction"></textarea>
				</td>					
				</tr>
				<tr>
				<td style="text-align:center">
					<input style="height:50px; font-weight:700 ;   padding: 0 10px;  border-radius: 5px;  background-color: rgb(242, 242, 242);
					box-shadow: 1px -3px 5px rgba(0, 0, 0, 0.5) inset;font-size: 17px;line-height: 1.38;letter-spacing: 1px;color: rgb(0, 0, 0);margin:30px;padding:10px;" 
					placeholder="Issued Quantity" type="text">
				</td>
				<td style="text-align:center">
					<input style="height:50px; font-weight:700 ;  padding: 0 10px;  border-radius: 5px;  background-color: rgb(242, 242, 242);
					box-shadow: 1px -3px 5px rgba(0, 0, 0, 0.5) inset;font-size: 17px;line-height: 1.38;letter-spacing: 1px;color: rgb(0, 0, 0);margin:30px;padding:10px; "
					placeholder="Received Quantity" type="text">
				</td>
				</tr>
				</table>
				<hr />
			
			<p  style="text-align:center ! important;color: rgb(22, 119, 248);padding-top:1px;font-size: .889em;font-weight: 700;
				letter-spacing: 1px;"  > Optional Details </p>
					
<br />

<table align="center" style="margin: 0px auto;" >
<tr>
<td style="text-align:center;">
				<select  id="selectSupplier" onchange="supplierChanged(this.options[this.selectedIndex].text)" class="_select _select-1"
	  name="Select Item" style="margin:10px;width:400px !important;font-size:16px;font-weight:700;">
	  <?php
					// Load field datas into List box
					$cn=mysql_connect("localhost",root) or die("Note: " . mysql_error());
					
					$res=mysql_select_db("stockmanagement",$cn) or die("Note: " . mysql_error());
					
					$res_supplier=mysql_query("select * from supplierlist;") or die("Note: " . mysql_error());
				?>
				
					<option  style="font-size:14px" value="Select Item" > Select Supplier </option>
					
					<?php
						while($row = mysql_fetch_array($res_supplier))
						{
							echo "<option style=\"font-size:14px\"  value=" .$row['supplierName'] . ">" . $row['supplierName'] . "</option>";
						}
					echo "</select> "
					?>
</td>
</tr>
</table>
				
		
	
			<table  align="center" style="margin: 0px auto;">
		<tr>
		<td style="text-align:center;">
					<input style="height:50px; font-weight:700 ;  padding: 0 10px;  border-radius: 5px;  background-color: rgb(242, 242, 242);
					box-shadow: 1px -3px 5px rgba(0, 0, 0, 0.5) inset;font-size: 17px;line-height: 1.38;letter-spacing: 1px;color: rgb(0, 0, 0);margin:30px;padding:10px; "
					placeholder="Unit Price" type="text">
				</td>
		<td style="text-align:center;">
					<input style="height:50px; font-weight:700 ;  padding: 0 10px;  border-radius: 5px;  background-color: rgb(242, 242, 242);
					box-shadow: 1px -3px 5px rgba(0, 0, 0, 0.5) inset;font-size: 17px;line-height: 1.38;letter-spacing: 1px;color: rgb(0, 0, 0);margin:30px;padding:10px; "
					placeholder="Unit Price" type="text">
				</td>
	<td style="text-align:center;">
					<input style="height:50px; font-weight:700 ;  padding: 0 10px;  border-radius: 5px;  background-color: rgb(242, 242, 242);
					box-shadow: 1px -3px 5px rgba(0, 0, 0, 0.5) inset;font-size: 17px;line-height: 1.38;letter-spacing: 1px;color: rgb(0, 0, 0);margin:30px;padding:10px; "
					placeholder="Unit Price" type="text">
				</td>
		</tr>
		<tr>
		<td style="text-align:center;" colspan="4">
					<input style="height:50px; font-weight:700 ;  padding: 0 10px;  border-radius: 5px;  background-color: rgb(242, 242, 242);
					box-shadow: 1px -3px 5px rgba(0, 0, 0, 0.5) inset;font-size: 17px;line-height: 1.38;letter-spacing: 1px;color: rgb(0, 0, 0);margin:30px;padding:10px; "
					placeholder="Unit Price" type="text">
				
		</tr>
		</table>
			</div>
		</div>
	  <a href="#popDiv"> <button onClick="pop('popDiv')" class="_button "  type="submit"><span class="placeholder">Submit</span></button></a>
    </div>
	
  </div>
  
  <footer style="margin-top:3%;" class="_container _container-4 clearfix">
    <p class="text _text text-4">Developed By AndroSemantic - Trail Verson</p>
  </footer>

  <script src="js/jquery-min.js"></script>
  <script src="js/rimages.js"></script>
</body>
</html>