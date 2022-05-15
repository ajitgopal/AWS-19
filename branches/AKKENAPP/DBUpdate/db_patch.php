<?php

  $version = "AKKEN_8_1_0_1876.log";
  $filepath = $path . $file . $version;

  $contents = "";
  $contents.="\n\n=======================================\n";
  $contents.=$companyuser . "\n";
  $contents.="=======================================\n";
  $contents.="=======================================\n";
  
$query ="alter table reg_category add column company_id int not null default 0, add index(company_id);";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query ="alter table reg_category add column accounttype enum('checking','saving') default 'checking';";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query ="alter table reg_category add column billing ENUM('N','Y') DEFAULT 'N';";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query ="alter table reg_category add column directdeposit ENUM('N','Y') DEFAULT 'N';";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query ="alter table reg_category add column officialcheck ENUM('N','Y') DEFAULT 'N';";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query ="alter table reg_category add column taxfiling ENUM('N','Y') DEFAULT 'N';";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query ="alter table reg_category add column thirdparty ENUM('N','Y') DEFAULT 'N';";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query ="ALTER TABLE `workerscomp` ADD COLUMN `company_id` VARCHAR(1000) NOT NULL DEFAULT '', ADD INDEX(company_id);";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query ="ALTER TABLE rates_period ADD COLUMN employer_amount double(8,5) NOT NULL DEFAULT '0.00000';";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);


$query ="ALTER TABLE rates_period ADD COLUMN employer_amountmode varchar(10) NOT NULL DEFAULT 'PER';";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query ="CREATE TABLE `ste_manage` (
  `sno` int(15) NOT NULL AUTO_INCREMENT,
  `type` varchar(25) NOT NULL DEFAULT '',  --- earn, ded, cont, garn, benefit etc...
  `ac_type` varchar(100) NOT NULL DEFAULT '',
  `ste_type` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`sno`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query ="ALTER TABLE `companyear` ADD COLUMN `company_id` varchar(800) NOT NULL DEFAULT '', ADD INDEX(company_id);";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query ="ALTER TABLE `companyear` ADD COLUMN benefit_type INT NOT NULL DEFAULT 0, ADD INDEX(benefit_type); -- mapped to ste_manage";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query ="ALTER TABLE companyear ADD COLUMN cuser int(15) NOT NULL;";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query ="ALTER TABLE companyear ADD COLUMN muser int(15) NOT NULL;";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query ="ALTER TABLE companyear ADD COLUMN mdate datetime NOT NULL;";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);


$query ="CREATE TABLE `er_contributions` (
  `sno` INT(15) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(20) NOT NULL DEFAULT '',
  `code` INT(15) NOT NULL DEFAULT 0,
  `type` INT(15) NOT NULL DEFAULT 0 COMMENT 'reference to ste_manage_list.sno', 
  `frequency` VARCHAR(50) NOT NULL DEFAULT '' COMMENT 'Per Pay Period, Twice a Month, Four time a Month, Monthly',
  `effective_date` DATE NOT NULL DEFAULT '0000-00-00',
  `stop_date` DATE NOT NULL DEFAULT '0000-00-00',
  `calculation_type` VARCHAR(45) NOT NULL DEFAULT '',
  `amount` DECIMAL(10,2) NOT NULL DEFAULT '0.00',
  `er_contribution_limit` DECIMAL(10,2) NOT NULL DEFAULT '0.00',
  `irs_max_limit` DECIMAL(10,2) NOT NULL DEFAULT '0.00',
  `display_order` INT(11) NOT NULL,
  `status` ENUM('active','inactive','backup') DEFAULT 'active',
  `er_contribution_taxation` VARCHAR(100),
  `er_boxes` VARCHAR(100),
  `er_code` VARCHAR(100),
  `expense_account` INT(15) NOT NULL DEFAULT 0,
  `liability_account` INT(15) NOT NULL DEFAULT 0,
  `cuser` INT(15) NOT NULL,
  `cdate` DATETIME NOT NULL,
  `muser` INT(15) NOT NULL,
  `mdate` DATETIME NOT NULL,
  PRIMARY KEY (`sno`),
  UNIQUE KEY `code` (`code`),
  KEY `type` (`type`),
  KEY `status` (`status`),
  KEY `expense_account` (`expense_account`),
  KEY `liability_account` (`liability_account`)
)";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query ="INSERT INTO ste_manage (sno,`type`,`ac_type`,`ste_type`) VALUES 
('','cont','125 Plan Pre-Tax','Benefit125'),
('','cont','FSA - Medical','BenefitFSA'),
('','cont','Health Savings Account (HSA)','BenefitHSA'),
('','cont','FSA - Dependent Care','BenefitFSADependentCare'),
('','cont','After Tax','BenefitCustom'),
('','cont','Commuter Benefit','BenefitCustom'),
('','cont','401k','Benefit401K'),
('','cont','401k Catch Up','Benefit401K'),
('','cont','403b','Benefit403B'),
('','cont','403b Catch Up','Benefit403B'),
('','cont','Simple IRA','BenefitSimpleIRA'),
('','cont','Simple IRA Catch Up','BenefitSimpleIRA'),
('','cont','Roth 401k','BenefitRoth401K'),
('','cont','Roth 403b','BenefitRoth403B')";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query ="CREATE TABLE `ste_manage_list` (
  `sno` INT(15) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL DEFAULT '',
  `type` VARCHAR(25) NOT NULL DEFAULT '', -- references ste_manage.sno
  `contribution_type` VARCHAR(50) NOT NULL DEFAULT '',
  `calculation_type` VARCHAR(20) NOT NULL DEFAULT '',
  `display_order` INT(11) NOT NULL,
  PRIMARY KEY (`sno`),
  KEY `name` (`name`),
  KEY `type` (`type`)
)";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query ="INSERT INTO ste_manage_list (sno,`type`,`name`,`contribution_type`,`calculation_type`,`display_order`) VALUES 
('','cont','ER Pre-Tax Medical','125 Plan Pre-Tax','$ Amount','1'),
('','cont','ER Pre-Tax Dental','125 Plan Pre-Tax','$ Amount','2'),
('','cont','ER Pre-Tax Vision','125 Plan Pre-Tax','$ Amount','3'),
('','cont','ER HSA','Health Savings Account (HSA)','$ Amount','4'),
('','cont','ER FSA','FSA - Dependent Care','$ Amount','5'),
('','cont','ER 401k','401k','$ Amount','6'),
('','cont','ER Other Deduction','After Tax','$ Amount','7')";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query ="ALTER TABLE `workerscomp` MODIFY COLUMN  `status` enum('active','backup','inactive') NOT NULL DEFAULT 'active';";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query ="ALTER table hrcon_w4 ADD column locationcode varchar(255) NOT NULL DEFAULT ''";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query ="ALTER table empcon_w4 ADD column locationcode varchar(255) NOT NULL DEFAULT ''";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query ="ALTER table net_w4 ADD column locationcode varchar(255) NOT NULL DEFAULT ''";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query ="ALTER TABLE hrcon_general ADD COLUMN `mail_address1` varchar(100) DEFAULT NULL, 
  ADD COLUMN `mail_address2` varchar(100) DEFAULT NULL,
  ADD COLUMN `mail_city` varchar(50) DEFAULT NULL,
  ADD COLUMN `mail_state` varchar(20) DEFAULT NULL,
  ADD COLUMN `mail_stateid` int(10) NOT NULL DEFAULT '0',ADD INDEX(mail_stateid),
  ADD COLUMN `mail_country` int(15) NOT NULL DEFAULT '0',
  ADD COLUMN `mail_zip` varchar(20) DEFAULT NULL,
  ADD COLUMN  `as_residence` enum('Y','N') NOT NULL DEFAULT 'N'";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);


$query ="ALTER TABLE empcon_general ADD COLUMN `mail_address1` varchar(100) DEFAULT NULL, 
  ADD COLUMN `mail_address2` varchar(100) DEFAULT NULL,
  ADD COLUMN `mail_city` varchar(50) DEFAULT NULL,
  ADD COLUMN `mail_state` varchar(20) DEFAULT NULL,
  ADD COLUMN `mail_stateid` int(10) NOT NULL DEFAULT '0',ADD INDEX(mail_stateid),
  ADD COLUMN `mail_country` int(15) NOT NULL DEFAULT '0',
  ADD COLUMN `mail_zip` varchar(20) DEFAULT NULL";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query ="ALTER table hrcon_deduct ADD column caltype enum('A','P');";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query ="ALTER table empcon_deduct ADD column caltype enum('A','P');";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query ="ALTER table empcon_deduct ADD column irs_max_limit double(10,2) not null default 0.00";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);
$query ="ALTER table hrcon_deduct ADD column irs_max_limit double(10,2) not null default 0.00";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

//Check the existing values will affect changed enum values
$query ="ALTER table hrcon_deduct MODIFY column frequency enum('R','O','P','SM','M') ";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db); 

$query ="ALTER table empcon_deduct MODIFY column frequency enum('R','O','P','SM','M') ";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query ="INSERT into `manage`(`name`,`type`,`cuser`,`cdate`,`muser`,`mdate`,`status`) VALUES 
('Per Diem Non-Taxable','earnings','1',NOW(),1,NOW(),'Y'),
('Per Diem Taxable','earnings','1',NOW(),1,NOW(),'Y'); ";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);


// Pay Schedule

