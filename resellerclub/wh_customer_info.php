<?php
/*

Version 1.5.4

*/


function woo_get_resellerclub_customers_info($customer_account_id,$product_id, $contact_type)
{
	

global 	$customer_account_id, $product_id, $arraydata, $method, $url, $data, $str, $contact_type,$x;



	// *************************************** get customer data ********************************************

			
				$view_data = get_option("view_data",true);
				$customer_id = $view_data['customer_id'];
				$product_id = $view_data[$customer_id][$x]['product_id'];
				$tld = $view_data[$customer_id][$x]['tld'];
				$api_user_id = get_option( "wh_reseller_id",true);
				$api_key = get_option( "wh_reseller_api",true);
				$rc_url = get_option( "wh_checkbox",true);
				if ($rc_url == "yes"){$rc_url = "test.";}
			
				$_product_name = get_the_title( $product_id );
				$view_data[$customer_id][$x]['domainname'] = $_product_name;
				$years = get_post_meta( $product_id, 'domainyears');
				$years = $years[0];
				$years = str_replace(' Years', '', $years);

				$country = get_user_meta( $customer_id, 'billing_country', true );
				
				
					// *** add rest of contact types here ***						
								
			$contact_type = "Contact";					
		
			
			if (($tld == '.co.uk') || ($tld == '.uk') || ($tld == '.me.uk') || ($tld == 'org.uk')){$contact_type = 'UkContact';}
			
					
				
			
				
	// *************************************************** Get Contact Info ******************************************************			
				



		
		$url = 'https://' . $rc_url . 'httpapi.com/api/contacts/default.json?';
		$str = 'auth-userid=' . $api_user_id . '&api-key=' . $api_key .'&customer-id=' . $customer_account_id . '&type=' . $contact_type;
		
$view_data[$customer_id][$x]["get_info_url"]=$url . $str;
		
			$method = false;

			$data = CheckDomainCallAPI($method, $url, $str, $data = false);
			$result = json_decode($data, TRUE);
		
			$view_data[$customer_id]['resellerclub']['get_info']=$result;
			update_option("view_data", $view_data);
		
						



		
				
				
				$details = $result[$contact_type]['techContactDetails'];
				
				$contact_company = $details['contact.company'];
				if($contact_company == ''){$contact_company = 'n/a';}
				
					$view_data[$customer_id]['contact.company'] = $contact_company;
					$view_data[$customer_id]['contact.telno'] = $details['contact.telno'];
					$view_data[$customer_id]['contact.contactid'] = $details['contact.contactid'];
					$view_data[$customer_id]['contact.zip'] = $details['contact.zip'];
					$view_data[$customer_id]['contact.city'] = $details['contact.city'];
					$view_data[$customer_id]['contact.country'] = $details['contact.country'];
					$view_data[$customer_id]['contact.address1'] = $details['contact.address1'];
					$view_data[$customer_id]['contact.telnocc'] = $details['contact.telnocc'];
					$view_data[$customer_id]['contact.name'] = $details['contact.name'];
					$view_data[$customer_id]['entity.customerid'] = $details['entity.customerid'];
					$view_data[$customer_id]['contact.state'] = $details['contact.state'];
					$view_data[$customer_id]["contact.emailaddr"] = $details["contact.emailaddr"];
					
					update_option("view_data",$view_data);
				
					return $contact_type;

}

add_shortcode('woo_get_resellerclub_customers_info', 'woo_get_resellerclub_customers_info');
