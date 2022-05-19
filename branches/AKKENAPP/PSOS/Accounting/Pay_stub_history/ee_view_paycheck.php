<?php
    ini_set('memory_limit', '-1');
	ob_start();
   include("pdffont/pdffontbase.php"); 
	require_once("global.inc");
	
	require_once("paystub_history/class.paystub.php");
	$paycheck = new paycheck_print();
	
	//$prhsno = explode(',',$prhsnos);
	//$pcount = count($prhsno);
	function numberTowords($num)
{ 
$ones = array( 
1 => "one", 
2 => "two", 
3 => "three", 
4 => "four", 
5 => "five", 
6 => "six", 
7 => "seven", 
8 => "eight", 
9 => "nine", 
10 => "ten", 
11 => "eleven", 
12 => "twelve", 
13 => "thirteen", 
14 => "fourteen", 
15 => "fifteen", 
16 => "sixteen", 
17 => "seventeen", 
18 => "eighteen", 
19 => "nineteen" 
); 
$tens = array( 
1 => "ten",
2 => "twenty", 
3 => "thirty", 
4 => "forty", 
5 => "fifty", 
6 => "sixty", 
7 => "seventy", 
8 => "eighty", 
9 => "ninety" 
); 
$hundreds = array( 
"hundred", 
"thousand", 
"million", 
"billion", 
"trillion", 
"quadrillion" 
); //limit t quadrillion 
$num = number_format($num,2,".",","); 
$num_arr = explode(".",$num); 
$wholenum = $num_arr[0]; 
$decnum = $num_arr[1]; 
$whole_arr = array_reverse(explode(",",$wholenum)); 
krsort($whole_arr); 
$rettxt = ""; 
foreach($whole_arr as $key => $i){ 
if($i < 20){ 
$rettxt .= $ones[$i]; 
}elseif($i < 100){ 
$rettxt .= $tens[substr($i,0,1)]; 
$rettxt .= " ".$ones[substr($i,1,1)]; 
}else{ 
$rettxt .= $ones[substr($i,0,1)]." ".$hundreds[0]; 
$rettxt .= " ".$tens[substr($i,1,1)]; 
$rettxt .= " ".$ones[substr($i,2,1)]; 
} 
if($key > 0){ 
$rettxt .= " ".$hundreds[$key]." "; 
} 
} 
if($decnum > 0){ 
$rettxt .= " and "; 
if($decnum < 20){ 
$rettxt .= $ones[$decnum]; 
}elseif($decnum < 100){ 
$rettxt .= $tens[substr($decnum,0,1)]; 
$rettxt .= " ".$ones[substr($decnum,1,1)]; 
} 
} 
return $rettxt; 
} 

	?>
	
<!DOCTYPE html>
<html>
<title>Employee View of Paycheck</title>
<head>
<style>

tr { page-break-inside: avoid !important; }

tr.border_bottom td {
  border-bottom: 1px solid black;
}
.fs-13{
	font-size:13px !important;
}
.fs-12{
	font-size:10px !important;
}
.text-right{
	text-align:right !important;
}


</style>
</head>
<body>
<?php

