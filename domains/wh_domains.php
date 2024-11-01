<?php
/*

Version 1.5.4

*/

function check_domain_name($processdomain)
{
	global $wh_global, $processdomain, $domainname, $tld, $data_tld1, $numberofyears, $new_post_id, $new_or_transfer, $auth_code, 
	$fulldomainname, $price1,$display_add_to_cart_button, $error;
	$lang = '';$newprice=false;
	$check_domain = new lang($lang);
	$fulldomainname = false; $domaincheck = false;$wh_domainname = false;
	$display_add_to_cart_button = false;
	$error = false;
	$path=false;
	$status = false;
	$domainstatus = false;

if (isset($_POST['check']) && isset($_POST['domain']) && isset($_POST['tld']))
	{
		
		$retrieved_nonce = $_REQUEST['_wpnonce'];
	if (!wp_verify_nonce($retrieved_nonce, 'wh_domain_form' ) ) die( htmlentities ($check_domain->security_token, ENT_COMPAT,'ISO-8859-1', true ) );
		processdomain:
		$domainname = sanitize_text_field ($_POST['domain']);

			$tld = sanitize_text_field ($_POST['tld']);
			$temp_tld = htmlentities($tld,ENT_COMPAT,'ISO-8859-1', true);
			$tld = $temp_tld;
			$numberofyears = sanitize_text_field ($_POST['years']);	

						
							$tempurl = $domainname . $tld ;
							$tempurl = "https://" . filter_var($tempurl, FILTER_SANITIZE_URL);
								if (filter_var($tempurl, FILTER_VALIDATE_URL) == false)
								
						{
							$domaincheckmessage = $domainname . ' ' . $check_domain->search_domain_name_error_not_valid_url; $error = true;
							echo $domaincheckmessage . "<br>";
							echo '<a href="' . esc_attr(get_home_url()) . esc_attr($wh_global["admin"]["wh_domainsformpage"]) . '"> Continue </a>';
							return;
							
						}
									
									$fulldomainname = $domainname . $tld;
									$tld = substr($tld, 1);
									domain_checker($processdomain);
									
									
									if(isset($processdomain))
									{
									process_domain_name($domainstatus,$processdomain);
									}
									else{$error = "cannot process domain name please try again later";echo $error;}
						// ********* if there is an error with domain checking stop domain product being created ***********
									if ($error == false)
									{
									wh_create_domain_product($new_post_id);
									
									}
									else
									{
									
									$lang = '';
									$reg_domain = new lang($lang);

									$domain_page = $wh_global['admin']['wh_domainspage'];

									$siteurl = get_home_url();
									
									?>
	<form action="<?php echo esc_attr ($siteurl) . esc_attr ($domain_page);?>" method="post">
	<?php wp_nonce_field('wh_domain_form'); ?>
	<table>
	<thead>
	<tr>
	<th><?php echo htmlentities ($reg_domain->search_domain_names, ENT_COMPAT,'ISO-8859-1', true); ?></th>
	</tr>
	<tr>
	<th><input name="domain" type="text" pattern="[a-z0-9 -]+" value=""/></th>
	<th><select name="tld"><?php $number_of_tld = get_option( 'tlds');$count = 0;?>
	<option><?php echo htmlentities ($reg_domain->select_tld, ENT_COMPAT,'ISO-8859-1', true); ?></option><?php
			do
			{
				$count++;
				$s = get_option( 'wh_tld' . $count);
				?><option><?php echo esc_html($s);?></option><?php
					} while ($count < $number_of_tld);
				?>
			</select>
	</th>
	<th>

	<?php
	?>
	<select name="years">
	<option value ="0"><?php echo htmlentities($reg_domain->number_of_years, ENT_COMPAT,'ISO-8859-1', true); ?></option>
	<option value ="1"> <?php echo $reg_domain->_1year; ?></option>
	<option value ="2"><?php echo $reg_domain->_2years; ?></option>
	<option value ="3"><?php echo $reg_domain->_3years; ?></option>
	<option value ="4"><?php echo $reg_domain->_4years; ?></option>
	<option value ="5"><?php echo $reg_domain->_5years; ?></option>
	</select>

	</th><th>
	<input name="check" type="submit" value="<?php echo htmlentities ($reg_domain->check, ENT_COMPAT,'ISO-8859-1', true); ?> "/>
	</th>
	</tr>
	</thead>
	</table>
	</form>
	<?php
									}
									
		if($display_add_to_cart_button == true)
		{
			
			
		?><div class="wh_button"><a href="<?php echo esc_html ($path) . '?add-to-cart=' . $new_post_id ; ?>"><?php echo htmlentities($check_domain->add_to_cart, ENT_COMPAT,'ISO-8859-1', true); ?> </a></div>
<?php	
		}
									
									
	}
	
	
if (isset($_POST['transfercheck']) && isset($_POST['domain']))
	{
		
		$retrieved_nonce = $_REQUEST['_wpnonce'];
		if (!wp_verify_nonce($retrieved_nonce, 'wh_transfer_form' ) ) die( htmlentities ($check_domain->security_token, ENT_COMPAT,'ISO-8859-1', true ) );
		$auth_code = sanitize_text_field ($_POST['authcode']);
		$domainname = sanitize_text_field ($_POST['domain']);	
		$numberofyears = sanitize_text_field ($_POST['years']);	
		if($numberofyears == 0)
		{
			$numberofyears = 1;
		}
		$tempurl = $domainname ;
		$tempurl = "https://" . filter_var($tempurl, FILTER_SANITIZE_URL);
								if (filter_var($tempurl, FILTER_VALIDATE_URL) == false)
								
						{
							$domaincheckmessage = $domainname . ' ' . $check_domain->search_domain_name_error_not_valid_url; $error = true;
							echo $domaincheckmessage . "<br>";
							echo '<a href="' . esc_attr(get_home_url()) . esc_attr($wh_global["admin"]["wh_domainsformpage"]) . '"> Continue </a>';
							return;
							
						}
						
						$fulldomainname = $domainname;
						
						$domainname = strstr($fulldomainname, '.', true); // As of PHP 5.3.0
							echo $domainname . "<br>";
							
							$tld = strstr($fulldomainname, '.');
							echo $tld;
							$tld = substr($tld, 1);
							
							domain_checker($processdomain);
									
									
												
						
						if(isset($processdomain))
									{
										$new_or_transfer = "transfer";
									process_domain_name($domainstatus,$processdomain);
									}
									else{$error = "cannot process domain name please try again later";echo $error;}
						// ********* if there is an error with domain checking stop domain product being created ***********
									if ($error == false)
									{
									wh_create_domain_product($new_post_id);
									
									}
									if($display_add_to_cart_button == true)
		{
			
			
		?><div class="wh_button"><a href="<?php echo esc_html ($path) . '?add-to-cart=' . $new_post_id ; ?>"><?php echo htmlentities($check_domain->add_to_cart, ENT_COMPAT,'ISO-8859-1', true); ?> </a></div>
<?php	
		}
	}
	
	
	
	
	
	
	
}
add_shortcode('check_domain_name','check_domain_name');

