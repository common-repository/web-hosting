<?php
/*

Version 1.5.4

*/


function woo_register_domain($admin_id, $product_id, $ordernumber, $customer_account_id, $contact_type)
{
	
	

global $product_id, $new_or_transfer, $customer_id, $customer_account_id, $admin_id, $domainresult, $data, $contact_type, $x, $ordernumber;

	$str = '';
	$ch = '';
	$ordernumber = false;
	$result = '';
	$tld = '';

// *************************************** get customer data ********************************************

	
	






	
				$view_data = get_option("view_data",true);
				$customer_id = $view_data['customer_id'];
				$product_id = $view_data[$customer_id][$x]['product_id'];
				$tld_type = get_post_meta($product_id,'domaintld',true);
				
				$new_or_transfer = get_post_meta($product_id,'new-or-transfer',true);
				$years = get_post_meta( $product_id, 'domainyears',true);
				if ($years == '0'){$years = '1';}
				$view_data[$customer_id][$x]['product_id']['tld']=$tld_type;
				update_option('view_data',$view_data);
				
				$rc_url = get_option( "wh_checkbox",true);
				$wh_nameserver01 = get_option("wh_nameserver01",true);
				$wh_nameserver02 = get_option("wh_nameserver02",true);
					if ($rc_url == "yes"){
						$rc_url = "test.";
						
						$wh_nameserver01 = "dns3.parkpage.foundationapi.com";
						$wh_nameserver02 = "dns4.parkpage.foundationapi.com";
						}
					
					
					
				$api_user_id = get_option( "wh_reseller_id",true);
				$api_key = get_option( "wh_reseller_api",true);
				$customer_account_id = $view_data[$customer_id]['customer_account_id'];
				
				$temp = get_post_meta( $product_id, 'package', true );
				$domainname = $view_data[$customer_id][$x]['domainname'];
				

				// ******** most TLD use this url ***********
				
		$str = 'auth-userid=' . $api_user_id . '&api-key=' . $api_key . '&domain-name=' . $domainname . '&years=' . $years . '&ns=' . $wh_nameserver01 . '&ns=' . $wh_nameserver02 . '&customer-id=' . $customer_account_id . '&reg-contact-id=' . $admin_id . '&admin-contact-id=' . $admin_id . '&tech-contact-id=' . $admin_id . '&billing-contact-id=' . $admin_id . '&invoice-option=NoInvoice&protect-privacy=false&cedcontactid=' . $admin_id;
		
			// ********* these use different url's **********************	
				
				
		$uk = array('.uk', '.co.uk', '.me.uk', '.org.uk',);
		$at = array('.at', '.berlin', '.ca', '.nl', '.london',);
		$com = array('.com', '.biz', '.net',);
		$donut1 = array('.supplies', '.supply',);
		
		$uk_array = array_fill_keys($uk, 'auth-userid=' . $api_user_id . '&api-key=' . $api_key . '&domain-name=' . $domainname . '&years=' . $years . '&ns=' . $wh_nameserver01 . '&ns=' . $wh_nameserver02 . '&customer-id=' . $customer_account_id . '&reg-contact-id=' . $admin_id . '&admin-contact-id=-1&tech-contact-id=-1&billing-contact-id=-1&invoice-option=NoInvoice');
		$com_array = array_fill_keys($com, 'auth-userid=' . $api_user_id . '&api-key=' . $api_key . '&domain-name=' . $domainname . '&years=' . $years . '&ns=' . $wh_nameserver01 . '&ns=' . $wh_nameserver02 . '&customer-id=' . $customer_account_id . '&reg-contact-id=' . $admin_id . '&admin-contact-id=' . $admin_id . '&tech-contact-id=' . $admin_id . '&billing-contact-id=' . $admin_id . '&invoice-option=NoInvoice&protect-privacy=false&cedcontactid=' . $admin_id);
		$at_array = array_fill_keys($at, 'auth-userid=' . $api_user_id . '&api-key=' . $api_key . '&domain-name=' . $domainname . '&years=' . $years . '&ns=' . $wh_nameserver01 . '&ns=' . $wh_nameserver02 . '&customer-id=' . $customer_account_id . '&reg-contact-id=' . $admin_id . '&admin-contact-id=' . $admin_id . '&tech-contact-id=' . $admin_id . '&billing-contact-id=-1&invoice-option=NoInvoice&auto-renew=0&protect-privacy=false&cedcontactid=' . $admin_id);
		$donut1_array = array_fill_keys($donut1, 'auth-userid=' . $api_user_id . '&api-key=' . $api_key . '&domain-name=' . $domainname . '&years=' . $years . '&ns=' . $wh_nameserver01 . '&ns=' . $wh_nameserver02 . '&customer-id=' . $customer_account_id . '&reg-contact-id=' . $admin_id . '&admin-contact-id=' . $admin_id . '&tech-contact-id=' . $admin_id . '&billing-contact-id=' . $admin_id . '&invoice-option=NoInvoice&protect-privacy=false&cedcontactid=' . $admin_id);

		$domain_types = array(
				'uk'=>$uk_array,
				'com'=>$com_array,
				'at'=>$at_array,
				'donut1'=>$donut1_array,
				);		
				
				
				
				
				foreach ($domain_types as $key=>$value)
		{
			
			foreach ($value as $key=>$item)
			{
				if($key == $tld_type)
				{ 
					$str = $item;
					break;
				}
			}
		}
				
				
				
				
				
				
		

	
	$view_data[$customer_id][$x]["domain-reg-domaintld"] = $domaintld;
	$view_data[$customer_id][$x]["domain-reg-domainname"] = $domainname;
					update_option("view_data",$view_data);


			//// ****************************Register a domain or transfer with resellerclub  *********
			
			
			
			

	
	
	
					
					
	
		if ($new_or_transfer == 'transfer')
		{
			$url = 'https://' . $rc_url . 'httpapi.com/api/domains/transfer.json?';
			$domaintld = '-1';
			$auth_code = get_post_meta($product_id,'_auth_code',true);
			$str = "auth-userid=" . $api_user_id . "&api-key=" . $api_key . "&domain-name=" . $domainname . "&auth-code=" . $auth_code . "&ns=" . $wh_nameserver01 . "&ns=" . $wh_nameserver02 . "&customer-id=" . $customer_account_id . "&reg-contact-id=" . $admin_id  ."&admin-contact-id=" . $admin_id . "&tech-contact-id=" . $admin_id . "&billing-contact-id=" . $admin_id . "&invoice-option=NoInvoice";
		}

			else
			{
				$url = 'https://' . $rc_url . 'httpapi.com/api/domains/register.json?';
			}



				if ($temp == 'domain-renew')
				{
					
				$domainname = get_the_title( $product_id );
				
				
				wh_get_domain_order_details($product_name,$data); 
				$datajson = json_decode($data, TRUE);
				$ordernumber=$datajson["orderid"];
				$view_data[$customer_id][$x]["if_temp-domain-renew"] = $datajson;
				update_option("view_data",$view_data);
				$url = 'https://' . $rc_url . 'httpapi.com/api/domains/renew.json?';
					if ($ordernumber == true)
					{
						$new_or_transfer = 'renew';
						$exp_date = $datajson["endtime"];
						$url = 'https://' . $rc_url . 'httpapi.com/api/domains/renew.json?';
					}
						else
							{
								$new_or_transfer = '';
								$domaintld = '-1';
							}

				}
								
								
			$datajson = '';
			$httpResponse = '';
			$url1 = $url;
			$url = $url1 . $str;
			$result = '';
			
			$view_data[$customer_id][$x]["url-str"] = $str;
			
			update_option("view_data",$view_data);
			
		
			
			$data = CallDomainAPI('POST', $url, $data);
			$result = json_decode($data, TRUE);
			
			
					$view_data[$customer_id][$x]["domain-reg-httpResponse"] = $result;
					update_option("view_data",$view_data);
			
			
			
			update_post_meta($product_id,'_result',$result);
			$resellerclub_message = get_option("Resellerclub_messages", true);
			$a = get_post_meta($product_id,'_result');	
			$b = $a[0];
			$c = $b['actionstatusdesc'];

			update_option("Resellerclub_messages", $resellerclub_message . " resellerclub domain result: " . $c);
			$httpResponse = $result;
			$datajson = $httpResponse;
			$message = $datajson["status"];
			$message2 = $datajson["message"];
			set_transient('domain_checker_userid', $customer_id, 60*20);

				if ($datajson["status"] == "error")
				{
					$register_message = ($datajson["error"]);
					$domainresult = false;
					return $register_message;
				}

					if ($datajson["status"] == "ERROR")
					{
						if ($datajson["message"] == "Domain already renewed.")
						{
							$domainresult = false;
							$register_message = ($datajson["message"]);
							return $register_message;
						}

						$register_message = ($datajson["message"]);
						return $register_message;
					}

		if (($datajson["status"] == "Success") || ($datajson["status"] == "AdminApproved")|| ($datajson["status"] == "ValidateAuthInfo"))
		{
			$domainresult = true;
			$register_message = ($datajson["actionstatusdesc"]);
			$ordernumber = ($datajson["entityid"]);
			update_post_meta($order_id, '_' . $product_name, $ordernumber);
			$view_data[$customer_id][$x]["domain-reg-ordernumber"] = $ordernumber;
					update_option("view_data",$view_data);
			return $ordernumber;
		}

}

add_shortcode('woo_register_domain','woo_register_domain');