$checkprhsno = "SELECT batchid,empid FROM prhmaster WHERE sno='{$prhsno}'";
	$checkprhsnoqry = mysql_query($checkprhsno,$db);
	$checkprhsnores = mysql_fetch_row($checkprhsnoqry);
	$bid = $checkprhsnores[0];
	$sno = $checkprhsnores[1];

	$hrow = $paycheck->get_paycheck_header($bid,$sno);
	//print_r($hrow);
	$erow = $paycheck->get_paycheck_earnings($bid,$sno);
	
	$trow = $paycheck->get_paycheck_tax($bid,$sno);
	
	$drow = $paycheck->get_paycheck_deduction($bid,$sno);
	
	$grow = $paycheck->get_paycheck_garnishments($bid,$sno);
	
	$crow = $paycheck->get_paycheck_contributions($bid,$sno);
	
	$brow = $paycheck->get_paycheck_batches($bid);
	
	?>
	<table width="100%" border="0">
      <tbody>
       <tr>
          <td width="100%" valign="top">
            <table width="100%" border="0">
              <tbody>
                <tr>
                  <td width="2%" align="left">
                    
                  </td>
                  <td width="67%" align="right">
                  <table width="100%" border="0">
                      <tbody>
					  <tr>
                          <td width="100%" colspan="2" valign="top" align="right" style="font-size:13px;"><?php echo $brow["paydate"];?></td>
					  </tr>
					  <tr>
                          <td width="100%" colspan="2">&nbsp;</td>
					  </tr>
                        <tr>
                          <td width="50%" valign="top" class="fs-13">
						  
                    <?php echo $hrow["empname"];?>
                    <br><br>
					<?php if($hrow["paymethod"] == 'DirectDeposit') {?>
					****This is not a Check.***Adivce of deposit only*****
					<br>
					<?php } else {
						echo strtoupper(numberTowords(number_format($hrow["netamount"],2,".","")));
					} 
					?>
                    
                    <br><br>
					 <?php echo $hrow["empname"];?>
					 <br>
                    <?php echo $hrow["empaddress1"]; ?>
					<br>
					<?php echo $hrow["empcity"];?>,<?php echo $hrow["state_name"];?>,<?php echo $hrow["empzipcode"];?>
					<br>
					Pay Period : <?php echo $brow["paysdate"].' - '.$brow["payedate"];?>
                  </td>
				  <td valign="top" class="text-right fs-13">
				  <?php  
				  if($hrow["paymethod"] == 'DirectDeposit') {
					  echo '0.00<br>***** NON-NEGOTIABLE*****';
				  }else{
				  echo (!empty($hrow["netamount"]))?number_format($hrow["netamount"],2,".",""):'';
				  }?></td>
                  
		</tr>
                      </tbody>
                    </table>
               </td>		  
                </tr>
              </tbody>
            </table>
          </td>
        </tr>
        
        <tr>
          <td width="100%" valign="top" style="padding-top:100px;">
            <table width="100%" border="0">
              <tbody>
                <tr>
				<td width="18%" valign="top">
                  </td>
                  <td width="40%" valign="top" >
                    <!--<strong>Earnings</strong>-->
                  </td>
                  <td width="2%"></td>
                  <td width="40%" valign="top" >
                    <!--<strong>Taxes</strong>-->
                  </td>
                  <!--<td width="5%"></td>
                  <td width="30%" valign="top" >
                    <strong>Deductions</strong>
                  </td>-->
                </tr>
                <tr>
				<td width="18%" class="fs-12" valign="top">
                    <?php echo $hrow["empname"];?>
                    <br>
                    <?php echo $hrow["empaddress1"]; ?>
		    <br>
					<?php echo $hrow["empcity"];?>
					<br>
					<?php echo $hrow["state_name"];?>
					<br>
					<?php echo $hrow["empzipcode"];?>
                  </td>
                  <td width="40%" valign="top">
                    <table class="fs-12" width="100%" cellspacing="0" cellpadding="0">
                      <tr class="border_bottom">
                        <td >
                           <strong>Pay</strong>
                        </td>
                        <td align="right">
                           <strong>Hours</strong>
                        </td>
                        <td align="right">
                           <strong>($)Rate</strong>
                        </td>
                        <td >
                           <strong></strong>
                        </td>
						<td align="right">
                           <strong>YTD</strong>
                        </td>
                        <!-- <td>
                          YTD Hours
                        </td>
                       <td>
                          ($) YTD Total Pay
                        </td>-->
                      </tr>
                      <?php 
				  $eamount=0;
				  $ytdeamount=0;
                   while($etrow=mysql_fetch_array($erow))
				   {	
				    if(count($etrow) >0){
				    
						 $eamount= $eamount+ $etrow["amount"];
						 $ytdeamount= $ytdeamount+ $etrow["ytd_amount"];
				   ?>
                  <tr>
                     <td><?php echo $etrow["type"];?></td>
                     <td align="right"><?php echo $etrow["hours"];?></td>
                     <td align="right"><?php echo number_format($etrow["rate"],2,".","");?></td>
                     <td align="right"><?php echo number_format($etrow["amount"],2,".","");?></td>
					  <td align="right"><?php echo number_format($etrow["ytd_amount"],2,".","");?></td>
                  </tr>
				   <?php  
                   }else{ ?>
					    <tr><td colspan="4" align="center">No Data</td></tr>
					   
				   <?php } 
				   }?>
                     
                      <!--<tr style="outline: thin solid">
							<td ><b>Gross pay</b></font></td>
							<td >&nbsp;</td>
							<td >&nbsp;</td>
							<td >$ <?php echo number_format($eamount,2,".","");?></td>
                      </tr>-->
                    </table>
                  </td>
                  <td width="2%"></td>
                  <td width="40%" valign="top">
                    <table class="fs-12" width="100%"cellspacing="0" cellpadding="0">
                      <tbody>
                        <tr class="border_bottom">
                          <td>
                            <strong>Taxes</strong>
                          </td>
                          <td align="right">
                            <strong>Current</strong>
                          </td>
                          <td align="right">
                           <strong>YTD<strong>
                          </td>
                        </tr>
                        <?php 
						   $tamount = 0;
						   $ytdtamount = 0;
						   while($ttrow=mysql_fetch_array($trow)){
							if(count($ttrow) >0){
						  
							
								 $tamount = $tamount+$ttrow["taxamount"];
								 $ytdtamount = $ytdtamount+$ttrow["ytd_taxamount"];
						   ?>
						  <tr>
							 <td><?php echo $ttrow["taxname"];?></td>
							 <td align="right"><?php echo $ttrow["taxamount"];?></td>
							 <td align="right"><?php echo $ttrow["ytd_taxamount"];?></td>
						   
						   
						  </tr>
						   <?php  
						   }else{ ?>
						   <tr><td colspan="2" align="center">No Data.</td></tr>
							   
						   <?php } }?>
				  
                        
                        <!--<tr style="outline: thin solid">
                           <td ><b>Total</b></td>
                   
                           <td  >$ <?php echo $tamount;?></td>
                        </tr>-->
                      </tbody>
                    </table>
                  </td>
                </tr>
             <tr>
			 <td colspan="4" style="padding-top:10px;" width="18%"></td>
			 </tr>
                <tr>
				<td class="fs-12" width="18%">
					<b><?php echo $brow["ername"];?></b>
                            <br>
                           <?php echo $brow["eraddress1"];?>
                            <br>
                           <?php echo $brow["ercity"];?> <?php echo $brow["er_state"];?> <?php echo $brow["erzipcode"];?>
                            <br>
                            <?php echo $brow["erphone"];?>
											
				</td>
				<td width="40%">
                     <table class="fs-12" width="100%"cellspacing="0" cellpadding="0">
                      <tbody>
                        <tr class="border_bottom">
                          <td>
                            <strong>Garnishments</strong>
                          </td>
                          <td align="right">
                            <strong>Current</strong>
                          </td>
						  <td align="right">
                           <strong>YTD<strong>
                          </td>
                        </tr>
							<?php 
					  $gamount = 0;
					  $ytdgamount = 0;
					   while($gtrow=mysql_fetch_array($grow)){
					  if(count($gtrow) >0){
					  
					   
							 $gamount = $gamount+$gtrow["dedamount"];
							 $ytdgamount = $ytdgamount+$gtrow["ytd_dedamount"];
					   ?>
					  <tr>
						<td ><?php echo $gtrow["dedname"];?></td>
						 <td align="right"><?php echo $gtrow["dedamount"];?></td>
					   <td align="right" ><?php echo $gtrow["ytd_dedamount"];?></td>
					  </tr>
					   <?php  
					   }else{ ?>
							<tr><td colspan="3" align="center">No Data</td></tr>
						   
					   <?php } }?>
							<!--<tr style="outline: thin solid">
							   <td align="left" ><b>Total</b></td>
					   
						 <td>$ <?php echo $gamount; ?></td>
						 <td align="right" ></td>
						
							</tr>-->
						  </tbody>
						</table>
                 </td>
                  <td width="2%"></td>
                  <td width='40%' valign="top">
                    <table class="fs-12" width="100%"cellspacing="0" cellpadding="0">
                      <tbody>
                        <tr class="border_bottom">
                          <td>
                            <strong>Deductions</strong>
                          </td>
                          <td align="right">
                            <strong>Current</strong>
                          </td>
						  <td align="right">
                           <strong>YTD<strong>
                          </td>
                        </tr>
                        <?php 
				  $damount = 0;
				  $ytddamount = 0;
                   while($dtrow=mysql_fetch_array($drow)){
				  if(count($dtrow) >0){
				  
				   
						 $damount = $damount+$dtrow["dedamount"];
						 $ytddamount = $ytddamount+$dtrow["ytd_dedamount"];
				   ?>
                  <tr>
                    <td ><?php echo $dtrow["dedname"];?></td>
                     <td align="right"><?php echo $dtrow["dedamount"];?></td>
                   <td align="right" ><?php echo $dtrow["ytd_dedamount"];?></td>
                  </tr>
				   <?php  
				   }else{ ?>
					    <tr><td colspan="3" align="center">No Data</td></tr>
					   
				   <?php } }?>
                        <!--<tr style="outline: thin solid">
                           <td align="left" ><b>Total</b></td>
                   
                     <td>$ <?php echo $damount; ?></td>
					 <td align="right" ></td>					 
                        </tr>-->
                      </tbody>
                    </table>
                  </td>
                </tr>
				<tr>
				<td colspan="4" style="padding-top:10px;" width="100%"></td>
				</tr>
				<tr>
				<td class="fs-12" width="18%">
					
							<b>Pay Period</b><br><?php echo $brow["paysdate"].' - '.$brow["payedate"];?>
							<br><br>
							<b>Pay Date</b><br><?php echo $brow["paydate"];?>
				
				</td>
				<td width="40%" valign="top">
                    <table class="fs-12" width="100%"cellspacing="0" cellpadding="0">
                      <tbody>
                        <tr class="border_bottom">
                          <td>
                            <strong>ER Contributions</strong>
                          </td>
                          <td align="right">
                            <strong>Used</strong>
                          </td>
						  <td align="right">
                           <strong>Available<strong>
                          </td>
                        </tr>
                        <?php 
				  $camount = 0;
				  $ytdcamount = 0;
                   while($ctrow=mysql_fetch_array($crow)){
				  if(count($ctrow) >0){
				  
				   
						 $camount = $camount+$ctrow["dedamount"];
						 $ytdcamount = $ytdcamount+$ctrow["ytd_dedamount"];
				   ?>
                  <tr>
                    <td ><?php echo $ctrow["dedname"];?></td>
                     <td align="right"><?php echo $ctrow["dedamount"];?></td>
                   <td align="right" ><?php echo $ctrow["ytd_dedamount"];?></td>
                  </tr>
				   <?php  
				   }else{ ?>
					    <tr><td colspan="3" align="center">No Data</td></tr>
					   
				   <?php } }?>
                        <!--<tr style="outline: thin solid">
                           <td align="left" ><b>Total</b></td>
                   
                     <td>$ <?php echo $camount; ?></td>
					 <td align="right" ></td>
					 
                        </tr>-->
                      </tbody>
                    </table>
                  </td>
				 <td width="2%">
				 </td>
				  <td width="40%">
					<table class="fs-12" width="100%" style="border:1px solid #000;border-collapse:collapse;">
					<tr style="border: 1px solid #000;"><th align="left"><b>Summery</b></th><th align="right"><b>Current</b></th><th align="right"><b>YTD</b></th></tr>
					<tr><td><b>Total Earnings:</b></td><td align="right"><?php echo '$'.number_format($eamount,2,".",""); ?></td><td align="right"><?php echo '$'.number_format($ytdeamount,2,".",""); ?></td></tr>
                    <tr><td><b>Total Tax:</b></td><td align="right"><?php echo '$'.number_format($tamount,2,".",""); ?></td><td align="right"><?php echo '$'.number_format($ytdtamount,2,".","");?></td></tr>
					<tr><td><b>Total Deduction:</b></td><td align="right"><?php echo '$'.number_format($damount,2,".",""); ?> </td><td align="right"> <?php echo '$'.number_format($ytddamount,2,".",""); ?></td></tr>
					</table>
					<table class="fs-12" width="100%" style="border-collapse:collapse;">
					<tr><th align="left">
					<span style="float:left;"><b>NET PAY:</b></span></th><td><span style="float:right;"><b><?php  echo (!empty($hrow["netamount"]))?'$'.number_format($hrow["netamount"],2,".",""):'';?></b></span></td>
					</tr>
					</table>
				  </td>
				  
                </tr>
				<tr><td width="18%" align="left" valign="top">
                            
                     </td>
					 <td colspan="3"></td>
					 </tr>
              </tbody>
            </table>
		</td>
		</tr>
        <tr>
          <td valign="top" style="padding-top:0px">
            <table class="fs-12" width="100%"  >
	            <tbody>
                  <tr>
                <td width="75%"><b>MEMO:</b></td>
                <td width="25%" align="right">
				
				  
                </td>
              </tr>
			  <tr><td width="75%"></td><td>
			  
			  </td></tr>
                </tbody>
            </table>
          </td>
        </tr>
      </tbody>
    </table>
	<?php