$query ="DROP TABLE pay_schedule ";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query ="CREATE TABLE `pay_schedule` (
  `sno` INT(15) NOT NULL AUTO_INCREMENT,
  `company_id` INT(15) NOT NULL DEFAULT '0',
  `pay_schedule_code` VARCHAR(100) DEFAULT '',
  `pay_schedule_name` VARCHAR(200) DEFAULT '',
  `pay_schedule` INT(15) NOT NULL DEFAULT '0',
  `standard_hours` VARCHAR(100) DEFAULT '2',
  `pay_period_date` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  `period_start_date` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  `period_end_date` VARCHAR(100) DEFAULT '',
  `holiday_rules` INT(15) NOT NULL DEFAULT '0',
  `days_before_pay_date` VARCHAR(10) DEFAULT '0',
  `inactive` ENUM('0','1') NOT NULL DEFAULT '0',
  `status` ENUM('active','backup') NOT NULL DEFAULT 'active',
  `cuser` INT(15) NOT NULL,
  `muser` INT(15) NOT NULL,
  `cdate` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  `mdate` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`sno`),
  KEY `company_id` (`company_id`),
  KEY `pay_schedule` (`pay_schedule`),
  KEY `holiday_rules` (`holiday_rules`)
) ";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query ="CREATE TABLE `pay_schedule_details` (
  `sno` INT(15) NOT NULL AUTO_INCREMENT,
  `pay_id` INT(15) NOT NULL DEFAULT '0',
  `start_date` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  `end_date` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  `pay_date` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  `run_date` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` ENUM('active','backup','completed') NOT NULL DEFAULT 'active',
  `cuser` INT(15) NOT NULL,
  `muser` INT(15) NOT NULL,
  `cdate` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  `mdate` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`sno`),
  KEY `pay_id` (`pay_id`)
) ";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query ="CREATE TABLE `steJurisdictions` (
  `sno` int(15) NOT NULL AUTO_INCREMENT,
  `uniqueTaxID` varchar(50) NOT NULL DEFAULT '',
  `stateCode` char(2) NOT NULL DEFAULT '',
  `stateAbbreviation` char(3) NOT NULL DEFAULT '',
  `parameterName` varchar(50) NOT NULL DEFAULT '',
  `dataType` varchar(25) NOT NULL DEFAULT '',
  `description` varchar(100) NOT NULL DEFAULT '',
  `defaultValue` varchar(25) NOT NULL DEFAULT '',
  `regexType` varchar(25) NOT NULL DEFAULT '',
  `regex` varchar(25) NOT NULL DEFAULT '',
  `listValues` varchar(255) NOT NULL DEFAULT '',
  `isOptional` char(5) NOT NULL DEFAULT '',
  `certificateLineNo` varchar(100) NOT NULL DEFAULT '',
  `2020_W4` char(5) NOT NULL DEFAULT '',
  `status` enum('N','Y') DEFAULT 'Y',
  PRIMARY KEY (`sno`),
  UNIQUE KEY `taxid_name` (`uniqueTaxID`,`parameterName`)
) ENGINE=MyISAM AUTO_INCREMENT=67 DEFAULT CHARSET=latin1;";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query ="INSERT INTO `steJurisdictions`(sno,uniqueTaxID,stateCode,stateAbbreviation,parameterName,dataType,description,defaultValue,regexType,regex,listValues,isOptional,certificateLineNo,`2020_W4`,status) VALUES (1,'13-000-0000-ER_SUTA_SC-011','13','GA','INCLUDE_SURCHARGE_AT_MIN_MAX','Boolean','Georgia Administrative Assessment Tax Override when rates are at the max or minimum for an employer','FALSE','PickList','^(TRUE|FALSE)$','','1','','','N')
, (2,'13-000-0000-SIT-000','13','GA','FILINGSTATUS','String','Filing Status','A','PickList','^(A|B|C|D|E)$','A=Single,B=Married Filing Joint both spouses working,C=Married Filing Joint one spouse working,D=Married Filing Separate,E=Head of Household','','Form G-4, Line 7, Letter Used','','Y')
, (3,'13-000-0000-SIT-000','13','GA','PERSONALALLOWANCES','Integer','Personal Allowances','0','PickList','^(0|1|2)$','0=Zero,1=One,2=Two','','Form G-4, Line 3','','Y')
, (4,'13-000-0000-SIT-000','13','GA','DEPENDENTALLOWANCES','Integer','Dependent Allowances','0','SingleValue','^({0-9}+)$','','','Form G-4, Line 4','','Y')
, (5,'13-000-0000-SIT-000','13','GA','ANNUAL_WAGES','Dollar','Total annual wages','0','SingleValue','^({0-9}+({.}{0-9}{0,2})?)','','','','','Y')
, (6,'13-000-0000-SIT-000','13','GA','ADDITIONALALLOWANCES','Integer','Additional Allowances','0','SingleValue','^({0-9}+)$','','','Form G-4, Line 5','','Y')
, (7,'13-000-0000-SIT-000','13','GA','MOST_RECENT_WH','Dollar','Most Recent Withholding Amount','0.0','SingleValue','^({0-9}+({.}{0-9}{0,2})?)','','1','','','N')
, (8,'19-000-0000-SIT-000','19','IA','FILINGSTATUS','String','Filing Status','S','PickList','^(S|M)$','S=Single, M=Married','','IA W-4, Marital Status','','Y')
, (9,'19-000-0000-SIT-000','19','IA','TOTALALLOWANCES','Integer','Total Allowances','0','SingleValue','^({0-9}+)$','','','IA W-4, Number 6','','Y')
, (10,'19-000-0000-SIT-000','19','IA','MOST_RECENT_WH','Dollar','Most Recent Withholding Amount','0.0','SingleValue','^({0-9}+({.}{0-9}{0,2})?)','','1','','','N')
, (11,'55-000-0000-SIT-000','55','WI','FILINGSTATUS','String','Filing Status','S','PickList','^(S|M|MH)$','S=Single, M=Married, MH=Married but use single rate','','Form WT-4, Filing Status Box (certificate front)','','Y')
, (12,'55-000-0000-SIT-000','55','WI','TOTALALLOWANCES','Integer','Total Allowances','0','SingleValue','^({0-9}+)$','','','Form WT-4, Line 1(d)','','Y')
, (13,'55-000-0000-SIT-000','55','WI','MOST_RECENT_WH','Dollar','Most Recent Withholding Amount','0.0','SingleValue','^({0-9}+({.}{0-9}{0,2})?)','','1','','','N')
, (14,'18-000-0000-SIT-000','18','IN','DEPENDENTEXEMPTIONS','Integer','Dependent Exemptions','0','SingleValue','^({0-9}+)$','','','Form WH-4, Line 6','','Y')
, (15,'18-000-0000-SIT-000','18','IN','PERSONALEXEMPTIONS','Integer','Personal Exemptions','0','SingleValue','^({0-9}+)$','','','Form WH-4, Line 5','','Y')
, (16,'18-000-0000-SIT-000','18','IN','PRINCIPALEMPLOYMENT','Integer','Principal Employment','0','PickList','^(0|000|001|003|005|007|0','0=None,001=Adams County,003=Allen County,005=Bartholomew County,007=Benton County,009=Blackford County,011=Boone County,013=Brown County,015=Carroll County,017=Cass County,019=Clark County,021=Clay County,023=Clinton County,025=Crawford County,027=Daviess','1','Form WH-4, Principal Employment','','N')
, (17,'18-000-0000-SIT-000','18','IN','MOST_RECENT_WH','Dollar','Most Recent Withholding Amount','0.0','SingleValue','^({0-9}+({.}{0-9}{0,2})?)','','1','','','N')
, (18,'18-063-0000-CNTY-000','18','IN','ADDITIONALCOUNTYWITHHOLDING','Dollar','Additional County Withholding','0','SingleValue','^({0-9}+({.}{0-9}{0,2})?)','','1','','','N')
, (19,'20-000-0000-SIT-000','20','KS','FILINGSTATUS','String','Filing Status','S','PickList','^(S|MJ)$','S=Single, MJ=Married','','Form K-4, Line 3','','Y')
, (20,'20-000-0000-SIT-000','20','KS','TOTALALLOWANCES','Integer','Total Allowances','0','SingleValue','^({0-9}+)$','','','Form K-4, Line 4','','Y')
, (21,'20-000-0000-SIT-000','20','KS','MOST_RECENT_WH','Dollar','Most Recent Withholding Amount','0.0','SingleValue','^({0-9}+({.}{0-9}{0,2})?)','','1','','','N')
, (22,'21-000-0000-SIT-000','21','KY','MOST_RECENT_WH','Dollar','Most Recent Withholding Amount','0.0','SingleValue','^({0-9}+({.}{0-9}{0,2})?)','','1','','','N')
, (23,'22-000-0000-SIT-000','22','LA','FILINGSTATUS','String','Filing Status','S','PickList','^(S|M|0)$','S=Single, M=Married, 0=No Exemptions','','Form L-4, Box 3','','Y')
, (24,'22-000-0000-SIT-000','22','LA','TOTALALLOWANCES','Integer','Total Allowances','0','PickList','^(0|1|2)$','0=Zero,1=One,2=Two','','Form L-4, Line 6','','Y')
, (25,'22-000-0000-SIT-000','22','LA','TOTALDEPENDENTS','Integer','Total Dependents','0','SingleValue','^({0-9}+)$','','','Form L-4, Line 7','','Y')
, (26,'22-000-0000-SIT-000','22','LA','MOST_RECENT_WH','Dollar','Most Recent Withholding Amount','0.0','SingleValue','^({0-9}+({.}{0-9}{0,2})?)','','1','','','N')
, (27,'29-000-0000-SIT-000','29','MO','FILINGSTATUS','String','Filing Status','S','PickList','^(S|M|H)$','S=Single or Married Spouse Works or Married Filing Separate, M=Married (spouse does not work), H=Head of Household','','Form MO W-4, Line 1','','Y')
, (28,'29-000-0000-SIT-000','29','MO','RESIDENTPERCENT','Percentage','Resident Percent','0.0','SingleValue','^(100(?:{.}0{0,2})?|{0-9}','','1','Form MO W-4C, Line 2','','Y')
, (29,'29-000-0000-SIT-000','29','MO','NONRESIDENTPERCENT','Percentage','Non-Resident Percent','0.0','SingleValue','^(100(?:{.}0{0,2})?|{0-9}','','1','Form MO W-4A, estimate portion of services performed within Missouri','','Y')
, (30,'29-000-0000-SIT-000','29','MO','REDUCED_WH_AMT','Dollar','Reduced Withholding Amount','0.0','SingleValue','^({0-9}+({.}{0-9}{0,2})?)','','1','Form MO W-4, Line 3','','Y')
, (31,'29-000-0000-SIT-000','29','MO','MOST_RECENT_WH','Dollar','Most Recent Withholding Amount','0.0','SingleValue','^({0-9}+({.}{0-9}{0,2})?)','','1','','','N')
, (32,'37-000-0000-SIT-000','37','NC','FILINGSTATUS','String','Filing Status','S','PickList','^(S|M|H)$','S=Single or Married Filing Separately, M=Married Filing Jointly or Surviving Spouse, H=Head of Household','','Form NC-4, Filing Status Box','','Y')
, (33,'37-000-0000-SIT-000','37','NC','TOTALALLOWANCES','Integer','Total Allowances','0','SingleValue','^({0-9}+)$','','','Form NC-4, Line 1','','Y')
, (34,'37-000-0000-SIT-000','37','NC','MOST_RECENT_WH','Dollar','Most Recent Withholding Amount','0.0','SingleValue','^({0-9}+({.}{0-9}{0,2})?)','','1','','','N')
, (35,'42-000-0000-SIT-000','42','PA','MOST_RECENT_WH','Dollar','Most Recent Withholding Amount','0.0','SingleValue','^({0-9}+({.}{0-9}{0,2})?)','','1','','','N')
, (36,'42-000-0000-SUI-000','42','PA','PA_WAGES_ONLY','Boolean','Tax PA SUI only on PA wages','TRUE','PickList','^(TRUE|FALSE)$','','','','','Y')
, (37,'42-000-1213644-ER_POP-006','42','PA','TOTAL_CURRENT_WAGES','Dollar','Total Current Wages','0.0','SingleValue','^({0-9}+({.}{0-9}{0,2})?)','','','','','N')
, (38,'42-003-1214818-EIT-027451','42','PA','PRIMARY_EIT','Boolean','Primary work location EIT','FALSE','PickList','^(TRUE|FALSE)$','','1','','','N')
, (39,'42-003-1214818-LST-027451','42','PA','MUNI_WH_YTD','Dollar','Municipal Withholding Year-to-date','0.0','SingleValue','^({0-9}+({.}{0-9}{0,2})?)','','','','','N')
, (40,'42-003-1214818-LST-027451','42','PA','SCHOOL_WH_YTD','Dollar','School Withholding Year-to-date','0.0','SingleValue','^({0-9}+({.}{0-9}{0,2})?)','','','','','N')
, (41,'39-000-0000-SIT-000','39','OH','TOTALALLOWANCES','Integer','Total Allowances','0','SingleValue','^({0-9}+)$','','','Form IT 4, Line 4','','Y')
, (42,'39-000-0000-SIT-000','39','OH','MOST_RECENT_WH','Dollar','Most Recent Withholding Amount','0.0','SingleValue','^({0-9}+({.}{0-9}{0,2})?)','','1','','','N')
, (43,'36-000-0000-ER_POP-001','36','NY','TOTAL_CURRENT_WAGES','Dollar','Total Current Wages','0.0','SingleValue','^({0-9}+({.}{0-9}{0,2})?)','','','','','N')
, (44,'36-000-0000-ER_POP-008','36','NY','TOTAL_CURRENT_WAGES','Dollar','Total Current Wages','0.0','SingleValue','^({0-9}+({.}{0-9}{0,2})?)','','','','','N')
, (45,'36-000-0000-ER_POP-008','36','NY','PER_PAY_PERIOD','Boolean','Calculate tax per pay period.','FALSE','PickList','^(TRUE|FALSE)$','','1','','','N')
, (46,'36-000-0000-ER_POP-008','36','NY','PREVIOUS_QUARTERLY_PAYROLL_EXPENSE','Dollar','The employer’s previous quarterly payroll expense.','0.0','SingleValue','^({0-9}+({.}{0-9}{0,2})?)','','1','','','N')
, (47,'36-000-0000-SIT-000','36','NY','FILINGSTATUS','String','Filing Status','S','PickList','^(S|M|MH)$','S=Single, M=Married,MH=Married but use single rate','','Form IT-2104, Filing Status Box (certificate front)','','Y')
, (48,'36-000-0000-SIT-000','36','NY','TOTALALLOWANCES','Integer','Total Allowances','0','SingleValue','^({0-9}+)$','','','Form IT-2104, Line 1','','Y')
, (49,'36-000-0000-SIT-000','36','NY','MOST_RECENT_WH','Dollar','Most Recent Withholding Amount','0.0','SingleValue','^({0-9}+({.}{0-9}{0,2})?)','','1','','','N')
, (50,'36-000-975772-CITY-000','36','NY','FILINGSTATUS','String','Filing Status','S','PickList','^(S|M|MH)$','S=Single, M=Married,MH=Married but use single rate','','Form IT-2104, Filing Status Box (certificate front)','','N')
, (51,'36-000-975772-CITY-000','36','NY','TOTALALLOWANCESNYC','Integer','Total Allowances - NYC','0','SingleValue','^({0-9}+)$','','1','Form IT-2104, Line 2','','N')
, (52,'36-000-975772-CITY-000','36','NY','ADDITIONALWH-NYC','Dollar','Additional Withholding - NYC','0.00','SingleValue','^({0-9}+({.}{0-9}{0,2})?)','','1','Form IT-2104, Line 4','','N')
, (53,'34-000-0000-ER_POP-001','34','NJ','TOTAL_CURRENT_WAGES','Dollar','Total Current Wages','0.0','SingleValue','^({0-9}+({.}{0-9}{0,2})?)','','','','','N')
, (54,'34-000-0000-SIT-000','34','NJ','FILINGSTATUS','String','Filing Status','S','PickList','^(S|MJ|MS|H|QW)$','S=Single, MJ=Married/Civil Union Couple Joint, MS=Married/Civil Union Partner Separate,H=Head of Household,QW=Qualifying Widow(er)/Surviving Civil Union Partner','','Form NJ-W4, Box 2','','Y')
, (55,'34-000-0000-SIT-000','34','NJ','TOTALALLOWANCES','Integer','Total Allowances','0','SingleValue','^({0-9}+)$','','','Form NJ-W4, Line 4','','Y')
, (56,'34-000-0000-SIT-000','34','NJ','RATETABLE','String','Rate code','B','PickList','^(A|B|C|D|E)$','A=A,B=B,C=C,D=D,E=E','','Form NJ-W4, Line 3','','Y')
, (57,'34-000-0000-SIT-000','34','NJ','MOST_RECENT_WH','Dollar','Most Recent Withholding Amount','0.0','SingleValue','^({0-9}+({.}{0-9}{0,2})?)','','1','','','N')
, (58,'00-000-0000-FIT-000','00','FED','2020_W4','Boolean','2020 W4','FALSE','PickList','^(TRUE|FALSE)$','','1','','','N')
, (59,'00-000-0000-FIT-000','00','FED','TOTALALLOWANCES','Integer','Total Allowances','0','SingleValue','^({0-9}+)$','','1','','','N')
, (60,'00-000-0000-FIT-000','00','FED','FILINGSTATUS','String','Filing Status','S','PickList','^(S|M|H|NRA)$','S=Single or Married filing separately, M=Married filing jointly or Qualifying widow(er), H=Head of household','','Form W-4, Step 1 Box (c)','','Y')
, (61,'00-000-0000-FIT-000','00','FED','TWO_JOBS','Boolean','Two Jobs','FALSE','PickList','^(TRUE|FALSE)$','','','Form W-4, Step 2 Box (c)','','Y')
, (62,'00-000-0000-FIT-000','00','FED','MOST_RECENT_WH','Dollar','Most Recent Withholding Amount','0.0','SingleValue','^({0-9}+({.}{0-9}{0,2})?)','','1','','','N')
, (63,'00-000-0000-FIT-000','00','FED','DEPENDENTS_AMT','Dollar','Dependent Amount','0.0','SingleValue','^({0-9}+({.}{0-9}{0,2})?)','','','Form W-4, Step 3','','Y')
, (64,'00-000-0000-FIT-000','00','FED','OTHER_INCOME','Dollar','Other Income','0.0','SingleValue','^({0-9}+({.}{0-9}{0,2})?)','','','Form W-4, Step 4 Box (a)','','Y')
, (65,'00-000-0000-FIT-000','00','FED','DEDUCTIONS','Dollar','Deductions','0.0','SingleValue','^({0-9}+({.}{0-9}{0,2})?)','','','Form W-4, Step 4 Box (b)','','Y')
, (66,'00-000-0000-FIT-000','00','FED','NRA_EXEMPTION_AMT','Dollar','NRA Exemption Amount','0.0','SingleValue','^({0-9}+({.}{0-9}{0,2})?)','','1','Exemption amount from Form 8233','','N')
, (67,'54-000-0000-SIT-000','54','WV','TOTALALLOWANCES','Integer','Total Allowances','0','SingleValue','^({0-9}+)$','','','Form WV/IT-104, Line 4','','N')
, (68,'54-000-0000-SIT-000','54','WV','TWOEARNERPERCENT','Boolean','Two-earner Percent','FALSE','PickList','^(TRUE|FALSE)$','','','Form WV/IT-104, Line 5','','N')
, (69,'54-000-0000-SIT-000','54','WV','MOST_RECENT_WH','Dollar','Most Recent Withholding Amount','0.0','SingleValue','^({0-9}+({.}{0-9}{0,2})?)','','1','','','N')
, (70,'06-000-0000-SIT-000','06','CA','FILINGSTATUS','String','Filing Status','S','PickList','^(S|M|H)$','S=Single or Married (with two or more incomes), M=Married (one income), H=Head of Household','','Form DE 4, Filing Status','','N')
, (71,'06-000-0000-SIT-000','06','CA','TOTALALLOWANCES','Integer','Total Allowances','0','SingleValue','^({0-9}+)$','','','Form DE 4, Line 1c','','N')
, (72,'06-000-0000-SIT-000','06','CA','REGULARALLOWANCES','Integer','Regular Allowances','0','SingleValue','^({0-9}+)$','','1','Form DE 4, Line 1a','','N')
, (73,'06-000-0000-SIT-000','06','CA','SUPPLEMENTAL','String','Supplemental Type','NONE','PickList','^(BONUS|COMMISSION|NONE)$','BONUS=BONUS,COMMISSION=COMMISSION,NONE=NONE','1','','','N')
, (74,'06-000-0000-SIT-000','06','CA','ADDITIONALALLOWANCES','Integer','Additional Allowances','0','SingleValue','^({0-9}+)$','','1','Form DE 4, Line 1b','','N')
, (75,'06-000-0000-SIT-000','06','CA','MOST_RECENT_WH','Dollar','Most Recent Withholding Amount','0.0','SingleValue','^({0-9}+({.}{0-9}{0,2})?)','','1','','','N')
, (76,'28-000-0000-SIT-000','28','MS','FILINGSTATUS','String','Filing Status','S','PickList','^(S|M1|M2|H)$','S=Single,M1=Married (Spouse NOT employed),M2=Married (Spouse IS employed),H=Head of Family','','Form 89-350, Lines 1, 2, and 3','','N')
, (77,'28-000-0000-SIT-000','28','MS','TOTALEXEMPTIONAMT','Dollar','Total Exemption Amount','0.00','SingleValue','^({0-9}+({.}{0-9}{0,2})?)','','','Form 89-350, Line 6','','N')
, (78,'28-000-0000-SIT-000','28','MS','MOST_RECENT_WH','Dollar','Most Recent Withholding Amount','0.0','SingleValue','^({0-9}+({.}{0-9}{0,2})?)','','1','','','N')
, (79,'30-000-0000-SIT-000','30','MT','TOTALALLOWANCES','Integer','Total Allowances','0','SingleValue','^({0-9}+)$','','','Form MW-4, Section 1 Line G','','N')
, (80,'30-000-0000-SIT-000','30','MT','MOST_RECENT_WH','Dollar','Most Recent Withholding Amount','0.0','SingleValue','^({0-9}+({.}{0-9}{0,2})?)','','1','','','N')
, (81,'01-000-0000-SIT-000','01','AL','FILINGSTATUS','String','Filing Status','S','PickList','^(S|M|MS|H|0)$','S=Single, M=Married, MS=Married Filing Separately,H=Head of Family,0=Zero','','Form A4, Line 1, 2 and 3','','N')
, (82,'01-000-0000-SIT-000','01','AL','DEPENDENTS','Integer','Dependents','0','SingleValue','^({0-9}+)$','','','Form A4, Line 4','','N')
, (83,'01-000-0000-SIT-000','01','AL','MOST_RECENT_WH','Dollar','Most Recent Withholding Amount','0.0','SingleValue','^({0-9}+({.}{0-9}{0,2})?)','','1','','','N')
, (84,'38-000-0000-SIT-000','38','ND','2020_W4','Boolean','2020 W4','FALSE','PickList','^(TRUE|FALSE)$','','1','','','N')
, (85,'38-000-0000-SIT-000','38','ND','TOTALALLOWANCES','Integer','Total Allowances','0','SingleValue','^({0-9}+)$','','','Form W-4, Line 5','','N')
, (86,'38-000-0000-SIT-000','38','ND','FILINGSTATUS','String','Filing Status','S','PickList','^(S|M|MH|H)$','S=Single, M=Married, MH=Married but use single rate,H=head of household','','Form W-4, Step 1 Box (c)','','N')
, (87,'38-000-0000-SIT-000','38','ND','MOST_RECENT_WH','Dollar','Most Recent Withholding Amount','0.0','SingleValue','^({0-9}+({.}{0-9}{0,2})?)','','1','','','N')
, (88,'31-000-0000-SIT-000','31','NE','FILINGSTATUS','String','Filing Status','S','PickList','^(S|M)$','S=Single, M=Married','','Form W-4N, Filing Status Box','','N')
, (89,'31-000-0000-SIT-000','31','NE','TOTALALLOWANCES','Integer','Total Allowances','0','SingleValue','^({0-9}+)$','','','Form W-4N, Line 1','','N')
, (90,'31-000-0000-SIT-000','31','NE','NONRESPERCENTAGE','Percentage','Nonresident Percentage','0','SingleValue','^(100(?:{.}0{0,2})?|{0-9}','','1','Form 9N, Percent of Compensation Subject to Withholding','','N')
, (91,'31-000-0000-SIT-000','31','NE','MOST_RECENT_WH','Dollar','Most Recent Withholding Amount','0.0','SingleValue','^({0-9}+({.}{0-9}{0,2})?)','','1','','','N')
, (92,'05-000-0000-SIT-000','05','AR','TOTALALLOWANCES','Integer','Total Allowances','0','SingleValue','^({0-9}+)$','','','Form AR4EC, Line 3','','N')
, (93,'05-000-0000-SIT-000','05','AR','TEXARKANARESIDENT','Boolean','Texarkana Resident','FALSE','PickList','^(TRUE|FALSE)$','','1','','','N')
, (94,'05-000-0000-SIT-000','05','AR','MOST_RECENT_WH','Dollar','Most Recent Withholding Amount','0.0','SingleValue','^({0-9}+({.}{0-9}{0,2})?)','','1','','','N')
, (95,'04-000-0000-SIT-000','04','AZ','PERCENTSTATE','Percentage','State elected percentage rate','2.7','PickList','^(0|0.8|1.3|1.8|2.7|3.6|4','0=Zero,0.8=0.8,1.3=1.3,1.8=1.8,2.7=2.7,3.6=3.6,4.2=4.2,5.1=5.1','','Form A-4, Box 1 or 2','','N')
, (96,'04-000-0000-SIT-000','04','AZ','MOST_RECENT_WH','Dollar','Most Recent Withholding Amount','0.0','SingleValue','^({0-9}+({.}{0-9}{0,2})?)','','1','','','N')
, (97,'35-000-0000-SIT-000','35','NM','FILINGSTATUS','String','Filing Status','S','PickList','^(S|M|MH|H)$','S=Single, M=Married, MH=Married but use single rate, H=Head of Household','','Form W-4, Box 3','','N')
, (98,'35-000-0000-SIT-000','35','NM','OTHER_INCOME','Dollar','Other Income','0.0','SingleValue','^({0-9}+({.}{0-9}{0,2})?)','','1','Form W-4, Step 4 Box (a)','','N')
, (99,'35-000-0000-SIT-000','35','NM','DEDUCTIONS','Dollar','Deductions','0.0','SingleValue','^({0-9}+({.}{0-9}{0,2})?)','','1','Form W-4, Step 4 Box (b)','','N')
, (100,'35-000-0000-SIT-000','35','NM','MOST_RECENT_WH','Dollar','Most Recent Withholding Amount','0.0','SingleValue','^({0-9}+({.}{0-9}{0,2})?)','','1','','','N')
, (101,'32-000-0000-ER_POP-002','32','NV','TOTAL_CURRENT_WAGES','Dollar','Total Current Wages','0.0','SingleValue','^({0-9}+({.}{0-9}{0,2})?)','','','','','N')
, (102,'32-000-0000-ER_POP-003','32','NV','TOTAL_CURRENT_WAGES','Dollar','Total Current Wages','0.0','SingleValue','^({0-9}+({.}{0-9}{0,2})?)','','','','','N')
, (103,'08-000-0000-ER_SUTA-000','08','CO','POLITICALSUBDIVISION','Boolean','Colorado Political Subdivision','FALSE','PickList','^(TRUE|FALSE)$','','1','','','N')
, (104,'08-000-0000-SIT-000','08','CO','FILINGSTATUS','String','Filing Status','S','PickList','^(S|M|MH|H)$','S=Single, M=Married, MH=Married but use single rate, H=head of household','','Form W-4, Step 1, Box (c)','','N')
, (105,'08-000-0000-SIT-000','08','CO','MOST_RECENT_WH','Dollar','Most Recent Withholding Amount','0.0','SingleValue','^({0-9}+({.}{0-9}{0,2})?)','','1','','','N')
, (106,'08-000-201738-CITY-000','08','CO','UPFRONT_WITHHOLDING','Boolean','Withhold if the current pay period wages would cause the threshold to be crossed in the month','FALSE','PickList','^(TRUE|FALSE)$','','1','','','N')
, (107,'08-000-201738-CITY-000','08','CO','DISABLE_PRORATION','Boolean','Withhold the entire monthly tax in a single payroll','FALSE','PickList','^(TRUE|FALSE)$','','1','','','N')
, (108,'08-000-201738-ER_EHT-000','08','CO','TOTAL_EMPLOYEES','Integer','Total number of employees','0','SingleValue','^({0-9}+)$','','','','','N')
, (109,'40-000-0000-SIT-000','40','OK','FILINGSTATUS','String','Filing Status','S','PickList','^(S|M|MH|NRA)$','S=Single, M=Married, MH=Married but use single rate,NRA=Nonresident Alien','','Form OK-W-4, Filing Status','','N')
, (110,'40-000-0000-SIT-000','40','OK','TOTALALLOWANCES','Integer','Total Allowances','0','SingleValue','^({0-9}+)$','','','Form OK-W-4, Line 5','','N')
, (111,'40-000-0000-SIT-000','40','OK','MOST_RECENT_WH','Dollar','Most Recent Withholding Amount','0.0','SingleValue','^({0-9}+({.}{0-9}{0,2})?)','','1','','','N')
, (112,'41-000-0000-ER_SUTA-000','41','OR','POLITICALSUBDIVISION','Boolean','Oregon Political Subdivision','FALSE','PickList','^(TRUE|FALSE)$','','1','','','N')
, (113,'41-000-0000-SIT-000','41','OR','FILINGSTATUS','String','Filing Status','S','PickList','^(S|M|MH)$','S=Single, M=Married, MH=Married but use single rate','','Form OR-W-4, Line 1','','N')
, (114,'41-000-0000-SIT-000','41','OR','TOTALALLOWANCES','Integer','Total Allowances','0','SingleValue','^({0-9}+)$','','','Form OR-W-4, Line 2','','N')
, (115,'41-000-0000-SIT-000','41','OR','MOST_RECENT_WH','Dollar','Most Recent Withholding Amount','0.0','SingleValue','^({0-9}+({.}{0-9}{0,2})?)','','1','','','N')
, (116,'41-000-0000-SST-001','41','OR','METRO_OPT_IN_WITHHOLDING_AMOUNT','Dollar','Designated amount to be withheld from the Employee OPT IN Form','0','SingleValue','^({0-9}+({.}{0-9}{0,2})?)','','1','','','N')
, (117,'41-000-0000-SST-001','41','OR','COURTESY','Boolean','The Courtesy Flag','FALSE','PickList','^(TRUE|FALSE)$','','1','','','N')
, (118,'41-000-0000-TRANS-000','41','OR','COURTESY','Boolean','The Courtesy Flag','TRUE','PickList','^(TRUE|FALSE)$','','','','','N')
, (119,'09-000-0000-SIT-000','09','CT','WITHHOLDINGCODE','String','Withholding code','NO_FORM','PickList','^(A|B|C|D|E|F|NO_FORM)$','A=A,B=B,C=C,D=D,E=E,F=F, NO_FORM=NO_FORM','','Form CT-W4, Number 1','','N')
, (120,'09-000-0000-SIT-000','09','CT','REDUCED_WH_AMT','Dollar','Reduced withholding','0.00','SingleValue','^({0-9}+({.}{0-9}{0,2})?)','','1','Form CT-W4, Number 3','','N')
, (121,'09-000-0000-SIT-000','09','CT','MOST_RECENT_WH','Dollar','Most Recent Withholding Amount','0.0','SingleValue','^({0-9}+({.}{0-9}{0,2})?)','','1','','','N')
, (122,'11-000-0000-SIT-000','11','DC','FILINGSTATUS','String','Filing Status','S','PickList','^(S|MJ|MDS|MS|H)$','S=Single, MJ=Married or Domestic partners filing jointly, MDS=Married or Domestic partners filing separately on same return, MS=Married Filing Separately, H=Head of Household','','Form D-4, Number 1','','N')
, (123,'11-000-0000-SIT-000','11','DC','TOTALALLOWANCES','Integer','Total Allowances','0','SingleValue','^({0-9}+)$','','','Form D-4, Number 2','','N')
, (124,'11-000-0000-SIT-000','11','DC','MOST_RECENT_WH','Dollar','Most Recent Withholding Amount','0.0','SingleValue','^({0-9}+({.}{0-9}{0,2})?)','','1','','','N')
, (125,'44-000-0000-SIT-000','44','RI','TOTALALLOWANCES','Integer','Total Allowances','0','SingleValue','^({0-9}+)$','','','Form RI W-4, Line 1','','N')
, (126,'44-000-0000-SIT-000','44','RI','MOST_RECENT_WH','Dollar','Most Recent Withholding Amount','0.0','SingleValue','^({0-9}+({.}{0-9}{0,2})?)','','1','','','N')
, (127,'10-000-0000-SIT-000','10','DE','FILINGSTATUS','String','Filing Status','S','PickList','^(S|M|MH)$','S=Single, M=Married, MH=Married but use single rate','','Form W-4, Box 3','','N')
, (128,'10-000-0000-SIT-000','10','DE','TOTALALLOWANCES','Integer','Total Allowances','0','SingleValue','^({0-9}+)$','','','Form W-4, Line 4','','N')
, (129,'10-000-0000-SIT-000','10','DE','MOST_RECENT_WH','Dollar','Most Recent Withholding Amount','0.0','SingleValue','^({0-9}+({.}{0-9}{0,2})?)','','1','','','N')
, (130,'10-000-214862-ER_EHT-000','10','DE','TOTAL_EMPLOYEES','Integer','Total number of employees','0','SingleValue','^({0-9}+)$','','','','','N')
, (131,'45-000-0000-SIT-000','45','SC','TOTALALLOWANCES','Integer','Total Allowances','0','SingleValue','^({0-9}+)$','','','Form SC W-4, Line 5','','N')
, (132,'45-000-0000-SIT-000','45','SC','MOST_RECENT_WH','Dollar','Most Recent Withholding Amount','0.0','SingleValue','^({0-9}+({.}{0-9}{0,2})?)','','1','','','N')
, (133,'15-000-0000-SDI-000','15','HI','PREMIUM_COST','Dollar','Premium Cost','0.0','SingleValue','^({0-9}+({.}{0-9}{0,2})?)','','','','','N')
, (134,'15-000-0000-SDI-000','15','HI','SDI_PERCENT','Percentage','Employee Percentage of SDI Tax','100','SingleValue','^(100(?:{.}0{0,2})?|{0-9}','','','The employee percentage of the SDI tax. (0-100)','','N')
, (135,'15-000-0000-SDI-000','15','HI','SDI_PERCENT_OF_PREMIUMS','Percentage','Employee Percentage of Employer SDI Premium','100','SingleValue','^(100(?:{.}0{0,2})?|{0-9}','','1','The employee percentage of the employer SDI premium tax calculation. (0-100)','','N')
, (136,'15-000-0000-SIT-000','15','HI','TOTALALLOWANCES','Integer','Total Allowances','0','SingleValue','^({0-9}+)$','','','Form HW-4, Section A Line 4','','N')
, (137,'15-000-0000-SIT-000','15','HI','MOST_RECENT_WH','Dollar','Most Recent Withholding Amount','0.0','SingleValue','^({0-9}+({.}{0-9}{0,2})?)','','1','','','N')
, (138,'49-000-0000-SIT-000','49','UT','FILINGSTATUS','String','Filing Status','S','PickList','^(S|M|MH)$','S=Single, M=Married, MH=Married but use single rate','','Form W-4, Box 3','','N')
, (139,'49-000-0000-SIT-000','49','UT','MOST_RECENT_WH','Dollar','Most Recent Withholding Amount','0.0','SingleValue','^({0-9}+({.}{0-9}{0,2})?)','','1','','','N')
, (140,'16-000-0000-SIT-000','16','ID','FILINGSTATUS','String','Filing Status','S','PickList','^(S|M|MH)$','S=Single, M=Married, MH=Married but use single rate','','ID W-4, Withholding Status','','N')
, (141,'16-000-0000-SIT-000','16','ID','TOTALALLOWANCES','Integer','Total Allowances','0','SingleValue','^({0-9}+)$','','','ID W-4, Number 1','','N')
, (142,'16-000-0000-SIT-000','16','ID','MOST_RECENT_WH','Dollar','Most Recent Withholding Amount','0.0','SingleValue','^({0-9}+({.}{0-9}{0,2})?)','','1','','','N')
, (143,'51-000-0000-SIT-000','51','VA','PERSONALEXEMPTIONS','Integer','Personal Exemptions','0','SingleValue','^({0-9}+)$','','','Form VA-4, Line 1(a)','','Y')
, (144,'51-000-0000-SIT-000','51','VA','AGEANDBLINDNESSEXEMPTIONS','Integer','Age and Blindness Exemptions','0','SingleValue','^({0-4})$','','','Form VA-4, Line 1(b)','','Y')
, (145,'51-000-0000-SIT-000','51','VA','MOST_RECENT_WH','Dollar','Most Recent Withholding Amount','0.0','SingleValue','^({0-9}+({.}{0-9}{0,2})?)','','1','','','N')
, (146,'17-000-0000-SIT-000','17','IL','BASICALLOWANCES','Integer','Basic Allowances','0','SingleValue','^({0-9}+)$','','','Form IL-W-4, Number 1','','Y')
, (147,'17-000-0000-SIT-000','17','IL','ADDITIONALALLOWANCES','Integer','Additional Allowances','0','SingleValue','^({0-9}+)$','','','Form IL-W-4, Number 2','','Y')
, (148,'17-000-0000-SIT-000','17','IL','MOST_RECENT_WH','Dollar','Most Recent Withholding Amount','0.0','SingleValue','^({0-9}+({.}{0-9}{0,2})?)','','1','','','N')
, (149,'50-000-0000-ER_EHT-000','50','VT','TOTAL_EMPLOYEES','Integer','Total number of employees','0','SingleValue','^({0-9}+)$','','','','','N')
, (150,'50-000-0000-SIT-000','50','VT','FILINGSTATUS','String','Filing Status','S','PickList','^(S|MJ|MS|MH)$','S=Single, MJ=Married/Civil Union filing jointly, MS=Married/Civil Union filing separately, MH=Married but use single rate','','Form W-4VT, Filing Status','','N')
, (151,'50-000-0000-SIT-000','50','VT','TOTALALLOWANCES','Integer','Total Allowances','0','SingleValue','^({0-9}+)$','','','Form W-4VT, Line 5','','N')
, (152,'50-000-0000-SIT-000','50','VT','NONRESPERCENTAGE','Percentage','Nonresident Percentage','0','SingleValue','^(100(?:{.}0{0,2})?|{0-9}','','1','','','N')
, (153,'50-000-0000-SIT-000','50','VT','MOST_RECENT_WH','Dollar','Most Recent Withholding Amount','0.0','SingleValue','^({0-9}+({.}{0-9}{0,2})?)','','1','','','N')
, (154,'53-000-0000-ER_FLI-000','53','WA','SPLIT_YTD_TAX','Boolean','Split EE and ER Year-to-date Withholding','FALSE','PickList','^(TRUE|FALSE)$','','1','','','N')
, (155,'53-000-0000-ER_SDI-000','53','WA','TOTAL_HOURS','Dollar','Total Hours','0.0','SingleValue','^({0-9}+({.}{0-9}{0,2})?)','','','','','N')
, (156,'53-000-0000-ER_SDI-000','53','WA','RATE_NAME','String','The Rate Name','','SingleValue','^{a-zA-Z0-9 }+$','','','','','N')
, (157,'53-000-0000-FLI-000','53','WA','NUMBER_EMPLOYEES','Integer','Number of Employees','0','SingleValue','^({0-9}+)$','','','','','N')
, (158,'53-000-0000-FLI-000','53','WA','EMPLOYER_ELECTED_PERCENTAGE','Dollar','The employer elected percentage.','0.0','SingleValue','^({0-9}+({.}{0-9}{0,2})?)','','','','','N')
, (159,'53-000-0000-FLI-000','53','WA','EMPLOYER_ELECTED_AMOUNT','Dollar','The employer elected amount.','0.0','SingleValue','^({0-9}+({.}{0-9}{0,2})?)','','','','','N')
, (160,'53-000-0000-FLI-000','53','WA','YTD_WAGES','Dollar','Year-to-date Wages','0.0','SingleValue','^({0-9}+({.}{0-9}{0,2})?)','','','','','N')
, (161,'53-000-0000-FLI-000','53','WA','SPLIT_YTD_TAX','Boolean','Split EE and ER Year-to-date Withholding','FALSE','PickList','^(TRUE|FALSE)$','','1','','','N')
, (162,'53-000-0000-SDI-000','53','WA','TOTAL_HOURS','Dollar','Total Hours','0.0','SingleValue','^({0-9}+({.}{0-9}{0,2})?)','','','','','N')
, (163,'53-000-0000-SDI-000','53','WA','RATE_NAME','String','The Rate Name','','SingleValue','^{a-zA-Z0-9 }+$','','','','','N')
, (164,'54-000-1542678-CITY-000','54','WV','UPFRONT_WITHHOLDING','Boolean','Withhold if the current pay period wages would cause the threshold to be crossed in the month','FALSE','PickList','^(TRUE|FALSE)$','','1','','','N')
, (165,'54-000-1542678-CITY-000','54','WV','DISABLE_PRORATION','Boolean','Withhold the entire monthly tax in a single payroll','FALSE','PickList','^(TRUE|FALSE)$','','1','','','N')
, (166,'25-000-0000-ER_EMAC-000','25','MA','YTD_WAGES','Dollar','Year-to-date Wages','0.0','SingleValue','^({0-9}+({.}{0-9}{0,2})?)','','','','','N')
, (167,'25-000-0000-ER_FLI-000','25','MA','EMPLOYER_FAMILY_EXEMPTION','Boolean','Employer Family Exemption','FALSE','PickList','^(TRUE|FALSE)$','','','','','N')
, (168,'25-000-0000-ER_FLI-000','25','MA','EMPLOYER_MEDICAL_EXEMPTION','Boolean','Employer Medical Exemption','FALSE','PickList','^(TRUE|FALSE)$','','','','','N')
, (169,'25-000-0000-ER_FLI-000','25','MA','SPLIT_YTD_TAX','Boolean','Split EE and ER Year-to-date Withholding','FALSE','PickList','^(TRUE|FALSE)$','','1','','','N')
, (170,'25-000-0000-FLI-000','25','MA','NUMBER_W2_WORKERS','Integer','Number of W2 Employees','0','SingleValue','^({0-9}+)$','','','','','N')
, (171,'25-000-0000-FLI-000','25','MA','NUMBER_1099_WORKERS','Integer','Number of 1099 contractors','0','SingleValue','^({0-9}+)$','','','','','N')
, (172,'25-000-0000-FLI-000','25','MA','EMPLOYER_FAMILY_LEAVE_PERCENTAGE','Dollar','The employer family leave percentage.','0.0','SingleValue','^({0-9}+({.}{0-9}{0,2})?)','','','','','N')
, (173,'25-000-0000-FLI-000','25','MA','EMPLOYER_MEDICAL_LEAVE_PERCENTAGE','Dollar','The employer medical leave percentage.','0.0','SingleValue','^({0-9}+({.}{0-9}{0,2})?)','','','','','N')
, (174,'25-000-0000-FLI-000','25','MA','YTD_WAGES','Dollar','Year-to-date Wages','0.0','SingleValue','^({0-9}+({.}{0-9}{0,2})?)','','','','','N')
, (175,'25-000-0000-FLI-000','25','MA','EMPLOYEE_FAMILY_EXEMPTION','Boolean','Employee Family Exemption','FALSE','PickList','^(TRUE|FALSE)$','','','','','N')
, (176,'25-000-0000-FLI-000','25','MA','EMPLOYEE_MEDICAL_EXEMPTION','Boolean','Employee Medical Exemption','FALSE','PickList','^(TRUE|FALSE)$','','','','','N')
, (177,'25-000-0000-FLI-000','25','MA','SPLIT_YTD_TAX','Boolean','Split EE and ER Year-to-date Withholding','FALSE','PickList','^(TRUE|FALSE)$','','1','','','N')
, (178,'25-000-0000-SIT-000','25','MA','TOTALALLOWANCES','Integer','Total Allowances','0','SingleValue','^({0-9}+)$','','','Form M-4, Line 4','','N')
, (179,'25-000-0000-SIT-000','25','MA','PERSONALBLINDNESS','Boolean','Personal Blindness','FALSE','PickList','^(TRUE|FALSE)$','','','Form M-4, Line 5 Box B','','N')
, (180,'25-000-0000-SIT-000','25','MA','SPOUSEBLINDNESS','Boolean','Spouse Blindness','FALSE','PickList','^(TRUE|FALSE)$','','','Form M-4, Line 5 Box C','','N')
, (181,'25-000-0000-SIT-000','25','MA','HEADOFHOUSEHOLD','Boolean','Head of Household','FALSE','PickList','^(TRUE|FALSE)$','','','Form M-4, Line 5 Box A','','N')
, (182,'25-000-0000-SIT-000','25','MA','FULLTIMESTUDENT','Boolean','Full Time Student','FALSE','PickList','^(TRUE|FALSE)$','','','Form M-4, Line 5 Box D','','N')
, (183,'25-000-0000-SIT-000','25','MA','CURRENT_PENSION_AMT','Dollar','Current Pension Amount','0.0','SingleValue','^({0-9}+({.}{0-9}{0,2})?)','','','','','N')
, (184,'25-000-0000-SIT-000','25','MA','YTD_PENSION_AMT','Dollar','Year-to-date Pension Amount','0.0','SingleValue','^({0-9}+({.}{0-9}{0,2})?)','','','','','N')
, (185,'25-000-0000-SIT-000','25','MA','MOST_RECENT_WH','Dollar','Most Recent Withholding Amount','0.0','SingleValue','^({0-9}+({.}{0-9}{0,2})?)','','1','','','N')
, (186,'24-000-0000-SIT-000','24','MD','PA_RESIDENT_EXEMPTION','Boolean','Maryland State Tax Exemption for PA residents','FALSE','PickList','^(TRUE|FALSE)$','','1','Form MW507, Line 5','','N')
, (187,'24-000-0000-SIT-000','24','MD','FILINGSTATUS','String','Filing Status','S','PickList','^(S|M|MH)$','S=Single, M=Married, MH=Married but use single rate','','Form MW507, Filing Status Box (certificate front)','','N')
, (188,'24-000-0000-SIT-000','24','MD','TOTALALLOWANCES','Integer','Total Allowances','0','SingleValue','^({0-9}+)$','','','Form MW507, Line 1','','N')
, (189,'24-000-0000-SIT-000','24','MD','MOST_RECENT_WH','Dollar','Most Recent Withholding Amount','0.0','SingleValue','^({0-9}+({.}{0-9}{0,2})?)','','1','','','N')
, (190,'23-000-0000-SIT-000','23','ME','FILINGSTATUS','String','Filing Status','S','PickList','^(S|M|MH)$','S=Single or Head of Household, M=Married, MH=Married but use single rate','','Form W-4ME, Box 3','','N')
, (191,'23-000-0000-SIT-000','23','ME','TOTALALLOWANCES','Integer','Total Allowances','0','SingleValue','^({0-9}+)$','','','Form W-4ME, Line 4','','N')
, (192,'23-000-0000-SIT-000','23','ME','MOST_RECENT_WH','Dollar','Most Recent Withholding Amount','0.0','SingleValue','^({0-9}+({.}{0-9}{0,2})?)','','1','','','N')
, (193,'26-000-0000-SIT-000','26','MI','TOTALALLOWANCES','Integer','Total Allowances','0','SingleValue','^({0-9}+)$','','','Form MI-W4, Line 6','','Y')
, (194,'26-000-0000-SIT-000','26','MI','PREDOMINANT_CITY','Integer','Predominant Place of Employment','0','PickList','^(0|619906|620755|1619197','0=None,619906=Albion,620755=Battle Creek,1619197=Big Rapids,1617959=Detroit,626170=Flint,627105=Grand Rapids,627264=Grayling,627707=Hamtramck,628251=Highland Park,628761=Hudson,629060=Ionia,629165=Jackson,1625035=Lansing,630146=Lapeer,1620963=Muskegon,633','','','','Y')
, (195,'26-000-0000-SIT-000','26','MI','MOST_RECENT_WH','Dollar','Most Recent Withholding Amount','0.0','SingleValue','^({0-9}+({.}{0-9}{0,2})?)','','1','','','N')
, (196,'27-000-0000-SIT-000','27','MN','FILINGSTATUS','String','Filing Status','S','PickList','^(S|M|MH)$','S=Single; Married but legally separated; or Spouse is a nonresident alien, M=Married, MH=Married but use single rate','','Form W-4MN, Marital Status Box','','N')
, (197,'27-000-0000-SIT-000','27','MN','TOTALALLOWANCES','Integer','Total Allowances','0','SingleValue','^({0-9}+)$','','','Form W-4MN, Minnesota Allowances (1)','','N')
, (198,'27-000-0000-SIT-000','27','MN','MOST_RECENT_WH','Dollar','Most Recent Withholding Amount','0.0','SingleValue','^({0-9}+({.}{0-9}{0,2})?)','','1','','','N')
, (199,'36-000-971828-CITY-000','36','NY','FILINGSTATUS','String','Filing Status','S','PickList','^(S|M|MH)$','S=Single, M=Married,MH=Married but use single rate','','Form IT-2104, Filing Status Box (certificate front)','','N')
, (200,'36-000-971828-CITY-000','36','NY','TOTALALLOWANCES','Integer','Total Allowances - Yonkers','0','SingleValue','^({0-9}+)$','','1','Form IT-2104, Line 1','','N')
, (201,'36-000-971828-CITY-000','36','NY','ADDITIONALWH-YONKERS','Dollar','Additional Withholding - Yonkers','0.00','SingleValue','^({0-9}+({.}{0-9}{0,2})?)','','1','Form IT-2104, Line 5','','N')
, (202,'18-097-0000-CNTY-000','18','IN','ADDITIONALCOUNTYWITHHOLDING','Dollar','Additional County Withholding','0','SingleValue','^({0-9}+({.}{0-9}{0,2})?)','','1','','','N')
, (203,'39-000-0000-JEDD-138','39','OH','TOTAL_ALLOWANCES','Integer','Total Allowances','0','SingleValue','^({0-9}+)$','','','','','N');
;";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query ="CREATE TABLE `ste_fedstate_exempt` (
  `sno` int(15) NOT NULL AUTO_INCREMENT,
  `exe_stateCode` varchar(255) DEFAULT NULL,
  `exe_parameterName` varchar(55) NOT NULL DEFAULT '',
  `exe_description` varchar(55) NOT NULL DEFAULT '',
  `exe_status` enum('N','Y') DEFAULT 'Y',
  PRIMARY KEY (`sno`),
  KEY `exe_stateCode` (`exe_stateCode`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query ="INSERT INTO ste_fedstate_exempt(sno,exe_stateCode,exe_parameterName,exe_description,exe_status) VALUES (1,'FED','exempt_fwh','Federal Withholding','Y')
, (2,'FED','exempt_soc_med','Social Security & Medicare','Y')
, (3,'FED','exempt_fui','Federal Unemployment Insurance','Y')
, (4,'GA,IA,IN,KS,KY,LA,MO,NC,NJ,NY,OH,PA,WI,IL,VA,MI','exempt_swh','State Withholding','Y')
, (5,'GA,FL,IA,IN,KS,KY,LA,MO,NC,NJ,NY,OH,PA,TN,TX,WI,IL,VA,MI','exempt_sui','State Unemployment Insurance','Y')
, (6,'IN,KY,NC,NJ,NY,OH,PA,IL,VA,MI','exempt_local','Local Taxes','Y')
, (7,'NJ','exempt_fli','Family Leave Insurance','Y')
, (8,'NY','exempt_flb','Family Leave Benefit','Y')
, (9,'NJ,NY','exempt_sdi','SDI','Y');";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);


$query ="CREATE TABLE `hrcon_taxes` (
  `sno` int(15) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(15) NOT NULL DEFAULT '',
  `tax` varchar(10) NOT NULL DEFAULT '',
  `fed_filingstatus` varchar(50) NOT NULL DEFAULT '',
  `fed_two_jobs` ENUM('TRUE','FALSE') DEFAULT 'FALSE',
  `fed_dependents_amt` double(8,2) NOT NULL DEFAULT '0.00',
  `fed_other_income` double(8,2) NOT NULL DEFAULT '0.00',
  `fed_deductions` double(8,2) NOT NULL DEFAULT '0.00',
  `fed_addwh_amt` double(8,2) NOT NULL DEFAULT '0.00',
  `fed_exempt_fwh` ENUM('Y','N') DEFAULT 'N',
  `fed_exempt_soc_med` ENUM('Y','N') DEFAULT 'N',
  `fed_exempt_fui` ENUM('Y','N') DEFAULT 'N',
  `state1_state` char(3) NOT NULL DEFAULT '',
  `state1_filingstatus` varchar(50) NOT NULL DEFAULT '',
  `state1_totalallowances` int(2) NOT NULL DEFAULT '0',
  `state1_personalallowances` int(2) NOT NULL DEFAULT '0',
  `state1_dependentallowances` int(2) NOT NULL DEFAULT '0',
  `state1_annual_wages` double(8,2) NOT NULL DEFAULT '0.00',
  `state1_additionalallowances` int(2) NOT NULL DEFAULT '0',
  `state1_dependentexemptions` int(2) NOT NULL DEFAULT '0',
  `state1_personalexemptions` int(2) NOT NULL DEFAULT '0',
  `state1_totaldependents` int(2) NOT NULL DEFAULT '0',
  `state1_residentpercent` double(5,2) NOT NULL DEFAULT '0.00',
  `state1_nonresidentpercent` double(5,2) NOT NULL DEFAULT '0.00',
  `state1_reduced_wh_amt` double(8,2) NOT NULL DEFAULT '0.00',
  `state1_ratetable` char(2) NOT NULL DEFAULT 'B',
  `state1_pa_wages_only` ENUM('TRUE','FALSE') DEFAULT 'TRUE',
  `state1_basicallowances` int(2) NOT NULL DEFAULT '0',
  `state1_ageandblindnessexemptions` int(2) NOT NULL DEFAULT '0',
  `state1_predominant_city` varchar(50) NOT NULL DEFAULT '',
  `state1_addwh_amt` double(8,2) NOT NULL DEFAULT '0.00',
  `state1_exempt_swh` ENUM('Y','N') DEFAULT 'N',
  `state1_exempt_sui` ENUM('Y','N') DEFAULT 'N',
  `state1_exempt_local` ENUM('Y','N') DEFAULT 'N',
  `state1_exempt_fli` ENUM('Y','N') DEFAULT 'N',
  `state1_exempt_flb` ENUM('Y','N') DEFAULT 'N',
  `state1_exempt_sdi` ENUM('Y','N') DEFAULT 'N',
  `state2_state` char(3) NOT NULL DEFAULT '',
  `state2_filingstatus` varchar(50) NOT NULL DEFAULT '',
  `state2_totalallowances` int(2) NOT NULL DEFAULT '0',
  `state2_personalallowances` int(2) NOT NULL DEFAULT '0',
  `state2_dependentallowances` int(2) NOT NULL DEFAULT '0',
  `state2_annual_wages` double(8,2) NOT NULL DEFAULT '0.00',
  `state2_additionalallowances` int(2) NOT NULL DEFAULT '0',
  `state2_dependentexemptions` int(2) NOT NULL DEFAULT '0',
  `state2_personalexemptions` int(2) NOT NULL DEFAULT '0',
  `state2_totaldependents` int(2) NOT NULL DEFAULT '0',
  `state2_residentpercent` double(5,2) NOT NULL DEFAULT '0.00',
  `state2_nonresidentpercent` double(5,2) NOT NULL DEFAULT '0.00',
  `state2_reduced_wh_amt` double(8,2) NOT NULL DEFAULT '0.00',
  `state2_ratetable` char(2) NOT NULL DEFAULT 'B',
  `state2_pa_wages_only` ENUM('TRUE','FALSE') DEFAULT 'TRUE',
  `state2_basicallowances` int(2) NOT NULL DEFAULT '0',
  `state2_ageandblindnessexemptions` int(2) NOT NULL DEFAULT '0',
  `state2_predominant_city` varchar(50) NOT NULL DEFAULT '',
  `state2_addwh_amt` double(8,2) NOT NULL DEFAULT '0.00',
  `state2_exempt_swh` ENUM('Y','N') DEFAULT 'N',
  `state2_exempt_sui` ENUM('Y','N') DEFAULT 'N',
  `state2_exempt_local` ENUM('Y','N') DEFAULT 'N',
  `state2_exempt_fli` ENUM('Y','N') DEFAULT 'N',
  `state2_exempt_flb` ENUM('Y','N') DEFAULT 'N',
  `state2_exempt_sdi` ENUM('Y','N') DEFAULT 'N',
  `contractor_id` tinyblob,
  `fname` varchar(255) NOT NULL DEFAULT '',
  `mname` varchar(255) NOT NULL DEFAULT '',
  `lname` varchar(255) NOT NULL DEFAULT '',
  `business_name` varchar(255) NOT NULL DEFAULT '',
  `address1` varchar(255) NOT NULL DEFAULT '',
  `address2` varchar(255) NOT NULL DEFAULT '',
  `city` varchar(50) NOT NULL DEFAULT '',
  `state` varchar(50) NOT NULL DEFAULT '',
  `zip` varchar(20) NOT NULL DEFAULT '',
  `ustatus` varchar(15) DEFAULT NULL,
  `udate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_user` int(11) NOT NULL DEFAULT '0',
  `approved_user` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`sno`),
  KEY `username` (`username`),
  KEY `ustatus` (`ustatus`),
  KEY `udate` (`udate`),
  KEY `tax` (`tax`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query = "ALTER TABLE hrcon_contrib 
MODIFY COLUMN frequency INT(15) NOT NULL, MODIFY COLUMN contrib_calc_method INT(15) NOT NULL";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query = "ALTER TABLE hrcon_compen ADD COLUMN `company_id` int(15) NOT NULL DEFAULT 0, ADD INDEX comp_sno (company_id);";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query = "ALTER TABLE consultant_deduct ADD COLUMN ded_status enum('active','inactive') NOT NULL DEFAULT 'active'";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query = "ALTER TABLE consultant_deduct ADD COLUMN udate datetime default NULL;";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);


$query ="CREATE TABLE `steLocationTaxIds` (
  `sno` int(15) NOT NULL AUTO_INCREMENT,
  `locationCode` varchar(30) NOT NULL DEFAULT '',
  `uniqueTaxID` varchar(50) NOT NULL DEFAULT '',
  `stateCode` char(2) NOT NULL DEFAULT '',
  `stateAbbreviation` char(3) NOT NULL DEFAULT '',
  `taxType` varchar(50) NOT NULL DEFAULT '',
  `description` varchar(100) NOT NULL DEFAULT '',
  `isEmployerTax` char(5) NOT NULL DEFAULT '',
  `isResident` char(5) NOT NULL DEFAULT '',
  `rate` double(10,6) NOT NULL DEFAULT '0.000000',
  `wageBase` double(15,6) NOT NULL DEFAULT '0.000000',
  `credit` double(10,6) NOT NULL DEFAULT '0.000000',
  `creditLimit` double(10,6) NOT NULL DEFAULT '0.000000',
  `taxLimit` double(10,6) NOT NULL DEFAULT '0.000000',
  `taxLimitPeriod` varchar(25) NOT NULL DEFAULT '',
  `taxEffectiveDate` date NOT NULL DEFAULT '0000-00-00',
  `taxInstallationDate` date NOT NULL DEFAULT '0000-00-00',
  PRIMARY KEY (`sno`),
  UNIQUE KEY `loc_taxid` (`locationCode`,`uniqueTaxID`)
) ENGINE=MyISAM AUTO_INCREMENT=63 DEFAULT CHARSET=latin1;";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query ="INSERT INTO `steLocationTaxIds` VALUES (1,'00-000-0000-0000-0000','00-000-0000-ER_FICA-000','00','FED','Federal','Employer FICA Tax','1','1',0.062000,142800.000000,0.000000,0.000000,8853.600000,'Annually','2021-01-01','2020-10-19'),(2,'00-000-0000-0000-0000','00-000-0000-ER_FUTA-000','00','FED','Federal','Federal Unemployment Tax','1','1',0.060000,7000.000000,0.000000,0.000000,0.000000,'None','2011-07-01','2011-07-01'),(3,'00-000-0000-0000-0000','00-000-0000-ER_MEDI-000','00','FED','Federal','Employer Medicare Tax','1','1',0.014500,0.000000,0.000000,0.000000,0.000000,'None','1900-01-01','1900-01-01'),(4,'00-000-0000-0000-0000','00-000-0000-FICA-000','00','FED','Federal','FICA','','1',0.062000,142800.000000,0.000000,0.000000,8853.600000,'Annually','2021-01-01','2020-10-19'),(5,'00-000-0000-0000-0000','00-000-0000-FIT-000','00','FED','Federal','Federal Income Tax','','1',0.000000,0.000000,0.000000,0.000000,0.000000,'None','1900-01-01','1900-01-01'),(6,'00-000-0000-0000-0000','00-000-0000-MEDI-000','00','FED','Federal','Medicare','','1',0.014500,0.000000,0.000000,0.000000,0.000000,'None','1900-01-01','1900-01-01'),(7,'00-000-0000-0000-0000','00-000-0000-MEDI2-000','00','FED','Federal','Additional Medicare','','1',0.009000,0.000000,0.000000,0.000000,0.000000,'None','2013-01-01','2013-01-01'),(8,'33-011-868677-0000-0000','33-000-0000-ER_SUTA-000','33','NH','State','New Hampshire State Unemployment Tax','1','1',0.000000,14000.000000,0.000000,0.000000,0.000000,'None','2012-01-01','2012-01-01'),(9,'33-011-868677-0000-0000','33-000-0000-ER_SUTA_SC-024','33','NH','Local','New Hampshire Administrative Contribution','1','1',0.004000,14000.000000,0.000000,0.000000,56.000000,'Annually','2019-10-01','2019-12-23'),(10,'12-103-280543-0000-0000','12-000-0000-ER_SUTA-000','12','FL','State','Florida State Unemployment Tax','1','1',0.000000,7000.000000,0.000000,0.000000,0.000000,'None','2015-01-01','2015-01-01'),(11,'13-089-331589-0000-0000','13-000-0000-ER_SUTA-000','13','GA','State','Georgia State Unemployment Tax','1','1',0.000000,9500.000000,0.000000,0.000000,0.000000,'None','2013-01-01','2013-01-01'),(12,'13-089-331589-0000-0000','13-000-0000-ER_SUTA_SC-011','13','GA','Local','Georgia Administrative Assessment Tax','1','1',0.000600,9500.000000,0.000000,0.000000,5.700000,'Annually','2017-01-01','2017-01-17'),(13,'13-089-331589-0000-0000','13-000-0000-SIT-000','13','GA','State','Georgia State Tax','','1',0.000000,0.000000,0.000000,0.000000,0.000000,'None','1900-01-01','1900-01-01'),(14,'19-013-462727-0000-0000','19-000-0000-ER_SUTA-000','19','IA','State','Iowa State Unemployment Tax','1','1',0.000000,32400.000000,0.000000,0.000000,0.000000,'None','2021-01-01','2020-10-13'),(15,'19-013-462727-0000-0000','19-000-0000-SIT-000','19','IA','State','Iowa State Tax','','1',0.000000,0.000000,0.000000,0.000000,0.000000,'None','1900-01-01','1900-01-01'),(16,'55-025-1581834-0000-0000','55-000-0000-ER_SUTA-000','55','WI','State','Wisconsin State Unemployment Tax','1','1',0.000000,14000.000000,0.000000,0.000000,0.000000,'None','2013-01-01','2013-01-01'),(17,'55-025-1581834-0000-0000','55-000-0000-SIT-000','55','WI','State','Wisconsin State Tax','','1',0.000000,0.000000,0.000000,0.000000,0.000000,'None','2011-01-01','2016-10-25'),(18,'18-063-430358-0000-0000','18-000-0000-ER_SUTA-000','18','IN','State','Indiana State Unemployment Tax','1','1',0.000000,9500.000000,0.000000,0.000000,0.000000,'None','2011-01-01','2011-01-01'),(19,'18-063-430358-0000-0000','18-000-0000-SIT-000','18','IN','State','Indiana State Tax','','1',0.032300,0.000000,0.000000,0.000000,0.000000,'None','2017-01-01','2017-02-28'),(20,'18-063-430358-0000-0000','18-063-0000-CNTY-000','18','IN','County','Hendricks County Tax','','1',0.017000,0.000000,0.000000,0.000000,0.000000,'None','2019-10-01','2019-09-27'),(21,'20-091-478925-0000-0000','20-000-0000-ER_SUTA-000','20','KS','State','Kansas State Unemployment Tax','1','1',0.000000,14000.000000,0.000000,0.000000,0.000000,'None','2016-01-01','2016-01-01'),(22,'20-091-478925-0000-0000','20-000-0000-SIT-000','20','KS','State','Kansas State Tax','','1',0.000000,0.000000,0.000000,0.000000,0.000000,'None','1900-01-01','1900-01-01'),(23,'21-111-509453-0000-02990','21-000-0000-ER_SUTA-000','21','KY','State','Kentucky State Unemployment Tax','1','1',0.000000,10800.000000,0.000000,0.000000,0.000000,'None','2020-01-01','2019-11-11'),(24,'21-111-509453-0000-02990','21-000-0000-SIT-000','21','KY','State','Kentucky State Tax','','1',0.050000,0.000000,0.000000,0.000000,0.000000,'None','2018-01-01','2018-05-14'),(25,'21-111-509453-0000-02990','21-111-0000-OLF-000','21','KY','County','Louisville / Jefferson County - OLF','','1',0.014500,0.000000,0.000000,0.000000,0.000000,'None','1900-01-01','1900-01-01'),(26,'21-111-509453-0000-02990','21-111-0000-OLTS-000','21','KY','County','Louisville / Jefferson County - OLTS','','1',0.007500,0.000000,0.000000,0.000000,0.000000,'None','1900-01-01','1900-01-01'),(27,'48-439-1336834-0000-0000','48-000-0000-ER_SUTA-000','48','TX','State','Texas State Unemployment Tax','1','1',0.000000,9000.000000,0.000000,0.000000,0.000000,'None','2009-01-01','2009-01-01'),(28,'22-071-1629985-0000-0000','22-000-0000-ER_SUTA-000','22','LA','State','Louisiana State Unemployment Tax','1','1',0.000000,7700.000000,0.000000,0.000000,0.000000,'None','2010-01-01','2010-01-01'),(29,'22-071-1629985-0000-0000','22-000-0000-SIT-000','22','LA','State','Louisiana State Tax','','1',0.000000,0.000000,0.000000,0.000000,0.000000,'None','1900-01-01','1900-01-01'),(30,'29-095-748198-0000-0000','29-000-0000-ER_SUTA-000','29','MO','State','Missouri State Unemployment Tax','1','1',0.000000,11000.000000,0.000000,0.000000,0.000000,'None','2021-01-01','2020-10-13'),(31,'29-095-748198-0000-0000','29-000-0000-SIT-000','29','MO','State','Missouri State Tax','','1',0.000000,0.000000,0.000000,0.000000,0.000000,'None','1900-01-01','1900-01-01'),(32,'29-095-748198-0000-0000','29-000-748198-CITY-000','29','MO','City','Kansas City City Tax','','1',0.010000,0.000000,0.000000,0.000000,0.000000,'None','1900-01-01','1900-01-01'),(33,'47-037-2405092-0000-0000','47-000-0000-ER_SUTA-000','47','TN','State','Tennessee State Unemployment Tax','1','1',0.000000,7000.000000,0.000000,0.000000,0.000000,'None','2018-01-01','2017-12-12'),(34,'37-133-987502-0000-0000','37-000-0000-ER_SUTA-000','37','NC','State','North Carolina State Unemployment Tax','1','1',0.000000,26000.000000,0.000000,0.000000,0.000000,'None','2021-01-01','2020-11-24'),(35,'37-133-987502-0000-0000','37-000-0000-SIT-000','37','NC','State','North Carolina State Tax','','1',0.000000,0.000000,0.000000,0.000000,0.000000,'None','1900-01-01','1900-01-01'),(36,'42-003-1213644-1214818-027451','42-000-0000-ER_SUTA-000','42','PA','State','Pennsylvania State Unemployment Tax','1','1',0.000000,10000.000000,0.000000,0.000000,0.000000,'None','2018-01-01','2017-10-30'),(37,'42-003-1213644-1214818-027451','42-000-0000-SIT-000','42','PA','State','Pennsylvania State Tax','','1',0.030700,0.000000,0.000000,0.000000,0.000000,'None','1900-01-01','1900-01-01'),(38,'42-003-1213644-1214818-027451','42-000-0000-SUI-000','42','PA','State','Pennsylvania SUI','','1',0.000600,0.000000,0.000000,0.000000,0.000000,'Annually','2018-01-01','2017-10-30'),(39,'42-003-1213644-1214818-027451','42-000-1213644-ER_POP-006','42','PA','City','Pittsburgh Payroll Tax','1','1',0.005500,0.000000,0.000000,0.000000,0.000000,'Annually','1900-01-01','1900-01-01'),(40,'42-003-1213644-1214818-027451','42-003-1214818-EIT-027451','42','PA','County','Pittsburgh - EIT - Pittsburgh S D (027451)','','1',0.030000,0.000000,0.000000,0.000000,0.000000,'None','2011-01-01','2011-01-01'),(41,'42-003-1213644-1214818-027451','42-003-1214818-LST-027451','42','PA','County','Pittsburgh - LST - Pittsburgh S D (027451)','','1',52.000000,0.000000,0.000000,0.000000,52.000000,'Annually','2011-01-01','2011-01-01'),(42,'39-009-1075290-0000-0502','39-000-0000-ER_SUTA-000','39','OH','State','Ohio State Unemployment Tax','1','1',0.000000,9000.000000,0.000000,0.000000,0.000000,'None','2020-01-01','2019-11-11'),(43,'39-009-1075290-0000-0502','39-000-0000-SIT-000','39','OH','State','Ohio State Tax','','1',0.000000,0.000000,0.000000,0.000000,0.000000,'None','1900-01-01','1900-01-01'),(44,'39-009-1075290-0000-0502','39-000-1075290-CITY-000','39','OH','City','Athens City Tax','','1',0.018500,0.000000,100.000000,1.250000,0.000000,'None','2017-01-01','2016-12-27'),(45,'39-009-1075290-0000-0502','39-000-0000-SCHL-0502','39','OH','Local','Athens CSD (0502) Tax','','1',0.010000,0.000000,0.000000,0.000000,0.000000,'None','2007-01-01','2007-01-01'),(46,'36-005-975772-0000-0000','36-000-0000-ER_ECET-000','36','NY','State','New York Employer Compensation Expense Tax','1','1',0.050000,0.000000,0.000000,0.000000,0.000000,'None','2021-01-01','2019-10-08'),(47,'36-005-975772-0000-0000','36-000-0000-ER_POP-001','36','NY','Local','NY Waterfront Payroll Tax - Employer (only select NY Harbor Employers)','1','1',0.016000,0.000000,0.000000,0.000000,0.000000,'None','2021-07-01','2021-11-16'),(48,'36-005-975772-0000-0000','36-000-0000-ER_POP-008?>?    ?>?                    ???            ?~?    (??            ?     @      ?            000000,'None','2012-04-01','2012-04-01'),(49,'36-005-975772-0000-0000','36-000-0000-ER_SUTA-000','36','NY','State','New York State Unemployment Tax','1','1',0.000000,11800.000000,0.000000,0.000000,0.000000,'None','2021-01-01','2020-10-26'),(50,'36-005-975772-0000-0000','36-000-0000-ER_SUTA_SC-025','36','NY','Local','New York Reemployment Fund','1','1',0.000750,11800.000000,0.000000,0.000000,8.850000,'Annually','2021-01-01','2020-10-26'),(51,'36-005-975772-0000-0000','36-000-0000-FLI-000','36','NY','State','New York Paid Family Leave Insurance','','1',0.005110,75408.840000,0.000000,0.000000,385.340000,'Annually','2021-01-01','2020-10-06'),(52,'36-005-975772-0000-0000','36-000-0000-SDI-000','36','NY','State','New York SDI','','1',0.005000,0.000000,0.000000,0.000000,0.600000,'Weekly','1900-01-01','1900-01-01'),(53,'36-005-975772-0000-0000','36-000-0000-SIT-000','36','NY','State','New York State Tax','','1',0.000000,0.000000,0.000000,0.000000,0.000000,'None','1900-01-01','1900-01-01'),(54,'36-005-975772-0000-0000','36-000-975772-CITY-000','36','NY','City','New York City Tax','','1',0.042500,0.000000,0.000000,0.000000,0.000000,'None','1900-01-01','1900-01-01'),(55,'34-001-874247-0000-0000','34-000-0000-ER_POP-001','34','NJ','Local','NJ Waterfront Payroll Tax - Employer (only select NJ Harbor Employers)','1','1',0.016000,0.000000,0.000000,0.000000,0.000000,'None','2021-07-01','2021-11-16'),(56,'34-001-874247-0000-0000','34-000-0000-ER_SDI-001','34','NJ','Local','New Jersey Employer SDI','1','1',0.005000,36200.000000,0.000000,0.000000,181.000000,'Annually','2021-01-01','2020-10-06'),(57,'34-001-874247-0000-0000','34-000-0000-ER_SUTA-000','34','NJ','State','New Jersey State Unemployment Tax','1','1',0.000000,36200.000000,0.000000,0.000000,0.000000,'None','2021-01-01','2020-11-02'),(58,'34-001-874247-0000-0000','34-000-0000-ER_SUTA_SC-048','34','NJ','Local','NJ Work Force Development/Supplemental Work Force','1','1',0.001175,36200.000000,0.000000,0.000000,42.540000,'Annually','2021-01-01','2020-11-09'),(59,'34-001-874247-0000-0000','34-000-0000-FLI-000','34','NJ','State','New Jersey Family Leave Insurance','','1',0.002800,138200.000000,0.000000,0.000000,386.960000,'Annually','2021-01-01','2020-12-03'),(60,'34-001-874247-0000-0000','34-000-0000-SDI-000','34','NJ','State','New Jersey SDI','','1',0.004700,138200.000000,0.000000,0.000000,649.540000,'Annually','2021-01-01','2020-11-23'),(61,'34-001-874247-0000-0000','34-000-0000-SIT-000','34','NJ','State','New Jersey State Tax','','1',0.000000,0.000000,0.000000,0.000000,0.000000,'None','2016-01-01','2016-10-25'),(62,'34-001-874247-0000-0000','34-000-0000-SUI-000','34','NJ','State','New Jersey SUI','','1',0.004250,36200.000000,0.000000,0.000000,153.850000,'Annually','2021-01-01','2020-11-02'),(63,'54-019-1544297-0000-0000','54-000-0000-ER_SUTA-000','54','WV','State','West Virginia State Unemployment Tax','1','1',0.000000,12000.000000,0.000000,0.000000,0.000000,'None','2009-01-01','2009-01-01'),(64,'54-019-1544297-0000-0000','54-000-0000-SIT-000','54','WV','State','West Virginia State Tax','','1',0.000000,0.000000,0.000000,0.000000,0.000000,'None','1900-01-01','1900-01-01'),(65,'06-085-277611-0000-0000','06-000-0000-ER_SUTA-000','06','CA','State','California State Unemployment Tax','1','1',0.000000,7000.000000,0.000000,0.000000,0.000000,'None','2009-01-01','2009-01-01'),(66,'06-085-277611-0000-0000','06-000-0000-ER_SUTA_SC-004','06','CA','Local','California Employment Training Tax','1','1',0.001000,7000.000000,0.000000,0.000000,7.000000,'Annually','1900-01-01','1900-01-01'),(67,'06-085-277611-0000-0000','06-000-0000-SDI-000','06','CA','State','California SDI','','1',0.012000,128298.000000,0.000000,0.000000,1539.580000,'Annually','2021-01-01','2020-12-07'),(68,'06-085-277611-0000-0000','06-000-0000-SIT-000','06','CA','State','California State Tax','','1',0.000000,0.000000,0.000000,0.000000,0.000000,'None','1900-01-01','1900-01-01'),(69,'28-073-691565-0000-0000','28-000-0000-ER_SUTA-000','28','MS','State','Mississippi State Unemployment Tax','1','1',0.000000,14000.000000,0.000000,0.000000,0.000000,'None','2011-01-01','2011-01-01'),(70,'28-073-691565-0000-0000','28-000-0000-ER_SUTA_SC-020','28','MS','Local','Mississippi Workforce Training Enhancement','1','1',0.002000,14000.000000,0.000000,0.000000,28.000000,'Annually','2017-01-01','2017-03-07'),(71,'28-073-691565-0000-0000','28-000-0000-SIT-000','28','MS','State','Mississippi State Tax','','1',0.000000,0.000000,0.000000,0.000000,0.000000,'None','1900-01-01','1900-01-01'),(72,'30-031-769173-0000-0000','30-000-0000-ER_SUTA-000','30','MT','State','Montana State Unemployment Tax','1','1',0.000000,35300.000000,0.000000,0.000000,0.000000,'None','2021-01-01','2020-10-26'),(73,'30-031-769173-0000-0000','30-000-0000-ER_SUTA_SC-022','30','MT','Local','Montana Administrative Fund Tax','1','1',0.000000,35300.000000,0.000000,0.000000,0.000000,'None','2021-01-01','2020-10-26'),(74,'30-031-769173-0000-0000','30-000-0000-SIT-000','30','MT','State','Montana State Tax','','1',0.000000,0.000000,0.000000,0.000000,0.000000,'None','1900-01-01','1900-01-01'),(75,'02-110-1404263-0000-0000','02-000-0000-ER_SUTA-000','02','AK','State','Alaska State Unemployment Tax','1','1',0.000000,43600.000000,0.000000,0.000000,0.000000,'None','2021-01-01','2020-12-07'),(76,'02-110-1404263-0000-0000','02-000-0000-SUI-000','02','AK','State','Alaska SUI','','1',0.005000,43600.000000,0.000000,0.000000,218.000000,'Annually','2021-01-01','2020-12-07'),(77,'01-097-0003042966108814299-0000-0000','01-000-0000-ER_SUTA-000','01','AL','State','Alabama State Unemployment Tax','1','1',0.000000,8000.000000,0.000000,0.000000,0.000000,'None','2009-01-01','2009-01-01'),(78,'01-097-0003042966108814299-0000-0000','01-000-0000-ER_SUTA_SC-001','01','AL','Local','Alabama Employment Security Assessment','1','1',0.000600,8000.000000,0.000000,0.000000,4.800000,'Annually','1900-01-01','1900-01-01'),(79,'01-097-0003042966108814299-0000-0000','01-000-0000-SIT-000','01','AL','State','Alabama State Tax','','1',0.000000,0.000000,0.000000,0.000000,0.000000,'None','2018-01-01','2017-05-08'),(80,'38-015-1035849-0000-0000','38-000-0000-ER_SUTA-000','38','ND','State','North Dakota State Unemployment Tax','1','1',0.000000,38500.000000,0.000000,0.000000,0.000000,'None','2021-01-01','2020-12-07'),(81,'38-015-1035849-0000-0000','38-000-0000-SIT-000','38','ND','State','North Dakota State Tax','','1',0.000000,0.000000,0.000000,0.000000,0.000000,'None','1900-01-01','1900-01-01'),(82,'31-055-835483-0000-0000','31-000-0000-ER_SUTA-000','31','NE','State','Nebraska State Unemployment Tax','1','1',0.000000,9000.000000,0.000000,0.000000,0.000000,'None','2009-01-01','2009-01-01'),(83,'31-055-835483-0000-0000','31-000-0000-SIT-000','31','NE','State','Nebraska State Tax','','1',0.000000,0.000000,0.000000,0.000000,0.000000,'None','1900-01-01','1900-01-01'),(84,'05-143-76914-0000-0000','05-000-0000-ER_SUTA-000','05','AR','State','Arkansas State Unemployment Tax','1','1',0.000000,10000.000000,0.000000,0.000000,0.000000,'None','2021-01-01','2020-10-26'),(85,'05-143-76914-0000-0000','05-000-0000-SIT-000','05','AR','State','Arkansas State Tax','','1',0.000000,0.000000,0.000000,0.000000,0.000000,'None','1900-01-01','1900-01-01'),(86,'33-001-0004348699107152754-0000-0000','33-000-0000-ER_SUTA-000','33','NH','State','New Hampshire State Unemployment Tax','1','1',0.000000,14000.000000,0.000000,0.000000,0.000000,'None','2012-01-01','2012-01-01'),(87,'33-001-0004348699107152754-0000-0000','33-000-0000-ER_SUTA_SC-024','33','NH','Local','New Hampshire Administrative Contribution','1','1',0.004000,14000.000000,0.000000,0.000000,56.000000,'Annually','2019-10-01','2019-12-23'),(88,'04-013-0003355459111187606-0000-0000','04-000-0000-ER_SUTA-000','04','AZ','State','Arizona State Unemployment Tax','1','1',0.000000,7000.000000,0.000000,0.000000,0.000000,'None','2009-01-01','2009-01-01'),(89,'04-013-0003355459111187606-0000-0000','04-000-0000-SIT-000','04','AZ','State','Arizona State Tax','','1',0.000000,0.000000,0.000000,0.000000,0.000000,'None','1900-01-01','1900-01-01'),(90,'06-109-2413660-0000-0000','06-000-0000-ER_SUTA-000','06','CA','State','California State Unemployment Tax','1','1',0.000000,7000.000000,0.000000,0.000000,0.000000,'None','2009-01-01','2009-01-01'),(91,'06-109-2413660-0000-0000','06-000-0000-ER_SUTA_SC-004','06','CA','Local','California Employment Training Tax','1','1',0.001000,7000.000000,0.000000,0.000000,7.000000,'Annually','1900-01-01','1900-01-01'),(92,'06-109-2413660-0000-0000','06-000-0000-SDI-000','06','CA','State','California SDI','','1',0.012000,128298.000000,0.000000,0.000000,1539.580000,'Annually','2021-01-01','2020-12-07'),(93,'06-109-2413660-0000-0000','06-000-0000-SIT-000','06','CA','State','California State Tax','','1',0.000000,0.000000,0.000000,0.000000,0.000000,'None','1900-01-01','1900-01-01'),(94,'35-031-902825-0000-0000','35-000-0000-ER_SUTA-000','35','NM','State','New Mexico State Unemployment Tax','1','1',0.000000,27000.000000,0.000000,0.000000,0.000000,'None','2021-01-01','2020-11-09'),(95,'35-031-902825-0000-0000','35-000-0000-SIT-000','35','NM','State','New Mexico State Tax','','1',0.000000,0.000000,0.000000,0.000000,0.000000,'None','1900-01-01','1900-01-01'),(96,'32-003-1867345-0000-0000','32-000-0000-ER_POP-002','32','NV','Local','Nevada MBT Financial Institution','1','1',0.018530,0.000000,0.000000,0.000000,0.000000,'None','2019-07-01','2021-07-27'),(97,'32-003-1867345-0000-0000','32-000-0000-ER_POP-003','32','NV','Local','Nevada MBT General Business','1','1',0.013780,0.000000,0.000000,0.000000,0.000000,'None','2019-07-01','2021-07-27'),(98,'32-003-1867345-0000-0000','32-000-0000-ER_SUTA-000','32','NV','State','Nevada State Unemployment Tax','1','1',0.000000,33400.000000,0.000000,0.000000,0.000000,'None','2021-01-01','2020-11-02'),(99,'32-003-1867345-0000-0000','32-000-0000-ER_SUTA_SC-023','32','NV','Local','Nevada Career Enhancement Program','1','1',0.000500,33400.000000,0.000000,0.000000,16.700000,'Annually','2021-01-01','2020-11-09'),(100,'08-031-201738-0000-0000','08-000-0000-ER_SUTA-000','08','CO','State','Colorado State Unemployment Tax','1','1',0.000000,13600.000000,0.000000,0.000000,0.000000,'None','2020-01-01','2019-12-09'),(101,'08-031-201738-0000-0000','08-000-0000-SIT-000','08','CO','State','Colorado State Tax','','1',0.045500,0.000000,0.000000,0.000000,0.000000,'None','2021-01-01','2021-01-14'),(102,'08-031-201738-0000-0000','08-000-201738-CITY-000','08','CO','City','Denver City Tax','','1',5.750000,0.000000,0.000000,0.000000,0.000000,'Monthly','1900-01-01','1900-01-01'),(103,'08-031-201738-0000-0000','08-000-201738-ER_EHT-000','08','CO','City','Denver - Employer OPT','1','1',4.000000,0.000000,0.000000,0.000000,0.000000,'Monthly','1900-01-01','1900-01-01'),(104,'40-109-1102140-0000-0000','40-000-0000-ER_SUTA-000','40','OK','State','Oklahoma State Unemployment Tax','1','1',0.000000,24000.000000,0.000000,0.000000,0.000000,'None','2021-01-01','2019-11-09'),(105,'40-109-1102140-0000-0000','40-000-0000-ER_SUTA_SC-057','40','OK','Local','Oklahoma Technology Fund','1','1',0.000000,24000.000000,0.000000,0.000000,0.000000,'None','2021-01-01','2020-11-09'),(106,'40-109-1102140-0000-0000','40-000-0000-SIT-000','40','OK','State','Oklahoma State Tax','','1',0.000000,0.000000,0.000000,0.000000,0.000000,'None','1900-01-01','1900-01-01'),(107,'41-029-1137318-0000-0000','41-000-0000-ER_SUTA-000','41','OR','State','Oregon State Unemployment Tax','1','1',0.000000,43800.000000,0.000000,0.000000,0.000000,'None','2021-01-01','2020-11-23'),(108,'41-029-1137318-0000-0000','41-000-0000-SIT-000','41','OR','State','Oregon State Tax','','1',0.000000,0.000000,0.000000,0.000000,0.000000,'None','1900-01-01','1900-01-01'),(109,'41-029-1137318-0000-0000','41-000-0000-SST-001','41','OR','Local','Metro Supportive Housing Services Income Tax','','1',0.010000,0.000000,0.000000,0.000000,0.000000,'None','2021-01-01','2021-03-30'),(110,'41-029-1137318-0000-0000','41-000-0000-TRANS-000','41','OR','State','Oregon Transit Tax','','1',0.001000,0.000000,0.000000,0.000000,0.000000,'None','2018-07-01','2018-03-26'),(111,'42-101-1209052-1209052-515001','42-000-0000-ER_SUTA-000','42','PA','State','Pennsylvania State Unemployment Tax','1','1',0.000000,10000.000000,0.000000,0.000000,0.000000,'None','2018-01-01','2017-10-30'),(112,'42-101-1209052-1209052-515001','42-000-0000-SIT-000','42','PA','State','Pennsylvania State Tax','','1',0.030700,0.000000,0.000000,0.000000,0.000000,'None','1900-01-01','1900-01-01'),(113,'42-101-1209052-1209052-515001','42-000-0000-SUI-000','42','PA','State','Pennsylvania SUI','','1',0.000600,0.000000,0.000000,0.000000,0.000000,'Annually','2018-01-01','2017-10-30'),(114,'42-101-1209052-1209052-515001','42-000-1209052-CITY-000','42','PA','City','Philadelphia City Tax','','1',0.038398,0.000000,0.000000,0.000000,0.000000,'None','2021-07-01','2021-06-28'),(115,'09-001-0004141649107339707-0000-0000','09-000-0000-ER_SUTA-000','09','CT','State','Connecticut State Unemployment Tax','1','1',0.000000,15000.000000,0.000000,0.000000,0.000000,'None','2009-01-01','2009-01-01'),(116,'09-001-0004141649107339707-0000-0000','09-000-0000-FLI-000','09','CT','State','Connecticut Paid Leave','','1',0.005000,142800.000000,0.000000,0.000000,714.000000,'Annually','2021-01-01','2020-09-29'),(117,'09-001-0004141649107339707-0000-0000','09-000-0000-SIT-000','09','CT','State','Connecticut State Tax','','1',0.000000,0.000000,0.000000,0.000000,0.000000,'None','1900-01-01','1900-01-01'),(118,'11-001-531871-0000-0000','11-000-0000-ER_FLI-000','11','DC','State','DC Paid Family Leave - Employer','1','1',0.006200,0.000000,0.000000,0.000000,0.000000,'None','2019-04-01','2019-04-02'),(119,'11-001-531871-0000-0000','11-000-0000-ER_SUTA-000','11','DC','State','District of Columbia State Unemployment Tax','1','1',0.000000,9000.000000,0.000000,0.000000,0.000000,'None','2009-01-01','2009-01-01'),(120,'11-001-531871-0000-0000','11-000-0000-ER_SUTA_SC-009','11','DC','Local','DC Administrative Funding Tax','1','1',0.002000,9000.000000,0.000000,0.000000,18.000000,'Annually','1900-01-01','1900-01-01'),(121,'11-001-531871-0000-0000','11-000-0000-SIT-000','11','DC','State','District of Columbia Tax','','1',0.000000,0.000000,0.000000,0.000000,0.000000,'None','1900-01-01','1900-01-01'),(122,'44-003-0004166993107150591-0000-0000','44-000-0000-ER_SUTA-000','44','RI','State','Rhode Island State Unemployment Tax','1','1',0.000000,24600.000000,0.000000,0.000000,0.000000,'None','2021-01-01','2020-12-14'),(123,'44-003-0004166993107150591-0000-0000','44-000-0000-ER_SUTA_SC-030','44','RI','Local','Rhode Island Job Development Surcharge','1','1',0.002100,24600.000000,0.000000,0.000000,51.660000,'Annually','2021-01-01','2020-12-14'),(124,'44-003-0004166993107150591-0000-0000','44-000-0000-SDI-000','44','RI','State','Rhode Island SDI','','1',0.013000,74000.000000,0.000000,0.000000,962.000000,'Annually','2021-01-01','2020-12-14'),(125,'44-003-0004166993107150591-0000-0000','44-000-0000-SIT-000','44','RI','State','Rhode Island State Tax','','1',0.000000,0.000000,0.000000,0.000000,0.000000,'None','1900-01-01','1900-01-01'),(126,'10-003-214862-0000-0000','10-000-0000-ER_SUTA-000','10','DE','State','Delaware State Unemployment Tax','1','1',0.000000,16500.000000,0.000000,0.000000,0.000000,'None','2018-01-01','2017-10-24'),(127,'10-003-214862-0000-0000','10-000-0000-ER_SUTA_SC-008','10','DE','Local','Delaware Training Tax','1','1',0.000950,16500.000000,0.000000,0.000000,15.680000,'Annually','2018-01-01','2017-10-24'),(128,'10-003-214862-0000-0000','10-000-0000-SIT-000','10','DE','State','Delaware State Tax','','1',0.000000,0.000000,0.000000,0.000000,0.000000,'None','1900-01-01','1900-01-01'),(129,'10-003-214862-0000-0000','10-000-214862-CITY-000','10','DE','City','Wilmington Earned Income Tax','','1',0.012500,0.000000,0.000000,0.000000,0.000000,'None','1900-01-01','1900-01-01'),(130,'10-003-214862-0000-0000','10-000-214862-ER_EHT-000','10','DE','City','Wilmington Business License Fee - Employer','1','1',15.000000,0.000000,0.000000,0.000000,0.000000,'Monthly','2010-01-01','2019-04-10'),(131,'45-019-1221516-0000-0000','45-000-0000-ER_SUTA-000','45','SC','State','South Carolina State Unemployment Tax','1','1',0.000000,14000.000000?>?    ?>?                    ???            ?~?    (??            ?     @      ?            00-ER_SUTA_SC-032','45','SC','Local','South Carolina SUI Admin Contingency Assessment Tax','1','1',0.000600,14000.000000,0.000000,0.000000,8.400000,'Annually','2015-01-01','2015-01-01'),(133,'45-019-1221516-0000-0000','45-000-0000-SIT-000','45','SC','State','South Carolina State Tax','','1',0.000000,0.000000,0.000000,0.000000,0.000000,'None','1900-01-01','1900-01-01'),(134,'46-103-0004401820110223950-0000-0000','46-000-0000-ER_SUTA-000','46','SD','State','South Dakota State Unemployment Tax','1','1',0.000000,15000.000000,0.000000,0.000000,0.000000,'None','2015-01-01','2015-01-01'),(135,'46-103-0004401820110223950-0000-0000','46-000-0000-ER_SUTA_SC-033','46','SD','Local','South Dakota Employer Investment Fee Tax','1','1',0.000000,15000.000000,0.000000,0.000000,0.000000,'Annually','2015-01-01','2015-01-01'),(136,'46-103-0004401820110223950-0000-0000','46-000-0000-ER_SUTA_SC-058','46','SD','Local','South Dakota Administrative Fee','1','1',0.000200,15000.000000,0.000000,0.000000,0.000000,'Annually','2018-01-01','2020-06-11'),(137,'15-001-362938-0000-0000','15-000-0000-ER_SUTA-000','15','HI','State','Hawaii State Unemployment Tax','1','1',0.000000,47400.000000,0.000000,0.000000,0.000000,'None','2021-01-01','2020-12-07'),(138,'15-001-362938-0000-0000','15-000-0000-ER_SUTA_SC-012','15','HI','Local','Hawaii Employment And Training Tax','1','1',0.000100,47400.000000,0.000000,0.000000,4.740000,'Annually','2021-01-01','2020-12-08'),(139,'15-001-362938-0000-0000','15-000-0000-SDI-000','15','HI','State','Hawaii SDI','','1',0.005000,1102.900000,0.000000,0.000000,5.514500,'Weekly','2021-01-01','2020-12-07'),(140,'15-001-362938-0000-0000','15-000-0000-SIT-000','15','HI','State','Hawaii State Tax','','1',0.000000,0.000000,0.000000,0.000000,0.000000,'None','1900-01-01','1900-01-01'),(141,'49-043-1445755-0000-0000','49-000-0000-ER_SUTA-000','49','UT','State','Utah State Unemployment Tax','1','1',0.000000,38900.000000,0.000000,0.000000,0.000000,'None','2021-01-01','2020-11-24'),(142,'49-043-1445755-0000-0000','49-000-0000-SIT-000','49','UT','State','Utah State Tax','','1',0.049500,0.000000,0.000000,0.000000,0.000000,'None','2018-05-01','2018-04-26'),(143,'16-085-0004428686111608870-0000-0000','16-000-0000-ER_SUTA-000','16','ID','State','Idaho State Unemployment Tax','1','1',0.000000,43000.000000,0.000000,0.000000,0.000000,'None','2021-01-01','2020-12-08'),(144,'16-085-0004428686111608870-0000-0000','16-000-0000-ER_SUTA_SC-049','16','ID','Local','Idaho Workforce Development','1','1',0.000000,43000.000000,0.000000,0.000000,0.000000,'None','2021-01-01','2020-12-08'),(145,'16-085-0004428686111608870-0000-0000','16-000-0000-SIT-000','16','ID','State','Idaho State Tax','','1',0.000000,0.000000,0.000000,0.000000,0.000000,'None','1900-01-01','1900-01-01'),(146,'51-810-1500261-0000-0000','51-000-0000-ER_SUTA-000','51','VA','State','Virginia State Unemployment Tax','1','1',0.000000,8000.000000,0.000000,0.000000,0.000000,'None','2009-01-01','2009-01-01'),(147,'51-810-1500261-0000-0000','51-000-0000-SIT-000','51','VA','State','Virginia State Tax','','1',0.000000,0.000000,0.000000,0.000000,0.000000,'None','1900-01-01','1900-01-01'),(148,'17-031-404907-0000-0000','17-000-0000-ER_SUTA-000','17','IL','State','Illinois State Unemployment Tax','1','1',0.000000,12960.000000,0.000000,0.000000,0.000000,'None','2021-01-01','2020-12-07'),(149,'17-031-404907-0000-0000','17-000-0000-SIT-000','17','IL','State','Illinois State Tax','','1',0.049500,0.000000,0.000000,0.000000,0.000000,'None','2017-07-01','2017-07-10'),(150,'50-001-0004416250107298820-0000-0000','50-000-0000-ER_EHT-000','50','VT','State','Vermont Catamount Healthcare Assessment Tax - Employer','1','1',186.560000,0.000000,0.000000,0.000000,0.000000,'Quarterly','2021-01-01','2020-12-02'),(151,'50-001-0004416250107298820-0000-0000','50-000-0000-ER_SUTA-000','50','VT','State','Vermont State Unemployment Tax','1','1',0.000000,14100.000000,0.000000,0.000000,0.000000,'None','2021-01-01','2020-10-26'),(152,'50-001-0004416250107298820-0000-0000','50-000-0000-SIT-000','50','VT','State','Vermont State Tax','','1',0.000000,0.000000,0.000000,0.000000,0.000000,'None','1900-01-01','1900-01-01'),(153,'53-033-1526014-0000-0000','53-000-0000-ER_FLI-000','53','WA','State','Washington Paid Family & Medical Leave - Employer','1','1',0.001467,142800.000000,0.000000,0.000000,209.460000,'Annually','2021-01-01','2020-10-26'),(154,'53-033-1526014-0000-0000','53-000-0000-ER_SDI-000','53','WA','State','Washington Industrial Insurance - Employer','1','1',0.000000,0.000000,0.000000,0.000000,0.000000,'None','1900-01-01','1900-01-01'),(155,'53-033-1526014-0000-0000','53-000-0000-ER_SUTA-000','53','WA','State','Washington State Unemployment Tax','1','1',0.000000,56500.000000,0.000000,0.000000,0.000000,'None','2021-01-01','2020-11-09'),(156,'53-033-1526014-0000-0000','53-000-0000-ER_SUTA_SC-052','53','WA','Local','Washington Rate Class 1 Thru 40 Employment Admin Fund','1','1',0.000000,56500.000000,0.000000,0.000000,0.000000,'Annually','2021-01-01','2020-11-09'),(157,'53-033-1526014-0000-0000','53-000-0000-FLI-000','53','WA','State','Washington Paid Family & Medical Leave','','1',0.002533,142800.000000,0.000000,0.000000,361.740000,'Annually','2021-01-01','2020-10-26'),(158,'53-033-1526014-0000-0000','53-000-0000-SDI-000','53','WA','State','Washington Industrial Insurance','','1',0.000000,0.000000,0.000000,0.000000,0.000000,'None','1900-01-01','1900-01-01'),(159,'54-005-1542678-0000-0000','54-000-0000-ER_SUTA-000','54','WV','State','West Virginia State Unemployment Tax','1','1',0.000000,12000.000000,0.000000,0.000000,0.000000,'None','2009-01-01','2009-01-01'),(160,'54-005-1542678-0000-0000','54-000-0000-SIT-000','54','WV','State','West Virginia State Tax','','1',0.000000,0.000000,0.000000,0.000000,0.000000,'None','1900-01-01','1900-01-01'),(161,'54-005-1542678-0000-0000','54-000-1542678-CITY-000','54','WV','City','Madison City Tax','','1',1.250000,0.000000,0.000000,0.000000,0.000000,'Weekly','2020-01-01','2020-01-13'),(162,'25-015-0004235476107256021-0000-0000','25-000-0000-ER_EMAC-000','25','MA','State','Massachusetts Employer Medical Assistance Contributions','1','1',0.003400,15000.000000,0.000000,0.000000,51.000000,'None','2020-01-01','2019-12-18'),(163,'25-015-0004235476107256021-0000-0000','25-000-0000-ER_FLI-000','25','MA','State','Massachusetts Paid Family and Medical Leave - Employer','1','1',0.003720,142800.000000,0.000000,0.000000,1071.000000,'Annually','2021-01-01','2020-10-26'),(164,'25-015-0004235476107256021-0000-0000','25-000-0000-ER_SUTA-000','25','MA','State','Massachusetts State Unemployment Tax','1','1',0.000000,15000.000000,0.000000,0.000000,0.000000,'None','2020-01-01','2020-04-20'),(165,'25-015-0004235476107256021-0000-0000','25-000-0000-ER_SUTA_SC-018','25','MA','Local','Massachusetts Workforce Training Fund','1','1',0.000560,15000.000000,0.000000,0.000000,8.400000,'Annually','2015-01-01','2015-01-01'),(166,'25-015-0004235476107256021-0000-0000','25-000-0000-ER_SUTA_SC-062','25','MA','Local','Massachusetts COVID-19 Recovery Assessment','1','1',0.000000,15000.000000,0.000000,0.000000,0.000000,'Annually','2021-01-01','2021-08-02'),(167,'25-015-0004235476107256021-0000-0000','25-000-0000-FLI-000','25','MA','State','Massachusetts Paid Family and Medical Leave - Employee','','1',0.003780,142800.000000,0.000000,0.000000,1071.000000,'Annually','2021-01-01','2020-10-26'),(168,'25-015-0004235476107256021-0000-0000','25-000-0000-SIT-000','25','MA','State','Massachusetts State Tax','','1',0.051500,0.000000,0.000000,0.000000,0.000000,'None','2015-01-01','2015-01-01'),(169,'56-029-1586861-0000-0000','56-000-0000-ER_SUTA-000','56','WY','State','Wyoming State Unemployment Tax','1','1',0.000000,27300.000000,0.000000,0.000000,0.000000,'None','2021-01-01','2020-11-09'),(170,'24-033-597104-0000-0000','24-000-0000-ER_SUTA-000','24','MD','State','Maryland State Unemployment Tax','1','1',0.000000,8500.000000,0.000000,0.000000,0.000000,'None','2009-01-01','2009-01-01'),(171,'24-033-597104-0000-0000','24-000-0000-SIT-000','24','MD','State','Maryland State Tax','','1',0.000000,0.000000,0.000000,0.000000,0.000000,'None','1900-01-01','1900-01-01'),(172,'23-019-561558-0000-0000','23-000-0000-ER_SUTA-000','23','ME','State','Maine State Unemployment Tax','1','1',0.000000,12000.000000,0.000000,0.000000,0.000000,'None','2009-01-01','2009-01-01'),(173,'23-019-561558-0000-0000','23-000-0000-ER_SUTA_SC-041','23','ME','Local','Maine CSSF','1','1',0.000700,12000.000000,0.000000,0.000000,8.400000,'Annually','2021-01-01','2021-01-04'),(174,'23-019-561558-0000-0000','23-000-0000-ER_SUTA_SC-061','23','ME','Local','Maine UPAF','1','1',0.001300,12000.000000,0.000000,0.000000,15.600000,'Annually','2021-01-01','2021-01-06'),(175,'23-019-561558-0000-0000','23-000-0000-SIT-000','23','ME','State','Maine State Tax','','1',0.000000,0.000000,0.000000,0.000000,0.000000,'None','1900-01-01','1900-01-01'),(176,'26-077-0004236815108538658-0000-0000','26-000-0000-ER_SUTA-000','26','MI','State','Michigan State Unemployment Tax','1','1',0.000000,9500.000000,0.000000,0.000000,0.000000,'None','2021-01-01','2021-01-25'),(177,'26-077-0004236815108538658-0000-0000','26-000-0000-SIT-000','26','MI','State','Michigan State Tax','','1',0.042500,0.000000,0.000000,0.000000,0.000000,'None','2012-10-01','2012-10-01'),(178,'27-163-639223-0000-0000','27-000-0000-ER_SUTA-000','27','MN','State','Minnesota State Unemployment Tax','1','1',0.000000,35000.000000,0.000000,0.000000,0.000000,'None','2020-01-01','2019-12-09'),(179,'27-163-639223-0000-0000','27-000-0000-ER_SUTA_SC-019','27','MN','Local','Minnesota Workforce Enhancement Fee','1','1',0.001000,35000.000000,0.000000,0.000000,35.000000,'Annually','2020-01-01','2019-12-09'),(180,'27-163-639223-0000-0000','27-000-0000-ER_SUTA_SC-043','27','MN','Local','Minnesota Federal Loan Interest Assessment','1','1',0.040000,0.000000,0.000000,0.000000,0.000000,'Quarterly','2021-01-01','2021-02-16'),(181,'27-163-639223-0000-0000','27-000-0000-SIT-000','27','MN','State','Minnesota State Tax','','1',0.000000,0.000000,0.000000,0.000000,0.000000,'None','1900-01-01','1900-01-01'),(182,'12-057-292005-0000-0000','12-000-0000-ER_SUTA-000','12','FL','State','Florida State Unemployment Tax','1','1',0.000000,7000.000000,0.000000,0.000000,0.000000,'None','2015-01-01','2015-01-01'),(183,'13-121-351615-0000-0000','13-000-0000-ER_SUTA-000','13','GA','State','Georgia State Unemployment Tax','1','1',0.000000,9500.000000,0.000000,0.000000,0.000000,'None','2013-01-01','2013-01-01'),(184,'13-121-351615-0000-0000','13-000-0000-ER_SUTA_SC-011','13','GA','Local','Georgia Administrative Assessment Tax','1','1',0.000600,9500.000000,0.000000,0.000000,5.700000,'Annually','2017-01-01','2017-01-17'),(185,'13-121-351615-0000-0000','13-000-0000-SIT-000','13','GA','State','Georgia State Tax','','1',0.000000,0.000000,0.000000,0.000000,0.000000,'None','1900-01-01','1900-01-01'),(186,'19-013-455240-0000-0000','19-000-0000-ER_SUTA-000','19','IA','State','Iowa State Unemployment Tax','1','1',0.000000,32400.000000,0.000000,0.000000,0.000000,'None','2021-01-01','2020-10-13'),(187,'19-013-455240-0000-0000','19-000-0000-SIT-000','19','IA','State','Iowa State Tax','','1',0.000000,0.000000,0.000000,0.000000,0.000000,'None','1900-01-01','1900-01-01'),(188,'20-209-478635-0000-0000','20-000-0000-ER_SUTA-000','20','KS','State','Kansas State Unemployment Tax','1','1',0.000000,14000.000000,0.000000,0.000000,0.000000,'None','2016-01-01','2016-01-01'),(189,'20-209-478635-0000-0000','20-000-0000-SIT-000','20','KS','State','Kansas State Tax','','1',0.000000,0.000000,0.000000,0.000000,0.000000,'None','1900-01-01','1900-01-01'),(190,'37-053-0003637620107582890-0000-0000','37-000-0000-ER_SUTA-000','37','NC','State','North Carolina State Unemployment Tax','1','1',0.000000,26000.000000,0.000000,0.000000,0.000000,'None','2021-01-01','2020-11-24'),(191,'37-053-0003637620107582890-0000-0000','37-000-0000-SIT-000','37','NC','State','North Carolina State Tax','','1',0.000000,0.000000,0.000000,0.000000,0.000000,'None','1900-01-01','1900-01-01'),(192,'39-167-1076339-0000-8404','39-000-0000-ER_SUTA-000','39','OH','State','Ohio State Unemployment Tax','1','1',0.000000,9000.000000,0.000000,0.000000,0.000000,'None','2020-01-01','2019-11-11'),(193,'39-167-1076339-0000-8404','39-000-0000-SIT-000','39','OH','State','Ohio State Tax','','1',0.000000,0.000000,0.000000,0.000000,0.000000,'None','1900-01-01','1900-01-01'),(194,'39-167-1076339-0000-8404','39-000-1076339-CITY-000','39','OH','City','Marietta City Tax','','1',0.018500,0.000000,100.000000,1.850000,0.000000,'None','2019-01-01','2019-08-23'),(195,'36-119-971828-0000-0000','36-000-0000-ER_ECET-000','36','NY','State','New York Employer Compensation Expense Tax','1','1',0.050000,0.000000,0.000000,0.000000,0.000000,'None','2021-01-01','2019-10-08'),(196,'36-119-971828-0000-0000','36-000-0000-ER_POP-001','36','NY','Local','NY Waterfront Payroll Tax - Employer (only select NY Harbor Employers)','1','1',0.016000,0.000000,0.000000,0.000000,0.000000,'None','2021-07-01','2021-11-16'),(197,'36-119-971828-0000-0000','36-000-0000-ER_POP-008','36','NY','Local','New York MCTMT Employer Payroll Tax','1','1',0.000000,0.000000,0.000000,0.000000,0.000000,'None','2012-04-01','2012-04-01'),(198,'36-119-971828-0000-0000','36-000-0000-ER_SUTA-000','36','NY','State','New York State Unemployment Tax','1','1',0.000000,11800.000000,0.000000,0.000000,0.000000,'None','2021-01-01','2020-10-26'),(199,'36-119-971828-0000-0000','36-000-0000-ER_SUTA_SC-025','36','NY','Local','New York Reemployment Fund','1','1',0.000750,11800.000000,0.000000,0.000000,8.850000,'Annually','2021-01-01','2020-10-26'),(200,'36-119-971828-0000-0000','36-000-0000-FLI-000','36','NY','State','New York Paid Family Leave Insurance','','1',0.005110,75408.840000,0.000000,0.000000,385.340000,'Annually','2021-01-01','2020-10-06'),(201,'36-119-971828-0000-0000','36-000-0000-SDI-000','36','NY','State','New York SDI','','1',0.005000,0.000000,0.000000,0.000000,0.600000,'Weekly','1900-01-01','1900-01-01'),(202,'36-119-971828-0000-0000','36-000-0000-SIT-000','36','NY','State','New York State Tax','','1',0.000000,0.000000,0.000000,0.000000,0.000000,'None','1900-01-01','1900-01-01'),(203,'36-119-971828-0000-0000','36-000-971828-CITY-000','36','NY','City','Yonkers City Tax','','1',0.016114,0.000000,0.000000,0.000000,0.000000,'None','1900-01-01','1900-01-01'),(204,'34-017-877147-0000-0000','34-000-0000-ER_POP-001','34','NJ','Local','NJ Waterfront Payroll Tax - Employer (only select NJ Harbor Employers)','1','1',0.016000,0.000000,0.000000,0.000000,0.000000,'None','2021-07-01','2021-11-16'),(205,'34-017-877147-0000-0000','34-000-0000-ER_SDI-001','34','NJ','Local','New Jersey Employer SDI','1','1',0.005000,36200.000000,0.000000,0.000000,181.000000,'Annually','2021-01-01','2020-10-06'),(206,'34-017-877147-0000-0000','34-000-0000-ER_SUTA-000','34','NJ','State','New Jersey State Unemployment Tax','1','1',0.000000,36200.000000,0.000000,0.000000,0.000000,'None','2021-01-01','2020-11-02'),(207,'34-017-877147-0000-0000','34-000-0000-ER_SUTA_SC-048','34','NJ','Local','NJ Work Force Development/Supplemental Work Force','1','1',0.001175,36200.000000,0.000000,0.000000,42.540000,'Annually','2021-01-01','2020-11-09'),(208,'34-017-877147-0000-0000','34-000-0000-FLI-000','34','NJ','State','New Jersey Family Leave Insurance','','1',0.002800,138200.000000,0.000000,0.000000,386.960000,'Annually','2021-01-01','2020-12-03'),(209,'34-017-877147-0000-0000','34-000-0000-SDI-000','34','NJ','State','New Jersey SDI','','1',0.004700,138200.000000,0.000000,0.000000,649.540000,'Annually','2021-01-01','2020-11-23'),(210,'34-017-877147-0000-0000','34-000-0000-SIT-000','34','NJ','State','New Jersey State Tax','','1',0.000000,0.000000,0.000000,0.000000,0.000000,'None','2016-01-01','2016-10-25'),(211,'34-017-877147-0000-0000','34-000-0000-SUI-000','34','NJ','State','New Jersey SUI','','1',0.004250,36200.000000,0.000000,0.000000,153.850000,'Annually','2021-01-01','2020-11-02'),(212,'18-097-443930-0000-0000','18-000-0000-ER_SUTA-000','18','IN','State','Indiana State Unemployment Tax','1','1',0.000000,9500.000000,0.000000,0.000000,0.000000,'None','2011-01-01','2011-01-01'),(213,'18-097-443930-0000-0000','18-000-0000-SIT-000','18?>?    ?>?                    ???            ?~?    (??            ?     @      ?            1','2017-02-28'),(214,'18-097-443930-0000-0000','18-097-0000-CNTY-000','18','IN','County','Marion County Tax','','1',0.020200,0.000000,0.000000,0.000000,0.000000,'None','2017-10-01','2017-10-03'),(215,'39-141-1060960-0000-7102','39-000-0000-ER_SUTA-000','39','OH','State','Ohio State Unemployment Tax','1','1',0.000000,9000.000000,0.000000,0.000000,0.000000,'None','2020-01-01','2019-11-11'),(216,'39-141-1060960-0000-7102','39-000-0000-SIT-000','39','OH','State','Ohio State Tax','','1',0.000000,0.000000,0.000000,0.000000,0.000000,'None','1900-01-01','1900-01-01'),(217,'39-141-1060960-0000-7102','39-000-1060960-CITY-000','39','OH','City','Chillicothe City Tax','','1',0.020000,0.000000,50.000000,1.000000,0.000000,'None','2016-01-01','2016-01-01'),(218,'39-049-1080996-0000-2503','39-000-0000-ER_SUTA-000','39','OH','State','Ohio State Unemployment Tax','1','1',0.000000,9000.000000,0.000000,0.000000,0.000000,'None','2020-01-01','2019-11-11'),(219,'39-049-1080996-0000-2503','39-000-0000-SIT-000','39','OH','State','Ohio State Tax','','1',0.000000,0.000000,0.000000,0.000000,0.000000,'None','1900-01-01','1900-01-01'),(220,'39-049-1080996-0000-2503','39-000-0000-JEDD-138','39','OH','Local','Sharon TWP JEDD','','1',0.025000,0.000000,0.000000,0.000000,0.000000,'None','2021-10-01','2021-09-28'),(221,'39-049-1080996-0000-2503','39-000-1080996-CITY-000','39','OH','City','Columbus City Tax','','1',0.025000,0.000000,100.000000,2.500000,0.000000,'None','2009-10-01','2009-10-01'),(222,'12-057-0002783807108210173-0000-0000','12-000-0000-ER_SUTA-000','12','FL','State','Florida State Unemployment Tax','1','1',0.000000,7000.000000,0.000000,0.000000,0.000000,'None','2015-01-01','2015-01-01'),(223,'06-085-277496-0000-0000','06-000-0000-ER_SUTA-000','06','CA','State','California State Unemployment Tax','1','1',0.000000,7000.000000,0.000000,0.000000,0.000000,'None','2009-01-01','2009-01-01'),(224,'06-085-277496-0000-0000','06-000-0000-ER_SUTA_SC-004','06','CA','Local','California Employment Training Tax','1','1',0.001000,7000.000000,0.000000,0.000000,7.000000,'Annually','1900-01-01','1900-01-01'),(225,'06-085-277496-0000-0000','06-000-0000-SDI-000','06','CA','State','California SDI','','1',0.012000,128298.000000,0.000000,0.000000,1539.580000,'Annually','2021-01-01','2020-12-07'),(226,'06-085-277496-0000-0000','06-000-0000-SIT-000','06','CA','State','California State Tax','','1',0.000000,0.000000,0.000000,0.000000,0.000000,'None','1900-01-01','1900-01-01'),(227,'30-027-798996-0000-0000','30-000-0000-ER_SUTA-000','30','MT','State','Montana State Unemployment Tax','1','1',0.000000,35300.000000,0.000000,0.000000,0.000000,'None','2021-01-01','2020-10-26'),(228,'30-027-798996-0000-0000','30-000-0000-ER_SUTA_SC-022','30','MT','Local','Montana Administrative Fund Tax','1','1',0.000000,35300.000000,0.000000,0.000000,0.000000,'None','2021-01-01','2020-10-26'),(229,'30-027-798996-0000-0000','30-000-0000-SIT-000','30','MT','State','Montana State Tax','','1',0.000000,0.000000,0.000000,0.000000,0.000000,'None','1900-01-01','1900-01-01'),(230,'01-073-152018-0000-0000','01-000-0000-ER_SUTA-000','01','AL','State','Alabama State Unemployment Tax','1','1',0.000000,8000.000000,0.000000,0.000000,0.000000,'None','2009-01-01','2009-01-01'),(231,'01-073-152018-0000-0000','01-000-0000-ER_SUTA_SC-001','01','AL','Local','Alabama Employment Security Assessment','1','1',0.000600,8000.000000,0.000000,0.000000,4.800000,'Annually','1900-01-01','1900-01-01'),(232,'01-073-152018-0000-0000','01-000-0000-SIT-000','01','AL','State','Alabama State Tax','','1',0.000000,0.000000,0.000000,0.000000,0.000000,'None','2018-01-01','2017-05-08'),(233,'01-073-152018-0000-0000','01-000-152018-CITY-000','01','AL','City','Leeds City Tax','','1',0.010000,0.000000,0.000000,0.000000,0.000000,'None','1900-01-01','1900-01-01'),(234,'33-001-0004350130107151402-0000-0000','33-000-0000-ER_SUTA-000','33','NH','State','New Hampshire State Unemployment Tax','1','1',0.000000,14000.000000,0.000000,0.000000,0.000000,'None','2012-01-01','2012-01-01'),(235,'33-001-0004350130107151402-0000-0000','33-000-0000-ER_SUTA_SC-024','33','NH','Local','New Hampshire Administrative Contribution','1','1',0.004000,14000.000000,0.000000,0.000000,56.000000,'Annually','2019-10-01','2019-12-23'),(236,'06-085-1654952-0000-0000','06-000-0000-ER_SUTA-000','06','CA','State','California State Unemployment Tax','1','1',0.000000,7000.000000,0.000000,0.000000,0.000000,'None','2009-01-01','2009-01-01'),(237,'06-085-1654952-0000-0000','06-000-0000-ER_SUTA_SC-004','06','CA','Local','California Employment Training Tax','1','1',0.001000,7000.000000,0.000000,0.000000,7.000000,'Annually','1900-01-01','1900-01-01'),(238,'06-085-1654952-0000-0000','06-000-0000-SDI-000','06','CA','State','California SDI','','1',0.012000,128298.000000,0.000000,0.000000,1539.580000,'Annually','2021-01-01','2020-12-07'),(239,'06-085-1654952-0000-0000','06-000-0000-SIT-000','06','CA','State','California State Tax','','1',0.000000,0.000000,0.000000,0.000000,0.000000,'None','1900-01-01','1900-01-01'),(240,'35-015-0003217397110445174-0000-0000','35-000-0000-ER_SUTA-000','35','NM','State','New Mexico State Unemployment Tax','1','1',0.000000,27000.000000,0.000000,0.000000,0.000000,'None','2021-01-01','2020-11-09'),(241,'35-015-0003217397110445174-0000-0000','35-000-0000-SIT-000','35','NM','State','New Mexico State Tax','','1',0.000000,0.000000,0.000000,0.000000,0.000000,'None','1900-01-01','1900-01-01'),(242,'36-061-975772-0000-0000','36-000-0000-ER_ECET-000','36','NY','State','New York Employer Compensation Expense Tax','1','1',0.050000,0.000000,0.000000,0.000000,0.000000,'None','2021-01-01','2019-10-08'),(243,'36-061-975772-0000-0000','36-000-0000-ER_POP-001','36','NY','Local','NY Waterfront Payroll Tax - Employer (only select NY Harbor Employers)','1','1',0.016000,0.000000,0.000000,0.000000,0.000000,'None','2021-07-01','2021-11-16'),(244,'36-061-975772-0000-0000','36-000-0000-ER_POP-008','36','NY','Local','New York MCTMT Employer Payroll Tax','1','1',0.000000,0.000000,0.000000,0.000000,0.000000,'None','2012-04-01','2012-04-01'),(245,'36-061-975772-0000-0000','36-000-0000-ER_SUTA-000','36','NY','State','New York State Unemployment Tax','1','1',0.000000,11800.000000,0.000000,0.000000,0.000000,'None','2021-01-01','2020-10-26'),(246,'36-061-975772-0000-0000','36-000-0000-ER_SUTA_SC-025','36','NY','Local','New York Reemployment Fund','1','1',0.000750,11800.000000,0.000000,0.000000,8.850000,'Annually','2021-01-01','2020-10-26'),(247,'36-061-975772-0000-0000','36-000-0000-FLI-000','36','NY','State','New York Paid Family Leave Insurance','','1',0.005110,75408.840000,0.000000,0.000000,385.340000,'Annually','2021-01-01','2020-10-06'),(248,'36-061-975772-0000-0000','36-000-0000-SDI-000','36','NY','State','New York SDI','','1',0.005000,0.000000,0.000000,0.000000,0.600000,'Weekly','1900-01-01','1900-01-01'),(249,'36-061-975772-0000-0000','36-000-0000-SIT-000','36','NY','State','New York State Tax','','1',0.000000,0.000000,0.000000,0.000000,0.000000,'None','1900-01-01','1900-01-01'),(250,'36-061-975772-0000-0000','36-000-975772-CITY-000','36','NY','City','New York City Tax','','1',0.042500,0.000000,0.000000,0.000000,0.000000,'None','1900-01-01','1900-01-01'),(251,'09-001-210639-0000-0000','09-000-0000-ER_SUTA-000','09','CT','State','Connecticut State Unemployment Tax','1','1',0.000000,15000.000000,0.000000,0.000000,0.000000,'None','2009-01-01','2009-01-01'),(252,'09-001-210639-0000-0000','09-000-0000-FLI-000','09','CT','State','Connecticut Paid Leave','','1',0.005000,142800.000000,0.000000,0.000000,714.000000,'Annually','2021-01-01','2020-09-29'),(253,'09-001-210639-0000-0000','09-000-0000-SIT-000','09','CT','State','Connecticut State Tax','','1',0.000000,0.000000,0.000000,0.000000,0.000000,'None','1900-01-01','1900-01-01'),(254,'44-003-0004166107107154645-0000-0000','44-000-0000-ER_SUTA-000','44','RI','State','Rhode Island State Unemployment Tax','1','1',0.000000,24600.000000,0.000000,0.000000,0.000000,'None','2021-01-01','2020-12-14'),(255,'44-003-0004166107107154645-0000-0000','44-000-0000-ER_SUTA_SC-030','44','RI','Local','Rhode Island Job Development Surcharge','1','1',0.002100,24600.000000,0.000000,0.000000,51.660000,'Annually','2021-01-01','2020-12-14'),(256,'44-003-0004166107107154645-0000-0000','44-000-0000-SDI-000','44','RI','State','Rhode Island SDI','','1',0.013000,74000.000000,0.000000,0.000000,962.000000,'Annually','2021-01-01','2020-12-14'),(257,'44-003-0004166107107154645-0000-0000','44-000-0000-SIT-000','44','RI','State','Rhode Island State Tax','','1',0.000000,0.000000,0.000000,0.000000,0.000000,'None','1900-01-01','1900-01-01'),(258,'10-005-0003871170107510430-0000-0000','10-000-0000-ER_SUTA-000','10','DE','State','Delaware State Unemployment Tax','1','1',0.000000,16500.000000,0.000000,0.000000,0.000000,'None','2018-01-01','2017-10-24'),(259,'10-005-0003871170107510430-0000-0000','10-000-0000-ER_SUTA_SC-008','10','DE','Local','Delaware Training Tax','1','1',0.000950,16500.000000,0.000000,0.000000,15.680000,'Annually','2018-01-01','2017-10-24'),(260,'10-005-0003871170107510430-0000-0000','10-000-0000-SIT-000','10','DE','State','Delaware State Tax','','1',0.000000,0.000000,0.000000,0.000000,0.000000,'None','1900-01-01','1900-01-01'),(261,'45-043-0003351274107908349-0000-0000','45-000-0000-ER_SUTA-000','45','SC','State','South Carolina State Unemployment Tax','1','1',0.000000,14000.000000,0.000000,0.000000,0.000000,'None','2015-01-01','2015-01-01'),(262,'45-043-0003351274107908349-0000-0000','45-000-0000-ER_SUTA_SC-032','45','SC','Local','South Carolina SUI Admin Contingency Assessment Tax','1','1',0.000600,14000.000000,0.000000,0.000000,8.400000,'Annually','2015-01-01','2015-01-01'),(263,'45-043-0003351274107908349-0000-0000','45-000-0000-SIT-000','45','SC','State','South Carolina State Tax','','1',0.000000,0.000000,0.000000,0.000000,0.000000,'None','1900-01-01','1900-01-01'),(264,'46-103-0004406320110221510-0000-0000','46-000-0000-ER_SUTA-000','46','SD','State','South Dakota State Unemployment Tax','1','1',0.000000,15000.000000,0.000000,0.000000,0.000000,'None','2015-01-01','2015-01-01'),(265,'46-103-0004406320110221510-0000-0000','46-000-0000-ER_SUTA_SC-033','46','SD','Local','South Dakota Employer Investment Fee Tax','1','1',0.000000,15000.000000,0.000000,0.000000,0.000000,'Annually','2015-01-01','2015-01-01'),(266,'46-103-0004406320110221510-0000-0000','46-000-0000-ER_SUTA_SC-058','46','SD','Local','South Dakota Administrative Fee','1','1',0.000200,15000.000000,0.000000,0.000000,0.000000,'Annually','2018-01-01','2020-06-11'),(267,'13-089-351615-0000-0000','13-000-0000-ER_SUTA-000','13','GA','State','Georgia State Unemployment Tax','1','1',0.000000,9500.000000,0.000000,0.000000,0.000000,'None','2013-01-01','2013-01-01'),(268,'13-089-351615-0000-0000','13-000-0000-ER_SUTA_SC-011','13','GA','Local','Georgia Administrative Assessment Tax','1','1',0.000600,9500.000000,0.000000,0.000000,5.700000,'Annually','2017-01-01','2017-01-17'),(269,'13-089-351615-0000-0000','13-000-0000-SIT-000','13','GA','State','Georgia State Tax','','1',0.000000,0.000000,0.000000,0.000000,0.000000,'None','1900-01-01','1900-01-01'),(270,'15-001-365355-0000-0000','15-000-0000-ER_SUTA-000','15','HI','State','Hawaii State Unemployment Tax','1','1',0.000000,47400.000000,0.000000,0.000000,0.000000,'None','2021-01-01','2020-12-07'),(271,'15-001-365355-0000-0000','15-000-0000-ER_SUTA_SC-012','15','HI','Local','Hawaii Employment And Training Tax','1','1',0.000100,47400.000000,0.000000,0.000000,4.740000,'Annually','2021-01-01','2020-12-08'),(272,'15-001-365355-0000-0000','15-000-0000-SDI-000','15','HI','State','Hawaii SDI','','1',0.005000,1102.900000,0.000000,0.000000,5.514500,'Weekly','2021-01-01','2020-12-07'),(273,'15-001-365355-0000-0000','15-000-0000-SIT-000','15','HI','State','Hawaii State Tax','','1',0.000000,0.000000,0.000000,0.000000,0.000000,'None','1900-01-01','1900-01-01'),(274,'48-029-0002967359109840345-0000-0000','48-000-0000-ER_SUTA-000','48','TX','State','Texas State Unemployment Tax','1','1',0.000000,9000.000000,0.000000,0.000000,0.000000,'None','2009-01-01','2009-01-01'),(275,'49-035-1439115-0000-0000','49-000-0000-ER_SUTA-000','49','UT','State','Utah State Unemployment Tax','1','1',0.000000,38900.000000,0.000000,0.000000,0.000000,'None','2021-01-01','2020-11-24'),(276,'49-035-1439115-0000-0000','49-000-0000-SIT-000','49','UT','State','Utah State Tax','','1',0.049500,0.000000,0.000000,0.000000,0.000000,'None','2018-05-01','2018-04-26'),(277,'16-001-2409876-0000-0000','16-000-0000-ER_SUTA-000','16','ID','State','Idaho State Unemployment Tax','1','1',0.000000,43000.000000,0.000000,0.000000,0.000000,'None','2021-01-01','2020-12-08'),(278,'16-001-2409876-0000-0000','16-000-0000-ER_SUTA_SC-049','16','ID','Local','Idaho Workforce Development','1','1',0.000000,43000.000000,0.000000,0.000000,0.000000,'None','2021-01-01','2020-12-08'),(279,'16-001-2409876-0000-0000','16-000-0000-SIT-000','16','ID','State','Idaho State Tax','','1',0.000000,0.000000,0.000000,0.000000,0.000000,'None','1900-01-01','1900-01-01'),(280,'17-031-423587-0000-0000','17-000-0000-ER_SUTA-000','17','IL','State','Illinois State Unemployment Tax','1','1',0.000000,12960.000000,0.000000,0.000000,0.000000,'None','2021-01-01','2020-12-07'),(281,'17-031-423587-0000-0000','17-000-0000-SIT-000','17','IL','State','Illinois State Tax','','1',0.049500,0.000000,0.000000,0.000000,0.000000,'None','2017-07-01','2017-07-10'),(282,'18-097-2395424-0000-0000','18-000-0000-ER_SUTA-000','18','IN','State','Indiana State Unemployment Tax','1','1',0.000000,9500.000000,0.000000,0.000000,0.000000,'None','2011-01-01','2011-01-01'),(283,'18-097-2395424-0000-0000','18-000-0000-SIT-000','18','IN','State','Indiana State Tax','','1',0.032300,0.000000,0.000000,0.000000,0.000000,'None','2017-01-01','2017-02-28'),(284,'18-097-2395424-0000-0000','18-097-0000-CNTY-000','18','IN','County','Marion County Tax','','1',0.020200,0.000000,0.000000,0.000000,0.000000,'None','2017-10-01','2017-10-03'),(285,'50-021-0004350879107286988-0000-0000','50-000-0000-ER_EHT-000','50','VT','State','Vermont Catamount Healthcare Assessment Tax - Employer','1','1',186.560000,0.000000,0.000000,0.000000,0.000000,'Quarterly','2021-01-01','2020-12-02'),(286,'50-021-0004350879107286988-0000-0000','50-000-0000-ER_SUTA-000','50','VT','State','Vermont State Unemployment Tax','1','1',0.000000,14100.000000,0.000000,0.000000,0.000000,'None','2021-01-01','2020-10-26'),(287,'50-021-0004350879107286988-0000-0000','50-000-0000-SIT-000','50','VT','State','Vermont State Tax','','1',0.000000,0.000000,0.000000,0.000000,0.000000,'None','1900-01-01','1900-01-01'),(288,'53-033-1512327-0000-0000','53-000-0000-ER_FLI-000','53','WA','State','Washington Paid Family & Medical Leave - Employer','1','1',0.001467,142800.000000,0.000000,0.000000,209.460000,'Annually','2021-01-01','2020-10-26'),(289,'53-033-1512327-0000-0000','53-000-0000-ER_SDI-000','53','WA','State','Washington Industrial Insurance - Employer','1','1',0.000000,0.000000,0.000000,0.000000,0.000000,'None','1900-01-01','1900-01-01'),(290,'53-033-1512327-0000-0000','53-000-0000-ER_SUTA-000','53','WA','State','Washington State Unemployment Tax','1','1',0.000000,56500.000000,0.000000,0.000000,0.000000,'None','2021-01-01','2020-11-09'),(291,'53-033-1512327-0000-0000','53-000-0000-ER_SUTA_SC-052','53','WA','Local','Washington Rate Class 1 Thru 40 Employment Admin Fund','1','1',0.000000,56500.000000,0.000000,0.000000,0.000000,'Annually','2021-01-01','2020-11-09'),(292,'53-033-1512327-0000-0000','53-000-0000-FLI-000','53','WA','State','Washington Paid Family & Medical Leave','','1',0.002533,142800.000000,0.000000,0.000000,361.740000,'Annually','2021-01-01','2020-10-26'),(293,'53-033-1512327-0000-0000','53-000-0000-SDI-000','53','WA','State','Washington Industrial Insurance','','1',0.000000,0.000000,0.000000,0.000000,0.000000,'None','1900-01-01','1900-01-01'),(294,'54-037-0003943510107781670-0000-0000','54-000-0000-ER_SUTA-000','54','WV','State','West Virginia State Unemployment Tax','1','1',0.000000,12000.000000,0.000000,0.000000,0.000000,'None','2009-01-01','2009-01-01'),(295,'54-037-0003943510107781670-0000-0000','54-000-0000-SIT-000','54','WV','State','West Virginia State Tax','','1',0.000000,0.000000,0.000000,0.000000,0.000000,'None','1900-01-01','1900-01-01'),(296,'25-027-611078-0000-0000','25-000-0000-ER_EMAC-000','25','MA','State','Massachusetts Employer Medical Assistance Contributions','1','1',0.003400,15000.000000,0.000000,0.000000,51.000000,'None','2020-01-01','2019-12-18'),(297,'25-027-611078-0000-0000','25-000-0000-ER_FLI-000','25','MA','State','Massachusetts Paid Family and Medical Leave - Employer','1','1',0.003720,142800.000000,0.000000,0.000000,1071.000000,'Annually','2021-01-01','2020-10-26'),(298,'25-027-611078-0000-0000','25-000-0000-ER_SUTA-000','25','MA','State','Massachusetts State Unemployment Tax','1','1',0.000000,15000.000000,0.000000,0.000000,0.000000,'None','2020-01-01','2020-04-20'),(299,'25-027-611078-0000-0000','25-000-0000-ER_SUTA_SC-018','25','MA','Local','Massachusetts Workforce Training Fund','1','1',0.000560,15000.000000,0.000000,0.000000,8.400000,'Annually','2015-01-01','2015-01-01'),(300,'25-027-611078-0000-0000','25-000-0000-ER_SUTA_SC-062','25','MA','Local','Massachusetts COVID-19 Recovery Assessment','1','1',0.000000,15000.000000,0.000000,0.000000,0.000000,'Annually','2021-01-01','2021-08-02'),(301,'25-027-611078-0000-0000','25-000-0000-FLI-000','25','MA','State','Massachusetts Paid Family and Medical Leave - Employee','','1',0.003780,142800.000000,0.000000,0.000000,1071.000000,'Annually','2021-01-01','2020-10-26'),(302,'25-027-611078-0000-0000','25-000-0000-SIT-000','25','MA','State','Massachusetts State Tax','','1',0.051500,0.000000,0.000000,0.000000,0.000000,'None','2015-01-01','2015-01-01'),(303,'23-005-573692-0000-0000','23-000-0000-ER_SUTA-000','23','ME','State','Maine State Unemployment Tax','1','1',0.000000,12000.000000,0.000000,0.000000,0.000000,'None','2009-01-01','2009-01-01'),(304,'23-005-573692-0000-0000','23-000-0000-ER_SUTA_SC-041','23','ME','Local','Maine CSSF','1','1',0.000700,12000.000000,0.000000,0.000000,8.400000,'Annually','2021-01-01','2021-01-04'),(305,'23-005-573692-0000-0000','23-000-0000-ER_SUTA_SC-061','23','ME','Local','Maine UPAF','1','1',0.001300,12000.000000,0.000000,0.000000,15.600000,'Annually','2021-01-01','2021-01-06'),(306,'23-005-573692-0000-0000','23-000-0000-SIT-000','23','ME','State','Maine State Tax','','1',0.000000,0.000000,0.000000,0.000000,0.000000,'None','1900-01-01','1900-01-01'),(307,'26-015-0004242940108540330-0000-0000','26-000-0000-ER_SUTA-000','26','MI','State','Michigan State Unemployment Tax','1','1',0.000000,9500.000000,0.000000,0.000000,0.000000,'None','2021-01-01','2021-01-25'),(308,'26-015-0004242940108540330-0000-0000','26-000-0000-SIT-000','26','MI','State','Michigan State Tax','','1',0.042500,0.000000,0.000000,0.000000,0.000000,'None','2012-10-01','2012-10-01'),(309,'27-137-661145-0000-0000','27-000-0000-ER_SUTA-000','27','MN','State','Minnesota State Unemployment Tax','1','1',0.000000,35000.000000,0.000000,0.000000,0.000000,'None','2020-01-01','2019-12-09'),(310,'27-137-661145-0000-0000','27-000-0000-ER_SUTA_SC-019','27','MN','Local','Minnesota Workforce Enhancement Fee','1','1',0.001000,35000.000000,0.000000,0.000000,35.000000,'Annually','2020-01-01','2019-12-09'),(311,'27-137-661145-0000-0000','27-000-0000-ER_SUTA_SC-043','27','MN','Local','Minnesota Federal Loan Interest Assessment','1','1',0.040000,0.000000,0.000000,0.000000,0.000000,'Quarterly','2021-01-01','2021-02-16'),(312,'27-137-661145-0000-0000','27-000-0000-SIT-000','27','MN','State','Minnesota State Tax','','1',0.000000,0.000000,0.000000,0.000000,0.000000,'None','1900-01-01','1900-01-01');";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

// Departments
$query ="ALTER TABLE department ADD COLUMN company_id INT(15) NOT NULL DEFAULT '0' AFTER depcode, ADD INDEX(company_id)";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

// Garnishments
$query ="ALTER TABLE `consultant_garnishments` ADD COLUMN `admin_fee` DOUBLE(8,2) NOT NULL DEFAULT '0.00'";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);
$query ="ALTER TABLE `consultant_garnishments` ADD COLUMN `garnish_amount` DOUBLE(8,2) NOT NULL DEFAULT '0.00'";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query ="ALTER TABLE `hrcon_garnishments` ADD COLUMN admin_fee DOUBLE(8,2) NOT NULL DEFAULT '0.00'";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);
$query ="ALTER TABLE `hrcon_garnishments` ADD COLUMN `garnish_amount` DOUBLE(8,2) NOT NULL DEFAULT '0.00'";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query ="ALTER TABLE `empcon_garnishments` ADD COLUMN admin_fee DOUBLE(8,2) NOT NULL DEFAULT '0.00'";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);
$query ="ALTER TABLE `empcon_garnishments` ADD COLUMN `garnish_amount` DOUBLE(8,2) NOT NULL DEFAULT '0.00'";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

// Admin Menus

$query ="UPDATE custmenu SET admin=CONCAT(admin,'+Payroll Employer Setup')";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query ="UPDATE custmenu SET admin=REPLACE(admin,'+Payroll Setup','+Timesheet Setup')";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query ="UPDATE custmenu SET admin=CONCAT(admin,'+Payroll Employee Setup')";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query ="UPDATE custmenu SET admin=CONCAT(admin,'+Process Payroll')";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query = "UPDATE sysuser SET admin=CONCAT(TRIM(TRAILING '+' FROM admin),'+') WHERE admin!='NO'"; 
mysql_query($query,$db); 
$contents.= "\n".$query."\n".mysql_error($db);

$query ="UPDATE sysuser SET admin=CONCAT(SUBSTRING_INDEX(admin,'+',40),'+-',REPLACE(admin,SUBSTRING_INDEX(admin,'+',40),'')) WHERE admin!='NO'";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query = "UPDATE sysuser SET admin=CONCAT(TRIM(TRAILING '+' FROM admin),'+') WHERE admin!='NO'"; 
mysql_query($query,$db); 
$contents.= "\n".$query."\n".mysql_error($db);

$query ="UPDATE sysuser SET admin=CONCAT(SUBSTRING_INDEX(admin,'+',41),'+-',REPLACE(admin,SUBSTRING_INDEX(admin,'+',41),'')) WHERE admin!='NO'";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query = "UPDATE sysuser SET admin=CONCAT(TRIM(TRAILING '+' FROM admin),'+') WHERE admin!='NO'"; 
mysql_query($query,$db); 
$contents.= "\n".$query."\n".mysql_error($db);

$query ="UPDATE sysuser SET admin=CONCAT(SUBSTRING_INDEX(admin,'+',42),'+-',REPLACE(admin,SUBSTRING_INDEX(admin,'+',42),'')) WHERE admin!='NO'";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

 $query ="ALTER TABLE er_contributions ADD COLUMN `companycode` VARCHAR(1000) NOT NULL;";
 mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query ="ALTER TABLE contact_manage ADD COLUMN  work_location enum('Y','N') NOT NULL DEFAULT 'N';";
 mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query = "ALTER TABLE consultant_contrib 
MODIFY COLUMN frequency INT(15) NOT NULL, MODIFY COLUMN contrib_calc_method INT(15) NOT NULL";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query = "ALTER TABLE earnings_list MODIFY COLUMN tsdisplay_val VARCHAR(800);";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);
$query = "ALTER TABLE er_contributions MODIFY COLUMN companycode VARCHAR(1000);";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);
$query = "ALTER TABLE deductions_list MODIFY COLUMN companycode VARCHAR(1000);";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);
$query = "ALTER TABLE deductions_list MODIFY COLUMN `effective_date` varchar(255) DEFAULT '';";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query = "ALTER TABLE consultant_compen ADD COLUMN `company_id` INT(15) NOT NULL DEFAULT '0', ADD INDEX comp_sno (company_id);";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query = "ALTER TABLE `hrcon_garnishments` ADD COLUMN `cuser` INT(15) NOT NULL DEFAULT '0'";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query = "ALTER TABLE `hrcon_garnishments` ADD COLUMN `cdate` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query = "ALTER TABLE `empcon_garnishments` ADD COLUMN `cuser` INT(15) NOT NULL DEFAULT '0'";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query = "ALTER TABLE `empcon_garnishments` ADD COLUMN `cdate` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query = "CREATE TABLE `contributions_list` (
  `sno` INT(15) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL DEFAULT '',
  `type` VARCHAR(50) NOT NULL DEFAULT '0',
  `companycode` VARCHAR(1000) DEFAULT NULL,
  `calc_type` INT(15) NOT NULL DEFAULT '0',
  `rate` DOUBLE(10,2) NOT NULL,
  `frequency` INT(15) NOT NULL DEFAULT '0',
  `effective_date` VARCHAR(255) DEFAULT '',
  `dlimit` DOUBLE(10,2) NOT NULL DEFAULT '0.00',
  `irs_max_limit` DOUBLE(10,2) NOT NULL DEFAULT '0.00',
  `display_order` INT(4) NOT NULL,
  `taxation` VARCHAR(255) DEFAULT NULL,
  `w2boxes` VARCHAR(255) DEFAULT NULL,
  `w2codes` VARCHAR(255) DEFAULT NULL,
  `expense_acc` INT(15) NOT NULL DEFAULT '0',
  `liability_acc` INT(15) NOT NULL DEFAULT '0',
  `status` ENUM('active','inactive','backup') DEFAULT 'active',
  `system_default` ENUM('Y','N') DEFAULT 'N',
  `cuser` INT(15) NOT NULL,
  `ctime` DATETIME NOT NULL,
  `muser` INT(15) NOT NULL,
  `mtime` DATETIME NOT NULL,
  PRIMARY KEY (`sno`),
  KEY `status` (`status`)
)";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query = "ALTER TABLE contributions_list MODIFY COLUMN companycode VARCHAR(1000);";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);
$query = "ALTER TABLE hrcon_deduct MODIFY COLUMN type varchar(100) NOT NULL DEFAULT '';";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);
$query = "ALTER TABLE hrcon_deduct ADD COLUMN  ded_status enum('active','inactive') NOT NULL DEFAULT 'active';";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);
$query = "ALTER table consultant_deduct modify frequency int(11) DEFAULT '52';";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query = "ALTER TABLE state_taxes ADD `fileSUI` ENUM('N','Y') NOT NULL DEFAULT 'N';";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query = "INSERT INTO dep_freq (`sno`,`dep_freq_name`,`state_code`,`status`) VALUES 
('','Semi-weekly','IL','active'),
('','Monthly','IL','active'),
('','Semi-weekly','VA','active'),
('','Monthly','VA','active'),
('','Quarterly','VA','active'),
('','Accelerated','MI','active'),
('','Monthly','MI','active'),
('','Quarterly','MI','active'),
('','Annual','MI','active')";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query = "ALTER TABLE consultant_general ADD COLUMN `mail_address1` varchar(100) DEFAULT NULL, 
  ADD COLUMN `mail_address2` varchar(100) DEFAULT NULL,
  ADD COLUMN `mail_city` varchar(50) DEFAULT NULL,
  ADD COLUMN `mail_state` varchar(20) DEFAULT NULL,
  ADD COLUMN `mail_stateid` int(10) NOT NULL DEFAULT '0',ADD INDEX(mail_stateid),
  ADD COLUMN `mail_country` int(15) NOT NULL DEFAULT '0',
  ADD COLUMN `mail_zip` varchar(20) DEFAULT NULL,
  ADD COLUMN  as_residence enum('Y','N') NOT NULL DEFAULT 'N';";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);


$query = "ALTER TABLE `employee_paysetup` 
MODIFY COLUMN  `stdhours_payperiod` varchar(10) NOT NULL DEFAULT '0',
MODIFY COLUMN  `no_days_payperiod` varchar(10) NOT NULL DEFAULT '0';";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query = "ALTER TABLE empcon_deduct ADD COLUMN ded_status enum('active','inactive') NOT NULL DEFAULT 'active'";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query = "ALTER TABLE empcon_deduct ADD COLUMN udate datetime default NULL;";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query = "ALTER TABLE hrcon_jobs ADD COLUMN daypay enum('Yes','No') NOT NULL Default 'No'";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query = "ALTER TABLE consultant_jobs ADD COLUMN daypay enum('Yes','No') NOT NULL Default 'No'";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query = "ALTER TABLE placement_jobs ADD COLUMN daypay enum('Yes','No') NOT NULL Default 'No'";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);


$query = "ALTER TABLE consultant_contrib ADD COLUMN `ustatus` VARCHAR(25) NOT NULL;";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query = "ALTER TABLE hrcon_deduct MODIFY deduction_code varchar(255) NOT NULL;";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query = "ALTER TABLE consultant_deduct MODIFY deduction_code varchar(255) NOT NULL;";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query = "ALTER TABLE empcon_deduct MODIFY deduction_code varchar(255) NOT NULL;";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query = "ALTER TABLE consultant_deduct MODIFY COLUMN type varchar(100) NOT NULL DEFAULT '';";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query = "ALTER TABLE empcon_deduct MODIFY COLUMN type varchar(100) NOT NULL DEFAULT '';";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query = "ALTER TABLE bulk_placement_jobs ADD COLUMN daypay enum('Yes','No') NOT NULL Default 'No'";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query = "ALTER TABLE his_hrcon_jobs ADD COLUMN daypay enum('Yes','No') NOT NULL Default 'No';";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

//Added dayay field in his_hrcon_jobs hence modified after insert trigger.
$query = "DROP TRIGGER hrcon_jobs_ai_trg;";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query = "CREATE TRIGGER `hrcon_jobs_ai_trg` AFTER INSERT ON `hrcon_jobs`
        FOR EACH ROW BEGIN
            SELECT exp_edate,s_date,pamount INTO @expedate,@s_date,@pamount FROM his_hrcon_jobs WHERE pusername=NEW.pusername AND ustatus='backup' ORDER BY mdate DESC LIMIT 1;
        UPDATE his_hrcon_jobs SET ustatus='backup' WHERE pusername=NEW.pusername;
        INSERT INTO his_hrcon_jobs        (sno,username,client,project,manager,s_date,e_date,rate,tsapp,jtype,pusername,rateper,otrate,ustatus,udate,imethod,iterms,pterms,sagent,commision,co_type,endclient,tweeks,tdays,notes,rtime,assg_status,posid,jotype,catid,postitle,refcode,posstatus,vendor,contact,candidate,exp_edate,hired_date,posworkhr,timesheet,bamount,bcurrency,bperiod,pamount,pcurrency,pperiod,emp_prate,reason,rateperiod,ot_period,ot_currency,placement_fee,placement_curr,bill_contact,bill_address,wcomp_code,bill_req,service_terms,hire_req,addinfo,avg_interview,calctype,burden,markup,margin,brateopen,brateopen_amt,prateopen,prateopen_amt,joblocation,owner,cdate,otbrate_amt,otbrate_curr,otbrate_period,otprate_amt,otprate_curr,otprate_period,payrollpid,notes_cancel,offlocation,double_brate_amt,double_brate_curr,double_brate_period,double_prate_amt,double_prate_curr,double_prate_period,po_num,job_loc_tax,department,muser,mdate,date_ended,date_placed,diem_lodging,diem_mie,diem_total,diem_currency,diem_period,diem_billable,diem_taxable,diem_billrate,madison_order_id,assign_no,classid,deptid,attention,vprt_GeoCode,vprt_State,vprt_County,vprt_Local,vprt_schdist,corp_code,industryid,bill_burden,worksite_code,copy_asignid,shiftid,starthour,endhour,shift_type,daypay)
        VALUES  (NEW.sno,NEW.username,NEW.client,NEW.project,NEW.manager,NEW.s_date,NEW.e_date,NEW.rate,NEW.tsapp,NEW.jtype,NEW.pusername,NEW.rateper,NEW.otrate,NEW.ustatus,NEW.udate,NEW.imethod,NEW.iterms,NEW.pterms,NEW.sagent,NEW.commision,NEW.co_type,NEW.endclient,NEW.tweeks,NEW.tdays,NEW.notes,NEW.rtime,NEW.assg_status,NEW.posid,NEW.jotype,NEW.catid,NEW.postitle,NEW.refcode,NEW.posstatus,NEW.vendor,NEW.contact,NEW.candidate,NEW.exp_edate,NEW.hired_date,NEW.posworkhr,NEW.timesheet,NEW.bamount,NEW.bcurrency,NEW.bperiod,NEW.pamount,NEW.pcurrency,NEW.pperiod,NEW.emp_prate,NEW.reason,NEW.rateperiod,NEW.ot_period,NEW.ot_currency,NEW.placement_fee,NEW.placement_curr,NEW.bill_contact,NEW.bill_address,NEW.wcomp_code,NEW.bill_req,NEW.service_terms,NEW.hire_req,NEW.addinfo,NEW.avg_interview,NEW.calctype,NEW.burden,NEW.markup,NEW.margin,NEW.brateopen,NEW.brateopen_amt,NEW.prateopen,NEW.prateopen_amt,NEW.joblocation,NEW.owner,NEW.cdate,NEW.otbrate_amt,NEW.otbrate_curr,NEW.otbrate_period,NEW.otprate_amt,NEW.otprate_curr,NEW.otprate_period,NEW.payrollpid,NEW.notes_cancel,NEW.offlocation,NEW.double_brate_amt,NEW.double_brate_curr,NEW.double_brate_period,NEW.double_prate_amt,NEW.double_prate_curr,NEW.double_prate_period,NEW.po_num,NEW.job_loc_tax,NEW.department,NEW.muser,NEW.mdate,NEW.date_ended,NEW.date_placed,NEW.diem_lodging,NEW.diem_mie,NEW.diem_total,NEW.diem_currency,NEW.diem_period,NEW.diem_billable,NEW.diem_taxable,NEW.diem_billrate,NEW.madison_order_id,NEW.assign_no,NEW.classid,NEW.deptid,NEW.attention,NEW.vprt_GeoCode,NEW.vprt_State,NEW.vprt_County,NEW.vprt_Local,NEW.vprt_schdist,NEW.corp_code,NEW.industryid,NEW.bill_burden,NEW.worksite_code,NEW.copy_asignid,NEW.shiftid,NEW.starthour,NEW.endhour,NEW.shift_type,NEW.daypay);
          
      
        SELECT greatplains_paydata INTO @gp_status FROM company_info;
        IF @gp_status = 'Y' THEN
          CALL gp_employee_xml_data(NEW.username);
          CALL gp_perm_xml_data(NEW.sno);
          CALL gp_temp_xml_data(NEW.sno);
          CALL gp_customer_xml_data(NEW.client,NEW.sno);
        END IF;
         
        SELECT custom_notification INTO @custom_notification FROM company_info;
        IF @custom_notification = 'Y' THEN
          IF @expedate != NEW.exp_edate THEN  
            CALL `exp_edate_change_notification`(NEW.sno);
          END IF;
          IF @pamount != NEW.pamount THEN  
            CALL pamount_change_notification(NEW.sno);
          END IF;
          IF @s_date != NEW.s_date THEN  
            CALL sdate_change_notification(NEW.sno);
          END IF;
          IF NEW.ustatus = 'closed' THEN  
            CALL assgn_close_notification(NEW.sno);
          END IF;   
        END IF;        
      END";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query ="DROP PROCEDURE `bulk_placement_proc`;";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query="CREATE PROCEDURE `bulk_placement_proc`(master_batch_id INT(15),req_id INT(25), cand_id INT(25), usr INT(25), seq_no INT(25),placement_queue_sno INT(25),shift_sno INT(2),OUT placement_status VARCHAR(50))
BEGIN

        DECLARE emp_uname VARCHAR(50);
        DECLARE jobtype VARCHAR(50);
        DECLARE asgn_id VARCHAR(50);
        DECLARE hrcon_sno INT DEFAULT 0;
        DECLARE conjob_sno INT DEFAULT 0;
        DECLARE placejob_sno INT DEFAULT 0;
        DECLARE shift_count INT DEFAULT 0;
        DECLARE placement_next_pos INT DEFAULT 0;
        DECLARE shift_rates_count INT DEFAULT 0;
        DECLARE empexists VARCHAR(50);
        DECLARE mng_sno VARCHAR(10);
        DECLARE job_sno VARCHAR(10);
        DECLARE com_sno INT DEFAULT 0;
        DECLARE con_sno INT DEFAULT 0;
        DECLARE assign_schedule_sno INT DEFAULT 0;
        DECLARE comp_schedule_sno INT DEFAULT 0;
        DECLARE bulk_place_jobs_sno INT DEFAULT 0;
        DECLARE schVersionType  VARCHAR(10);
        DECLARE rateShiftSno  INT DEFAULT 0;  
        DECLARE resume_status_sno  INT DEFAULT 0;
        DECLARE shiftType VARCHAR(10);  
        DECLARE ShiftModeType  VARCHAR(10);
        DECLARE submission_rates_count INT DEFAULT 0;
        DECLARE rates_on_submission_flag VARCHAR(10) DEFAULT 'NO';
        DECLARE shift_rates1_count INT DEFAULT 0;
        DECLARE shift_rates2_count INT DEFAULT 0;
        DECLARE shift_rates3_count INT DEFAULT 0;
  DECLARE perdiem_start_date VARCHAR(50);
  DECLARE perdiem_exp_enddate VARCHAR(50);

        SET jobtype = '';
        SET job_sno = req_id;

        SELECT mng.name INTO jobtype FROM posdesc jo, manage mng WHERE jo.posid = req_id AND jo.postype = mng.sno;
        SELECT company, contact INTO com_sno, con_sno FROM posdesc WHERE posid = req_id;

        SELECT sno, schedule_display, shift_type ,rate_on_submission INTO bulk_place_jobs_sno, schVersionType, shiftType,rates_on_submission_flag FROM bulk_placement_jobs WHERE batch_id = master_batch_id;
        
        SELECT sno INTO resume_status_sno FROM resume_status WHERE res_id = cand_id AND req_id = job_sno AND seqnumber = seq_no AND shift_id = shift_sno;

        IF schVersionType = 'OLD' THEN
         SET rateShiftSno='0';
        ELSE
         SET rateShiftSno = shift_sno;
        END IF;
        
        SET ShiftModeType = shiftType;
        
        IF jobtype = 'Direct' THEN

          CALL Consultant_Proc(cand_id, req_id,usr,@empuname);
          CALL Employee_Proc(cand_id,usr,@empuname);
          SET emp_uname = @empuname;
          CALL get_Assginment_Seq(@pusername);
          SET asgn_id =  @pusername;
          
          INSERT INTO consultant_jobs(username,CLIENT,project,manager,s_date,e_date,rate,tsapp,jtype,pusername,rateper,otrate,imethod,iterms,pterms,sagent,commision,co_type,endclient,tweeks,tdays,notes,rtime,assg_status,posid,jotype,catid,postitle,refcode,posstatus,vendor,contact,candidate,exp_edate,hired_date,posworkhr,timesheet,bamount,bcurrency,bperiod,pamount,pcurrency,pperiod,emp_prate,reason,rateperiod,ot_period,ot_currency,placement_fee,placement_curr,bill_contact,bill_address,wcomp_code,bill_req,service_terms,hire_req,addinfo,avg_interview,calctype,burden,markup,margin,brateopen,brateopen_amt,prateopen,prateopen_amt,joblocation,OWNER,cdate,otbrate_amt,otbrate_curr,otbrate_period,otprate_amt,otprate_curr,otprate_period,payrollpid,notes_cancel,offlocation,double_brate_amt,double_brate_curr,double_brate_period,double_prate_amt,double_prate_curr,double_prate_period,po_num,job_loc_tax,department,muser,mdate,date_ended,date_placed,diem_lodging,diem_mie,diem_total,diem_currency,diem_period,diem_billable,diem_taxable,diem_billrate,assign_no,classid,deptid,attention,corp_code,industryid,schedule_display,bill_burden,shiftid,worksite_code,starthour,endhour,shift_type,daypay)
          SELECT emp_uname,CLIENT,project,manager,s_date,e_date,rate,tsapp,jtype,asgn_id,rateper,otrate,imethod,iterms,pterms,sagent,commision,co_type,endclient,tweeks,tdays,notes,rtime,assg_status,posid,jotype,catid,postitle,refcode,posstatus,vendor,contact,cand_id,exp_edate,hired_date,posworkhr,timesheet,bamount,bcurrency,bperiod,pamount,pcurrency,pperiod,emp_prate,reason,rateperiod,ot_period,ot_currency,placement_fee,placement_curr,bill_contact,bill_address,wcomp_code,bill_req,service_terms,hire_req,addinfo,avg_interview,calctype,burden,markup,margin,brateopen,brateopen_amt,prateopen,prateopen_amt,joblocation,OWNER,NOW(),otbrate_amt,otbrate_curr,otbrate_period,otprate_amt,otprate_curr,otprate_period,payrollpid,notes_cancel,offlocation,double_brate_amt,double_brate_curr,double_brate_period,double_prate_amt,double_prate_curr,double_prate_period,po_num,job_loc_tax,department,muser,NOW(),date_ended,NOW(),diem_lodging,diem_mie,diem_total,diem_currency,diem_period,diem_billable,diem_taxable,diem_billrate,asgn_id,classid,deptid,attention,corp_code,industryid,schedule_display,bill_burden,shiftid,worksite_code,starthour,endhour,shift_type,daypay 
          FROM bulk_placement_jobs WHERE sno = bulk_place_jobs_sno;

          SET conjob_sno = LAST_INSERT_ID();

          INSERT INTO assignment_schedule(userid, title, startdate, enddate, contactsno, modulename, 
          invapproved, recstatus, assign_no, cuser, muser, cdate, mdate)
          SELECT a.username,a.project,'','',a.sno,'HR->Assignments',
          'active','active',a.pusername,a.owner,a.muser,a.cdate,a.mdate
          FROM consultant_jobs a, consultant_compen cmp
          WHERE a.assign_no = asgn_id AND a.username = cmp.username ; 

          SET comp_schedule_sno = LAST_INSERT_ID();

          INSERT INTO consultant_tab(sno,consno,starthour,endhour,wdays,sch_date,coltype)
          SELECT '', comp_schedule_sno, starthour, endhour, wdays, sch_date, coltype
          FROM bulk_placement_tab WHERE bulk_place_sno = bulk_place_jobs_sno AND coltype = 'assign';

          INSERT INTO multiplerates_assignment(asgnid, asgn_mode, ratemasterid, ratetype, rate, period, currency, 
          billable, taxable, STATUS,cuser, cdate, muser, mdate)
          SELECT conjob_sno, 'consultant', ratemasterid, ratetype, rate, period, currency, 
          billable, taxable, 'ACTIVE',cuser, NOW(), cuser, NOW()
          FROM bulk_place_multiplerates 
          WHERE bulk_place_sno = bulk_place_jobs_sno AND shiftid = rateShiftSno;

          INSERT INTO assign_commission(username, assignid, assigntype,
          person, TYPE, co_type, comm_calc, amount, roleid, overwrite, enableUserInput,shift_id)
          SELECT username, conjob_sno, 'C', person, TYPE, co_type, comm_calc, amount,
          roleid, overwrite, enableUserInput, shift_sno 
          FROM bulk_place_assign_commission WHERE bulk_place_sno = bulk_place_jobs_sno;

          CALL bulk_placement_cdf_proc(conjob_sno,bulk_place_jobs_sno,'consultantjob');

          INSERT INTO consultant_burden_details(consultant_jobs_sno, ratemasterid, ratetype, bt_id, bi_id) 
          SELECT conjob_sno, ratemasterid, ratetype, bt_id, bi_id FROM bulk_place_burden_details WHERE bulk_place_sno=bulk_place_jobs_sno;

          INSERT INTO placement_jobs(username,CLIENT,project,manager,s_date,e_date,rate,tsapp,jtype,pusername,rateper,otrate,imethod,iterms,pterms,sagent,commision,co_type,endclient,tweeks,tdays,notes,rtime,assg_status,posid,jotype,catid,postitle,refcode,posstatus,vendor,contact,candidate,exp_edate,hired_date,posworkhr,timesheet,bamount,bcurrency,bperiod,pamount,pcurrency,pperiod,emp_prate,reason,rateperiod,ot_period,ot_currency,placement_fee,placement_curr,bill_contact,bill_address,wcomp_code,bill_req,service_terms,hire_req,addinfo,avg_interview,calctype,burden,markup,margin,brateopen,brateopen_amt,prateopen,prateopen_amt,joblocation,OWNER,cdate,otbrate_amt,otbrate_curr,otbrate_period,otprate_amt,otprate_curr,otprate_period,payrollpid,notes_cancel,offlocation,double_brate_amt,double_brate_curr,double_brate_period,double_prate_amt,double_prate_curr,double_prate_period,po_num,job_loc_tax,department,muser,mdate,date_ended,date_placed,diem_lodging,diem_mie,diem_total,diem_currency,diem_period,diem_billable,diem_taxable,diem_billrate,assign_no,seqnumber,deptid,attention,corp_code,industryid,schedule_display,bill_burden,shiftid,starthour,endhour,shift_type,daypay)
          SELECT emp_uname,CLIENT,project,manager,s_date,e_date,rate,tsapp,jtype,asgn_id,rateper,otrate,imethod,iterms,pterms,sagent,commision,co_type,endclient,tweeks,tdays,notes,rtime,'Needs Approval',posid,jotype,catid,postitle,refcode,posstatus,vendor,contact,CONCAT('cand',cand_id),exp_edate,hired_date,posworkhr,timesheet,bamount,bcurrency,bperiod,pamount,pcurrency,pperiod,emp_prate,reason,rateperiod,ot_period,ot_currency,placement_fee,placement_curr,bill_contact,bill_address,wcomp_code,bill_req,service_terms,hire_req,addinfo,avg_interview,calctype,burden,markup,margin,brateopen,brateopen_amt,prateopen,prateopen_amt,joblocation,OWNER,NOW(),otbrate_amt,otbrate_curr,otbrate_period,otprate_amt,otprate_curr,otprate_period,payrollpid,notes_cancel,offlocation,double_brate_amt,double_brate_curr,double_brate_period,double_prate_amt,double_prate_curr,double_prate_period,po_num,job_loc_tax,department,muser,NOW(),date_ended,NOW(),diem_lodging,diem_mie,diem_total,diem_currency,diem_period,diem_billable,diem_taxable,diem_billrate,asgn_id,seq_no,deptid,attention,corp_code,industryid,schedule_display,bill_burden,shiftid,starthour,endhour,shift_type,daypay
          FROM bulk_placement_jobs WHERE sno = bulk_place_jobs_sno;

          SET placejob_sno = LAST_INSERT_ID();

          INSERT INTO placement_tab(sno, consno, starthour, endhour, wdays, sch_date, coltype)
          SELECT '', placejob_sno, starthour, endhour, wdays, sch_date, coltype
          FROM bulk_placement_tab WHERE bulk_place_sno = bulk_place_jobs_sno AND coltype = 'assign';

                  IF ShiftModeType <> 'perdiem' THEN
                      UPDATE posdesc SET closepos=closepos+1 WHERE posid=req_id;
                    UPDATE hotjobs SET closepos=closepos+1 WHERE req_id =req_id AND STATUS!='BP';
                  END IF; 

                  SELECT sno INTO mng_sno FROM manage WHERE NAME = 'Needs Approval' AND TYPE='interviewstatus' LIMIT 1;

          UPDATE resume_status SET STATUS = mng_sno ,pstatus = 'P',mdate = NOW() WHERE res_id = cand_id AND req_id = job_sno AND seqnumber = seq_no AND shift_id = shift_sno;
           
          INSERT INTO resume_history (cli_name, req_id, res_id, comp_id, appuser, appdate, STATUS, TYPE, muser, mdate, seqnumber,shift_id)
          VALUES (con_sno, req_id, cand_id, com_sno, usr, NOW(), mng_sno, 'cand', usr, NOW(), seq_no,shift_sno);

          INSERT INTO multiplerates_joborder(joborderid, jo_mode, ratemasterid, ratetype, rate, period, currency, 
          billable, taxable, STATUS, cuser, cdate, muser, mdate)
          SELECT placejob_sno, 'placement', ratemasterid, ratetype, rate, period, currency, 
          billable, taxable, 'ACTIVE',cuser, NOW(), cuser, NOW()
          FROM bulk_place_multiplerates 
          WHERE bulk_place_sno = bulk_place_jobs_sno AND shiftid = shift_sno ;


          INSERT INTO assign_commission(username, assignid, assigntype,
          person, TYPE, co_type, comm_calc, amount, roleid, overwrite, enableUserInput,shift_id)
          SELECT username, placejob_sno, 'P', person, TYPE, co_type, comm_calc, amount,
          roleid, overwrite, enableUserInput, shift_sno 
          FROM bulk_place_assign_commission WHERE bulk_place_sno = bulk_place_jobs_sno;


          INSERT INTO placement_burden_details(placement_jobs_sno, ratemasterid, ratetype, bt_id, bi_id)
          SELECT placejob_sno, ratemasterid, ratetype, bt_id, bi_id FROM bulk_place_burden_details WHERE bulk_place_sno=bulk_place_jobs_sno;

          INSERT INTO hrcon_jobs (username,CLIENT,project,manager,s_date,e_date,rate,tsapp,jtype,pusername,rateper,otrate,ustatus,imethod,iterms,pterms,sagent,commision,co_type,endclient,tweeks,tdays,notes,rtime,assg_status,posid,jotype,catid,postitle,refcode,posstatus,vendor,contact,candidate,exp_edate,hired_date,posworkhr,timesheet,bamount,bcurrency,bperiod,pamount,pcurrency,pperiod,emp_prate,reason,rateperiod,ot_period,ot_currency,placement_fee,placement_curr,bill_contact,bill_address,wcomp_code,bill_req,service_terms,hire_req,addinfo,avg_interview,calctype,burden,markup,margin,brateopen,brateopen_amt,prateopen,prateopen_amt,joblocation,OWNER,cdate,otbrate_amt,otbrate_curr,otbrate_period,otprate_amt,otprate_curr,otprate_period,payrollpid,notes_cancel,offlocation,double_brate_amt,double_brate_curr,double_brate_period,double_prate_amt,double_prate_curr,double_prate_period,po_num,job_loc_tax,department,muser,mdate,date_ended,date_placed,diem_lodging,diem_mie,diem_total,diem_currency,diem_period,diem_billable,diem_taxable,diem_billrate,assign_no,classid,deptid,attention,corp_code,industryid,schedule_display,bill_burden,shiftid,worksite_code,starthour,endhour,shift_type,daypay)
          SELECT emp_uname,CLIENT,project,manager,s_date,e_date,rate,tsapp,jtype,asgn_id,rateper,otrate,'pending',imethod,iterms,pterms,sagent,commision,co_type,endclient,tweeks,tdays,notes,rtime,assg_status,posid,jotype,catid,postitle,refcode,posstatus,vendor,contact,cand_id,exp_edate,hired_date,posworkhr,timesheet,bamount,bcurrency,bperiod,pamount,pcurrency,pperiod,emp_prate,reason,rateperiod,ot_period,ot_currency,placement_fee,placement_curr,bill_contact,bill_address,wcomp_code,bill_req,service_terms,hire_req,addinfo,avg_interview,calctype,burden,markup,margin,brateopen,brateopen_amt,prateopen,prateopen_amt,joblocation,OWNER,NOW(),otbrate_amt,otbrate_curr,otbrate_period,otprate_amt,otprate_curr,otprate_period,payrollpid,notes_cancel,offlocation,double_brate_amt,double_brate_curr,double_brate_period,double_prate_amt,double_prate_curr,double_prate_period,po_num,job_loc_tax,department,muser,NOW(),date_ended,NOW(),diem_lodging,diem_mie,diem_total,diem_currency,diem_period,diem_billable,diem_taxable,diem_billrate,asgn_id,classid,deptid,attention,corp_code,industryid,schedule_display,bill_burden,shiftid,worksite_code,starthour,endhour,shift_type,daypay FROM bulk_placement_jobs WHERE sno = bulk_place_jobs_sno;

          SET hrcon_sno = LAST_INSERT_ID();

          INSERT INTO assignment_schedule(userid, title, startdate, enddate, contactsno, modulename, 
          invapproved, recstatus, assign_no, cuser, muser, cdate, mdate)
          SELECT a.username,a.project,a.s_date,a.e_date,CONCAT(a.sno,'|'),'HR->Assignments',
          IF(a.ustatus = 'pending','active',a.ustatus),'active',a.assign_no,a.owner,a.muser,a.cdate,a.mdate
          FROM hrcon_jobs a
          WHERE a.assign_no = asgn_id; 

          SET assign_schedule_sno = LAST_INSERT_ID();

          INSERT INTO hrcon_tab(sno, tabsno, starthour, endhour, wdays, sch_date, coltype)
          SELECT '', assign_schedule_sno, starthour, endhour, wdays, sch_date, coltype
          FROM bulk_placement_tab WHERE bulk_place_sno = bulk_place_jobs_sno AND coltype = 'assign';

          INSERT INTO empcon_tab(sno, tabsno, starthour, endhour, wdays, sch_date, coltype)
          SELECT '', assign_schedule_sno, starthour, endhour, wdays, sch_date, coltype
          FROM bulk_placement_tab WHERE bulk_place_sno = bulk_place_jobs_sno AND coltype = 'assign';

          INSERT INTO multiplerates_assignment(asgnid, asgn_mode, ratemasterid, ratetype, rate, period, currency, 
          billable, taxable, STATUS, cuser, cdate, muser, mdate)
          SELECT hrcon_sno, 'hrcon', ratemasterid, ratetype, rate, period, currency, 
          billable, taxable, 'ACTIVE',cuser, NOW(), cuser, NOW()
          FROM bulk_place_multiplerates 
          WHERE bulk_place_sno = bulk_place_jobs_sno AND shiftid = rateShiftSno;

          INSERT INTO assign_commission(username, assignid, assigntype,
          person, TYPE, co_type, comm_calc, amount, roleid, overwrite, enableUserInput,shift_id)
          SELECT username, hrcon_sno, 'H', person, TYPE, co_type, comm_calc, amount,
          roleid, overwrite, enableUserInput, shift_sno 
          FROM bulk_place_assign_commission WHERE bulk_place_sno = bulk_place_jobs_sno;

          INSERT INTO hrcon_burden_details(hrcon_jobs_sno, ratemasterid, ratetype, bt_id, bi_id)
          SELECT hrcon_sno, ratemasterid, ratetype, bt_id, bi_id FROM bulk_place_burden_details WHERE bulk_place_sno=bulk_place_jobs_sno;

          CALL bulk_placement_cdf_proc(hrcon_sno,bulk_place_jobs_sno,'hrconjob');
          UPDATE bulk_placement_queue SET STATUS = 'Completed',pusername = asgn_id WHERE sno = placement_queue_sno; 
          SET placement_status = 'Completed';
          
        ELSE 
          
          SET empexists = '';

          SELECT candid INTO empexists FROM candidate_list WHERE sno = cand_id;
          
          IF empexists NOT LIKE 'emp%' THEN
            
            CALL Accounting_Vendor_Proc(cand_id);
            
            CALL Consultant_Proc(cand_id, req_id,usr,@empuname);

            SET emp_uname = @empuname;
            CALL get_Assginment_Seq(@pusername);
            SET asgn_id =  @pusername;

            INSERT INTO consultant_jobs(username,CLIENT,project,manager,s_date,e_date,rate,tsapp,jtype,pusername,rateper,otrate,imethod,iterms,pterms,sagent,commision,co_type,endclient,tweeks,tdays,notes,rtime,assg_status,posid,jotype,catid,postitle,refcode,posstatus,vendor,contact,candidate,exp_edate,hired_date,posworkhr,timesheet,bamount,bcurrency,bperiod,pamount,pcurrency,pperiod,emp_prate,reason,rateperiod,ot_period,ot_currency,placement_fee,placement_curr,bill_contact,bill_address,wcomp_code,bill_req,service_terms,hire_req,addinfo,avg_interview,calctype,burden,markup,margin,brateopen,brateopen_amt,prateopen,prateopen_amt,joblocation,OWNER,cdate,otbrate_amt,otbrate_curr,otbrate_period,otprate_amt,otprate_curr,otprate_period,payrollpid,notes_cancel,offlocation,double_brate_amt,double_brate_curr,double_brate_period,double_prate_amt,double_prate_curr,double_prate_period,po_num,job_loc_tax,department,muser,mdate,date_ended,date_placed,diem_lodging,diem_mie,diem_total,diem_currency,diem_period,diem_billable,diem_taxable,diem_billrate,assign_no,classid,deptid,attention,corp_code,industryid,schedule_display,bill_burden,shiftid,worksite_code,starthour,endhour,shift_type,daypay)
            SELECT emp_uname,CLIENT,project,manager,s_date,e_date,rate,tsapp,jtype,asgn_id,rateper,otrate,imethod,iterms,pterms,sagent,commision,co_type,endclient,tweeks,tdays,notes,rtime,assg_status,posid,jotype,catid,postitle,refcode,posstatus,vendor,contact,cand_id,exp_edate,hired_date,posworkhr,timesheet,bamount,bcurrency,bperiod,pamount,pcurrency,pperiod,emp_prate,reason,rateperiod,ot_period,ot_currency,placement_fee,placement_curr,bill_contact,bill_address,wcomp_code,bill_req,service_terms,hire_req,addinfo,avg_interview,calctype,burden,markup,margin,brateopen,brateopen_amt,prateopen,prateopen_amt,joblocation,OWNER,NOW(),otbrate_amt,otbrate_curr,otbrate_period,otprate_amt,otprate_curr,otprate_period,payrollpid,notes_cancel,offlocation,double_brate_amt,double_brate_curr,double_brate_period,double_prate_amt,double_prate_curr,double_prate_period,po_num,job_loc_tax,department,muser,NOW(),date_ended,NOW(),diem_lodging,diem_mie,diem_total,diem_currency,diem_period,diem_billable,diem_taxable,diem_billrate,asgn_id,classid,deptid,attention,corp_code,industryid,schedule_display,bill_burden,shiftid,worksite_code,starthour,endhour,shift_type,daypay
            FROM bulk_placement_jobs WHERE sno = bulk_place_jobs_sno;

            SET conjob_sno = LAST_INSERT_ID();

            INSERT INTO assignment_schedule(userid, title, startdate, enddate, contactsno, modulename, 
            invapproved, recstatus, assign_no, cuser, muser, cdate, mdate)
            SELECT a.username,a.project,'','',a.sno,'HR->Assignments',
            'active','active',a.pusername,a.owner,a.muser,a.cdate,a.mdate
            FROM consultant_jobs a, consultant_compen cmp
            WHERE a.assign_no = asgn_id AND a.username = cmp.username ; 

            SET comp_schedule_sno = LAST_INSERT_ID();

            INSERT INTO consultant_tab(sno,consno,starthour,endhour,wdays,sch_date,coltype)
            SELECT '', comp_schedule_sno, starthour, endhour, wdays, sch_date, coltype
            FROM bulk_placement_tab WHERE bulk_place_sno = bulk_place_jobs_sno AND coltype = 'assign';

            UPDATE consultant_jobs SET shiftid = shift_sno WHERE  sno = conjob_sno;

            IF ShiftModeType = 'regular' THEN

              INSERT INTO consultantjob_sm_timeslots(sno,pid,shift_date,shift_starttime,shift_endtime,event_type,event_no,event_group_no,shift_status,sm_sno,no_of_positions,cuser,ctime,muser,mtime)SELECT  '',conjob_sno,shift_date,shift_starttime,shift_endtime,event_type,event_no,event_group_no,shift_status,sm_sno,no_of_positions,usr,NOW(),usr,NOW() FROM posdesc_sm_timeslots WHERE pid = req_id AND sm_sno = shift_sno AND shift_date >=  DATE_ADD(CURDATE(),INTERVAL -2 MONTH);
            END IF;

            IF ShiftModeType = 'perdiem' THEN

              INSERT INTO consultantjob_perdiem_shift_sch(sno,consultantjob_sno,pusername,no_of_shift_position,shift_startdate,
                shift_enddate,shift_starttime,shift_endtime,split_shift,shift_id,cdate,cuser,mdate,muser)SELECT '',conjob_sno,asgn_id,no_of_shift_position,shift_startdate,shift_enddate,shift_starttime,shift_endtime,split_shift,shift_id,cdate,cuser,mdate,muser FROM bulk_place_perdiem_shift_sch WHERE bulk_place_sno=bulk_place_jobs_sno AND shift_id=shift_sno;

              SELECT DATE_FORMAT(MIN(shift_startdate),'%c-%e-%Y'),DATE_FORMAT(MAX(shift_enddate),'%Y-%m-%d') INTO perdiem_start_date,perdiem_exp_enddate 
              FROM consultantjob_perdiem_shift_sch WHERE consultantjob_sno=conjob_sno;

              UPDATE consultant_jobs SET s_date=perdiem_start_date,exp_edate=perdiem_exp_enddate WHERE sno=conjob_sno;
            END IF;

            INSERT INTO assign_commission(username, assignid, assigntype,
            person, TYPE, co_type, comm_calc, amount, roleid, overwrite, enableUserInput,shift_id)
            SELECT username, conjob_sno, 'C', person, TYPE, co_type, comm_calc, amount,
            roleid, overwrite, enableUserInput, shift_sno 
            FROM bulk_place_assign_commission WHERE bulk_place_sno = bulk_place_jobs_sno;

            INSERT INTO consultant_burden_details(consultant_jobs_sno, ratemasterid, ratetype, bt_id, bi_id) 
            SELECT conjob_sno, ratemasterid, ratetype, bt_id, bi_id FROM bulk_place_burden_details WHERE bulk_place_sno=bulk_place_jobs_sno;
            
            SELECT COUNT(1) INTO submission_rates_count FROM multiplerates_joborder WHERE joborderid = resume_status_sno AND jo_mode = 'submission' ;
            
            SELECT COUNT(1) INTO shift_rates_count FROM bulk_place_multiplerates WHERE bulk_place_sno = bulk_place_jobs_sno AND shiftid = shift_sno ;
            
            IF (submission_rates_count  > 0  AND rates_on_submission_flag = 'YES') THEN
    
              INSERT INTO multiplerates_assignment(asgnid, asgn_mode, ratemasterid, ratetype, rate, period, currency, 
              billable, taxable, STATUS,cuser, cdate, muser, mdate)
              SELECT conjob_sno, 'consultant', ratemasterid, ratetype, rate, period, currency, 
              billable, taxable, 'ACTIVE',usr, NOW(), usr, NOW()
              FROM multiplerates_joborder 
              WHERE joborderid = resume_status_sno AND jo_mode = 'submission';

              SELECT COUNT(1) INTO shift_rates1_count FROM multiplerates_assignment WHERE asgnid = conjob_sno AND ratemasterid = 'rate1' AND asgn_mode='consultant';
              IF shift_rates1_count = 0 THEN
                INSERT INTO multiplerates_assignment (asgnid,asgn_mode,ratemasterid,ratetype,rate,period,currency,billable,taxable,STATUS,cuser,cdate) VALUES (conjob_sno,'consultant','rate1','payrate','0','HOUR','USD','N','N','ACTIVE',usr,NOW());
                INSERT INTO multiplerates_assignment (asgnid,asgn_mode,ratemasterid,ratetype,rate,period,currency,billable,taxable,STATUS, cuser,cdate) VALUES (conjob_sno,'consultant','rate1','billrate','0','HOUR','USD','N','N','ACTIVE',usr,NOW());
              END IF;

              SELECT COUNT(1) INTO shift_rates2_count FROM multiplerates_assignment WHERE asgnid = conjob_sno AND ratemasterid = 'rate2' AND asgn_mode='consultant';

              IF shift_rates2_count = 0 THEN
                INSERT INTO multiplerates_assignment (asgnid,asgn_mode,ratemasterid,ratetype,rate,period,currency,billable,taxable,STATUS, cuser,cdate) VALUES (conjob_sno,'consultant','rate2','payrate','0','HOUR','USD','N','N','ACTIVE',usr,NOW());
                INSERT INTO multiplerates_assignment (asgnid,asgn_mode,ratemasterid,ratetype,rate,period,currency,billable,taxable,STATUS, cuser,cdate) VALUES (conjob_sno,'consultant','rate2','billrate','0','HOUR','USD','N','N','ACTIVE',usr,NOW());
              END IF;

              SELECT COUNT(1) INTO shift_rates3_count FROM multiplerates_assignment WHERE asgnid = conjob_sno AND ratemasterid = 'rate3' AND asgn_mode='consultant';
              IF shift_rates3_count = 0 THEN
                INSERT INTO multiplerates_assignment (asgnid,asgn_mode,ratemasterid,ratetype,rate,period,currency,billable,taxable,STATUS, cuser,cdate) VALUES (conjob_sno,'consultant','rate3','payrate','0','HOUR','USD','N','N','ACTIVE',usr,NOW());
                INSERT INTO multiplerates_assignment (asgnid,asgn_mode,ratemasterid,ratetype,rate,period,currency,billable,taxable,STATUS, cuser,cdate) VALUES (conjob_sno,'consultant','rate3','billrate','0','HOUR','USD','N','N','ACTIVE',usr,NOW());
              END IF;
            
            ELSEIF shift_rates_count > 0  THEN

              INSERT INTO multiplerates_assignment(asgnid, asgn_mode, ratemasterid, ratetype, rate, period, currency, 
              billable, taxable, STATUS,cuser, cdate, muser, mdate)
              SELECT conjob_sno, 'consultant', ratemasterid, ratetype, rate, period, currency, 
              billable, taxable, 'ACTIVE',cuser, NOW(), cuser, NOW()
              FROM bulk_place_multiplerates 
              WHERE bulk_place_sno = bulk_place_jobs_sno AND shiftid = shift_sno;

            ELSE

              INSERT INTO multiplerates_assignment(asgnid, asgn_mode, ratemasterid, ratetype, rate, period, currency, 
              billable, taxable, STATUS,cuser, cdate, muser, mdate)
              SELECT conjob_sno, 'consultant', ratemasterid, ratetype, rate, period, currency, 
              billable, taxable, 'ACTIVE',cuser, NOW(), cuser, NOW()
              FROM bulk_place_multiplerates 
              WHERE bulk_place_sno = bulk_place_jobs_sno AND shiftid ='0';
              
            END IF;
            
            IF (submission_rates_count  > 0 OR shift_rates_count > 0) THEN

              UPDATE consultant_jobs AS cj,multiplerates_assignment AS ma SET cj.bamount = ma.rate,cj.bcurrency = ma.currency,cj.bperiod = ma.period
              WHERE cj.sno = ma.asgnid AND ma.asgn_mode = 'consultant' AND ratetype = 'billrate' AND  ma.ratemasterid= 'rate1' AND cj.sno = conjob_sno;
              UPDATE consultant_jobs AS cj,multiplerates_assignment AS ma SET cj.pamount = ma.rate,cj.pcurrency = ma.currency,cj.pperiod = ma.period
              WHERE cj.sno = ma.asgnid AND ma.asgn_mode = 'consultant' AND ratetype = 'payrate' AND  ma.ratemasterid= 'rate1' AND cj.sno = conjob_sno;

              UPDATE consultant_jobs AS cj,multiplerates_assignment AS ma SET cj.otbrate_amt = ma.rate,cj.otbrate_curr = ma.currency,cj.otbrate_period = ma.period
              WHERE cj.sno = ma.asgnid AND ma.asgn_mode = 'consultant' AND ratetype = 'billrate' AND  ma.ratemasterid= 'rate2' AND cj.sno = conjob_sno;

              UPDATE consultant_jobs AS cj,multiplerates_assignment AS ma SET cj.otprate_amt = ma.rate,cj.otprate_curr = ma.currency,cj.otprate_period = ma.period
              WHERE cj.sno = ma.asgnid AND ma.asgn_mode = 'consultant' AND ratetype = 'payrate' AND  ma.ratemasterid= 'rate2' AND cj.sno = conjob_sno;

              UPDATE consultant_jobs AS cj,multiplerates_assignment AS ma SET cj.double_brate_amt = ma.rate,cj.double_brate_curr = ma.currency,cj.double_brate_period = ma.period
              WHERE cj.sno = ma.asgnid AND ma.asgn_mode = 'consultant' AND ratetype = 'billrate' AND  ma.ratemasterid= 'rate3' AND cj.sno = conjob_sno;

              UPDATE consultant_jobs AS cj,multiplerates_assignment AS ma SET cj.double_prate_amt = ma.rate,cj.double_prate_curr = ma.currency,cj.double_prate_period = ma.period
              WHERE cj.sno = ma.asgnid AND ma.asgn_mode = 'consultant' AND ratetype = 'payrate' AND  ma.ratemasterid= 'rate3' AND cj.sno = conjob_sno;
            END IF;

            SELECT COUNT(1)+1 INTO placement_next_pos FROM placement_jobs WHERE posid = req_id AND assg_status != 'Cancelled'  AND shiftid = shift_sno;

            INSERT INTO placement_jobs(username,CLIENT,project,manager,s_date,e_date,rate,tsapp,jtype,pusername,rateper,otrate,imethod,iterms,pterms,sagent,commision,co_type,endclient,tweeks,tdays,notes,rtime,assg_status,posid,jotype,catid,postitle,refcode,posstatus,vendor,contact,candidate,exp_edate,hired_date,posworkhr,timesheet,bamount,bcurrency,bperiod,pamount,pcurrency,pperiod,emp_prate,reason,rateperiod,ot_period,ot_currency,placement_fee,placement_curr,bill_contact,bill_address,wcomp_code,bill_req,service_terms,hire_req,addinfo,avg_interview,calctype,burden,markup,margin,brateopen,brateopen_amt,prateopen,prateopen_amt,joblocation,OWNER,cdate,otbrate_amt,otbrate_curr,otbrate_period,otprate_amt,otprate_curr,otprate_period,payrollpid,notes_cancel,offlocation,double_brate_amt,double_brate_curr,double_brate_period,double_prate_amt,double_prate_curr,double_prate_period,po_num,job_loc_tax,department,muser,mdate,date_ended,date_placed,diem_lodging,diem_mie,diem_total,diem_currency,diem_period,diem_billable,diem_taxable,diem_billrate,assign_no,seqnumber,deptid,attention,corp_code,industryid,schedule_display,bill_burden,shiftid,starthour,endhour,shift_type,daypay)
            SELECT emp_uname,CLIENT,project,manager,s_date,e_date,rate,tsapp,jtype,asgn_id,rateper,otrate,imethod,iterms,pterms,sagent,commision,co_type,endclient,tweeks,tdays,notes,rtime,'Needs Approval',posid,jotype,catid,postitle,refcode,posstatus,vendor,contact,CONCAT('cand',cand_id),exp_edate,hired_date,posworkhr,timesheet,bamount,bcurrency,bperiod,pamount,pcurrency,pperiod,emp_prate,reason,rateperiod,ot_period,ot_currency,placement_fee,placement_curr,bill_contact,bill_address,wcomp_code,bill_req,service_terms,hire_req,addinfo,avg_interview,calctype,burden,markup,margin,brateopen,brateopen_amt,prateopen,prateopen_amt,joblocation,OWNER,NOW(),otbrate_amt,otbrate_curr,otbrate_period,otprate_amt,otprate_curr,otprate_period,payrollpid,notes_cancel,offlocation,double_brate_amt,double_brate_curr,double_brate_period,double_prate_amt,double_prate_curr,double_prate_period,po_num,job_loc_tax,department,muser,NOW(),date_ended,NOW(),diem_lodging,diem_mie,diem_total,diem_currency,diem_period,diem_billable,diem_taxable,diem_billrate,asgn_id,seq_no,deptid,attention,corp_code,industryid,schedule_display,bill_burden,shiftid,starthour,endhour,shift_type,daypay
            FROM bulk_placement_jobs WHERE sno = bulk_place_jobs_sno;

            SET placejob_sno = LAST_INSERT_ID();

            INSERT INTO placement_tab(sno, consno, starthour, endhour, wdays, sch_date, coltype)
            SELECT '', placejob_sno, starthour, endhour, wdays, sch_date, coltype
            FROM bulk_placement_tab WHERE bulk_place_sno = bulk_place_jobs_sno AND coltype = 'assign';

                      IF ShiftModeType <> 'perdiem' THEN
                        UPDATE posdesc SET closepos=closepos+1 WHERE posid=req_id;
                          UPDATE hotjobs SET closepos=closepos+1 WHERE req_id =req_id AND STATUS!='BP';
                      END IF;

                      UPDATE placement_jobs SET shiftid = shift_sno WHERE  sno = placejob_sno;
            
                      SELECT sno INTO mng_sno FROM manage WHERE NAME = 'Needs Approval' AND TYPE='interviewstatus' LIMIT 1;

            UPDATE resume_status SET STATUS = mng_sno ,pstatus = 'P',mdate = NOW() WHERE res_id = cand_id AND req_id = job_sno AND seqnumber = seq_no AND shift_id = shift_sno;

            INSERT INTO resume_history (cli_name, req_id, res_id, comp_id, appuser, appdate, STATUS, TYPE, muser, mdate, seqnumber,shift_id)
            VALUES (con_sno, req_id, cand_id, com_sno, usr, NOW(), mng_sno, 'cand', usr, NOW(), seq_no,shift_sno);

            IF ShiftModeType = 'regular' THEN
              UPDATE sm_timeslot_positions SET candid= CONCAT('cand',cand_id),color_code='#04B431' 
              WHERE shift_date >= DATE_ADD(CURDATE(),INTERVAL -2 MONTH) AND sm_sno= shift_sno AND POSITION = placement_next_pos AND pid = req_id;

              INSERT INTO placement_sm_timeslots(sno,pid,shift_date,shift_starttime,shift_endtime,event_type,event_no,event_group_no,shift_status,sm_sno,no_of_positions,cuser,ctime,muser,mtime)
              SELECT  '',placejob_sno,shift_date,shift_starttime,shift_endtime,event_type,event_no,event_group_no,shift_status,sm_sno,no_of_positions,usr,NOW(),usr,NOW() FROM posdesc_sm_timeslots WHERE pid = req_id AND sm_sno = shift_sno  AND shift_date >= DATE_ADD(CURDATE(),INTERVAL -2 MONTH);
            END IF;

            IF ShiftModeType = 'perdiem' THEN

              INSERT INTO placement_perdiem_shift_sch (sno, placementjob_sno,candid,pusername,no_of_shift_position, shift_startdate,shift_enddate,shift_starttime,shift_endtime,split_shift,shift_id,cdate,cuser,mdate,muser)SELECT '',placejob_sno,CONCAT('cand',cand_id),asgn_id,no_of_shift_position,shift_startdate,shift_enddate,shift_starttime,shift_endtime,split_shift,shift_id,cdate,cuser,mdate,muser FROM bulk_place_perdiem_shift_sch WHERE bulk_place_sno=bulk_place_jobs_sno AND shift_id=shift_sno; 

              SELECT DATE_FORMAT(MIN(shift_startdate),'%c-%e-%Y'),DATE_FORMAT(MAX(shift_enddate),'%Y-%m-%d') INTO perdiem_start_date,perdiem_exp_enddate 
              FROM placement_perdiem_shift_sch WHERE placementjob_sno=placejob_sno;

              UPDATE placement_jobs SET s_date=perdiem_start_date,exp_edate=perdiem_exp_enddate WHERE sno=placejob_sno;
              CALL `bulk_jo_perdiem_shift_sch_detail_proc`(bulk_place_jobs_sno,shift_sno,cand_id,asgn_id,usr);

              UPDATE bulk_place_perdiem_shift_sch SET no_of_shift_position = no_of_shift_position + 1 WHERE bulk_place_sno=bulk_place_jobs_sno AND shift_id=shift_sno;
            END IF; 
            
            IF (submission_rates_count  > 0 AND rates_on_submission_flag = 'YES') THEN
    
              INSERT INTO multiplerates_joborder(joborderid, jo_mode, ratemasterid, ratetype, rate, period, currency, 
              billable, taxable, STATUS, cuser, cdate, muser, mdate)
              SELECT placejob_sno, 'placement', ratemasterid, ratetype, rate, period, currency, 
              billable, taxable, 'ACTIVE',usr, NOW(), usr, NOW()
              FROM multiplerates_joborder 
              WHERE joborderid = resume_status_sno AND jo_mode = 'submission';
              
              SELECT COUNT(1) INTO shift_rates1_count FROM multiplerates_joborder WHERE joborderid = placejob_sno AND ratemasterid = 'rate1' AND jo_mode='placement';
              IF shift_rates1_count = 0 THEN
                INSERT INTO multiplerates_joborder (joborderid,jo_mode,ratemasterid,ratetype,rate,period,currency,billable,taxable,STATUS, cuser,cdate) VALUES (placejob_sno,'placement','rate1','payrate','0','HOUR','USD','N','N','ACTIVE',usr,NOW());
                INSERT INTO multiplerates_joborder (joborderid,jo_mode,ratemasterid,ratetype,rate,period,currency,billable,taxable,STATUS, cuser,cdate) VALUES (placejob_sno,'placement','rate1','billrate','0','HOUR','USD','N','N','ACTIVE',usr,NOW());
              END IF;

              SELECT COUNT(1) INTO shift_rates2_count FROM multiplerates_joborder WHERE joborderid = placejob_sno AND ratemasterid = 'rate2' AND jo_mode='placement';

              IF shift_rates2_count = 0 THEN
                INSERT INTO multiplerates_joborder (joborderid,jo_mode,ratemasterid,ratetype,rate,period,currency,billable,taxable,STATUS, cuser,cdate) VALUES (placejob_sno,'placement','rate2','payrate','0','HOUR','USD','N','N','ACTIVE',usr,NOW());
                INSERT INTO multiplerates_joborder (joborderid,jo_mode,ratemasterid,ratetype,rate,period,currency,billable,taxable,STATUS, cuser,cdate) VALUES (placejob_sno,'placement','rate2','billrate','0','HOUR','USD','N','N','ACTIVE',usr,NOW());
              END IF;

              SELECT COUNT(1) INTO shift_rates3_count FROM multiplerates_joborder WHERE joborderid = placejob_sno AND ratemasterid = 'rate3' AND jo_mode='placement';
              IF shift_rates3_count = 0 THEN
                INSERT INTO multiplerates_joborder (joborderid,jo_mode,ratemasterid,ratetype,rate,period,currency,billable,taxable,STATUS, cuser,cdate) VALUES (placejob_sno,'placement','rate3','payrate','0','HOUR','USD','N','N','ACTIVE',usr,NOW());
                INSERT INTO multiplerates_joborder (joborderid,jo_mode,ratemasterid,ratetype,rate,period,currency,billable,taxable,STATUS, cuser,cdate) VALUES (placejob_sno,'placement','rate3','billrate','0','HOUR','USD','N','N','ACTIVE',usr,NOW());
              END IF;

            ELSEIF shift_rates_count > 0 THEN

              INSERT INTO multiplerates_joborder(joborderid, jo_mode, ratemasterid, ratetype, rate, period, currency, 
              billable, taxable, STATUS, cuser, cdate, muser, mdate)
              SELECT placejob_sno, 'placement', ratemasterid, ratetype, rate, period, currency, 
              billable, taxable, 'ACTIVE',cuser, NOW(), cuser, NOW()
              FROM bulk_place_multiplerates 
              WHERE bulk_place_sno = bulk_place_jobs_sno AND shiftid = shift_sno ;
            ELSE

              INSERT INTO multiplerates_joborder(joborderid, jo_mode, ratemasterid, ratetype, rate, period, currency, 
              billable, taxable, STATUS, cuser, cdate, muser, mdate)
              SELECT placejob_sno, 'placement', ratemasterid, ratetype, rate, period, currency, 
              billable, taxable, 'ACTIVE',cuser, NOW(), cuser, NOW()
              FROM bulk_place_multiplerates 
              WHERE bulk_place_sno = bulk_place_jobs_sno AND shiftid ='0';
            END IF;
            
            IF (submission_rates_count  > 0 OR shift_rates_count > 0) THEN
            
              UPDATE placement_jobs AS cj,multiplerates_joborder AS ma SET cj.bamount = ma.rate,cj.bcurrency = ma.currency,cj.bperiod = ma.period
              WHERE cj.sno = ma.joborderid AND ma.jo_mode = 'placement' AND ratetype = 'billrate' AND  ma.ratemasterid= 'rate1' AND cj.sno = placejob_sno;
              UPDATE placement_jobs AS cj,multiplerates_joborder AS ma SET cj.pamount = ma.rate,cj.pcurrency = ma.currency,cj.pperiod = ma.period
              WHERE cj.sno = ma.joborderid AND ma.jo_mode = 'placement' AND ratetype = 'payrate' AND  ma.ratemasterid= 'rate1' AND cj.sno = placejob_sno;

              UPDATE placement_jobs AS cj,multiplerates_joborder AS ma SET cj.otbrate_amt = ma.rate,cj.otbrate_curr = ma.currency,cj.otbrate_period = ma.period
              WHERE cj.sno = ma.joborderid AND ma.jo_mode = 'placement' AND ratetype = 'billrate' AND  ma.ratemasterid= 'rate2' AND cj.sno = placejob_sno;

              UPDATE placement_jobs AS cj,multiplerates_joborder AS ma SET cj.otprate_amt = ma.rate,cj.otprate_curr = ma.currency,cj.otprate_period = ma.period
              WHERE cj.sno = ma.joborderid AND ma.jo_mode = 'placement' AND ratetype = 'payrate' AND  ma.ratemasterid= 'rate2' AND cj.sno = placejob_sno;

              UPDATE placement_jobs AS cj,multiplerates_joborder AS ma SET cj.double_brate_amt = ma.rate,cj.double_brate_curr = ma.currency,cj.double_brate_period = ma.period
              WHERE cj.sno = ma.joborderid AND ma.jo_mode = 'placement' AND ratetype = 'billrate' AND  ma.ratemasterid= 'rate3' AND cj.sno = placejob_sno;

              UPDATE placement_jobs AS cj,multiplerates_joborder AS ma SET cj.double_prate_amt = ma.rate,cj.double_prate_curr = ma.currency,cj.double_prate_period = ma.period
              WHERE cj.sno = ma.joborderid AND ma.jo_mode = 'placement' AND ratetype = 'payrate' AND  ma.ratemasterid= 'rate3' AND cj.sno = placejob_sno;
            
            END IF;

            INSERT INTO assign_commission(username, assignid, assigntype,
            person, TYPE, co_type, comm_calc, amount, roleid, overwrite, enableUserInput,shift_id)
            SELECT username, placejob_sno, 'P', person, TYPE, co_type, comm_calc, amount,
            roleid, overwrite, enableUserInput, shift_sno 
            FROM bulk_place_assign_commission WHERE bulk_place_sno = bulk_place_jobs_sno;

            INSERT INTO placement_burden_details(placement_jobs_sno, ratemasterid, ratetype, bt_id, bi_id)
            SELECT placejob_sno, ratemasterid, ratetype, bt_id, bi_id FROM bulk_place_burden_details WHERE bulk_place_sno=bulk_place_jobs_sno;

            CALL bulk_placement_cdf_proc(conjob_sno,bulk_place_jobs_sno,'consultantjob');

            UPDATE bulk_placement_queue SET STATUS = 'Completed',pusername = asgn_id WHERE sno = placement_queue_sno; 

            
            SET placement_status = 'Completed';
            
          ELSE
            
            CALL Accounting_Vendor_Proc(cand_id);
            CALL get_Assginment_Seq(@pusername);
            SET asgn_id =  @pusername;

            SELECT emp.username INTO emp_uname FROM  emp_list AS emp INNER JOIN candidate_list AS cl ON (cl.candid = CONCAT('emp',emp.sno)) WHERE cl.sno = cand_id;

            SELECT COUNT(1)+1 INTO placement_next_pos FROM placement_jobs WHERE posid = req_id AND assg_status != 'Cancelled'  AND shiftid = shift_sno;

            INSERT INTO placement_jobs(username,CLIENT,project,manager,s_date,e_date,rate,tsapp,jtype,pusername,rateper,otrate,imethod,iterms,pterms,sagent,commision,co_type,endclient,tweeks,tdays,notes,rtime,assg_status,posid,jotype,catid,postitle,refcode,posstatus,vendor,contact,candidate,exp_edate,hired_date,posworkhr,timesheet,bamount,bcurrency,bperiod,pamount,pcurrency,pperiod,emp_prate,reason,rateperiod,ot_period,ot_currency,placement_fee,placement_curr,bill_contact,bill_address,wcomp_code,bill_req,service_terms,hire_req,addinfo,avg_interview,calctype,burden,markup,margin,brateopen,brateopen_amt,prateopen,prateopen_amt,joblocation,OWNER,cdate,otbrate_amt,otbrate_curr,otbrate_period,otprate_amt,otprate_curr,otprate_period,payrollpid,notes_cancel,offlocation,double_brate_amt,double_brate_curr,double_brate_period,double_prate_amt,double_prate_curr,double_prate_period,po_num,job_loc_tax,department,muser,mdate,date_ended,date_placed,diem_lodging,diem_mie,diem_total,diem_currency,diem_period,diem_billable,diem_taxable,diem_billrate,assign_no,seqnumber,deptid,attention,corp_code,industryid,schedule_display,bill_burden,shiftid,starthour,endhour,shift_type,daypay)
            SELECT emp_uname,CLIENT,project,manager,s_date,e_date,rate,tsapp,jtype,asgn_id,rateper,otrate,imethod,iterms,pterms,sagent,commision,co_type,endclient,tweeks,tdays,notes,rtime,'Needs Approval',posid,jotype,catid,postitle,refcode,posstatus,vendor,contact,CONCAT('cand',cand_id),exp_edate,hired_date,posworkhr,timesheet,bamount,bcurrency,bperiod,pamount,pcurrency,pperiod,emp_prate,reason,rateperiod,ot_period,ot_currency,placement_fee,placement_curr,bill_contact,bill_address,wcomp_code,bill_req,service_terms,hire_req,addinfo,avg_interview,calctype,burden,markup,margin,brateopen,brateopen_amt,prateopen,prateopen_amt,joblocation,OWNER,NOW(),otbrate_amt,otbrate_curr,otbrate_period,otprate_amt,otprate_curr,otprate_period,payrollpid,notes_cancel,offlocation,double_brate_amt,double_brate_curr,double_brate_period,double_prate_amt,double_prate_curr,double_prate_period,po_num,job_loc_tax,department,muser,NOW(),date_ended,NOW(),diem_lodging,diem_mie,diem_total,diem_currency,diem_period,diem_billable,diem_taxable,diem_billrate,asgn_id,seq_no,deptid,attention,corp_code,industryid,schedule_display,bill_burden,shiftid,starthour,endhour,shift_type,daypay
            FROM bulk_placement_jobs WHERE sno = bulk_place_jobs_sno;

            SET placejob_sno = LAST_INSERT_ID();
            INSERT INTO placement_tab(sno, consno, starthour, endhour, wdays, sch_date, coltype)
            SELECT '', placejob_sno, starthour, endhour, wdays, sch_date, coltype
            FROM bulk_placement_tab WHERE bulk_place_sno = bulk_place_jobs_sno AND coltype = 'assign';
                      IF ShiftModeType <> 'perdiem' THEN
                          UPDATE posdesc SET closepos=closepos+1 WHERE posid=req_id;
                          UPDATE hotjobs SET closepos=closepos+1 WHERE req_id =req_id AND STATUS!='BP';
                      END IF;
            UPDATE placement_jobs SET shiftid = shift_sno WHERE  sno = placejob_sno;

            SELECT sno INTO mng_sno FROM manage WHERE NAME = 'Needs Approval' AND TYPE='interviewstatus' LIMIT 1;

            UPDATE resume_status SET STATUS = mng_sno ,pstatus = 'P',mdate = NOW() WHERE res_id = cand_id AND req_id = job_sno AND seqnumber = seq_no AND shift_id = shift_sno;
             
            INSERT INTO resume_history (cli_name, req_id, res_id, comp_id, appuser, appdate, STATUS, TYPE, muser, mdate, seqnumber,shift_id)
            VALUES (con_sno, req_id, cand_id, com_sno, usr, NOW(), mng_sno, 'cand', usr, NOW(), seq_no,shift_sno);

            SELECT COUNT(1) INTO shift_rates_count FROM bulk_place_multiplerates WHERE bulk_place_sno = bulk_place_jobs_sno AND shiftid = shift_sno ;
            
            SELECT COUNT(1) INTO submission_rates_count FROM multiplerates_joborder WHERE joborderid = resume_status_sno AND jo_mode = 'submission' ;
            
            
            IF (submission_rates_count  > 0 AND rates_on_submission_flag = 'YES') THEN
    
              INSERT INTO multiplerates_joborder(joborderid, jo_mode, ratemasterid, ratetype, rate, period, currency, 
              billable, taxable, STATUS, cuser, cdate, muser, mdate)
              SELECT placejob_sno, 'placement', ratemasterid, ratetype, rate, period, currency, 
              billable, taxable, 'ACTIVE',usr, NOW(), usr, NOW()
              FROM multiplerates_joborder 
              WHERE joborderid = resume_status_sno AND jo_mode = 'submission';

              SELECT COUNT(1) INTO shift_rates1_count FROM multiplerates_joborder WHERE joborderid = placejob_sno AND ratemasterid = 'rate1' AND jo_mode='placement';
              IF shift_rates1_count = 0 THEN
                INSERT INTO multiplerates_joborder (joborderid,jo_mode,ratemasterid,ratetype,rate,period,currency,billable,taxable,STATUS, cuser,cdate) VALUES (placejob_sno,'placement','rate1','payrate','0','HOUR','USD','N','N','ACTIVE',usr,NOW());
                INSERT INTO multiplerates_joborder (joborderid,jo_mode,ratemasterid,ratetype,rate,period,currency,billable,taxable,STATUS, cuser,cdate) VALUES (placejob_sno,'placement','rate1','billrate','0','HOUR','USD','N','N','ACTIVE',usr,NOW());
              END IF;

              SELECT COUNT(1) INTO shift_rates2_count FROM multiplerates_joborder WHERE joborderid = placejob_sno AND ratemasterid = 'rate2' AND jo_mode='placement';

              IF shift_rates2_count = 0 THEN
                INSERT INTO multiplerates_joborder (joborderid,jo_mode,ratemasterid,ratetype,rate,period,currency,billable,taxable,STATUS, cuser,cdate) VALUES (placejob_sno,'placement','rate2','payrate','0','HOUR','USD','N','N','ACTIVE',usr,NOW());
                INSERT INTO multiplerates_joborder (joborderid,jo_mode,ratemasterid,ratetype,rate,period,currency,billable,taxable,STATUS, cuser,cdate) VALUES (placejob_sno,'placement','rate2','billrate','0','HOUR','USD','N','N','ACTIVE',usr,NOW());
              END IF;

              SELECT COUNT(1) INTO shift_rates3_count FROM multiplerates_joborder WHERE joborderid = placejob_sno AND ratemasterid = 'rate3' AND jo_mode='placement';
              IF shift_rates3_count = 0 THEN
                INSERT INTO multiplerates_joborder (joborderid,jo_mode,ratemasterid,ratetype,rate,period,currency,billable,taxable,STATUS, cuser,cdate) VALUES (placejob_sno,'placement','rate3','payrate','0','HOUR','USD','N','N','ACTIVE',usr,NOW());
                INSERT INTO multiplerates_joborder (joborderid,jo_mode,ratemasterid,ratetype,rate,period,currency,billable,taxable,STATUS, cuser,cdate) VALUES (placejob_sno,'placement','rate3','billrate','0','HOUR','USD','N','N','ACTIVE',usr,NOW());
              END IF;
            
            ELSEIF shift_rates_count > 0 THEN

              INSERT INTO multiplerates_joborder(joborderid, jo_mode, ratemasterid, ratetype, rate, period, currency, 
              billable, taxable, STATUS, cuser, cdate, muser, mdate)
              SELECT placejob_sno, 'placement', ratemasterid, ratetype, rate, period, currency, 
              billable, taxable, 'ACTIVE',cuser, NOW(), cuser, NOW()
              FROM bulk_place_multiplerates 
              WHERE bulk_place_sno = bulk_place_jobs_sno AND shiftid = shift_sno ;

            ELSE

              INSERT INTO multiplerates_joborder(joborderid, jo_mode, ratemasterid, ratetype, rate, period, currency, 
              billable, taxable, STATUS, cuser, cdate, muser, mdate)
              SELECT placejob_sno, 'placement', ratemasterid, ratetype, rate, period, currency, 
              billable, taxable, 'ACTIVE',cuser, NOW(), cuser, NOW()
              FROM bulk_place_multiplerates 
              WHERE bulk_place_sno = bulk_place_jobs_sno AND shiftid ='0';
            END IF;
            
            IF(submission_rates_count  > 0 OR shift_rates_count > 0) THEN
            
              UPDATE placement_jobs AS cj,multiplerates_joborder AS ma SET cj.bamount = ma.rate,cj.bcurrency = ma.currency,cj.bperiod = ma.period
              WHERE cj.sno = ma.joborderid AND ma.jo_mode = 'placement' AND ratetype = 'billrate' AND  ma.ratemasterid= 'rate1' AND cj.sno = placejob_sno;
              UPDATE placement_jobs AS cj,multiplerates_joborder AS ma SET cj.pamount = ma.rate,cj.pcurrency = ma.currency,cj.pperiod = ma.period
              WHERE cj.sno = ma.joborderid AND ma.jo_mode = 'placement' AND ratetype = 'payrate' AND  ma.ratemasterid= 'rate1' AND cj.sno = placejob_sno;

              UPDATE placement_jobs AS cj,multiplerates_joborder AS ma SET cj.otbrate_amt = ma.rate,cj.otbrate_curr = ma.currency,cj.otbrate_period = ma.period
              WHERE cj.sno = ma.joborderid AND ma.jo_mode = 'placement' AND ratetype = 'billrate' AND  ma.ratemasterid= 'rate2' AND cj.sno = placejob_sno;

              UPDATE placement_jobs AS cj,multiplerates_joborder AS ma SET cj.otprate_amt = ma.rate,cj.otprate_curr = ma.currency,cj.otprate_period = ma.period
              WHERE cj.sno = ma.joborderid AND ma.jo_mode = 'placement' AND ratetype = 'payrate' AND  ma.ratemasterid= 'rate2' AND cj.sno = placejob_sno;

              UPDATE placement_jobs AS cj,multiplerates_joborder AS ma SET cj.double_brate_amt = ma.rate,cj.double_brate_curr = ma.currency,cj.double_brate_period = ma.period
              WHERE cj.sno = ma.joborderid AND ma.jo_mode = 'placement' AND ratetype = 'billrate' AND  ma.ratemasterid= 'rate3' AND cj.sno = placejob_sno;

              UPDATE placement_jobs AS cj,multiplerates_joborder AS ma SET cj.double_prate_amt = ma.rate,cj.double_prate_curr = ma.currency,cj.double_prate_period = ma.period
              WHERE cj.sno = ma.joborderid AND ma.jo_mode = 'placement' AND ratetype = 'payrate' AND  ma.ratemasterid= 'rate3' AND cj.sno = placejob_sno;
            
            END IF;
            
            IF ShiftModeType = 'regular' THEN

              UPDATE sm_timeslot_positions SET candid= CONCAT('cand',cand_id),color_code='#04B431' 
              WHERE shift_date >= DATE_ADD(CURDATE(),INTERVAL -2 MONTH) AND sm_sno= shift_sno AND POSITION = placement_next_pos AND pid = req_id;

              INSERT INTO placement_sm_timeslots(sno,pid,shift_date,shift_starttime,shift_endtime,event_type,event_no,event_group_no,shift_status,sm_sno,no_of_positions,cuser,ctime,muser,mtime) SELECT  '',placejob_sno,shift_date,shift_starttime,shift_endtime,event_type,event_no,event_group_no,shift_status,sm_sno,no_of_positions,usr,NOW(),usr,NOW() FROM posdesc_sm_timeslots WHERE pid = req_id AND sm_sno = shift_sno  AND shift_date >= DATE_ADD(CURDATE(),INTERVAL -2 MONTH);
            END IF;

            IF ShiftModeType = 'perdiem' THEN

              INSERT INTO placement_perdiem_shift_sch (`sno`, `placementjob_sno`,`candid`,`pusername`,`no_of_shift_position`, `shift_startdate`,`shift_enddate`,`shift_starttime`,`shift_endtime`,`split_shift`,`shift_id`,`cdate`,`cuser`,`mdate`,`muser`)SELECT   '',placejob_sno,CONCAT('cand',cand_id),asgn_id,no_of_shift_position,shift_startdate,shift_enddate,shift_starttime,shift_endtime,split_shift,shift_id,cdate,cuser,mdate,muser FROM bulk_place_perdiem_shift_sch WHERE bulk_place_sno=bulk_place_jobs_sno AND shift_id=shift_sno;

              SELECT DATE_FORMAT(MIN(shift_startdate),'%c-%e-%Y'),DATE_FORMAT(MAX(shift_enddate),'%Y-%m-%d') INTO perdiem_start_date,perdiem_exp_enddate 
              FROM placement_perdiem_shift_sch WHERE placementjob_sno=placejob_sno;

              UPDATE placement_jobs SET s_date=perdiem_start_date,exp_edate=perdiem_exp_enddate WHERE sno=placejob_sno;

              CALL `bulk_jo_perdiem_shift_sch_detail_proc`(bulk_place_jobs_sno,shift_sno,cand_id,asgn_id,usr);

            END IF;       

            INSERT INTO assign_commission(username, assignid, assigntype,
            person, TYPE, co_type, comm_calc, amount, roleid, overwrite, enableUserInput,shift_id)
            SELECT username, placejob_sno, 'P', person, TYPE, co_type, comm_calc, amount,
            roleid, overwrite, enableUserInput, shift_sno 
            FROM bulk_place_assign_commission WHERE bulk_place_sno = bulk_place_jobs_sno;

            INSERT INTO placement_burden_details(placement_jobs_sno, ratemasterid, ratetype, bt_id, bi_id)
            SELECT placejob_sno, ratemasterid, ratetype, bt_id, bi_id FROM bulk_place_burden_details WHERE bulk_place_sno=bulk_place_jobs_sno;
             
            INSERT INTO hrcon_jobs (username,CLIENT,project,manager,s_date,e_date,rate,tsapp,jtype,pusername,rateper,otrate,ustatus,imethod,iterms,pterms,sagent,commision,co_type,endclient,tweeks,tdays,notes,rtime,assg_status,posid,jotype,catid,postitle,refcode,posstatus,vendor,contact,candidate,exp_edate,hired_date,posworkhr,timesheet,bamount,bcurrency,bperiod,pamount,pcurrency,pperiod,emp_prate,reason,rateperiod,ot_period,ot_currency,placement_fee,placement_curr,bill_contact,bill_address,wcomp_code,bill_req,service_terms,hire_req,addinfo,avg_interview,calctype,burden,markup,margin,brateopen,brateopen_amt,prateopen,prateopen_amt,joblocation,OWNER,cdate,otbrate_amt,otbrate_curr,otbrate_period,otprate_amt,otprate_curr,otprate_period,payrollpid,notes_cancel,offlocation,double_brate_amt,double_brate_curr,double_brate_period,double_prate_amt,double_prate_curr,double_prate_period,po_num,job_loc_tax,department,muser,mdate,date_ended,date_placed,diem_lodging,diem_mie,diem_total,diem_currency,diem_period,diem_billable,diem_taxable,diem_billrate,assign_no,classid,deptid,attention,corp_code,industryid,schedule_display,bill_burden,shiftid,worksite_code,starthour,endhour,shift_type,daypay)
            SELECT emp_uname,CLIENT,project,manager,s_date,e_date,rate,tsapp,jtype,asgn_id,rateper,otrate,'pending',imethod,iterms,pterms,sagent,commision,co_type,endclient,tweeks,tdays,notes,rtime,assg_status,posid,jotype,catid,postitle,refcode,posstatus,vendor,contact,cand_id,exp_edate,hired_date,posworkhr,timesheet,bamount,bcurrency,bperiod,pamount,pcurrency,pperiod,emp_prate,reason,rateperiod,ot_period,ot_currency,placement_fee,placement_curr,bill_contact,bill_address,wcomp_code,bill_req,service_terms,hire_req,addinfo,avg_interview,calctype,burden,markup,margin,brateopen,brateopen_amt,prateopen,prateopen_amt,joblocation,OWNER,NOW(),otbrate_amt,otbrate_curr,otbrate_period,otprate_amt,otprate_curr,otprate_period,payrollpid,notes_cancel,offlocation,double_brate_amt,double_brate_curr,double_brate_period,double_prate_amt,double_prate_curr,double_prate_period,po_num,job_loc_tax,department,muser,NOW(),date_ended,NOW(),diem_lodging,diem_mie,diem_total,diem_currency,diem_period,diem_billable,diem_taxable,diem_billrate,asgn_id,classid,deptid,attention,corp_code,industryid,schedule_display,bill_burden,shiftid,worksite_code,starthour,endhour,shift_type,daypay FROM bulk_placement_jobs WHERE sno = bulk_place_jobs_sno;

            SET hrcon_sno = LAST_INSERT_ID();
            UPDATE hrcon_jobs SET shiftid = shift_sno WHERE  sno = hrcon_sno;

            INSERT INTO assignment_schedule(userid, title, startdate, enddate, contactsno, modulename, 
            invapproved, recstatus, assign_no, cuser, muser, cdate, mdate)
            SELECT a.username,a.project,a.s_date,a.e_date,CONCAT(a.sno,'|'),'HR->Assignments',
            IF(a.ustatus = 'pending','active',a.ustatus),'active',a.assign_no,a.owner,a.muser,a.cdate,a.mdate
            FROM hrcon_jobs a
            WHERE a.assign_no = asgn_id; 

            SET assign_schedule_sno = LAST_INSERT_ID();

            INSERT INTO hrcon_tab(sno, tabsno, starthour, endhour, wdays, sch_date, coltype)
            SELECT '', assign_schedule_sno, starthour, endhour, wdays, sch_date, coltype
            FROM bulk_placement_tab WHERE bulk_place_sno = bulk_place_jobs_sno AND coltype = 'assign';

            INSERT INTO empcon_tab(sno, tabsno, starthour, endhour, wdays, sch_date, coltype)
            SELECT '', assign_schedule_sno, starthour, endhour, wdays, sch_date, coltype
            FROM bulk_placement_tab WHERE bulk_place_sno = bulk_place_jobs_sno AND coltype = 'assign';

            IF ShiftModeType = 'regular' THEN

              INSERT INTO hrconjob_sm_timeslots(sno,pid,shift_date,shift_starttime,shift_endtime,event_type,event_no,event_group_no,shift_status,sm_sno,no_of_positions,cuser,ctime,muser,mtime)SELECT  '',hrcon_sno,shift_date,shift_starttime,shift_endtime,event_type,event_no,event_group_no,shift_status,sm_sno,no_of_positions,usr,NOW(),usr,NOW() FROM posdesc_sm_timeslots WHERE pid = req_id AND sm_sno = shift_sno  AND shift_date >= DATE_ADD(CURDATE(),INTERVAL -2 MONTH);
            END IF;

            IF ShiftModeType = 'perdiem' THEN

              INSERT INTO hrconjob_perdiem_shift_sch (`sno`, `hrconjob_sno`,`pusername`,`no_of_shift_position`, `shift_startdate`,`shift_enddate`,`shift_starttime`,`shift_endtime`,`split_shift`,`shift_id`,`cdate`,`cuser`,`mdate`,`muser`)SELECT '',hrcon_sno,asgn_id,no_of_shift_position,shift_startdate,shift_enddate,shift_starttime,shift_endtime,split_shift,shift_id,cdate,cuser,mdate,muser FROM bulk_place_perdiem_shift_sch WHERE bulk_place_sno=bulk_place_jobs_sno AND shift_id=shift_sno;
              SELECT DATE_FORMAT(MIN(shift_startdate),'%c-%e-%Y'),DATE_FORMAT(MAX(shift_enddate),'%Y-%m-%d') INTO perdiem_start_date,perdiem_exp_enddate 
              FROM hrconjob_perdiem_shift_sch WHERE hrconjob_sno=hrcon_sno;

              UPDATE hrcon_jobs SET s_date=perdiem_start_date,exp_edate=perdiem_exp_enddate WHERE sno=hrcon_sno;
            END IF;

            INSERT INTO assign_commission(username, assignid, assigntype,
            person, TYPE, co_type, comm_calc, amount, roleid, overwrite, enableUserInput,shift_id)
            SELECT username, hrcon_sno, 'H', person, TYPE, co_type, comm_calc, amount,
            roleid, overwrite, enableUserInput, shift_sno 
            FROM bulk_place_assign_commission WHERE bulk_place_sno = bulk_place_jobs_sno;

            INSERT INTO hrcon_burden_details(hrcon_jobs_sno, ratemasterid, ratetype, bt_id, bi_id)
             SELECT hrcon_sno, ratemasterid, ratetype, bt_id, bi_id FROM bulk_place_burden_details WHERE bulk_place_sno=bulk_place_jobs_sno;
             
            IF (submission_rates_count  > 0 AND rates_on_submission_flag = 'YES') THEN 
    
              INSERT INTO multiplerates_assignment(asgnid, asgn_mode, ratemasterid, ratetype, rate, period, currency, 
              billable, taxable, STATUS,cuser, cdate, muser, mdate)
              SELECT hrcon_sno, 'hrcon', ratemasterid, ratetype, rate, period, currency, 
              billable, taxable, 'ACTIVE',usr, NOW(), usr, NOW()
              FROM multiplerates_joborder 
              WHERE joborderid = resume_status_sno AND jo_mode = 'submission';

              SELECT COUNT(1) INTO shift_rates1_count FROM multiplerates_assignment WHERE asgnid = hrcon_sno AND ratemasterid = 'rate1' AND asgn_mode='hrcon';
              IF shift_rates1_count = 0 THEN
                INSERT INTO multiplerates_assignment (asgnid,asgn_mode,ratemasterid,ratetype,rate,period,currency,billable,taxable,STATUS, cuser,cdate) VALUES (hrcon_sno,'hrcon','rate1','payrate','0','HOUR','USD','N','N','ACTIVE',usr,NOW());
                INSERT INTO multiplerates_assignment (asgnid,asgn_mode,ratemasterid,ratetype,rate,period,currency,billable,taxable,STATUS, cuser,cdate) VALUES (hrcon_sno,'hrcon','rate1','billrate','0','HOUR','USD','N','N','ACTIVE',usr,NOW());
              END IF;

              SELECT COUNT(1) INTO shift_rates2_count FROM multiplerates_assignment WHERE asgnid = hrcon_sno AND ratemasterid = 'rate2' AND asgn_mode='hrcon';

              IF shift_rates2_count = 0 THEN
                INSERT INTO multiplerates_assignment (asgnid,asgn_mode,ratemasterid,ratetype,rate,period,currency,billable,taxable,STATUS, cuser,cdate) VALUES (hrcon_sno,'hrcon','rate2','payrate','0','HOUR','USD','N','N','ACTIVE',usr,NOW());
                INSERT INTO multiplerates_assignment (asgnid,asgn_mode,ratemasterid,ratetype,rate,period,currency,billable,taxable,STATUS, cuser,cdate) VALUES (hrcon_sno,'hrcon','rate2','billrate','0','HOUR','USD','N','N','ACTIVE',usr,NOW());
              END IF;

              SELECT COUNT(1) INTO shift_rates3_count FROM multiplerates_assignment WHERE asgnid = hrcon_sno AND ratemasterid = 'rate3' AND asgn_mode='hrcon';
              IF shift_rates3_count = 0 THEN
                INSERT INTO multiplerates_assignment (asgnid,asgn_mode,ratemasterid,ratetype,rate,period,currency,billable,taxable,STATUS, cuser,cdate) VALUES (hrcon_sno,'hrcon','rate3','payrate','0','HOUR','USD','N','N','ACTIVE',usr,NOW());
                INSERT INTO multiplerates_assignment (asgnid,asgn_mode,ratemasterid,ratetype,rate,period,currency,billable,taxable,STATUS, cuser,cdate) VALUES (hrcon_sno,'hrcon','rate3','billrate','0','HOUR','USD','N','N','ACTIVE',usr,NOW());
              END IF;

            ELSEIF shift_rates_count > 0 THEN

              INSERT INTO multiplerates_assignment(asgnid, asgn_mode, ratemasterid, ratetype, rate, period, currency, 
              billable, taxable, STATUS, cuser, cdate, muser, mdate)
              SELECT hrcon_sno, 'hrcon', ratemasterid, ratetype, rate, period, currency, 
              billable, taxable, 'ACTIVE',cuser, NOW(), cuser, NOW()
              FROM bulk_place_multiplerates 
              WHERE bulk_place_sno = bulk_place_jobs_sno AND shiftid = shift_sno;

            ELSE

              INSERT INTO multiplerates_assignment(asgnid, asgn_mode, ratemasterid, ratetype, rate, period, currency, 
              billable, taxable, STATUS, cuser, cdate, muser, mdate)
              SELECT hrcon_sno, 'hrcon', ratemasterid, ratetype, rate, period, currency, 
              billable, taxable, 'ACTIVE',cuser, NOW(), cuser, NOW()
              FROM bulk_place_multiplerates 
              WHERE bulk_place_sno = bulk_place_jobs_sno AND shiftid ='0';
            END IF;
            
            IF(submission_rates_count  > 0 OR shift_rates_count > 0) THEN
            
              UPDATE hrcon_jobs AS cj,multiplerates_assignment AS ma SET cj.bamount = ma.rate,cj.bcurrency = ma.currency,cj.bperiod = ma.period
              WHERE cj.sno = ma.asgnid AND ma.asgn_mode = 'hrcon' AND ratetype = 'billrate' AND  ma.ratemasterid= 'rate1' AND cj.sno = hrcon_sno;
              UPDATE hrcon_jobs AS cj,multiplerates_assignment AS ma SET cj.pamount = ma.rate,cj.pcurrency = ma.currency,cj.pperiod = ma.period
              WHERE cj.sno = ma.asgnid AND ma.asgn_mode = 'hrcon' AND ratetype = 'payrate' AND  ma.ratemasterid= 'rate1' AND cj.sno = hrcon_sno;

              UPDATE hrcon_jobs AS cj,multiplerates_assignment AS ma SET cj.otbrate_amt = ma.rate,cj.otbrate_curr = ma.currency,cj.otbrate_period = ma.period
              WHERE cj.sno = ma.asgnid AND ma.asgn_mode = 'hrcon' AND ratetype = 'billrate' AND  ma.ratemasterid= 'rate2' AND cj.sno = hrcon_sno;

              UPDATE hrcon_jobs AS cj,multiplerates_assignment AS ma SET cj.otprate_amt = ma.rate,cj.otprate_curr = ma.currency,cj.otprate_period = ma.period
              WHERE cj.sno = ma.asgnid AND ma.asgn_mode = 'hrcon' AND ratetype = 'payrate' AND  ma.ratemasterid= 'rate2' AND cj.sno = hrcon_sno;

              UPDATE hrcon_jobs AS cj,multiplerates_assignment AS ma SET cj.double_brate_amt = ma.rate,cj.double_brate_curr = ma.currency,cj.double_brate_period = ma.period
              WHERE cj.sno = ma.asgnid AND ma.asgn_mode = 'hrcon' AND ratetype = 'billrate' AND  ma.ratemasterid= 'rate3' AND cj.sno = hrcon_sno;

              UPDATE hrcon_jobs AS cj,multiplerates_assignment AS ma SET cj.double_prate_amt = ma.rate,cj.double_prate_curr = ma.currency,cj.double_prate_period = ma.period
              WHERE cj.sno = ma.asgnid AND ma.asgn_mode = 'hrcon' AND ratetype = 'payrate' AND  ma.ratemasterid= 'rate3' AND cj.sno = hrcon_sno;
            END IF;

            CALL bulk_placement_cdf_proc(hrcon_sno,bulk_place_jobs_sno,'hrconjob');
            UPDATE bulk_placement_queue SET STATUS = 'Completed',pusername = asgn_id WHERE sno = placement_queue_sno;

            SET placement_status = 'Completed';
            
          END IF;
        END IF;
      END";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query = "ALTER TABLE earnings_list CHANGE COLUMN code w2boxes varchar(255);";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query = "INSERT into `earnings_list`(`name`,`type`,`calculation_type`,`display_order`,`cuser`,`ctime`,`muser`,`mtime`,system_default) 
  values ('Regular','Regular Pay','Rate',1,1,NOW(),1,NOW(),'Y'),
      ('Salary','Salary','Amount',2,1,NOW(),1,NOW(),'Y'),
      ('Hourly','Hourly','Rate',3,1,NOW(),1,NOW(),'Y'),
      ('Overtime','Overtime','multiplier',4,1,NOW(),1,NOW(),'Y'),
      ('Double Time','Overtime','multiplier',5,1,NOW(),1,NOW(),'Y'),
      ('Holiday','Regular','Rate',6,1,NOW(),1,NOW(),'Y'),
      ('Bonus','Bonus','Amount',7,1,NOW(),1,NOW(),'Y'),
      ('Mileage Reimb','Reimbursement','Amount',8,1,NOW(),1,NOW(),'Y'),
      
      ('Commission','Supplemental/Flat','Amount',9,1,NOW(),1,NOW(),'Y'), /*Removed Covid statements*/
      ('Cash Tips','Tips','Amount',10,1,NOW(),1,NOW(),'Y'),
      ('Credit Card Tips','Tips','Amount',11,1,NOW(),1,NOW(),'Y'),
      ('S Corp Health','SCorp 2%','Amount',12,1,NOW(),1,NOW(),'Y'),
      ('Referral Bonus','Bonus','Amount',13,1,NOW(),1,NOW(),'Y'),
      ('Retro Pay','Regular','Rate',14,1,NOW(),1,NOW(),'Y'),
      ('Severance','Supplemental Pay','Rate',15,1,NOW(),1,NOW(),'Y'),
      ('Service Charges','Regular Pay','Rate',16,1,NOW(),1,NOW(),'Y'),
      ('Sick','Regular Pay ','Rate',17,1,NOW(),1,NOW(),'Y'),
      ('Vacation','Regular Pay ','Rate',18,1,NOW(),1,NOW(),'Y'),
      ('Expense Reimbursement','Reimbursement','Amount',19,1,NOW(),1,NOW(),'Y'),
      ('Per Diem','Per Diem','Amount',20,1,NOW(),1,NOW(),'Y'),
      ('1099 Contractor Pay','1099 Contractor','Amount',21,1,NOW(),1,NOW(),'Y');";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db); 
 
$query = "INSERT INTO ste_manage (sno,`type`,`ac_type`,`ste_type`)
VALUES ('','deductions','FSA - Medical','Benefit125'),
('','deductions','FSA - Medical','BenefitFSA'),
('','deductions','Health Savings Account (HSA)','BenefitHSA'),
('','deductions','FSA - Dependent Care','BenefitFSADependentCare'),
('','deductions','After Tax','BenefitCustom'),
('','deductions','Group Term Life (GTL)','Imputed Income'),
('','deductions','Commuter Benefit','BenefitCustom'),
('','deductions','PUCC','BenefitCustom'),
('','deductions','401k','Benefit401K'),
('','deductions','401k Catch Up','Benefit401K'),
('','deductions','403b','Benefit403B'),
('','deductions','403b Catch Up','Benefit403B'),
('','deductions','Simple IRA','BenefitSimpleIRA'),
('','deductions','Simple IRA Catch Up','BenefitSimpleIRA'),
('','deductions','Roth 401k','BenefitRoth401K'),
('','deductions','Roth 403b','BenefitRoth403B');";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);
 
$query = "INSERT INTO ste_manage (sno,`type`,`ac_type`,`ste_type`)
VALUES
('','earnings','Regular Pay','Regular'),
('','earnings','Salary','Regular'),
('','earnings','Hourly','Regular'),
('','earnings','Overtime','Regular'),
('','earnings','Bonus','Supplemental/Flat'),
('','earnings','Reimbursement','CustomWage'),
('','earnings','Commission','Supplemental/Flat'), /*Removed Covid statements*/
('','earnings','Cash Tips','Tips'),
('','earnings','Charge Tips','Tips'),
('','earnings','SCorp 2%','Imputed Income/ Custom'),
('','earnings','Supplemental Pay','Supplemental/Flat'),
('','earnings','1099 Contractor','CustomWage'),
('','earnings','Per Diem Non-Taxable','CustomWage'),
('','earnings','Per Diem Taxable','Regular')";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query ="INSERT INTO ste_manage (sno,`type`,`ac_type`,`ste_type`) VALUES
('','deductions','125 Plan Pre-Tax','Benefit125'), 
('','deductions','Garnishment - Bankruptcy','BenefitCustom'), 
('','deductions','Garnishment - Child Support','BenefitCustom'), 
('','deductions','Garnishment - Creditor Garnishment','BenefitCustom'), 
('','deductions','Garnishment - IRS Tax Levy','BenefitCustom'), 
('','deductions','Garnishment - State Tax Levy','BenefitCustom');"; 
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);


$query = "ALTER TABLE contact_manage ADD locationCode varchar(30) NOT NULL DEFAULT '' AFTER push_data";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query = "ALTER TABLE emp_list ADD locationCode varchar(30) NOT NULL DEFAULT '' AFTER emp_jtype";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query = "ALTER TABLE consultant_general ADD locationCode varchar(30) NOT NULL DEFAULT ''";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query = "ALTER TABLE hrcon_general ADD locationCode varchar(30) NOT NULL DEFAULT ''";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query = "ALTER TABLE mpHR_payGroups ADD `sup_ded` ENUM('Y','N') NOT NULL DEFAULT 'N'";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query = "ALTER TABLE mpHR_payGroups ADD `sup_garn` ENUM('Y','N') NOT NULL DEFAULT 'N'";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query = "ALTER TABLE mpHR_payGroups ADD `sup_con` ENUM('Y','N') NOT NULL DEFAULT 'N'";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query = "ALTER TABLE contact_manage MODIFY column other varchar(50)";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);


$query = "ALTER TABLE prhearnings ADD `voidid` int(11) NOT NULL DEFAULT '0';";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);
$query = "ALTER TABLE prhearnings ADD `voiduser` varchar(15) NOT NULL DEFAULT '';";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);
$query = "ALTER TABLE prhearnings ADD `voiddatetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00';";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query = "ALTER TABLE prhdeductions ADD `voidid` int(11) NOT NULL DEFAULT '0';";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);
$query = "ALTER TABLE prhdeductions ADD `voiduser` varchar(15) NOT NULL DEFAULT '';";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);
$query = "ALTER TABLE prhdeductions ADD `voiddatetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00';";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query = "ALTER TABLE prhdeposits ADD `voidid` int(11) NOT NULL DEFAULT '0';";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);
$query = "ALTER TABLE prhdeposits ADD `voiduser` varchar(15) NOT NULL DEFAULT '';";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);
$query = "ALTER TABLE prhdeposits ADD `voiddatetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00';";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query = "ALTER TABLE prhtaxes ADD `voidid` int(11) NOT NULL DEFAULT '0';";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);
$query = "ALTER TABLE prhtaxes ADD `voiduser` varchar(15) NOT NULL DEFAULT '';";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);
$query = "ALTER TABLE prhtaxes ADD `voiddatetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00';";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);


