<?php

// Version: 1.5.4


	// create a scheduled event (if it does not exist already)
		function wh_cronstarter_activation() 
		{
			if( !wp_next_scheduled( 'wh_check_domains' ) ) 
			{  
				wp_schedule_event( time(), 'daily', 'wh_check_domains' );  
			}
		}
			// and make sure it's called whenever WordPress loads
			add_action('wp', 'wh_cronstarter_activation');

		function wh_cronstarter_deactivate() 
		{	
			// find out when the last event was scheduled
			$timestamp = wp_next_scheduled ('wh_check_domains');
			// unschedule previous event if any
			wp_unschedule_event ($timestamp, 'wh_check_domains');
		} 
			register_deactivation_hook (__FILE__, 'wh_cronstarter_deactivate');
			// here's the function we'd like to call with our cron job
	function wh_check_domains_function() 
	{
	clear_unused_domain_names();
	
	}
		// hook that function onto our scheduled event:
		add_action ('wh_check_domains', 'wh_check_domains_function'); 




function woo_get_orders($old_status)

{
	global $order_id, $view_data, $customer_id, $api_user_id, $api_key, $customer_account_id, $contact_type, $admin_id, $product_id,$order,
	$woocommerce, $x, $ordernumber, $wh_countryArray;
	$newdomain = false;
	$domain_renew = false;
	$domainresult = false;
	$json = false;
	$error = false;
	$process = false;
	$invoice_type = false;
	
	$order = wc_get_order( $old_status );
	


		update_option("Resellerclub_messages","");
		
	update_option("woo_get_orders_old_status",$old_status);	
	update_option("woo_get_orders_order",$order);
	$order_id = $order->get_id();
	$status = $order->get_status();
	$view_data = array();
	$view_data['order_status']=$status;
	update_option("view_data",$view_data);
	
	
	
	
	$option_exists = (get_post_meta($order_id,'_invoice_type_' . $order_id, null) !== null);
				if ($option_exists) {
					$invoice_type = get_post_meta($order_id,'_invoice_type_' . $order_id,true);
					} else {
						add_post_meta($order_id,'_invoice_type_' . $order_id,"no");
							}
	
	
	
	
	$invoice_type = get_post_meta($order_id,'_invoice_type_' . $order_id,true);
	
	$wh_order_data = array();
	
	$option_exists = (get_post_meta($order_id,'_order_' . $order_id, null) !== null);

				if ($option_exists) {
					
					$wh_order_data = get_post_meta($order_id,'_order_' . $order_id,true);
					
					
					} else {
						
						add_post_meta($order_id,'_order_' . $order_id,$wh_order_data);
						
					
						
							}
	
	
	
		if(($order_id) && ($status == "completed"))
		{
			$order = wc_get_order( $order_id );
			$order_id = $order->get_id();
			$paid = $order->get_status();
			$orderdate= $order->get_date_created();
			$customer_id = $order->get_customer_id();

			$user_id  = $customer_id;
			$accountemail = $order->get_billing_email();
			
			
								$view_data["customer_id"] = $customer_id; 
								$api_user_id = get_option( "wh_reseller_id",true);
								$api_key = get_option( "wh_reseller_api",true);
								$view_data["api_user_id"] = $api_user_id; 
								$view_data["api_key"] = $api_key;
								$view_data[$customer_id]["order_id"] = $order_id;								
								$view_data[$customer_id]["order_status"] = $status;
								$view_data[$customer_id]["invoice_type"] = $invoice_type;
								$view_data[$customer_id]["orderdate"] = $orderdate;
								
								$view_data[$customer_id]["customer_email"] = $order->get_billing_email();
								$view_data[$customer_id]["customer_first_name"] = $order->get_billing_first_name();
								$view_data[$customer_id]["customer_last_name"] = $order->get_billing_last_name();
								$view_data[$customer_id]["customer_name"] = $order->get_billing_first_name() . " " . $order->get_billing_last_name();
								$view_data[$customer_id]["customer_company"] = $order->get_billing_company();
								$view_data[$customer_id]["customer_address1"] = $order->get_billing_address_1();
								$view_data[$customer_id]["customer_address2"] = $order->get_billing_address_2();
								$view_data[$customer_id]["customer_city"] = $order->get_billing_city();
								$view_data[$customer_id]["customer_state"] = $order->get_billing_state();
								$view_data[$customer_id]["customer_postcode"] = $order->get_billing_postcode();
								$view_data[$customer_id]["customer_country"] = $order->get_billing_country();
								$phone = $order->get_billing_phone();
								$phone = str_replace(" ","",$phone);
								$view_data[$customer_id]["customer_phone"] = $phone;
								$country = get_user_meta( $customer_id, 'billing_country', true );
					
						
						
			// ********************* get the dialing code for the customers country here **********************************
						
						foreach ($wh_countryArray as $key => $value)
						{
							
							if($key == $country)
							{
							$phone_cc = $value['code'];
							}								
						
						}
						
							$view_data[$customer_id]['phone_cc']=$phone_cc;
							update_user_meta($customer_id,'phone_cc',$phone_cc);
								
								
								update_option("view_data",$view_data);
			
			
														
			
			$x=0;
			foreach ( $order->get_items() as $item_id => $item )
			{
				$newdomain = $item->get_meta('custom_option_text');
				if($newdomain ==""){$newdomain = $item->get_meta('custom_option');}
				
				$view_data[$customer_id]['x'] = $x;
				
				update_option('view_data',$view_data);
				
				$product = apply_filters( 'woocommerce_order_item_product', $item->get_product(), $item );
				$product_id = $product->get_id();

				$parent_id = $product->get_parent_id();
				$view_data[$customer_id][$x]["parent_id"] = $parent_id;
				$product_name =$product->get_name();
				
				if($newdomain ==""){$newdomain = $product_name;}
				$view_data[$customer_id][$x]['newdomain']=$newdomain;
				
					if (isset($parent_id) && ($parent_id >0))
					{
						$producttype = get_post_meta( $parent_id, 'package',true);
					}
						else
						{
							$producttype = get_post_meta( $product_id, 'package',true);
						}
			$view_data[$customer_id][$x][$product_id]['producttype']=$producttype;	
			
				$view_data[$customer_id][$x]["product_id"] = $product_id;
			
						update_option('view_data',$view_data);					

				if (($paid == 'completed') && ($process == false))
				{
					
						if (($producttype == "domain") || ($producttype == "domain-renew"))
						{
							$product_name = $newdomain;
							if(isset($view_data[$customer_id][$x]['invoice_type']))
							{
							$invoice_type = $view_data[$customer_id][$x]['invoice_type'];
							}
							$domain_renew = $wh_order_data['_' . $product_id . '_package'];				 // need to check this 05-05-2020
							update_post_meta( $order_id, '_domain_name',$newdomain);
							$tld = get_post_meta( $product_id, 'domaintld',true);
							$view_data[$customer_id][$x]['tld'] = $tld;
							

							
						}
							$view_data[$customer_id][$x]["invoice_type"] = $invoice_type;
							$view_data[$customer_id][$x]["domain_renew"] = $domain_renew;
							update_option("view_data",$view_data);
					
					
					if ((empty($invoice_type)) || ( $domain_renew == 'domain-renew'))
					{
						
						
								if (isset($producttype) && ($producttype == "hosting")) // && ($newdomain <> false))
								{
									if (isset($parent_id) && ($parent_id >0)){$product_id = $parent_id;}
									
									$view_data[$customer_id][$x]['WHM']['newdomain'] = $newdomain;
									update_option("view_data",$view_data);
								
									WHM_create_account($json,$error);
									
										
									
									
								
									/*		
									
									$admin_email = get_option('admin_email');

									if($error)
									{
									mail($admin_email,'whm' . htmlentities($woo_orders->email_error, ENT_COMPAT,'ISO-8859-1', true) ,htmlentities($woo_orders->email_error, ENT_COMPAT,'ISO-8859-1', true) . ': ' . $error, $headers);
									}

									if($json)
									{
										$reason = $json->{'metadata'}->{'reason'};
										mail($admin_email,'whm','message: ' . $reason, $headers);
									}
									*/
									
									$wh_domainname = $wh_order_data['_domain_field'];
									

								}

									
							
							
							
							
								if (($producttype == "domain") || ($producttype == "domain-renew"))
								{
							
							
									$processed = get_post_meta($order_id,'_' . $product_id . ' ' . $product_name,true);
									if ($processed <>"processed")
									{
							
										$domainreg = get_post_meta( $product_id, 'domain-registered',true);
						
										$new_or_transfer = get_post_meta( $product_id, 'new-or-transfer',true); // for transfer
										$auth_code = get_post_meta( $product_id, 'auth-code',true); // for transfer
										$view_data[$customer_id][$x]["domainreg"] = $domainreg;
										update_option("view_data",$view_data);
							
										if(($domainreg == 'no') || ($producttype == "domain-renew"))
										{
							
							
											woo_resellerclub_signup();

								
											if (!empty($customer_account_id))
												{
													woo_get_resellerclub_customers_id($contact_type,$admin_id,$customer_account_id);
												}

										
											if (!empty($customer_account_id))
												{
												woo_get_resellerclub_customers_info($customer_account_id,$product_id, $contact_type);
												}
										
										
											if (!empty($customer_account_id))
												{
													woo_get_resellerclub_customers_id($contact_type,$admin_id,$customer_account_id);
												}
									
											if (!empty($contact_type))
												{
													$ordernumber = false;
													woo_register_domain($admin_id, $product_id, $ordernumber, $customer_account_id, $contact_type);
										
												}

													if(!empty($ordernumber))
													{
														wh_update_domains_after_order_status($order_id);
														update_post_meta($order_id,'_invoice_type_' . $order_id,"yes");
													}
						
						
						
										} // end of if(($domainreg == 'no') || ($producttype == "domain-renew"))
									} // end of if ($processed <>"processed")

						
				
				
				

								} // end of if (($producttype) && ($producttype == "domain"))
					
					}// end of if ($invoice_type == false)

			}// end of if (isset($paid) && ($paid == 'wc-completed')

				
			$x++;
		} // end of foreach ( $order->get_items() as $item_id => $item )foreach 

	}	// end of if(($order_id) && ($status == "completed"))

		
} // end of function

