<?php

$opt_name_id = 'wh_reseller_id';
$opt_name_api = 'wh_reseller_api';
$opt_name_whm_hash = 'wh_whm_hash';
$opt_name_whm_servername = 'wh_whm_servername';
$opt_name_whm_username = 'wh_whm_username';   
$opt_name_whm_ip = 'wh_whm_ip';
$opt_name_whm_ip_address = 'wh_whm_ip_address';
$opt_name_whm_port = 'wh_whm_port';
$opt_name_whm_cp_port = 'wh_whm_cp_port';
$opt_name_hostingpage = 'wh_hostingpage';   
$opt_name_addonspage = 'wh_addonspage';
$opt_name_domainspage = 'wh_domainspage';
$opt_name_shoppingpage = 'wh_shoppingpage';
$opt_name_nameserver01 = 'wh_nameserver01';
$opt_name_nameserver02 = 'wh_nameserver02';
$opt_name_nameserver03 = 'wh_nameserver03';
$opt_name_nameserver04 = 'wh_nameserver04';
$opt_name_checkbox = 'wh_checkbox';


	$data_field_id = 'wh_reseller_id';
	$data_field_api = 'wh_api_key';
	$data_field_whm_hash = 'wh_whm_hash';
	$data_field_whm_servername = 'wh_whm_servername';
	$data_field_whm_username = 'wh_whm_username';
	$data_field_whm_ip = 'wh_whm_ip';
	$data_field_whm_ip_address = 'wh_whm_ip_address';
	$data_field_whm_port = 'wh_whm_port';
	$data_field_whm_cp_port = 'wh_whm_cp_port';
	$data_field_hostingpage = 'wh_hostingpage';
	$data_field_addonspage = 'wh_addonspage';
	$data_field_domainspage = 'wh_domainspage';
	$data_field_shoppingpage = 'wh_shoppingpage';
	$data_field_nameserver01 = 'wh_nameserver01';
	$data_field_nameserver02 = 'wh_nameserver02';
	$data_field_nameserver03 = 'wh_nameserver03';
	$data_field_nameserver04 = 'wh_nameserver04';
	$data_field_checkbox = 'wh_checkbox';


    // Read in existing option value from database
        $opt_val_id = get_option( $opt_name_id );
      $opt_val_api = get_option( $opt_name_api );
    $opt_val_whm_hash = get_option( $opt_name_whm_hash );
  $opt_val_whm_servername = get_option( $opt_name_whm_servername );
  $opt_val_whm_username = get_option( $opt_name_whm_username );
$opt_val_whm_ip = get_option( $opt_name_whm_ip );
$opt_val_whm_ip_address = get_option( $opt_name_whm_ip_address );
$opt_val_whm_port = get_option( $opt_name_whm_port );
$opt_val_whm_cp_port = get_option( $opt_name_whm_cp_port );
$opt_val_hostingpage = get_option( $opt_name_hostingpage );
$opt_val_addonspage = get_option( $opt_name_addonspage );
$opt_val_domainspage = get_option( $opt_name_domainspage );
$opt_val_shoppingpage = get_option( $opt_name_shoppingpage );

$opt_val_nameserver01 = get_option( $opt_name_nameserver01 );
$opt_val_nameserver02 = get_option( $opt_name_nameserver02 );
$opt_val_nameserver03 = get_option( $opt_name_nameserver03 );
$opt_val_nameserver04 = get_option( $opt_name_nameserver04 );
$opt_val_checkbox = get_option( $opt_name_checkbox );


if ($opt_val_id) {$api_user_id = $opt_val_id;} 
	
if ($opt_val_api){$api_key = $opt_val_api;} 

if ($opt_val_whm_hash){$whm_hash_key = $opt_val_whm_hash;} 

if ($opt_val_whm_servername){$whm_servername = $opt_val_whm_servername;} 

if ($opt_val_whm_username){$whm_username = $opt_val_whm_username;} 

if ($opt_val_whm_ip){$whm_ip = $opt_val_whm_ip;} 

if ($opt_val_whm_ip_address){$whm_ip_address = $opt_val_whm_ip_address;} 

if ($opt_val_whm_port){$whm_port = $opt_val_whm_port;} 

if ($opt_val_whm_cp_port){$whm_cp_port = $opt_val_whm_cp_port;} 

if ($opt_val_hostingpage){$wh_hostingpage = $opt_val_hostingpage;} 

if ($opt_val_addonspage){$wh_addonspage = $opt_val_addonspage;} 

if ($opt_val_domainspage){$wh_domainspage = $opt_val_domainspage;} 
if ($opt_val_shoppingpage){$wh_shoppingpage = $opt_val_shoppingpage;} 

if ($opt_val_nameserver01){$wh_nameserver01 = $opt_val_nameserver01;}
if ($opt_val_nameserver02){$wh_nameserver02 = $opt_val_nameserver02;}
if ($opt_val_nameserver03){$wh_nameserver03 = $opt_val_nameserver03;}
if ($opt_val_nameserver04){$wh_nameserver04 = $opt_val_nameserver04;}

if ($opt_val_checkbox){$wh_checkbox = $opt_val_checkbox;}

