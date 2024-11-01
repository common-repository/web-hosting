<?php

/*

Version 1.5.4

*/



function process_domain_name($domainstatus,$processdomain)

{

//global $httpResponse,$domainstatus,$wpdb,$domainname,$tld,$domainmessage,$fulldomainname,$new_or_transfer,
//$transferstatus,$data_tld1,$domaincheckmessage,$transfer_error,$numberofyears,$display_add_to_cart_button,$error,$contact_type;
global $wh_global, $domainstatus, $processdomain, $new_or_transfer, $domaintld, $wpdb, $domaincheckmessage, $domainname, $tld,$data_tld1,
 $numberofyears, $display_add_to_cart_button, $price1, $error;
$lang = '';$domaincheckmessage=false;

$process_domain = new lang($lang);
$a = false;$status = false;
$view_data = get_option("view_data",true);
					

			if ($new_or_transfer == 'transfer2')
			{
				$tld = $domaintld;
				$pos = -1;
				$pos = strpos($tld, '.');

					if ($pos === 0)
					{
						$temp_tld = substr($tld, 1);
						$tld = $temp_tld;
					}

			}
			

			$fulldomainname = $domainname . '.' . $tld ;
			if(isset($processdomain[$fulldomainname]["status"])){  $status = $processdomain[$fulldomainname]["status"] ;}
			
			
			
			if ($status == "available")
			{
			$view_data['domain_status'] = $status;
			update_option("view_data",$view_data);
			$domainstatus = true;	
			
			if($new_or_transfer == "transfer")
			{
			$domaincheckmessage = $process_domain->search_domain_names_sorry . ' ' . $fulldomainname . ' ' . $process_domain->transfer_domain_names_is_not_available;
				
			}
			else
			{
			$domaincheckmessage = $process_domain->search_domain_names_congratulations . ' ' . $fulldomainname . ' ' . $process_domain->search_domain_names_is_available;
			}
			if (isset($domaincheckmessage))
				{
					if ($domainstatus == true)
					{
						wh_get_number_of_tld($data_tld1);
						
					/*	?><pre><?php print_r($data_tld1);?></pre><?php */
						$domaintld = '.' . $tld;
						
						
							
						foreach( $data_tld1 as $key => $value)
						{
							if ($key == $domaintld)
								{
									$value = number_format($value,2);
									
									$numberofyears = number_format($numberofyears);
									$price1 =  htmlentities ($value, ENT_QUOTES, 'UTF-8') *  htmlentities ($numberofyears, ENT_QUOTES, 'UTF-8') ;
								}

						}

								if($numberofyears == 1)

								{$yearstext = $process_domain->search_domain_name_year;}
									else 
									{
										$yearstext = $process_domain->search_domain_name_years;
									}
						?> <div class="whmessageboxgreen"> <?php echo htmlentities ($domaincheckmessage, ENT_COMPAT,'ISO-8859-1', true)  . ' ' . esc_html($numberofyears) . ' ' . htmlentities($yearstext, ENT_COMPAT,'ISO-8859-1', true)  . ' ' . htmlentities ($process_domain->cost, ENT_COMPAT,'ISO-8859-1', true) . ' ' . $process_domain->currency . esc_html($price1);?> </div> <?php
						$display_add_to_cart_button = true;
						return;	
					}

					else

					{ 
						?> <div class="whmessageboxred"> <?php echo esc_html ($domaincheckmessage);?> </div> <?php
						$show_reg_form = true;
						$error = $domaincheckmessage;
						$view_data['domains_years1']=$numberofyears;
						$view_data['domain_price1']=$price1;
						$view_data['domain_error1']=$error;
						update_option("view_data",$view_data);
						return $error;

					}
					
				if($price1 >0)
				{
					$view_data['domains_years2']=$numberofyears;
					$view_data['domain_price2']=$price1;
					$view_data['domain_error2']=$error;
					update_option("view_data",$view_data);
					return;
				}
				else
				{$error = "price is zero"; 
			$view_data['domains_years3']=$numberofyears;
			$view_data['domain_price3']=$price1;
			$view_data['domain_error3']=$error;
			update_option("view_data",$view_data);
				return $error;
			
			}
				} // end of if (isset($domaincheckmessage)	
				
			
			
			}
				
			
			
			


			if(($status == "ERROR") || ($status == "unknown"))
			{
				$domainstatus = false;$transferstatus = false;
				if(isset($processdomain["message"]))
				{
				$domaincheckmessage = $processdomain["message"] ;
				}
				$error = true;

					if ($domaincheckmessage <>'')
					{
						?> <div class="whmessageboxred"> <?php echo esc_html ($domaincheckmessage);?> </div> <?php
						$show_reg_form = true;
					return $error;
					}
			

						else
						{	// added this bracket 29/03/2020
						$domaincheckmessage = $process_domain->search_domain_name_unknown_error;
						?> <div class="whmessageboxred"> <?php echo esc_html ($domaincheckmessage);?> </div> <?php
						$show_reg_form = true;
						
						
						
						return $error;
						}
			}
			
			
	
			if (($status == "regthroughus") || ($status == "regthroughothers"))

			{
				$domainstatus = false;
					if ($new_or_transfer == 'transfer')

				{
					$transferstatus = true;$domainstatus = true;
					$domaincheckmessage = $process_domain->transfer_domain_names_congratulations . ' ' . $fulldomainname . ' ' . $process_domain->transfer_domain_names_is_available_to_transfer;
				
/*				?> <div class="whmessageboxgreen"> <?php echo esc_html ($domaincheckmessage);?> </div> <?php */
						
						
						
						if (isset($domaincheckmessage))
				{
					if ($domainstatus == true)
					{
						wh_get_number_of_tld($data_tld1);
						
					/*	?><pre><?php print_r($data_tld1);?></pre><?php */
						$domaintld = '.' . $tld;
						
						
							
						foreach( $data_tld1 as $key => $value)
						{
							if ($key == $domaintld)
								{
									$value = number_format($value,2);
									
									$numberofyears = number_format($numberofyears);
									$price1 =  htmlentities ($value, ENT_QUOTES, 'UTF-8') *  htmlentities ($numberofyears, ENT_QUOTES, 'UTF-8') ;
								}

						}

								if($numberofyears == 1)

								{$yearstext = $process_domain->search_domain_name_year;}
									else 
									{
										$yearstext = $process_domain->search_domain_name_years;
									}
						?> <div class="whmessageboxgreen"> <?php echo htmlentities ($domaincheckmessage, ENT_COMPAT,'ISO-8859-1', true)  . ' ' . esc_html($numberofyears) . ' ' . htmlentities($yearstext, ENT_COMPAT,'ISO-8859-1', true)  . ' ' . htmlentities ($process_domain->cost, ENT_COMPAT,'ISO-8859-1', true) . ' ' . $process_domain->currency . esc_html($price1);?> </div> <?php
						$display_add_to_cart_button = true;
						return;	
					}

					else

					{ 
						?> <div class="whmessageboxred"> <?php echo esc_html ($domaincheckmessage);?> </div> <?php
						$show_reg_form = true;
						$error = $domaincheckmessage;
						$view_data['domains_years1']=$numberofyears;
						$view_data['domain_price1']=$price1;
						$view_data['domain_error1']=$error;
						update_option("view_data",$view_data);
						return $error;

					}
					
				if($price1 >0)
				{
					$view_data['domains_years2']=$numberofyears;
					$view_data['domain_price2']=$price1;
					$view_data['domain_error2']=$error;
					update_option("view_data",$view_data);
					return;
				}
				else
				{$error = "price is zero"; 
			$view_data['domains_years3']=$numberofyears;
			$view_data['domain_price3']=$price1;
			$view_data['domain_error3']=$error;
			update_option("view_data",$view_data);
				return $error;
			
			}
				} // end of if (isset($domaincheckmessage)	
						
						
						
						
						
						
						
						
						
						
						
						
						
					return $transferstatus;
				}

					else

					{
						$domaincheckmessage = $process_domain->search_domain_names_sorry . ' ' . $fulldomainname . ' ' . $process_domain->search_domain_names_is_not_available;
						?> <div class="whmessageboxred"> <?php echo esc_html ($domaincheckmessage);?> </div> <?php
						$show_reg_form = true;
						$error = true;
						return $error;
					}

			} // end of if ($httpResponse[$fulldomainname]["status"] == "regthroughus"
			

	
			
				





					

} // end of the function