$query = "ALTER TABLE state_add_tax ADD COLUMN unique_tax_id VARCHAR(50) NOT NULL DEFAULT '' AFTER state_tax_id";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query = "ALTER TABLE state_add_tax ADD COLUMN expense_account INT(15) NOT NULL DEFAULT '0' AFTER add_acc_name";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query = "ALTER TABLE state_add_tax ADD COLUMN liability_account INT(15) NOT NULL DEFAULT '0' AFTER expense_account";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query = "ALTER TABLE state_suisur_tax ADD COLUMN unique_tax_id VARCHAR(50) NOT NULL DEFAULT '' AFTER state_tax_id";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query = "ALTER TABLE state_suisur_tax ADD COLUMN expense_account INT(15) NOT NULL DEFAULT '0' AFTER effective_edate";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query = "ALTER TABLE state_suisur_tax ADD COLUMN liability_account INT(15) NOT NULL DEFAULT '0' AFTER expense_account";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query = "ALTER TABLE apUsers ADD COLUMN compids longtext AFTER locids";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query = "ALTER TABLE prhtaxdeductions ADD `voidid` int(11) NOT NULL DEFAULT '0'";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query = "ALTER TABLE prhtaxdeductions ADD `voiduser` varchar(15) NOT NULL DEFAULT ''";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query = "ALTER TABLE prhtaxdeductions ADD `voiddatetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query = "ALTER TABLE contact_manage MODIFY inactive enum('Y','N') DEFAULT 'N'";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

