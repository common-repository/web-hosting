<?php
/*

Version 1.5.4

*/


function woo_resellerclub_signup()

{
	

global $error, $method, $url, $str, $data, $result, $encrypt_password, $decrypt_password, $br, $customer_account_id, $customer_id, $x;

				$view_data = get_option("view_data",true);
				$customer_id = $view_data['customer_id'];
PASSWD:

		$customer_account_id = false;
		
		$customer_account_id = get_user_meta( $customer_id, 'resellerclub_id', true );
		if(empty($customer_account_id))
		{
		
		
			$user_info = get_userdata($customer_id);
			$username = $user_info->user_login;
		
			$password = array();
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
				
							
						}
		
		
			
			

				else
				{
PASSWORD_RETRY:
					$random = resellerclub_random_password( $length = 14);
					
					if($random)
					{
						$encrypt_password = $random;
						encryptIt($encrypt_password,$result);
						
						if(empty($result['ciphertext']))
						{
							$error = "Cannot create password";
							$customer_account_id = '';
							return $customer_account_id;
	
							
						}
						else
						{
							$encrypted_password = array(
							'cipher' => $result['cipher'],
							'iv' => $result['iv'],
							'tag' => $result['tag'],
							'ciphertext' => $result['ciphertext'],
							'key' => $result['key'],
							
							
							);
							
							
							
							update_user_meta($customer_id, 'resellerclub_password_ciphertext', $encrypted_password['ciphertext']);
							update_user_meta($customer_id, 'resellerclub_password_cipher', $encrypted_password['cipher']);
							update_user_meta($customer_id, 'resellerclub_password_iv',  base64_encode($encrypted_password['iv']));
							update_user_meta($customer_id, 'resellerclub_password_tag',  base64_encode($encrypted_password['tag']));

							$pathInPieces = explode('/', $_SERVER['DOCUMENT_ROOT']);
							$path = "/" . $pathInPieces[1] . "/" . $pathInPieces[2] . '/';
							$passfile = $path . 'wh_data/' . $customer_id . "-rc_pass.php";
							$myfile = fopen($passfile, "w") ;
							fwrite($myfile, base64_encode($encrypted_password['key']));
							fclose($myfile);
							update_user_meta($customer_id, 'resellerclub_password', "yes");
					
							$encrypted_password ="";
							$password = $random;
							
						}
						
					}

						else
						{
						
						$customer_account_id = '';
						return $customer_account_id;

						}

				}

SIGNUP:

			
				if ($customer_account_id == false)
				{
					
					$customer_first_name = get_user_meta( $customer_id, 'billing_first_name', true );
					$view_data[$customer_id]['customer_first_name']=$customer_first_name;
					$customer_last_name = get_user_meta( $customer_id, 'billing_last_name', true );
					$view_data[$customer_id]['customer_last_name']=$customer_last_name;
					$company_name = get_user_meta( $customer_id, 'billing_company_name', true );
						if ($company_name == '')
						{
							$company_name = 'n/a';
							$view_data[$customer_id]['company_name']="n/a";
						}
						else
						{
						$view_data[$customer_id]['company_name']=$company_name;	
						}
					$customer_email = get_user_meta( $customer_id, 'billing_email', true );
					$view_data[$customer_id]['customer_email']=$customer_email;
					$phone = get_user_meta( $customer_id, 'billing_phone', true );
					
					$phone = str_replace(' ', '', $phone);
					$view_data[$customer_id]['phone']=$phone;
					$country = get_user_meta( $customer_id, 'billing_country', true );
					
					
					
					// * add the rest of countries here ***
					
					
					
						if ($country == 'GB')
						{
							$phone_cc = '44'; 
							$view_data[$customer_id]['phone_cc']=$phone_cc;
							update_user_meta($customer_id,'phone_cc',$phone_cc);
							
						}
						
						$view_data[$customer_id]['country']=$country;
						$view_data[$customer_id]['phone_cc'] = $phone_cc;
				
						
						
						
					$state = get_user_meta( $customer_id, 'billing_state', true );
					$view_data[$customer_id]['state']=$state;
					$customer_address1 = get_user_meta( $customer_id, 'billing_address_1', true );
					$view_data[$customer_id]['customer_address1']=$customer_address1;
					$city = get_user_meta( $customer_id, 'billing_city', true );
					$view_data[$customer_id]['city']=$city;
					$postcode = get_user_meta( $customer_id, 'billing_postcode', true );
					$view_data[$customer_id]['postcode']=$postcode;
					
				
	
					$rc_url = get_option( "wh_checkbox",true);
					if ($rc_url == "yes"){$rc_url = "test.";}
	
					$api_user_id = get_option( "wh_reseller_id",true);
					$api_key = get_option( "wh_reseller_api",true);
	
	
$url = 'https://' . $rc_url . 'httpapi.com/api/customers/signup.json?';
$str = 'auth-userid=' . $api_user_id . '&api-key=' . $api_key . '&username=' . $customer_email . '&passwd=' . $password . '&name=' . $customer_first_name . ' ' . $customer_last_name . '&company=' . $company_name . '&address-line-1=' . $customer_address1 . '&city=' . $city . '&state=' . $state . '&country=' . $country . '&zipcode=' . $postcode . '&phone-cc=' . $phone_cc . '&phone=' . $phone . '&lang-pref=en';

	

					$view_data[$customer_id]["password"] = $password;
					$view_data[$customer_id]["sign-up-url-str"] = $url . $str;
					update_option("view_data",$view_data);
					if ($password <> '')

					{
			
						$method = false;
						$data = CheckDomainCallAPI($method, $url, $str, $data = false);
						
						
						$view_data[$customer_id]["sign-up-data"] = $data;
						update_option("view_data",$view_data);

						if (ctype_digit($data))
						{
							$customer_account_id = $data;
							update_user_meta( $customer_id, 'resellerclub_id', $data ) ;
							$view_data[$customer_id]["customer_account_id"] = $customer_account_id;
							update_option("view_data",$view_data);
						}
							else
							{
								$datajson = json_decode($data, TRUE);
								$message = ($datajson["message"]);
							//	echo "message = " . $message . $br;

									if ($message == '{passwd=Password should be alphanumeric characters with minimum of 8 characters and maximum of 15 characters}')
									{
									goto PASSWORD_RETRY;	

									}

							}
							
							

						return $customer_account_id;

					} // end of If ($password <> '')
				
				} // end of if ($customer_account_id == false)
		}
	
				$view_data[$customer_id]["customer_account_id"] = $customer_account_id;
				update_option("view_data",$view_data);
			return $customer_account_id;

}

add_shortcode('woo_resellerclub_signup','woo_resellerclub_signup');