function wh_create_domain_product($new_post_id)
{
	global $wh_global, $fulldomainname, $wpdb, $new_post_id, $years ,$price1, $tld, $numberofyears, $new_or_transfer, $auth_code;

	$domain_id = false;$price = false;$wh_nameserver01 = false;$wh_nameserver02 = false;$wh_nameserver03 = false;$wh_nameserver04 = false;

	$domain_id = $wpdb->get_var( "SELECT ID FROM $wpdb->posts WHERE post_title = '" . $fulldomainname . "'" );

	if ($domain_id == false)
	{
	$user_ID = '';
	$new_post = array(
	'post_id' => '',
	'post_title' => $fulldomainname,
	'post_content' => 'Domain Name',
	'post_status' => 'publish',
	'post_date' => date('Y-m-d H:i:s'),
	'post_author' => $user_ID,
	'post_type' => 'product',
	'post_category' => array(0)
	);
	$post_id = wp_insert_post($new_post);
	$new_post_id = $post_id;
	$imgurl = site_url();
	if(isset($wh_global["admin"]["wh_nameserver01"] )){$wh_nameserver01 = $wh_global["admin"]["wh_nameserver01"];}
	if(isset($wh_global["admin"]["wh_nameserver02"] )){$wh_nameserver02 = $wh_global["admin"]["wh_nameserver02"];}
	if(isset($wh_global["admin"]["wh_nameserver03"] )){$wh_nameserver03 = $wh_global["admin"]["wh_nameserver03"];}
	if(isset($wh_global["admin"]["wh_nameserver04"] )){$wh_nameserver04 = $wh_global["admin"]["wh_nameserver04"];}
	add_post_meta( $new_post_id, 'nameserver01', $wh_nameserver01);
	add_post_meta( $new_post_id, 'nameserver02', $wh_nameserver02);
	add_post_meta( $new_post_id, 'nameserver03', $wh_nameserver03);
	add_post_meta( $new_post_id, 'nameserver04', $wh_nameserver04);
	add_post_meta( $new_post_id, 'domaintype', '1' );
	add_post_meta( $new_post_id, 'customer-id', '' );
	add_post_meta( $new_post_id, 'domain-registered', 'no' );
	add_post_meta( $new_post_id, 'domain-registered-date', '' );
	add_post_meta( $new_post_id, 'domainyears', $numberofyears);
	add_post_meta( $new_post_id, '_auth_code', $auth_code);
	add_post_meta( $new_post_id, 'package', 'domain' );
	if(isset($new_or_transfer))
	{
	add_post_meta( $new_post_id, 'new-or-transfer', $new_or_transfer);
	}
	else
	{
	add_post_meta( $new_post_id, 'new-or-transfer', '');	
	}
	add_post_meta( $new_post_id, 'auth-code', '');
	$tld_temp = '.' . $tld; $tld = $tld_temp;
	
	
	add_post_meta( $new_post_id, 'domainexpiry', '' );
	wp_set_object_terms($new_post_id, 'simple', 'product_type');
	wp_set_object_terms( $new_post_id, 'Domains', 'product_cat' );
	update_post_meta( $new_post_id, '_visibility', 'Hidden' );
	update_post_meta( $new_post_id, '_stock_status', 'instock');
	update_post_meta( $new_post_id, 'total_sales', '0');
	update_post_meta( $new_post_id, '_downloadable', 'no');
	update_post_meta( $new_post_id, '_virtual', 'yes');
	update_post_meta( $new_post_id, '_regular_price', $price1 );
	update_post_meta( $new_post_id, '_sale_price', "" );
	update_post_meta( $new_post_id, '_purchase_note', '' );
	update_post_meta( $new_post_id, '_featured', "no" );
	update_post_meta( $new_post_id, '_weight', "" );
	update_post_meta( $new_post_id, '_length', "" );
	update_post_meta( $new_post_id, '_width', "" );
	update_post_meta( $new_post_id, '_height', "" );
	update_post_meta( $new_post_id, '_sku', "");
	update_post_meta( $new_post_id, '_product_attributes', array());
	update_post_meta( $new_post_id, '_sale_price_dates_from', "" );
	update_post_meta( $new_post_id, '_sale_price_dates_to', "" );
	update_post_meta( $new_post_id, '_price', $price1 );
	update_post_meta( $new_post_id, '_sold_individually', "yes" );
	update_post_meta( $new_post_id, '_manage_stock', "no" );
	update_post_meta( $new_post_id, '_backorders', "no" );
	update_post_meta( $new_post_id, '_stock', "1" );
	update_post_meta( $new_post_id, '_type' , "domain");
	update_post_meta( $new_post_id, 'domaintld', $tld );
	update_post_meta( $new_post_id, '_invoice_type' , "1");
	update_post_meta( $new_post_id, 'domain-registered' , "no");
	} // end of if ($domain_id == false)
	else {$new_post_id = $domain_id;}

/*
		$wh_domain_data = get_option("wh_domain_data",true);
		$wh_domain_data['domain-name']=$fulldomainname;
		$wh_domain_data[$fulldomainname]['post_date'] = date('Y-m-d H:i:s');
		$wh_domain_data[$fulldomainname]['nameserver01']= $wh_nameserver01;
		$wh_domain_data[$fulldomainname]['nameserver02']= $wh_nameserver02;
		$wh_domain_data[$fulldomainname]['nameserver03']= $wh_nameserver03;
		$wh_domain_data[$fulldomainname]['nameserver04']= $wh_nameserver04;
		$wh_domain_data[$fulldomainname]['domainyears']= $numberofyears;
		$wh_domain_data[$fulldomainname]['price']= $price1;
		$wh_domain_data[$fulldomainname]['domaintld']= $tld;
		
		
		
		
		
		
		update_option("wh_domain_data",$wh_domain_data);
	//	wh_hide_category( $terms, $taxonomies, $args ,$new_post_id);
	//	add_filter( 'get_terms', 'wh_hide_category', 10, 4 );
*/		
	return $new_post_id;
}