echo $contents;

$query = "ALTER TABLE prhearnings ADD COLUMN expensebankid int(10) NOT NULL DEFAULT 0";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query ="ALTER TABLE contributions_list ADD COLUMN typeid INT(10)  NOT NULL DEFAULT '0' AFTER type";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query = "CREATE TABLE `check_format_options` (
  `sno` int(15) NOT NULL AUTO_INCREMENT,
  `username` varchar(15) NOT NULL DEFAULT '',
  `ptype` varchar(10) NOT NULL DEFAULT '',
  PRIMARY KEY (`sno`)
)";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);



// Rapid Pay Card DB Patch
$query ="UPDATE custmenu SET admin=CONCAT(admin,'+Manage Rapid Paycard');";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query = "UPDATE sysuser SET admin=CONCAT(TRIM(TRAILING '+' FROM admin),'+') WHERE admin!='NO'"; 
mysql_query($query,$db);
$contents.= "\n".$query."\n".mysql_error($db); 

$query = "UPDATE sysuser SET admin=CONCAT(SUBSTRING_INDEX(admin,'+',43),'+-',REPLACE(admin,SUBSTRING_INDEX(admin,'+',43),'')) WHERE admin!='NO'"; 
mysql_query($query,$db);
$contents.= "\n".$query."\n".mysql_error($db);

