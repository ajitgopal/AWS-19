<?php 
	require("global.inc");
	//require("functions.php");
	//require("dispfunc.php");
	/*$xajax = new xajax();
	$xajax->registerExternalFunction(array("gridData","gridData","getPayStubHistory"),"gridData.inc");
	$xajax->processRequests();*/

	$XAJAX_ON="YES";
	$XAJAX_MOD="PayStubHistory";
	
	global $db;
	$GridHS	= true;
	
	require("Menu.inc");
	$menu=new EmpMenu(); 
	require_once($akken_psos_include_path.'commonfuns.inc'); 
	//check for page access ,if no access then redirect to home
	
	    $que = "SELECT accounting FROM sysuser WHERE username = '".$username."'";		
		$res = mysql_query($que,$db);
		$row = mysql_fetch_row($res);
		
		if (strpos($row[0], '+6+') == false) {
			
			 
			 print "<script>alert('You have no access to this page.');window.location.href = '/BSOS/Home/home.php';</script>";
			 
		}
	

	//require("activewidgets.php");

	/*if(!isset($val) || $val == "")
	{
	   $thisday2=mktime(date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"));
	   $servicedateto=date("m/d/Y",$thisday2);
	
    	$zque="SELECT ".tzRetQueryStringDate('MIN(par_expense.sdate)','Date','/').", ".tzRetQueryStringDate('MAX(par_expense.edate)','Date','/')." FROM par_expense LEFT JOIN expense ON par_expense.sno=expense.parid WHERE par_expense.astatus = 'ER' AND expense.status = 'ER'";
        $zres=mysql_query($zque,$db);
        $zrow=mysql_fetch_row($zres);
	 
        if ((is_null($zrow[0])) || (is_null($zrow[1])) )
        {
            $thisday1=mktime(date("H"),date("i"),date("s"),date("m"),date("d")-30,date("Y"));
            $servicedate=date("m/d/Y",$thisday1);
            $servicedateto=date("m/d/Y");
        }
        else
        {
            $zrow[0]=str_replace("-","/",$zrow[0]);
            $servicedate=$zrow[0];
            $servicedateto=$zrow[1];
        }
	}
	else
	{*/
	   if($val=="serv")
	   {
         $thisday1=$t1;
         $servicedate=date("m/d/Y",$t1);                 
         $servicedateto=$t2;
         $t21=explode("/",$t2);
         $thisday2= mktime (0,0,0,$t21[0],$t21[1],$t21[2]);
         $todaf=date("Y-m-d",$thisday2);
         $tod=date("Y-m-d",$t1);     
		 $sno=$addr1;       
       }
       else if($val=="servto")
       {
         $servicedate=$t1;                         
         $servicedateto=date("m/d/Y",$t2);  
         $t11=explode("/",$t1);
         $thisday1= mktime (0,0,0,$t11[0],$t11[1],$t11[2]);
         $todaf=date("Y-m-d",$t2);
         $tod=date("Y-m-d",$thisday1);
		 $sno=$addr1;
       }
	   else if($val=="0")
       {
         $servicedate=$t1;                         
         //$servicedateto=date("m/d/Y",$t2);  
		 $servicedateto=$t2;
         $t11=explode("/",$t1);
         $thisday1= mktime (0,0,0,$t11[0],$t11[1],$t11[2]);
         $todaf=date("Y-m-d",$t2);
         $tod=date("Y-m-d",$thisday1);
		 $sno=$addr1;
       }
	   else
	   {
	     /*$t11=explode("/",$servicedate);
	     $thisday1= mktime (0,0,0,$t11[0],$t11[1],$t11[2]);
         $tod=date("Y-m-d",$thisday1);
	     $t21=explode("/",$servicedateto);				 
		 $thisday2= mktime (0,0,0,$t21[0],$t21[1],$t21[2]);
         $todaf=date("Y-m-d",$thisday2);
		 */
		 $thisday=mktime(date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"));
	     $servicedateto=date("m/d/Y",$thisday);

	      $thisday=mktime(date("H"),date("i"),date("s"),date("m"),date("d")-30,date("Y"));
	      $servicedate=date("m/d/Y",$thisday);
	   }
   /// }
	/*$thisday=mktime(date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"));
	$servicedateto=date("m/d/Y",$thisday);

	$thisday=mktime(date("H"),date("i"),date("s"),date("m"),date("d")-30,date("Y"));
	$servicedate=date("m/d/Y",$thisday);*/
  	$menu->showHeader("accounting","Pay Stub History","6|");
?>
<link type="text/css" rel="stylesheet" href="/BSOS/css/ajax-tooltip.css">
<link rel="stylesheet" href="/BSOS/popupmessages/css/popup_message.css" media="screen" type="text/css">
<script type="text/javascript" src="/BSOS/popupmessages/scripts/popupMsgArray.js"></script>
<script type="text/javascript" src="/BSOS/popupmessages/scripts/popup-message.js"></script>
<!-- For New Calendar -->
<script type="text/javascript" src="/BSOS/scripts/calendar.js"></script>
<link rel="stylesheet" type="text/css" href="/BSOS/css/calendar.css">
<script src=/BSOS/scripts/date_format.js language=javascript></script>

<!-- For ModalBox PopUp -->
<link rel="stylesheet" type="text/css" media="screen" href="/BSOS/css/sphinx_modalbox.css" />
<script type="text/javascript" src="/BSOS/scripts/jquery-1.8.3.js"></script>
<script type="text/javascript" language="javascript" src="/BSOS/scripts/sphinx/jquery.modalbox.js"></script>
<script type="text/javascript" src="/BSOS/scripts/shift_schedule/jquery.modalbox.js"></script> 




<script language="javascript">
function openNewWindow()
{    
    
    /* id = gridActData[gridRowId][10];
	var v_width  = 1025;
	var v_heigth = 670;
	var top=(window.screen.availHeight-v_heigth)/2;
	var left=(window.screen.availWidth-v_width)/2;	
	remote=window.open("/BSOS/Accounting/Pay_stub_history/er_view_paycheck.php?sno="+id,"Department","width="+v_width+"px,height="+v_heigth+"px,statusbar=no,menubar=no,resizable=yes,scrollbars=yes,dependent=yes,left="+left+",top="+top);
	remote.focus(); */
	
	
}
function modalBoxClose()
{
	$().modalBox('close');
}
function kev(obj)
{
	//form=document.paystub_history;
	if(obj)
		var e=obj
	else
		var e = (document.forms["paystub_history"].ck) ? document.forms["paystub_history"].ck : document.getElementById("ck");
	if ( e.checked == true )
	{
		checkAll();
	}
	else
	{ 
		clearAll();
	}
}	

function checkAll()
{
	form=document.paystub_history;
	var e = document.getElementsByName("auids[]");
	for (var i=0; i < e.length; i++)
			e[i].checked = true;
}
function numSelected()
{
	var form=document.paystub_history;
	var e = document.getElementsByName("auids[]");
	var bNone = true;
	var iFound = 0;
	for (var i=0; i < e.length; i++) 
	{
		bNone = false;
		if (e[i].checked == true)
			iFound++;
	}
	if (bNone) 
	{
		iFound = -1;
	}
        
	return iFound;
}

function valSelected()
{
	var form=document.paystub_history;
	var e = document.getElementsByName("auids[]");
	var bNone = true;
	var iVal = "";
	for (var i=0; i < e.length; i++) 
	{
			bNone = false;
			if (e[i].checked == true)
				if(iVal=="")
					iVal=e[i].value;
				else
					iVal=iVal+","+e[i].value;
	}
	if (bNone) 
	{
		iVal = "";
	}
	return iVal;
}
function doExportPH()
{ 
	var form=document.paystub_history;
	numAddrs = numSelected();
	valAddrs = valSelected();
	
	if (numAddrs < 0) 
	{
		alert("There are no record selected to Export.");
		return;
	}
	else if (! numAddrs) 
	{
		alert("Select a record to Export.");
		return;
	}
	else if (numAddrs > 10) 
	{
		alert("You can Export only 10 records at a time.");//You can only save upto 20 Invoices At a Time.
		return;
	}
	var invaddr = valAddrs;
	document.getElementById("AllAddr").value = invaddr;
	form.action="export_paystub.php?addr="+invaddr;
	form.target = '';
	form.submit();
	clearAll();
	var  chkbox = document.getElementById('ck') ? document.getElementById('ck') : document.paystub_history.ck;
	if(chkbox.checked==true)
	{
		chkbox.checked=false;
	}	
}
function clearAll()
{
	form=document.paystub_history;
	var e = document.getElementsByName("auids[]");
	for (var i=0; i < e.length; i++) 
			e[i].checked = false;
}
function updateDeptList()
{
	var form=document.paystub_history;
	
	locid  = form.invlocation.value;
   
	DynCls_Ajax_result("filterDept.php?locid="+locid,"rtype","updateDept","refreshDeptList()");
	if(locid == 0){
		var refresh=true
		gridsearch(refresh); 
	}
}
function refreshDeptList()
{
	var form=document.paystub_history;
	var invdept = form.invdept;
	var current_ctrl = document.getElementById('department');

	invdept.length=0;

	var oOption = document.createElement("option");
	oOption.appendChild(document.createTextNode("ALL"));
	oOption.setAttribute("value","");
	current_ctrl.appendChild(oOption);

	if(DynCls_Ajx_responseTxt!="")
	{
		sdept = DynCls_Ajx_responseTxt.split("|akkenCSplit|");
		for(i=0;i<sdept.length;i++)
		{
			ssdept = sdept[i].split("|akkenPSplit|");
			var oOption = document.createElement("option");
			oOption.appendChild(document.createTextNode(ssdept[1]));
			oOption.setAttribute("value",ssdept[0]);
			current_ctrl.appendChild(oOption);
		} 
		
	}
}
function gridsearch(refresh){
	
	 
	 var form=document.paystub_history;
	 form.action="paystub_history.php";
	 fromDate=form.servicedate.value;
	 toDate=form.servicedateto.value;
	 document.getElementById('t1').value=fromDate;						
	 document.getElementById('t2').value=toDate;
     document.getElementById('val').value='0';	
	 locid  = form.invlocation.value;
	 if(locid == 0 && (refresh)){
	 document.getElementById('department').value='';	
	 }
	 //department=form.invdept.value;
     
     form.submit();
	
	
} 
</script>
<style>
.active-column-7 .active-box-resize{display: none;}
.active-column-7 {width: 100px;}
.active-column-1 {width: 150px;}
.active-column-4 {width: 180px;}
.fa.fa-calendar {margin-left: 5px;}
//.active-column-3,.active-column-4, .active-column-5 , .active-column-6,.active-column-7,.active-column-2,.active-column-1 {text-align: left;}
.left-margin{padding: 10px 0px 15px 20px !important;}
</style>
<script>
</script>

<form name=paystub_history method=post action=paystub_history.php>
<input type=hidden name=from id=from>
<input type=hidden name=addr id=addr>
<input type=hidden name=t1 id=t1>
<input type=hidden name=t2 id=t2>
<input type=hidden name=val id=val>	
<input type=hidden name=aa id=aa>	
<input type=hidden name=invdept id=invdept value=''>	

<input type="hidden" name="chkBoxsGrd" id="chkBoxsGrd" value="" />
<input type="hidden" name="AllAddr" id="AllAddr" value="" />
<div id="oque"></div>
<div id="tque"></div>
<div id="main">
	<td valign=top align=center class=tbldata>
		<table width=100% cellpadding=0 cellspacing=0 border=0 class="ProfileNewUI defaultTopRange">
		<div id="content">
		<tr>
		<td class="titleNewPad">
        <table width=100% cellpadding=0 cellspacing=0 border=0>
        	<tr>
    			<td colspan=2><font class=bstrip>&nbsp;</font></td>
		    </tr>
   			<tr>
                <td align=left><font class=modcaption>Pay Checks</font></td>
				
           		<td align=right>
				<font class=afontstyle>
				To view PayStubs of all employees for a specific pay date select From&nbsp;<input type=text size=10  maxlength="10" name=servicedate id=servicedate value="<?php echo $servicedate;?>">
				<script language='JavaScript'>new tcal ({'formname':window.form,'controlname':'servicedate'});</script>
				</font>
				<font class=afontstyle color=black>&nbsp;
				To&nbsp;<input type=text size=10 maxlength="10"  name=servicedateto id=servicedateto value="<?php echo $servicedateto;?>">
				<script language='JavaScript'>new tcal ({'formname':window.form,'controlname':'servicedateto'});</script>
				&nbsp;<a href=javascript:DateCheck('servicedate','servicedateto');>view</a>
				</font>
			</td>
		    </tr>
		</table>
        </td>
		</tr>
		<tr>
			<td colspan=2><font class=bstrip>&nbsp;</font></td>
			<td ><font class=bstrip>&nbsp;</font></td>
		</tr>
			<tr>
    			<td colspan=2><font class=bstrip>&nbsp;</font></td>
		    </tr>
		<tr class="left-margin">
	
                
				<td colspan="5" class="left-margin">
				    <font class=afontstyle>&nbsp;Select Location&nbsp;</font>
					<select name="invlocation" id="location" class=drpdwne style="width:175px" onChange="gridsearch(false);">
                      <option value="0" <?php echo getSel($invlocation,0);?>>ALL</option>
                      <?php
						//$lque = "SELECT serial_no, CONCAT(loccode,' - ',heading) FROM contact_manage ORDER BY loccode";
						$lque = "SELECT DISTINCT c.serial_no, CONCAT(c.loccode,' - ',c.heading) FROM contact_manage c, department d WHERE c.serial_no =d.loc_id  AND FIND_IN_SET(CONCAT('+','".$username."','+'),REPLACE(CONCAT('+',d.permission,'+'),',','+,+'))>0 AND d.status='Active' ORDER BY c.loccode";
						//$lque = "SELECT DISTINCT c.serial_no, CONCAT(c.loccode,' - ',c.heading) FROM contact_manage c, department d WHERE c.serial_no =d.loc_id AND FIND_IN_SET('".$username."',d.permission)>0 AND d.status='Active' ORDER BY c.loccode";
						$lres = mysql_query($lque,$db); 
						while($lrow = mysql_fetch_row($lres))
							print "<option value='".$lrow[0]."' ".getSel($invlocation,$lrow[0]).">".$lrow[1]."</option>";
						?>
                    </select>
                   <!-- <font class="afontstyle">&nbsp;in Department</font>
                    <select name="invdept" id="department" class=drpdwne style="width:175px" onChange="gridsearch(false);">
                      <option value="" <?php echo getSel($invdept,"");?>>ALL</option>
                      <?php
						if($invlocation!=0)
							$wcl = "  AND loc_id=$invlocation ";

						$dque = "SELECT sno, deptname,depcode FROM department WHERE  status='Active' AND FIND_IN_SET(CONCAT('+','".$username."','+'),REPLACE(CONCAT('+',permission,'+'),',','+,+'))>0 ".$wcl."  ORDER BY deptname";
						$dres = mysql_query($dque,$db);
						while($drow = mysql_fetch_row($dres)) 
							print "<option value='".$drow[2]."' ".getSel($invdept,$drow[2]).">".$drow[1]."</option>";
						?>
                    </select>-->
                    </td>
                </tr>
		
		<tr class="left-margin">
			<td class="left-margin" colspan=2><strong>Instructions</strong> :</td>
		</tr>
		<tr class="left-margin">
		
		   
			<td  colspan="2" class="left-margin">
			<div style="width:100%">
			      <div id="" class="afontstyle" style="width:50%">
			          <ul>
					    <li>By default, the pay date filter will be auto-populated with a period of past 1 month from the current date.</li>
						<li>The records will be filtered based on department only.</li>
						<li>Once the user selects the 'Location', the departments belong to that particular location will be displayed in the department dropdown.</li>
						<li>You can see only those locations & departments for which you have been assigned user permissions.</li>
						<li>To display the <strong>'Employer view'</strong> of  pay stub, please double click  on the record.  </li>
						
						</ul>
						
				</div><div id="" class="afontstyle" style="width:50%">
			          <ul>
					    <li>To display the <strong>'Employee view'</strong> of  pay stub, please click on the view icon (<i class='fa fa-eye' title='Employee View of Paystub'></i>).</li>
						<li>The search in the grid is a universal search and it does not depend on any filters.</li>
						<li>User can sort all columns except pay period.</li>
                        <li>To Export the pay stubs, we need to select the records and click on "Export to PDF" button. Only ten records can be exported at a time.</li>
						</ul>
						</div>
		</td>
		 
		</tr>
		</div>
		
		<div id="topheader">
		<tr class="NewGridTopBg">
		<?php
			
			$name=explode("|","fa-arrow-up~Export to &nbsp;PDF");
		    $link=explode("|","javascript:doExportPH();");
            $heading="user.gif~";
			$menu->showMainGridHeadingStrip1($name,$link,$heading);
		?>
		</tr>
		</div>
<?php
                $message="No Data Found";
            ?>
			
		<div id="grid_form">
		<tr>
		<td>    
          
		<script>
			var gridHeadCol = ["<label class='container-chk'><input type=checkbox name=chk id=chk onClick=kev(this,document.paystubhistory,'auids[]')><span class='checkmark'></span></label>","Employee Name","Employee ID","Batch ID","Pay Period","Pay Date","Gross Pay","Net Pay","","Reset"];
		
			 var gridHeadData = ["","<input class=gridserbox type=text name=aw-column1 id=aw-column1>","<input class=gridserbox type=text name=aw-column2 id=aw-column2>","<input class=gridserbox type=text name=aw-column3 id=aw-column3>","<input class=gridserbox type=hidden name=aw-column4 id=aw-column4 style='display:none'>","<input class=gridserbox type=text name=aw-column5 id=aw-column5>","<input class=gridserbox type=text name=aw-column6 id=aw-column6>","<input class=gridserbox type=text name=aw-column7 id=aw-column7>","<input class=gridserbox type=hidden name=aw-column7 id=aw-column8>","<input type=hidden id=aw-column9><a href=javascript:clearGridSearch(),doGridSearch('reset');><i class='fa fa-reply fa-lg' alt='Reset'></i></a>"];
			 
			var gridActCol = ["","","","","","","","",""];
			var gridActData = [];
			var gridValue = "paystub_history";
			gridForm=document.forms[0];
			gridSearchResetColumn="9|";
			gridSortCol=5;
			var gridSort = 'DESC';
			   
			gridExtraFields=new Array();
			gridExtraFields['invloc']="<? echo  $invlocation; ?>";
		    gridExtraFields['invdept']="<? echo  $invdept; ?>";
			gridExtraFields['servicedate']="<? echo  $servicedate; ?>";
			gridExtraFields['servicedateto']="<? echo  $servicedateto; ?>";
			initGrids(10);
			//getGridSearch(); 
			xajax_gridData(gridSortCol,gridSort,gridPage,gridRecords,gridSearchType,gridSearchFields,gridExtraFields);
			
		</script>
	    </td>
		</tr> 
		</div>
		
		<div id="botheader">
		<tr class="NewGridBotBg">
		<?php
			/*$name=explode("|", $imgGrid);
			$link=explode("|", $scriptGrid);
			$heading="";
			$menu->showMainGridHeadingStrip1($name,$link,$heading);*/
		?>
		</tr>
		</div>
</table>
</td>
</div>

<?php
	$menu->showFooter();
?>
</form>
<form action="searchresults.php" name=search method="get">
<input type=hidden name=search id=search>
<input type=hidden name=type id=type>
</form>
</body>
</html>