add_action('woocommerce_order_status_completed','woo_get_orders',10,8);


function wh_update_domains_after_order_status($order_id)

{
	global $x,$order_id,$product_name,$data;
	$product_id=false;$domainname=false;
	
				$view_data = get_option("view_data",true);
				$customer_id = $view_data['customer_id'];
				if(isset($view_data[$customer_id][$x]["domain-reg-domainname"]))
				{
				$domainname = $view_data[$customer_id][$x]["domain-reg-domainname"];
				}
				if(isset($view_data[$customer_id][$x]['product_id']))
				{
				$product_id = $view_data[$customer_id][$x]['product_id'];
				}
				$producttype = get_post_meta( $product_id, 'package',true);
				$new_or_transfer = get_post_meta( $product_id, 'new-or-transfer',true);				
				$product_name = $domainname;			

						if (isset($producttype) && ($producttype == "domain") || ($producttype == "domain-renew"))
				{
					wh_get_domain_order_details($product_name, $data);
					$result = json_decode($data, TRUE);
					$view_data[$customer_id][$product_name]['result']=$result;
					update_option('view_data',$view_data);
					
					update_post_meta($order_id, '_' . $product_name . ' result', $result);
					$endtime = $result["endtime"];
					if($new_or_transfer == "transfer"){$endtime = $result['executioninfoparams']['registryEndTime'];}
					$domainreg = $result['currentstatus'];
					$customerid = $result['customerid'];
					$orderid = $result['orderid'];
					if(isset($result ['actiontypedesc']))
					{
					$actiontypedesc = $result ['actiontypedesc'];
					$actionstatusdesc = $result['actionstatusdesc'];
					}
					if(isset($endtime) && ($endtime >1))
						{
							if (ctype_digit($endtime))
							{
							$date = date("F j, Y", $endtime);
							$expirydate = $date;
							}
							update_post_meta($order_id,'_' . $product_name . '_domain-registered',$domainreg);
							update_post_meta($order_id,'_' . $product_name . '_domainexpiry',$expirydate);
							update_post_meta($order_id,'_' . $product_name . '_actiontypedesc',$actiontypedesc);
							update_post_meta($order_id,'_' . $product_name . '_domain_details',$result);
							/*
							update_post_meta($order_id,'_' . 'completed_order_details',$view_data);
							$view_data = array();
							update_option("view_data",$view_data);
							*/
							update_post_meta($order_id,'_domain_order_status','0');
							update_post_meta( $product_id, 'domain-registered', $domainreg);
							update_post_meta( $product_id, 'domain-registered-date', date("F j, Y"));
							update_post_meta( $product_id, 'domainexpiry', $expirydate );
							update_post_meta( $product_id, 'in_cart', '' );
							if($new_or_transfer == "transfer")
							{
							update_post_meta( $product_id, 'transfer message', $actionstatusdesc );
							}
							update_post_meta( $product_id, 'customer_id', $customerid );
							$query = array(
							'ID' => $product_id,
							'post_status' => 'private',
								);
								wp_update_post( $query, true );
						}

							else
							{
								// domain name transfer info
								update_post_meta($order_id,'_' . $product_name . '_domain-registered',$domainreg);
								update_post_meta($order_id,'_' . $product_name . '_actiontypedesc',$actiontypedesc);
								update_post_meta($order_id,'_' . $product_name . '_domain_details',$result);
								update_post_meta($order_id,'_' . $product_name . '_domainexpiry','Pending');

							}
				}
	
return;	
}