$query ="CREATE TABLE `rapid_setup` (
          `sno` int(15) unsigned NOT NULL AUTO_INCREMENT,
          `routingNumber` TINYBLOB NOT NULL DEFAULT '',
          `certCardID` varchar(25) NOT NULL DEFAULT '',
          `certPasscode` varchar(6) NOT NULL DEFAULT '',
          `csSnos` longtext DEFAULT NULL COMMENT 'comma seperated company_setup sno',
          `rgSno` varchar(1000) NOT NULL DEFAULT '' COMMENT 'reg_category sno',
          `cdate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
          `cuser` varchar(15) NOT NULL DEFAULT '',
          `mdate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
          `muser` varchar(15) NOT NULL DEFAULT '',
          `status` enum('A','B') NOT NULL DEFAULT 'A',
          PRIMARY KEY (`sno`),
          KEY `certCardID` (`certCardID`),
          KEY `certPasscode` (`certPasscode`),
          KEY `rgSno` (`rgSno`),
          KEY `cuser` (`cuser`),
          KEY `muser` (`muser`)
        )";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query ="CREATE TABLE paycards (
            sno int(15) unsigned NOT NULL AUTO_INCREMENT,
            empid varchar(15) NOT NULL DEFAULT '',
            username varchar(15) NOT NULL DEFAULT '',
            cardtype varchar(20) NOT NULL DEFAULT '',
            empcardid varchar(15) NOT NULL DEFAULT '',
            custcardid varchar(15) NOT NULL DEFAULT '',
            expiredate date NOT NULL DEFAULT '0000-00-00',
            status varchar(20) NOT NULL DEFAULT 'Active',
            balance double(10,2) NOT NULL DEFAULT '0.00',
            cuser varchar(15) NOT NULL DEFAULT '',
            cdate datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
            muser varchar(15) NOT NULL DEFAULT '',
            mdate datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
            PRIMARY KEY (`sno`),
            KEY username (`username`),
            KEY cardtype (`cardtype`),
            KEY empcardid (`empcardid`),
            KEY custcardid (`custcardid`)
          )";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query ="CREATE TABLE paycard_transactions (
		  sno bigint(20) NOT NULL AUTO_INCREMENT,
		  empid bigint(20) DEFAULT NULL,
		  name varchar(45) DEFAULT NULL,
		  paybatch_sno int(15) DEFAULT NULL,
		  prhmaster_sno int(15) DEFAULT NULL,
		  amount double(10,2) DEFAULT NULL,
		  card_id varchar(15) DEFAULT NULL,
		  cardtype varchar(20) NOT NULL DEFAULT '',
		  funds_status varchar(50) DEFAULT NULL,
		  api_code int(3) DEFAULT NULL,
		  api_status varchar(2500) DEFAULT NULL,
		  cuser int(15) DEFAULT NULL,
		  cdate datetime DEFAULT NULL,
		  muser int(15) DEFAULT NULL,
		  mdate datetime DEFAULT NULL,
		  PRIMARY KEY (`sno`),
		  KEY empid (`empid`),
		  KEY paybatch_sno (`paybatch_sno`),
		  KEY prhmaster_sno (`prhmaster_sno`),
		  KEY card_id (`card_id`),
		  KEY funds_status (`funds_status`),
		  KEY api_code (`api_code`),
		  KEY cuser (`cuser`),
		  KEY muser (`muser`)
		)";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query ="CREATE TABLE rapid_paycard_logs (
            sno bigint(11) NOT NULL AUTO_INCREMENT,
            headers longtext,
            endpoint longtext,
            request longtext,
            response longtext,
            cuser int(11) DEFAULT '0',
            cdate datetime DEFAULT NULL,
            PRIMARY KEY (`sno`)
          )";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query ="ALTER TABLE hrcon_deposit ADD COLUMN acc1_deposit_type enum('BANK','PAYCARD') DEFAULT 'BANK';";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query ="ALTER TABLE hrcon_deposit ADD COLUMN acc1_paycard varchar(25) NOT NULL DEFAULT '';";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query ="ALTER TABLE hrcon_deposit ADD COLUMN acc1_active_status enum('ACTIVE','INACTIVE') DEFAULT 'ACTIVE';";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query ="ALTER TABLE hrcon_deposit ADD COLUMN acc2_deposit_type enum('BANK','PAYCARD') DEFAULT 'BANK';";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query ="ALTER TABLE hrcon_deposit ADD COLUMN acc2_paycard varchar(25) NOT NULL DEFAULT '';";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query ="ALTER TABLE hrcon_deposit ADD COLUMN acc2_active_status enum('ACTIVE','INACTIVE') DEFAULT 'INACTIVE';";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query ="ALTER TABLE hrcon_deposit ADD COLUMN acc3_deposit_type enum('BANK','PAYCARD') DEFAULT 'BANK';";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query ="ALTER TABLE hrcon_deposit ADD COLUMN acc3_paycard varchar(25) NOT NULL DEFAULT '';";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query ="ALTER TABLE hrcon_deposit ADD COLUMN acc3_active_status enum('ACTIVE','INACTIVE') DEFAULT 'INACTIVE';";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);
