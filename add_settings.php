<?php
/**********************************************************************************
* add_settings.php                                                                *
***********************************************************************************
***********************************************************************************
* This program is distributed in the hope that it is and will be useful, but      *
* WITHOUT ANY WARRANTIES; without even any implied warranty of MERCHANTABILITY    *
* or FITNESS FOR A PARTICULAR PURPOSE.                                            *
*                                                                                 *
* This file is a simplified database installer. It does what it is suppoed to.    *
**********************************************************************************/

// If we have found SSI.php and we are outside of SMF, then we are running standalone.
if (file_exists(dirname(__FILE__) . '/SSI.php') && !defined('SMF'))
	require_once(dirname(__FILE__) . '/SSI.php');
elseif (!defined('SMF')) // If we are outside SMF and can't find SSI.php, then throw an error
	die('<b>Error:</b> Cannot install - please verify you put this file in the same place as SMF\'s SSI.php.');

if (SMF == 'SSI')
	db_extend('packages');
	
global $modSettings, $smcFunc, $sourcedir;

// mod settings for the settings table
$mod_settings = array(
	'geoIP_enablemap' => 0,
	'geoIP_enablepinid' => 0,
	'geoIP_enablereg' => 0,
	'geoIP_cc_block' => 0,
	'geoIPSidebar' => 'right',
	'geoIPType' => 'ROADMAP',
	'geoIPNavType' => 'DEFAULT',
	'geoIPDefaultLat' => 0.00000000000,
	'geoIPDefaultLong' => 0.00000000000,
	'geoIPDefaultZoom' => 1,
	'geoIPPinBackground' => '66FF66',
	'geoIPPinForeground' => '202020',
	'geoIPPinStyle' => 'plainpin',
	'geoIPPinShadow' => 1,
	'geoIPPinSize' => 25,
	'geoIPPinText' => '',
	'geoIPPinIcon' => '',
	'geoIP_enableflags' => 0
);

// Attempt to stop from dying...
if (ini_get('memory_limit') < 128)
	@ini_set('memory_limit', '128M');

// Don't timeout doing this either
@set_time_limit(300);