add_action('wh_create_domain_product','wh_create_domain_product');

function domain_checker($processdomain)
{
	global $wh_global, $domainname, $tld, $processdomain;
	$rc_url=false;$api_user_id=false;$api_key=false;
	$view_data = get_option("view_data",true);
		if(isset($wh_global['admin']['resellerclub']['wh_checkbox']))
		{
			$rc_url = $wh_global['admin']['resellerclub']['wh_checkbox'];
		}
		if ($rc_url == "yes"){$rc_url = "domaincheck.";}
		
			if(isset($wh_global['admin']['resellerclub']['api_user_id']))
			{
				$api_user_id = $wh_global['admin']['resellerclub']['api_user_id'];
			}

				if(isset($wh_global['admin']['resellerclub']['wh_reseller_api_key']))
				{
				$api_key = $wh_global['admin']['resellerclub']['wh_reseller_api_key'];
				}

			$url1 = 'https://' . $rc_url . 'httpapi.com/api/domains/available.json?';
			$str = 'auth-userid=' . $api_user_id . '&api-key=' . $api_key . '&domain-name=' . $domainname . '&tlds=' . $tld ;
			$url = $url1 . $str;
			$data = "";
			$view_data['domain_checker']['url']=$url;
			$data = CallDomainAPI('GET', $url, $data);
			$processdomain = json_decode($data, TRUE);
			$view_data['domain_checker']['result']=$processdomain;
			update_option("view_data",$view_data);
			return $processdomain;
} // end of function


function CallDomainAPI($method, $url, $data = false)
{
	
	$curl = curl_init();
	switch ($method)
	{
	case "POST":
	curl_setopt($curl, CURLOPT_POST, 1);
	if ($data)
	curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
	break;
	case "PUT":
	curl_setopt($curl, CURLOPT_PUT, 1);
	break;
	default:
	if ($data)
	$url = sprintf("%s?%s", $url, http_build_query($data));
	}
	curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	curl_setopt($curl, CURLOPT_USERPWD, "username:password");
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	return curl_exec($curl);
}

function wh_get_number_of_tld($data_tld1)
{
	global $data_tld1;
	$number_of_tld = get_option( 'tlds');
	$count = '0';
	do
	{
	$count++;
	$s = get_option( 'wh_tld' . $count) ;
	$data_tld1[$s] = get_option( 'wh_tld' . $count . 'price');
	} while ($count < $number_of_tld );
	return $data_tld1;
}
add_action('wh_get_number_of_tld','wh_get_number_of_tld');