// Rapid Pay Card DB Patch

//Check Printing Start
$query ="CREATE TABLE `check_printing`(
	`sno` int(15) UNSIGNED NOT NULL AUTO_INCREMENT,
	`prhmsno` int(15) NOT NULL DEFAULT '0', 
	`check_no` varchar(15) NOT NULL DEFAULT '',
	`void_memo` varchar(100) NOT NULL DEFAULT '',
	`new_check_no` varchar(15) NOT NULL DEFAULT '',
	`void_date` DATETIME NOT NULL,
	`cdate` DATETIME NOT NULL,
	`reprint_date` DATETIME NOT NULL,
	`mdate` DATETIME NOT NULL,
	`cuser` INT(15) NOT NULL DEFAULT '0',
	`muser` INT(15) NOT NULL DEFAULT '0',
	PRIMARY KEY (`sno`),
	KEY `prhmsno` (`prhmsno`)
);";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query ="CREATE TABLE check_printing_history(
	`sno` int(15) UNSIGNED NOT NULL AUTO_INCREMENT,
	`notes` varchar(100) NOT NULL DEFAULT '',
	`muser` INT(15) NOT NULL DEFAULT '0',
	`mdate` DATETIME NOT NULL,	
	PRIMARY KEY (`sno`)
);";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);
//Check Printing End