$hrow = $paycheck->get_paycheck_header($bid,$sno);
	//print_r($hrow);
	$erow = $paycheck->get_paycheck_earnings($bid,$sno);
	
	$trow = $paycheck->get_paycheck_tax($bid,$sno);
	
	$drow = $paycheck->get_paycheck_deduction($bid,$sno);
	
	$grow = $paycheck->get_paycheck_garnishments($bid,$sno);
	
	$crow = $paycheck->get_paycheck_contributions($bid,$sno);
	
	$brow = $paycheck->get_paycheck_batches($bid);
	?>
	<table width="100%" border="0">
      <tbody>
       
        <tr>
          <td width="100%" valign="top" style="padding-top:50px;">
            <table width="100%" border="0">
              <tbody>
                <tr>
				<td width="18%" valign="top">
                  </td>
                  <td width="40%" valign="top" >
                    <!--<strong>Earnings</strong>-->
                  </td>
                  <td width="2%"></td>
                  <td width="40%" valign="top" >
                    <!--<strong>Taxes</strong>-->
                  </td>
                  <!--<td width="5%"></td>
                  <td width="30%" valign="top" >
                    <strong>Deductions</strong>
                  </td>-->
                </tr>
                <tr>
				<td width="18%" class="fs-12" valign="top">
                    <?php echo $hrow["empname"];?>
                    <br>
                    <?php echo $hrow["empaddress1"]; ?>
		    <br>
					<?php echo $hrow["empcity"];?>
					<br>
					<?php echo $hrow["state_name"];?>
					<br>
					<?php echo $hrow["empzipcode"];?>
                  </td>
                  <td width="40%" valign="top">
                    <table class="fs-12" width="100%" cellspacing="0" cellpadding="0">
                      <tr class="border_bottom">
                        <td >
                           <strong>Pay</strong>
                        </td>
                        <td align="right">
                           <strong>Hours</strong>
                        </td>
                        <td align="right">
                           <strong>($)Rate</strong>
                        </td>
                        <td >
                           <strong></strong>
                        </td>
						<td align="right">
                           <strong>YTD</strong>
                        </td>
                        <!-- <td>
                          YTD Hours
                        </td>
                       <td>
                          ($) YTD Total Pay
                        </td>-->
                      </tr>
                      <?php 
				  $eamount=0;
				  $ytdeamount=0;
                   while($etrow=mysql_fetch_array($erow))
				   {	
				    if(count($etrow) >0){
				    
						 $eamount= $eamount+ $etrow["amount"];
						 $ytdeamount= $ytdeamount+ $etrow["ytd_amount"];
				   ?>
                  <tr>
                     <td><?php echo $etrow["type"];?></td>
                     <td align="right"><?php echo $etrow["hours"];?></td>
                     <td align="right"><?php echo number_format($etrow["rate"],2,".","");?></td>
                     <td align="right"><?php echo number_format($etrow["amount"],2,".","");?></td>
					  <td align="right"><?php echo number_format($etrow["ytd_amount"],2,".","");?></td>
                  </tr>
				   <?php  
                   }else{ ?>
					    <tr><td colspan="4" align="center">No Data</td></tr>
					   
				   <?php } 
				   }?>
                     
                      <!--<tr style="outline: thin solid">
							<td ><b>Gross pay</b></font></td>
							<td >&nbsp;</td>
							<td >&nbsp;</td>
							<td >$ <?php echo number_format($eamount,2,".","");?></td>
                      </tr>-->
                    </table>
                  </td>
                  <td width="2%"></td>
                  <td width="40%" valign="top">
                    <table class="fs-12" width="100%"cellspacing="0" cellpadding="0">
                      <tbody>
                        <tr class="border_bottom">
                          <td>
                            <strong>Taxes</strong>
                          </td>
                          <td align="right">
                            <strong>Current</strong>
                          </td>
                          <td align="right">
                           <strong>YTD<strong>
                          </td>
                        </tr>
                        <?php 
						   $tamount = 0;
						   $ytdtamount = 0;
						   while($ttrow=mysql_fetch_array($trow)){
							if(count($ttrow) >0){
						  
							
								 $tamount = $tamount+$ttrow["taxamount"];
								 $ytdtamount = $ytdtamount+$ttrow["ytd_taxamount"];
						   ?>
						  <tr>
							 <td><?php echo $ttrow["taxname"];?></td>
							 <td align="right"><?php echo $ttrow["taxamount"];?></td>
							 <td align="right"><?php echo $ttrow["ytd_taxamount"];?></td>
						   
						   
						  </tr>
						   <?php  
						   }else{ ?>
						   <tr><td colspan="2" align="center">No Data.</td></tr>
							   
						   <?php } }?>
				  
                        
                        <!--<tr style="outline: thin solid">
                           <td ><b>Total</b></td>
                   
                           <td  >$ <?php echo $tamount;?></td>
                        </tr>-->
                      </tbody>
                    </table>
                  </td>
                </tr>
             <tr>
			 <td colspan="4" style="padding-top:10px;"></td>
			 </tr>
                <tr>
				<td class="fs-12" width="18%">
					<b><?php echo $brow["ername"];?></b>
                            <br>
                           <?php echo $brow["eraddress1"];?>
                            <br>
                           <?php echo $brow["ercity"];?> <?php echo $brow["er_state"];?> <?php echo $brow["erzipcode"];?>
                            <br>
                            <?php echo $brow["erphone"];?>
											
				</td>
				<td width="40%">
                     <table class="fs-12" width="100%"cellspacing="0" cellpadding="0">
                      <tbody>
                        <tr class="border_bottom">
                          <td>
                            <strong>Garnishments</strong>
                          </td>
                          <td align="right">
                            <strong>Current</strong>
                          </td>
						  <td align="right">
                           <strong>YTD<strong>
                          </td>
                        </tr>
							<?php 
					  $gamount = 0;
					  $ytdgamount = 0;
					   while($gtrow=mysql_fetch_array($grow)){
					  if(count($gtrow) >0){
					  
					   
							 $gamount = $gamount+$gtrow["dedamount"];
							 $ytdgamount = $ytdgamount+$gtrow["ytd_dedamount"];
					   ?>
					  <tr>
						<td ><?php echo $gtrow["dedname"];?></td>
						 <td align="right"><?php echo $gtrow["dedamount"];?></td>
					   <td align="right" ><?php echo $gtrow["ytd_dedamount"];?></td>
					  </tr>
					   <?php  
					   }else{ ?>
							<tr><td colspan="3" align="center">No Data</td></tr>
						   
					   <?php } }?>
							<!--<tr style="outline: thin solid">
							   <td align="left" ><b>Total</b></td>
					   
						 <td>$ <?php echo $gamount; ?></td>
						 <td align="right" ></td>
						
							</tr>-->
						  </tbody>
						</table>
                 </td>
                  <td width="2%"></td>
                  <td width='40%' valign="top">
                    <table class="fs-12" width="100%"cellspacing="0" cellpadding="0">
                      <tbody>
                        <tr class="border_bottom">
                          <td>
                            <strong>Deductions</strong>
                          </td>
                          <td align="right">
                            <strong>Current</strong>
                          </td>
						  <td align="right">
                           <strong>YTD<strong>
                          </td>
                        </tr>
                        <?php 
				  $damount = 0;
				  $ytddamount = 0;
                   while($dtrow=mysql_fetch_array($drow)){
				  if(count($dtrow) >0){
				  
				   
						 $damount = $damount+$dtrow["dedamount"];
						 $ytddamount = $ytddamount+$dtrow["ytd_dedamount"];
				   ?>
                  <tr>
                    <td ><?php echo $dtrow["dedname"];?></td>
                     <td align="right"><?php echo $dtrow["dedamount"];?></td>
                   <td align="right" ><?php echo $dtrow["ytd_dedamount"];?></td>
                  </tr>
				   <?php  
				   }else{ ?>
					    <tr><td colspan="3" align="center">No Data</td></tr>
					   
				   <?php } }?>
                        <!--<tr style="outline: thin solid">
                           <td align="left" ><b>Total</b></td>
                   
                     <td>$ <?php echo $damount; ?></td>
					 <td align="right" ></td>					 
                        </tr>-->
                      </tbody>
                    </table>
                  </td>
                </tr>
				<tr>
				<td colspan="4" style="padding-top:10px;" width="100%"></td>
				</tr>
				<tr>
				<td class="fs-12" width="18%">
					
							<b>Pay Period</b><br><?php echo $brow["paysdate"].' - '.$brow["payedate"];?>
							<br><br>
							<b>Pay Date</b><br><?php echo $brow["paydate"];?>
				
				</td>
				<td width="40%" valign="top">
                    <table class="fs-12" width="100%"cellspacing="0" cellpadding="0">
                      <tbody>
                        <tr class="border_bottom">
                          <td>
                            <strong>ER Contributions</strong>
                          </td>
                          <td align="right">
                            <strong>Used</strong>
                          </td>
						  <td align="right">
                           <strong>Available<strong>
                          </td>
                        </tr>
                        <?php 
				  $camount = 0;
				  $ytdcamount = 0;
                   while($ctrow=mysql_fetch_array($crow)){
				  if(count($ctrow) >0){
				  
				   
						 $camount = $camount+$ctrow["dedamount"];
						 $ytdcamount = $ytdcamount+$ctrow["ytd_dedamount"];
				   ?>
                  <tr>
                    <td ><?php echo $ctrow["dedname"];?></td>
                     <td align="right"><?php echo $ctrow["dedamount"];?></td>
                   <td align="right" ><?php echo $ctrow["ytd_dedamount"];?></td>
                  </tr>
				   <?php  
				   }else{ ?>
					    <tr><td colspan="3" align="center">No Data</td></tr>
					   
				   <?php } }?>
                        <!--<tr style="outline: thin solid">
                           <td align="left" ><b>Total</b></td>
                   
                     <td>$ <?php echo $camount; ?></td>
					 <td align="right" ></td>
					 
                        </tr>-->
                      </tbody>
                    </table>
                  </td>
				 <td width="2%">
				 </td>
				  <td width="40%">
					<table class="fs-12" width="100%" style="border:1px solid #000;border-collapse:collapse;">
					<tr style="border: 1px solid #000;"><th align="left"><b>Summery</b></th><th align="right"><b>Current</b></th><th align="right"><b>YTD</b></th></tr>
					<tr><td><b>Total Earnings:</b></td><td align="right"><?php echo '$'.number_format($eamount,2,".",""); ?></td><td align="right"><?php echo '$'.number_format($ytdeamount,2,".",""); ?></td></tr>
                    <tr><td><b>Total Tax:</b></td><td align="right"><?php echo '$'.number_format($tamount,2,".",""); ?></td><td align="right"><?php echo '$'.number_format($ytdtamount,2,".","");?></td></tr>
					<tr><td><b>Total Deduction:</b></td><td align="right"><?php echo '$'.number_format($damount,2,".",""); ?> </td><td align="right"> <?php echo '$'.number_format($ytddamount,2,".",""); ?></td></tr>
					</table>
					<table class="fs-12" width="100%" style="border-collapse:collapse;">
					<tr><th align="left">
					<span style="float:left;"><b>NET PAY:</b></span></th><td><span style="float:right;"><b><?php  echo (!empty($hrow["netamount"]))?'$'.number_format($hrow["netamount"],2,".",""):'';?></b></span></td>
					</tr>
					</table>
				  </td>
				  
                </tr>
				<tr><td width="18%" align="left" valign="top">
                            
                     </td>
					 <td colspan="3"></td>
					 </tr>
              </tbody>
            </table>
		</td>
		</tr>
        <tr>
          <td valign="top" style="padding-top:0px">
            <table class="fs-12" width="100%"  >
	            <tbody>
                  <tr>
                <td width="75%"><b>MEMO:</b></td>
                <td width="25%" align="right">
				
				  
                </td>
              </tr>
			  <tr><td width="75%"></td><td>
			  
			  </td></tr>
                </tbody>
            </table>
          </td>
        </tr>
      </tbody>
    </table>	
