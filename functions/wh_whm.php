<?php
// Version: 1.5.4

function WHM_create_account($json,$error)
{


global $view_data,$whm_result,$query,$encrypt_password,$result,$username,$x;
		
		$str = false;
		$pos = false;
		$packageactive = false;
		$whm_result = false;
		$whmcount3 = 3;
		$prefix = false;
		$owner =false;

	$lang='';
	$whm_lang = new lang($lang);
	
	$customer_id = $view_data["customer_id"];
	$order_id = $view_data[$customer_id]['order_id'];

	$newdomain = $view_data[$customer_id][$x]['WHM']['newdomain'];
	$product_id = $view_data[$customer_id][$x]["product_id"];
	$post = get_post($product_id);
	
	$parent_id = wp_get_post_parent_id( $post );
		if($parent_id)
		{
			$post = get_post($parent_id);
			$slug = $post->post_name; // need to get parent name here
		}
			else
			{
				$slug = $post->post_name; // need to get product name here
			}

	$view_data[$customer_id][$x][$product_name]['slug']=$slug;
	$view_data[$customer_id][$x]['post']=$post;
	$view_data[$customer_id][$x]['parent_id']=$parent_id;
	update_option("view_data",$view_data);
	

	$product_name = get_the_title( $product_id );
	$whm_username = get_option('wh_whm_username',true);
$prefix = $whm_username;
	$package = $slug;
		if ($prefix)
		{
			$check_underscore = substr($prefix, -1);    // returns "_"
			if($under_score =="_")
			{
				$package = $prefix . $slug;
			}
				else
				{
					$package = $prefix . '_' . $slug;
		
				}
		}
			else
		{
	
			$prefix = $whm_username;
	
		}
	
	$whm_ip = get_option('wh_whm_ip',true);
	$whm_port = get_option( 'wh_whm_port',true);
	$accountemail =$view_data[$customer_id]["customer_email"];
	

	$view_data[$customer_id][$x]['WHM']['slug']=$slug;
	update_option("view_data",$view_data);
	
	$username = $newdomain;
	
	
			
		
				
CREATE:
				
				$a = whm_username($username);
				$username = $a;	
				$checkusernames = false;
				$checkusernames2 = false;
				$exit = 0;
				
				
					
					
$query = 'https://' . $whm_ip . ':' . $whm_port . '/json-api/listaccts?api.version=1&search=' . $newdomain . '&searchtype=domain';

$view_data[$customer_id][$x]['WHM']['url']= $query;
update_option('view_data',$view_data);
	$json = array();
	get_whm_query($query,$whm_result);
	$json = json_decode($whm_result);
	$view_data[$customer_id][$x]['WHM']['check_account']=$json;
	
	
		if ($json->{'data'}->{'acct'} <>'') 
		{
			$checkusernames = true; $error = htmlentities($whm_lang->whm_error_domain_name, ENT_COMPAT,'ISO-8859-1', true) . ' '. $newdomain . ' ' . htmlentities($whm_lang->whm_error_domain_name_message, ENT_COMPAT,'ISO-8859-1', true) ;
			return $error;
		}
		
			if($checkusernames == false)
			{
				$query = 'https://' . $whm_ip . ':' . $whm_port . '/json-api/listaccts?api.version=1&search=' . $username . '&searchtype=user';
				get_whm_query($query,$whm_result);
				$json = json_decode($whm_result);
				$view_data[$customer_id][$x]['WHM']['check_username']=$json;
				update_option('view_data',$view_data);
				if ($json->{'data'}->{'acct'} <>'')
				{
					$count++;
					if ($count > 100){$error = 'username '. $username . htmlentities($whm_lang->whm_error_could_not_be_created, ENT_COMPAT,'ISO-8859-1', true) ;goto EXITA;}

					goto CREATE;
				}
			}
			
				$checkusernames2 = $json;
				if ($checkusernames == false)
				{
					$accountpassword = '';
					//$random = random_password( $length = 12);
					$random = resellerclub_random_password( $length = 12);

					if($random)
					{
						$accountpassword = $random;
						$encrypt_password = $random;
						encryptIt($encrypt_password,$result);
						
						if(empty($result['ciphertext']))
						{
							$error = "Cannot create password";
							$customer_account_id = '';
							return $error;
	
							
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
							
							
							
							update_user_meta($customer_id, 'WHM_password_ciphertext', $encrypted_password['ciphertext']);
							update_user_meta($customer_id, 'WHM_password_cipher', $encrypted_password['cipher']);
							update_user_meta($customer_id, 'WHM_password_iv',  base64_encode($encrypted_password['iv']));
							update_user_meta($customer_id, 'WHM_password_tag',  base64_encode($encrypted_password['tag']));
						
						
							$pathInPieces = explode('/', $_SERVER['DOCUMENT_ROOT']);
							$path = "/" . $pathInPieces[1] . "/" . $pathInPieces[2] . '/';
							$passfile = $path . 'wh_data/' . $customer_id . "-WHM_pass.php";
							
							$myfile = fopen($passfile, "w") ;
							fwrite($myfile, base64_encode($encrypted_password['key']));
							fclose($myfile);
							update_user_meta($customer_id, 'WHM_password', "yes");
					
							$encrypted_password ="";
						}
					}
							else
							{
								$error = htmlentities($whm_lang->whm_error_could_not_create_password, ENT_COMPAT,'ISO-8859-1', true) ;
								goto EXITA;
							}
					
						$query = 'https://' . $whm_ip . ':' . $whm_port . '/json-api/createacct?api.version=1&username=' . $username . '&domain=' . $newdomain . '&plan=' . $package . '&featurelist=default&quota=0&password=' . $accountpassword . '&ip=n&cgi=1&hasshell=1&contactemail=' . $accountemail . '&cpmod=paper_lantern&language=en&max_defer_fail_percentage=80&owner=';
						$view_data[$customer_id][$x]['WHM']['create-account-url']= $query;
						update_option('view_data',$view_data);
						get_whm_query($query,$whm_result);
						$json = json_decode($whm_result);
						$view_data[$customer_id][$x]['WHM']['create_account']=$json;
						update_option('view_data',$view_data);
						update_post_meta($order_id,'whm_json',$json);
						$whm = array("username" => $username, "password" => $encrypted, "key" => $key);
						
						update_post_meta($order_id, '_WHM_' . $newdomain, $username );
						update_post_meta($order_id, '_WHM_' . $newdomain . 'pass', $accountpassword );
						update_post_meta($order_id,'_whm_account' . $username, $whm );
				} // end of if ($checkusernames == false)
	return $json;
	EXITA:
	return $error;
	

} // end of WHM_create_account