$query ="ALTER TABLE candidate_general ADD CONSTRAINT ucname_general UNIQUE(username);";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query ="ALTER TABLE candidate_prof ADD CONSTRAINT ucname_prof UNIQUE(username);";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query ="ALTER table state_codes ADD column ste_status enum('N','Y') DEFAULT 'N';";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query ="UPDATE state_codes SET ste_status='Y' WHERE state_abbr IN ('FL','GA','IA','IL','IN','KS','KY','LA','MI','MO','NC','NJ','NY','OH','PA','TN','TX','VA','WI','WA','OR','CO');";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db); 


$query ="ALTER TABLE steJurisdictions MODIFY listValues varchar(1000) NOT NULL DEFAULT '';";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query ="ALTER TABLE steLocationTaxIds MODIFY locationCode VARCHAR(50) NOT NULL DEFAULT '';";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query ="ALTER TABLE emp_list MODIFY locationCode VARCHAR(50) NOT NULL DEFAULT '';";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query ="ALTER TABLE contact_manage MODIFY locationCode VARCHAR(50) NOT NULL DEFAULT '';";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query ="UPDATE ste_fedstate_exempt SET exe_status='N' WHERE sno='8';";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query ="UPDATE ste_fedstate_exempt SET exe_stateCode='NJ,NY' WHERE sno='7';";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);