add_shortcode("wh_update_domains_after_order_status","wh_update_domains_after_order_status");



function wh_get_domain_order_details($product_name, $data)
{
	global $product_id,$product_name,$data,$woocommerce,$order_id,$url,$str,$method,$x;
	
					$api_user_id = get_option( "wh_reseller_id",true);
					$api_key = get_option( "wh_reseller_api",true);
					$rc_url = get_option( "wh_checkbox",true);
					if ($rc_url == "yes"){$rc_url = "test.";}
					$view_data = get_option("view_data",true);
					if (empty($view_data))
					{
					$view_data = get_post_meta($order_id,'_' . 'completed_order_details',true);
					}
					$customer_id = $view_data['customer_id'];
					if(isset($view_data[$customer_id][$x]["domain-reg-domainname"]))
					{
					$product_name = $view_data[$customer_id][$x]["domain-reg-domainname"];
					}
					
				
	
	$url = 'https://' . $rc_url . 'httpapi.com/api/domains/details-by-name.json?auth-userid=' . $api_user_id . '&api-key=' . $api_key . '&domain-name=' . $product_name . '&options=All' ; // OrderDetails';

	$data = '';
	$data = CallDomainAPI('GET', $url, $data);
	return	$data;

}

add_shortcode('wh_get_domain_order_details','wh_get_domain_order_details');