// Settings to create the new tables...
$smcFunc['db_query']('', '
	DROP TABLE IF EXISTS {db_prefix}geoip_blocks',
	array(
	)
);
$smcFunc['db_query']('', '
	DROP TABLE IF EXISTS {db_prefix}geoip_countries',
	array(
	)
);
$smcFunc['db_query']('', '
	DROP TABLE IF EXISTS {db_prefix}geoip_regions',
	array(
	)
);
$smcFunc['db_query']('', '
	DROP TABLE IF EXISTS {db_prefix}geoip_ip',
	array(
	)
);
$smcFunc['db_query']('', '
	DROP TABLE IF EXISTS {db_prefix}geoip_ip_temp',
	array(
	)
);
$tables = array();
$tables[] = array(
	'table_name' => '{db_prefix}geoip_blocks',
	'columns' => array(
		array('name' => 'locid','type' => 'int', 'unsigned' => true,'null' => false,),
		array('name' => 'country', 'type' => 'char', 'size' => 2,'null' => false,),
		array('name' => 'region', 'type' => 'char', 'size' => 2,'null' => false,),
		array('name' => 'city', 'type' => 'varchar', 'size' => 255,'null' => false,),
		array('name' => 'postalcode', 'type' => 'char', 'size' => 5,'null' => false,),
		array('name' => 'latitude', 'type' => 'float', 'null' => false,),
		array('name' => 'longitude', 'type' => 'float', 'null' => false,),
		array('name' => 'dmacode', 'type' => 'int', 'unsigned' => true,'null' => false,),
		array('name' => 'areacode', 'type' => 'int', 'unsigned' => true,'null' => false,),
	),
	'indexes' => array(
		array('columns' => array('locid'), 'type' => 'primary',),
	),
	'if_exists' => 'skip',
	'error' => 'fatal',
	'parameters' => array(),
);
$tables[] = array(
	'table_name' => '{db_prefix}geoip_regions',
	'columns' => array(
		array('name' => 'cc', 'type' => 'char', 'size' => 2, 'auto' => false, 'null' => false,),
		array('name' => 'rc', 'type' => 'char', 'size' => 2, 'auto' => false, 'null' => false,),
		array('name' => 'rn', 'type' => 'varchar', 'size' => 255, 'auto' => false, 'null' => false,),
	),
	'indexes' => array(
		array('columns' => array('rc'),'type' => 'index',),
		array('columns' => array('cc'),'type' => 'index',),
	),
	'if_exists' => 'skip',
	'error' => 'fatal',
	'parameters' => array(),
);
$tables[] = array(
	'table_name' => '{db_prefix}geoip_countries',
	'columns' => array(
		array('name' => 'ci', 'type' => 'tinyint', 'size' => 2, 'auto' => true,'null' => false, 'unsigned' => true),
		array('name' => 'cc', 'type' => 'char', 'size' => 2, 'auto' => false, 'null' => false,),
		array('name' => 'cn', 'type' => 'varchar', 'size' => 255, 'auto' => false, 'null' => false,),
	),
	'indexes' => array(
		array('columns' => array('ci'), 'type' => 'primary',),
		array('columns' => array('cc'), 'type' => 'index',),
	),
	'if_exists' => 'skip',
	'error' => 'fatal',
	'parameters' => array(),
);
$tables[] = array(
	'table_name' => '{db_prefix}geoip_ip',
	'columns' => array(
		array('name' => 'start', 'type' => 'int', 'unsigned' => true, 'auto' => false, 'null' => false,),
		array('name' => 'end', 'type' => 'int', 'unsigned' => true, 'auto' => false, 'null' => false,),
		array('name' => 'locid', 'type' => 'int', 'unsigned' => true, 'auto' => false, 'null' => false,),
	),
	'indexes' => array(
		array('columns' => array('end'), 'type' => 'index',),
	),
	'if_exists' => 'skip',
	'error' => 'fatal',
	'parameters' => array(),
);
$tables[] = array(
	'table_name' => '{db_prefix}geoip_ip_temp',
	'columns' => array(
		array('name' => 'start_ip', 'type' => 'char', 'size' => '15', 'auto' => false, 'null' => false,),
		array('name' => 'end_ip', 'type' => 'char', 'size' => '15', 'auto' => false, 'null' => false,),
		array('name' => 'start', 'type' => 'int', 'unsigned' => true, 'auto' => false, 'null' => false,),
		array('name' => 'end', 'type' => 'int', 'unsigned' => true, 'auto' => false, 'null' => false,),
		array('name' => 'cc', 'type' => 'char', 'size' => '2', 'auto' => false, 'null' => false,),
		array('name' => 'cn', 'type' => 'varchar', 'size' => '50', 'auto' => false, 'null' => false,),
	),
	'indexes' => array(),
	'if_exists' => 'skip',
	'error' => 'fatal',
	'parameters' => array(),
);

// Add a row to the scheduled tasks
$rows = array();
$rows[] = array(
	'method' => 'ignore',
	'table_name' => '{db_prefix}scheduled_tasks',
	'columns' => array('next_time' => 'int', 'time_offset' => 'int', 'time_regularity' => 'int', 'time_unit' => 'string', 'disabled' => 'int', 'task' => 'string',),
	'data' => array (1317434580, 97380, 5, 'w', 0, 'geoIP'),
	'keys' => array('id_task'),
);