function get_number_of_years($domainstatus)
{
	global $tld,$data_tld1,$fulldomainname,$domainstatus,$domaintld,$years,$newprice,$numberofyears;

	if (isset($domainstatus) && ($domainstatus == true))
	{
		if (isset($transferstatus) && ($transferstatus == true))
		{
			$new_or_transfer = 'transfer';
		}

			else {$new_or_transfer = 'new';}
			$product_id = "";
			if(isset($new_post_id)){ $product_id = $new_post_id;} // changed 02-05-2017

				if ($years == '0'){$years = '1'; } // added 23-03-2017
					$number_of_tld = get_option( 'tlds');
					$count = 0;
						do

						{
							$count++;
							$s = get_option( 'wh_tld' . $count);
							$data_tld1[$s] = get_option( 'wh_tld' . $count . 'price');
								if ($s == $domaintld){$we_sell_it = true;$price = $data_tld1[$s];}

						} while ($count < $number_of_tld);

			$newprice = ($price * $numberofyears);
			if ($we_sell_it == false) {echo 'domain is available but we are currently not selling ' . esc_html ($domaintld);}

	} // end of if (isset($domainstatus)

} // end of function



function resellerclub_random_password( $length) {
global $randpassword;
$count=false;
GENERATE:

if ($count > 1000){return ;}
$randpassword = substr(str_shuffle(implode(array_merge(range('a', 'z'), range('A', 'Z'), range('0', '9')))),0, $length-1);
$specialchar = "/\#~()";
$randomchar = $specialchar[rand(0, strlen($specialchar)-1)];
$temp = $randpassword . $randomchar;
$randpassword = $temp;
if (preg_match("/^[a-zA-Z0-9]*$/",$randpassword)) {$count++; goto GENERATE;}

//$view_data["randpassword"] = $randpassword;
//update_option("view_data",$view_data);

return $randpassword;

}


		


// ************************ RESELLERCLUB CUSTOMER ID **********************************



function CheckDomainCallAPI($method, $url, $str, $data)
{
	global $url,$data,$method,$str;
	if ($method == true)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url . $str);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_POST,TRUE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$data = curl_exec($ch);

	}

		else
		{
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_VERBOSE, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
			curl_setopt($ch, CURLOPT_POST,TRUE);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS,$str);
			$data = curl_exec($ch);

		}

	return $data;

}
