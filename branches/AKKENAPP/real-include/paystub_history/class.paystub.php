<?php

require_once("json_functions.inc");

class paycheck_print
{
	

	public function __construct()
	{
		global $companyuser,$username,$maindb,$db,$WDOCUMENT_ROOT;
		
		$this->companyuser=$companyuser;
		$this->WDOCUMENT_ROOT = $WDOCUMENT_ROOT;
		$this->username=$username;
		$this->maindb=$maindb;
		$this->db=$db;

	}

	function formatDate($date)
	{
		return preg_replace("/(\d+)\D+(\d+)\D+(\d+)/","$3-$1-$2",$date);
	}
    function get_paycheck_header($bid,$sno='')
	{ 
		if(!empty($sno))
		{
		 $pshque="SELECT     empname,empid,
		                     empssn,
							 empaddress1,
							 empcity,
							 state_name,
							 empzipcode,
							 paymethod,
							 checknumber,
							 checkamount,
							 bankaccount1,
							 netamount
							 
							 FROM prhmaster LEFT JOIN state_codes ON state_abbr=empstate WHERE batchid='".$bid."' AND empid='".$sno."'";
		$pshres=mysql_query($pshque,$this->db);
		$pshrow=mysql_fetch_array($pshres);
		    return $pshrow;
		}else{
			return 0;
		}
	}
	function get_paycheck_earnings($bid,$sno='')
	{ 
		if(!empty($sno))
		{
			 $pshque="SELECT
				hours,
				rate,
				amount,
				ytd_hours,
				ytd_amount,
				earningstype AS type
				FROM prhearnings
				WHERE parid='".$bid."' AND empid='".$sno."'";
		 
		$pshres=mysql_query($pshque,$this->db);
		
		    return $pshres;
		}else{
			return 0;
		}
	}
	
	function get_paycheck_tax($bid,$sno='')
	{ 
		if(!empty($sno))
		{
			 $pshque="
				SELECT 
				taxname,
				taxamount,
				ytd_taxamount,
				'tax' AS type
				FROM prhtaxes
				WHERE responsible='E' AND parid='".$bid."' AND empid='".$sno."'";

				
		 
		$pshres=mysql_query($pshque,$this->db);
		
		    return $pshres;
		}else{
			return 0;
		}
	}
	
	function get_paycheck_deduction($bid,$sno='')
	{ 
		if(!empty($sno))
		{
			 $pshque="SELECT 
				dedname,
				dedamount,
				ytd_dedamount,
				'deduction' AS type
				FROM prhdeductions
				WHERE dedtype='D' AND responsible='E' AND parid='".$bid."' AND empid='".$sno."'";
		 
		$pshres=mysql_query($pshque,$this->db);
		
		    return $pshres;
		}else{
			return 0;
		}
	}
	
	function get_paycheck_garnishments($bid,$sno='')
	{ 
		if(!empty($sno))
		{
			 $pshque="SELECT 
				dedname,
				dedamount,
				ytd_dedamount,
				'deduction' AS type
				FROM prhdeductions
				WHERE dedtype='G' AND responsible='E' AND parid='".$bid."' AND empid='".$sno."'";
		 
		$pshres=mysql_query($pshque,$this->db);
		
		    return $pshres;
		}else{
			return 0;
		}
	}
	
	function get_paycheck_contributions($bid,$sno='')
	{ 
		if(!empty($sno))
		{
			 $pshque="SELECT 
				dedname,
				dedamount,
				ytd_dedamount,
				'deduction' AS type
				FROM prhdeductions
				WHERE dedtype='C' AND responsible='M' AND parid='".$bid."' AND empid='".$sno."'";
		 
		$pshres=mysql_query($pshque,$this->db);
		
		    return $pshres;
		}else{
			return 0;
		}
	}
	
	function get_paycheck_batches($bid)
	{ 
		if(!empty($bid))
		{
			$pshque="SELECT
				ername,
				 eraddress1,
				 eraddress2,
				 ercity,
				 erstate,
				 erzipcode,
				 ercountry,
				 erphone,
				".tzRetQueryStringDate('paysdate','Date','/')." paysdate,
				".tzRetQueryStringDate('payedate','Date','/')." payedate,
				".tzRetQueryStringDate('paydate','Date','/')." paydate
				FROM prhbatches
				WHERE sno='".$bid."'";
		 
		$pshres=mysql_query($pshque,$this->db);
		$pshrow=mysql_fetch_assoc($pshres);
		    return $pshrow;
		}else{
			return 0;
		}
	}
}
?>