function decryptIt($result, $decrypt_password) 
{
	global $decrypt_password,$result;
	
	$ciphertext = $result['ciphertext'];
	$cipher = $result['cipher'];
	$iv = $result['iv'];
	$tag = $result['tag'];
	$key = $result['key'];
	$decrypt_password = openssl_decrypt($ciphertext, $cipher, $key, $options=0, $iv, $tag);
	return $decrypt_password;
		
		

}

function encryptIt($encrypt_password, $result) 
{
	global $result, $encrypt_password;
	$cipher = "aes-128-gcm";
	$key = random_bytes(8);
		if (in_array($cipher, openssl_get_cipher_methods()))
		{
		$ivlen = openssl_cipher_iv_length($cipher);
		$iv = openssl_random_pseudo_bytes($ivlen);
		$ciphertext = openssl_encrypt($encrypt_password, $cipher, $key, $options=0, $iv, $tag);
		
		$result = array();
		$result['cipher'] = $cipher;
		$result['iv'] = $iv;
		$result['tag'] = $tag;
		$result['ciphertext'] = $ciphertext;
		$result['key'] = $key;
		
		return $result;
		}

}
function whm_username($username)
{
	
	$username = str_replace(".","",$username);
	$username = str_replace("-","",$username);
	$one_letter = makeuserName(1);
	$username = $one_letter . $username;
	$user_len = strlen($username);
	
	if($user_len < 8 )
	{
		$needed_length = 8 - $user_len;
		$newusername = makeuserName($needed_length);
		$username .= $newusername;
	}	
	
	$username = substr($username, 0, 8);
	return $username;
}