// Add new columns to the online log file
$columns = array();
$columns[] = array(
	'table_name' => '{db_prefix}log_online',
	'if_exists' => 'ignore',
	'error' => 'fatal',
	'parameters' => array(),
	'column_info' => array(
		 'name' => 'longitude',
		 'auto' => false,
		 'default' => 0,
		 'type' => 'decimal(18,15)',
		 'null' => true,
	)
);
$columns[] = array(
	'table_name' => '{db_prefix}log_online',
	'if_exists' => 'ignore',
	'error' => 'fatal',
	'parameters' => array(),
	'column_info' => array(
		 'name' => 'latitude',
		 'auto' => false,
		 'default' => 0,
		 'type' => 'decimal(18,15)',
		 'null' => true,
	)
);
$columns[] = array(
	'table_name' => '{db_prefix}log_online',
	'if_exists' => 'ignore',
	'error' => 'fatal',
	'parameters' => array(),
	'column_info' => array(
		 'name' => 'country',
		 'auto' => false,
		 'type' => 'varchar',
		 'size' => 255,
		 'null' => false,
	)
);
$columns[] = array(
	'table_name' => '{db_prefix}log_online',
	'if_exists' => 'ignore',
	'error' => 'fatal',
	'parameters' => array(),
	'column_info' => array(
		 'name' => 'city',
		 'auto' => false,
		 'type' => 'varchar',
		 'size' => 255,
		 'null' => false,
	)
);
$columns[] = array(
	'table_name' => '{db_prefix}log_online',
	'if_exists' => 'ignore',
	'error' => 'fatal',
	'parameters' => array(),
	'column_info' => array(
		 'name' => 'cc',
		 'auto' => false,
		 'type' => 'char',
		 'size' => 2,
		 'null' => false,
	)
);

// create all the geoIP tables
foreach ($tables as $table)
	$smcFunc['db_create_table']($table['table_name'], $table['columns'], $table['indexes'], $table['parameters'], $table['if_exists'], $table['error']);

// Add the new row to scheduled task
foreach ($rows as $row)
	$smcFunc['db_insert']($row['method'], $row['table_name'], $row['columns'], $row['data'], $row['keys']);

// Add the new cols to the online log
foreach ($columns as $column)
	$smcFunc['db_add_column']($column['table_name'], $column['column_info'], $column['parameters'], $column['if_exists'], $column['error']);

// load in the country codes table csv file
$filename = $sourcedir . '/geoIP/GeoLiteCity-CountryCodes.csv';
importCsv($filename, 'geoip_countries',	array('cc' => 'string', 'cn' => 'string'));

// load in the region code table csv file
$filename = $sourcedir . '/geoIP/GeoLiteCity-RegionCodes.csv';
importCsv($filename, 'geoip_regions', array('cc' => 'string', 'rc' => 'string', 'rn' => 'string'));

// Update the mod settings if applicable
foreach ($mod_settings as $new_setting => $new_value)
{
	if (!isset($modSettings[$new_setting]))
		updateSettings(array($new_setting => $new_value));
}

if (SMF == 'SSI')
   echo 'Congratulations! You have successfully installed this mod!';

function importCsv($filename, $tablename, $colnames)
{
	global $smcFunc;

	$chunk = 250;
	$count = 0;
	error_reporting(0);
	
	// read the geoip csv file and write it out to the database
	if (file_exists($filename) && is_readable($filename))
	{
		$handle = fopen($filename, "r");

		// read it line by line
		while (($data = fgetcsv($handle, 1000, ', ', '"')) !== false)
		{
			$dataline = array();
			foreach ($data as $value)
				$dataline[] = trim($value, '"');
			
			// build the insert chunks
			if ($count++ < $chunk)
				$insert_me[] = $dataline;
			else
			{
				// Write this chunk out to the database
				$insert_me[] = $dataline;
				$smcFunc['db_insert']('ignore',
					'{db_prefix}' . $tablename,
					$colnames,
					$insert_me,
					array(
					)
				);
			
				// Next loop
				$insert_me = array();
				$count = 0;
				
				// try to avoid a timeout
				if (function_exists('apache_reset_timeout'))
					apache_reset_timeout();
			}
		}
		// done reading the file, write out any stragglers we have
		if ($count > 0)
		{
			// finish this
			$smcFunc['db_insert']('ignore',
				'{db_prefix}' . $tablename,
				$colnames,
				$insert_me,
				array(
					'tablename' => $tablename
				)
			);
		}
	}
}