</body>
		
	<?php	
	/*$html = ob_get_contents();
	ob_end_clean();
	$filename = $hrow['ee_id']."_".str_replace("/","",$hrow['pay_date']);
	
    $target_file = $filename.'_paystub.pdf';	
	
    $mpdf=new mPDF('utf-8', 'A4-L', '10.5', 'courier', 15, 15, 10, 10, 9, 9, 'L');
    
	$mpdf->SetDisplayMode('fullpage');
	
	$mpdf->shrink_tables_to_fit = 1;
                                     
	
	$mpdf->WriteHTML($html);	
	
	$mpdf->Output($target_file, 'I');
	exit;
	
	*/
	$filename = $hrow['empid']."_".str_replace("/","",$hrow['datehire']);
	$landscape_mode=1;
    $target_file = $filename.'_paystub.pdf';
	$html_content = ob_get_contents();
ob_end_clean();
//require("wkHTMLPDF.php");

	$html_content = preg_replace('/>\s+</', "><", $html_content);

	$temp_dir=$WDOCUMENT_ROOT."/wkpdf";
	$temp_file=md5(time());

	if(!is_dir($temp_dir))
		mkdir($temp_dir);

	$html_file=$temp_dir."/".$temp_file.".html";
	$pdf_file=$temp_dir."/".$temp_file.".pdf";
	
	file_put_contents($html_file,$html_content);

	exec("wkhtmltopdf --encoding iso-8859-1 -O portrait --margin-top 1cm --margin-left 1cm --margin-bottom 1cm --margin-right 1cm --footer-font-name arial --footer-font-size 4  ".$html_file." ".$pdf_file);

	
$filename1 = filesize($pdf_file);
header("Cache-Control: private");
header('Content-type: application/pdf');
header("Content-Length: ".$filename1);
header('Content-Disposition: inline; filename="'.$target_file."'");
@readfile($pdf_file);
unlink($isDirEx."/".$head); // Added By Rayudu on 31/12/2008 to delete the created header temp image from the server. 
unlink($isDirEx."/".$foot); // Added By Rayudu on 31/12/2008 to delete the created footer temp image from the server. 
unlink($html_file);
unlink($pdf_file);
	
	
		?>
	</html>	