function makeuserName($needed_length) { 
    $characters = 'abcdefghijklmnopqrstuvwxyz'; 
    $randomString = ''; 
  
    for ($i = 0; $i < $needed_length; $i++) { 
        $index = rand(0, strlen($characters) - 1); 
        $randomString .= $characters[$index]; 
    } 
  
    return $randomString; 
} 



function wh_display_email_order_meta( $order, $sent_to_admin, $plain_text)

{
	global $decrypt_password, $result;
	$customer_id = ""; $newdomain = ""; $message = ""; $x=0; $decrypt_password = "";
	$lang='';
	$email_lang = new lang($lang);
	
	

	
$order_id = $order->get_id();

$view_data = get_option("view_data",true);

if(isset($view_data['customer_id']))
{
	$customer_id = $view_data['customer_id'];
}
else
{
$view_data = get_post_meta($order_id,'_' . 'completed_order_details',true);	
$customer_id = $view_data['customer_id'];
}


			$blog = get_bloginfo( $show = 'name');
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
			$headers .= htmlentities($email_lang->email_from, ENT_COMPAT,'ISO-8859-1', true) . ': ' . $blog . "\r\n";
			
			
			foreach ( $order->get_items() as $item_id => $item )
			{
				
				$product = apply_filters( 'woocommerce_order_item_product', $item->get_product(), $item );
				$product_id = $product->get_id();
				$parent_id = $product->get_parent_id();
				$product_name = $product->get_name();
				if($newdomain ==""){$newdomain = $product_name;}
				
				if (isset($parent_id) && ($parent_id >0))
					{
						$producttype = get_post_meta( $parent_id, 'package',true);
					}
						else
						{
							$producttype = get_post_meta( $product_id, 'package',true);
						}
				
				if (isset($producttype) && ($producttype == "hosting"))
				{
					$newdomain = $item->get_meta('custom_option_text');
					if($newdomain ==""){$newdomain = $item->get_meta('custom_option');}
					$customer_email = $view_data[$customer_id]["customer_email"];
					$first_name = $view_data[$customer_id]["customer_first_name"];
					$newdomain = $view_data[$customer_id][$x]['WHM']['newdomain'];
					
					$password = get_post_meta($order_id, '_WHM_' . $newdomain . 'pass',true );
					if ($password)
					{
					$message .= '<hr><h5>' . htmlentities($email_lang->email_hosting, ENT_COMPAT,'ISO-8859-1', true) . '</h5>';
					$message .= htmlentities($email_lang->email_hi, ENT_COMPAT,'ISO-8859-1', true) . ' ' . $first_name . ' ' . htmlentities($email_lang->email_your_password, ENT_COMPAT,'ISO-8859-1', true) . ' ' . $newdomain . ' ' . htmlentities($email_lang->email_is, ENT_COMPAT,'ISO-8859-1', true) . ' ' . $password .'<br>';
					echo $message;
					}
									
				}
				if (isset($producttype) && ($producttype == "domain"))
				{
				}
			$x++;
			}
					$customer_account_id = get_user_meta( $customer_id, 'resellerclub_id', true );
					$password = get_user_meta($customer_id, 'resellerclub_password', true);
						if ($password == "yes")
						{
							$pathInPieces = explode('/', $_SERVER['DOCUMENT_ROOT']);
							$path = "/" . $pathInPieces[1] . "/" . $pathInPieces[2] . '/';
							$passfile = $path . 'wh_data/' . $customer_id . "-rc_pass.php";
							$wh_key = fopen($passfile, "r") ;
							$key = fread($wh_key, filesize($passfile));
							$key = base64_decode($key);
							
							$password = array();
							$password['key'] = $key;
							$ciphertext = get_user_meta($customer_id, 'resellerclub_password_ciphertext',true);
							$password['ciphertext'] = $ciphertext;
							$cipher = get_user_meta($customer_id, 'resellerclub_password_cipher',true);
							$password['cipher'] = $cipher;
							$iv = base64_decode(get_user_meta($customer_id, 'resellerclub_password_iv',true));
							
							$password['iv'] = $iv;
							$tag = base64_decode(get_user_meta($customer_id, 'resellerclub_password_tag',true));
							$password['tag'] = $tag;
							fclose($wh_key);
							
							$result = $password;
							decryptIt( $decrypt_password,$result );
							$password = $decrypt_password;
							echo '<h5>' . htmlentities($email_lang->email_resellerclub, ENT_COMPAT,'ISO-8859-1', true) . '</h5>';
							echo htmlentities($email_lang->email_your_password_resellerclub, ENT_COMPAT,'ISO-8859-1', true) . ' ' .	$customer_account_id . ' ' . htmlentities($email_lang->email_is, ENT_COMPAT,'ISO-8859-1', true) . ' ' . $decrypt_password . "<hr>";
						}

					
							update_post_meta($order_id,'_' . 'completed_order_details',$view_data);
							


}
add_action('woocommerce_email_customer_details', 'wh_display_email_order_meta',10,3 );