$query ="ALTER TABLE sysuser MODIFY admin VARCHAR(255) NOT NULL DEFAULT '';";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query = "ALTER TABLE consultant_list ADD locationCode varchar(50) NOT NULL DEFAULT '';";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query = "ALTER TABLE prhbatches ADD `ername` varchar(100) NOT NULL DEFAULT '' AFTER locid;";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query = "ALTER TABLE prhbatches ADD `eraddress1` varchar(100) NOT NULL DEFAULT '' AFTER ername;";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query = "ALTER TABLE prhbatches ADD `eraddress2` varchar(100) NOT NULL DEFAULT '' AFTER eraddress1;";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query = "ALTER TABLE prhbatches ADD `ercity` varchar(50) NOT NULL DEFAULT '' AFTER eraddress2;";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query = "ALTER TABLE prhbatches ADD `erstate` varchar(5) NOT NULL DEFAULT '' AFTER ercity;";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query = "ALTER TABLE prhbatches ADD `erzipcode` varchar(10) NOT NULL DEFAULT '' AFTER erstate;";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query = "ALTER TABLE prhbatches ADD `ercountry` varchar(5) NOT NULL DEFAULT '' AFTER erzipcode;";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query = "ALTER TABLE prhbatches ADD `erphone` varchar(20) NOT NULL DEFAULT '' AFTER ercountry;";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);

$query = "ALTER TABLE prhbatches ADD `erfax` varchar(20) NOT NULL DEFAULT '' AFTER erphone;";
mysql_query($query,$db);
$contents .= "\n".$query."\n".mysql_error($db);


?>