function wh_change_username($username)
{
global $username, $view_data, $x;
$extra_letters = 'abcdefghijklmnopqursuvwxyz';
$customer_id = $view_data['customer_id'];
//CREATE2:
$whmcount++;$exit++;
$username = substr($username, 0, 7);$username = $username . $whmcount;
		if ($whmcount > 9)
		{
			$whmcount = 0;$whmcount2++;
			$extra_letter = substr($extra_letters, 0, $whmcount2);
			$username = substr($username, 0, -$whmcount3);$whmcount3++;$username = $username . $extra_letter . $whmcount;
			$view_data[$customer_id][$x]['whm_username'] = $username;
			update_option('view_data',$view_data);
				return $username;
		}

			if ($exit > 30) 
			{
				$error = 'over 30 attempts';
				$view_data[$customer_id][$x]['whm_username']['error'] = $error;
				update_option('view_data',$view_data);
				return $error;
			}
				$view_data[$customer_id][$x]['whm_username'] = $username;
				update_option('view_data',$view_data);
				return $username;

}

function get_whm_query($query,$whm_result)
{
global $whm_result,$query;
$user =  get_option( 'wh_whm_username',true );
$token = get_option( 'wh_whm_token',true );
$curl = curl_init();
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST,0);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,0);
curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
$header[0] = "Authorization: whm $user:$token";
curl_setopt($curl,CURLOPT_HTTPHEADER,$header);
curl_setopt($curl, CURLOPT_URL, $query);
$whm_result = curl_exec($curl);
curl_close($curl);
return $whm_result;
}
add_action('get_whm_query','get_whm_query');