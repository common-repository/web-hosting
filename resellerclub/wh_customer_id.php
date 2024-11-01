<?php
/*

Version 1.5.4

*/

function woo_get_resellerclub_customers_id($contact_type,$admin_id,$customer_account_id)
{
	/*
	global $contact_type,$admin_id,$contact_company,$contact_telephone,$contact_id,$contact_postcode,
	$contact_city,$contact_country,$contact_address1,$contact_telephone_cc,$contact_name,$djg_account_id,
	$contact_state,$contact_email,$api_user_id,$api_key,$domaintdl,$product_id,$httpResponse,$url,$str,$method,
	$rc_url;
	
*/
global $url, $str, $data, $admin_id,$customer_account_id, $br, $contact_type, $customer_id, $x;

// *************************************** mimic customer data ********************************************

				
				$view_data = get_option("view_data",true);
				$customer_id = $view_data["customer_id"]; 
				
				
		
		/*		
				$customer_name = $view_data[$customer_id]['contact.name'];
				$company_name = $view_data[$customer_id]['contact.company'];
				$customer_email = $view_data[$customer_id]['contact.emailaddr'];
				$customer_address1 = $view_data[$customer_id]['contact.address1'];
				$city = $view_data[$customer_id]['contact.city'];
				$state = $view_data[$customer_id]['contact.state'];
				$country = $view_data[$customer_id]['contact.country'];
				$postcode = $view_data[$customer_id]['contact.zip'];
				$phone_cc = $view_data[$customer_id]['contact.telnocc'];
				$phone = $view_data[$customer_id]['contact.telno'];
				$customer_account_id = $view_data[$customer_id]['customer_account_id'];
		*/		
				
				
				
				
				
						$customer_email = $view_data[$customer_id]["customer_email"];
						$customer_name = $view_data[$customer_id]["customer_name"];
						$company_name = $view_data[$customer_id]["customer_company"];
						$customer_address1 = $view_data[$customer_id]["customer_address1"];
						$city = $view_data[$customer_id]["customer_city"];
						$state = $view_data[$customer_id]["customer_state"];
						$postcode = $view_data[$customer_id]["customer_postcode"];
						$country =	$view_data[$customer_id]["customer_country"];
						$phone = $view_data[$customer_id]["customer_phone"];
						
						$phone_cc = $view_data[$customer_id]['phone_cc'];
						$customer_account_id = $view_data[$customer_id]['customer_account_id'];	
						$tld = $view_data[$customer_id][$x]['tld'];

						
								
							// *** add rest of contact types here ***	
				$contact_type = "Contact";				
		
			if ($tld == '.com'){$contact_type = 'Contact';}
			if ($tld == '.biz'){$contact_type = 'Contact';}
			if (($tld == '.co.uk') || ($tld == '.uk') || ($tld == '.me.uk') || ($tld == 'org.uk')){$contact_type = 'UkContact';}
			
						
						

	
				
				
	// *********************************************************************************************************			

	$rc_url = get_option( "wh_checkbox",true);
	if ($rc_url == "yes"){$rc_url = "test.";}
					$api_user_id = get_option( "wh_reseller_id",true);
					$api_key = get_option( "wh_reseller_api",true);

	

		

	//$url = 'https://' . $rc_url . 'httpapi.com/api/contacts/details.json?';
//	$url = 'https://' . $rc_url . 'httpapi.com/api/contacts/default.json?';
	$url = 'https://' . $rc_url . 'httpapi.com/api/contacts/add.json?';
	//$str = 'auth-userid=' . $api_user_id . '&api-key=' . $api_key . '&type=' . $contact_type . '&contact-id=' . $customer_account_id . '&customer-id=' . $customer_account_id;
	$str = 'auth-userid=' . $api_user_id . '&api-key=' . $api_key . '&name=' . $customer_name . '&company=' . $company_name . '&email=' . $customer_email . '&address-line-1=' . $customer_address1 . '&city=' . $city . '&country=' . $country . '&zipcode=' . $postcode . '&phone-cc=' . $phone_cc . '&phone=' . $phone . '&customer-id=' . $customer_account_id . '&type=' . $contact_type;

//	echo $str;
	
	$view_data[$customer_id][$x]["get_id_url"]=$url . $str;
	$method = true;
		$data = CheckDomainCallAPI($method, $url, $str, $data);
		
		$result = json_decode($data, TRUE);
		$view_data[$customer_id][$x]['get_id']=$result;
		$admin_id = $result;
		$reg_id = $result;
		
	
	//	$admin_id = $result['Contact']['admin'];
	//	$reg_id = $result[$contact_type]['registrant'];
		$view_data[$customer_id][$x]["customer-info-reg_id"] = $reg_id;
		$view_data[$customer_id][$x]["customer-info-admin_id"] = $admin_id;
		update_option('view_data',$view_data);
	

			if (ctype_digit($admin_id)) 
			{
				//$admin_id = $result;
				$view_data[$customer_id][$x]["customer-info-admin_id"] = $admin_id;
				update_option("view_data",$view_data);
				//echo "admin_id " . $admin_id . $br;
				return $admin_id;
			}

				else

				{
					$error = 'cannot get resellerclub account id';
					$resellerclub_message = get_option("Resellerclub_messages", true);
					update_option("Resellerclub_messages", $resellerclub_message . " resellerclub customers get account id: Error " . $error);
					$admin_id = false;
					update_option("view_data",$view_data);
					return $admin_id;
				}

}

add_shortcode('woo_get_resellerclub_customers_id' , 'woo_get_resellerclub_customers_id');