function wh_woocommerce_version_check($wooversion='2.5.0') {

global $woocommerce,$wooversion;

$wooversion = $woocommerce->version;

if ($wooversion >= '2.6.0') {return true;

} else

{

return false;

}

}




 function custom_pre_get_posts_query( $q ) {

    $tax_query = (array) $q->get( 'tax_query' );

    $tax_query[] = array(
           'taxonomy' => 'product_cat',
           'field' => 'slug',
           'terms' => array( 'domains' ), // Don't display products in the domains category on the shop page.
           'operator' => 'NOT IN'
    );


    $q->set( 'tax_query', $tax_query );

}
add_action( 'woocommerce_product_query', 'custom_pre_get_posts_query' );  



function wh_woocommerce_email_footer_text($get_option)

{

$get_option = get_bloginfo() . ' – Powered by WooCommerce and Web-Hosting for Wordpress';

	

	return $get_option;

	

}

add_filter('woocommerce_email_footer_text','wh_woocommerce_email_footer_text');





add_filter( 'woocommerce_get_country_locale', 'wh_change_locale_field_defaults');
 
function wh_change_locale_field_defaults($countries) {
	
	foreach ($countries as $key => $value)
	{
		if(isset($countries[$key]['state']['required']))
		{
			$countries[$key]['state']['required'] = true;
		}
		
	}
    return $countries;
}




