<?php

// Version: 1.5.4


function wh_extra_fields()

{
	global $woocommerce, $product_name, $domainreg,$output_string2,
$product_count, $order_count, $nameserver_array, $order_id, $product_id,$lock;

$domainreg = false;$order_id = false;$havedomain = false;$product_count=0;$order_count=0;$hosting_domain_string="";
$lang=''; $data = false;
$extra_fields = new lang($lang);

$havehosting = false;$have_got_hosting = false;$haveaddons = false;$expirydate = false;
$have_got_no_hosting = false;$domain_string = false;$hosting_string = false;$hosting_string = false;
$you_have_got_a_domain = false;$have_got_domains = false;
$check_if_its_an_old_order = false;$domainreg = false;$domaininarray = false;
$addons_string = false;$cpanel_string = false;$wh_domainspage = false;$status=false;$actionstatusdesc=false;

if ( is_user_logged_in() )

	{
		$whm_ip_address = get_option("wh_whm_ip_address",true);
		$whm_cp_port = get_option("wh_whm_cp_port",true);
		$whm_servername = get_option("wh_whm_servername",true);
		$siteurl = get_home_url();
 
				if(isset($_POST['checkns']))
				{
						if ($_POST['checkns'])
						{
							$wh_run_checkns = sanitize_text_field ($_POST['wh_run_checkns']);
							if ($wh_run_checkns == "yes")
							{
								$wh_run_checkns = false;
							$retrieved_nonce = $_REQUEST['_wpnonce'];
							if (!wp_verify_nonce($retrieved_nonce, 'wh_checkns' ) ) die( htmlentities($edit_domains->security_token, ENT_COMPAT,'ISO-8859-1', true) );
							$ns1 = false; $ns2 = false;$ns3 = false; $ns4 = false;
							
							$domainname = sanitize_text_field ($_POST['product_name']);
							$product_id = sanitize_text_field ($_POST['product_id']);
							$order_id = sanitize_text_field ($_POST['order_id']);
							$ns1 = sanitize_text_field ($_POST['ns1']);

							if (!preg_match("/\b(?:(?:ns?)[0-9]\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $ns1))
							{echo '<div class ="whmessageboxred">' . htmlentities($edit_domains->resellerclub_nameserver_error_1, ENT_COMPAT,'ISO-8859-1', true) . '</div>';$error=true;}

							$ns2 = sanitize_text_field ($_POST['ns2']);
							if (!preg_match("/\b(?:(?:ns?)[0-9]\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $ns2))
							{echo '<div class ="whmessageboxred">' . htmlentities($edit_domains->resellerclub_nameserver_error_2, ENT_COMPAT,'ISO-8859-1', true) . '</div>';$error=true;}

							$ns3 = sanitize_text_field ($_POST['ns3']);
							if(isset($ns3) && ($ns3 <> ''))
							{
								if (!preg_match("/\b(?:(?:ns?)[0-9]\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $ns3))
								{echo '<div class ="whmessageboxred">' . htmlentities($edit_domains->resellerclub_nameserver_error_3, ENT_COMPAT,'ISO-8859-1', true) . '</div>';$error=true;}
							}

							$ns4 = sanitize_text_field ($_POST['ns4']);
							if(isset($ns4) && ($ns4 <> ''))
							{
								if (!preg_match("/\b(?:(?:ns?)[0-9]\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $ns4))
								{echo '<div class ="whmessageboxred">' . htmlentities($edit_domains->resellerclub_nameserver_error_4, ENT_COMPAT,'ISO-8859-1', true) . '</div>';$error=true;}
							}


							if ($ns1 == false)
							{
								$errormessage = htmlentities($edit_domains->resellerclub_nameserver_1_error_requires_valid_name, ENT_COMPAT,'ISO-8859-1', true);
								if ($ns2 == false)
								{
									$errormessage = htmlentities($edit_domains->resellerclub_nameserver_1_2_error_requires_valid_name, ENT_COMPAT,'ISO-8859-1', true);
								}
							}

							if ($ns2 == false)	
							{
								$errormessage = htmlentities($edit_domains->resellerclub_nameserver_2_error_requires_valid_name, ENT_COMPAT,'ISO-8859-1', true);
								if ($ns1 == false)	
								{
									$errormessage = htmlentities($edit_domains->resellerclub_nameserver_1_2_error_requires_valid_name, ENT_COMPAT,'ISO-8859-1', true);
								}
							}
							$nameserver_array = array();
							$nameserver_array['ns1'] = $ns1;
							$nameserver_array['ns2'] = $ns2;
							$nameserver_array['ns3'] = $ns3;
							$nameserver_array['ns4'] = $ns4;
							$nameserver_array['order_id'] = $order_id;
							$nameserver_array['product_id'] = $product_id;
							
							
							update_nameservers_api($product_id);
							
							$_POST['checkns'] = '';
							}
						}
				}	
	
	
	
	


	if (isset($_POST['select']))
	{
		$lang='';
		$edit_domains = new lang($lang);
		$path = '';
		$pageposition = '';
		$retrieved_nonce = $_REQUEST['_wpnonce'];
		if (!wp_verify_nonce($retrieved_nonce, 'wh_domain_options_form' ) ) die( htmlentities($edit_domains->$this->security_token, ENT_COMPAT,'ISO-8859-1', true ));
		$domainaction = sanitize_text_field ($_POST['select']);
		
		if ($domainaction == '1')
		{
			
			$domainname = sanitize_text_field ($_POST['product_name']);
			$product_id = sanitize_text_field ($_POST['product_id']);
			$order_id = sanitize_text_field ($_POST['order_id']);
			$customer_id = get_current_user_id();

			echo '<h4>' . htmlentities($edit_domains->form_nameserver, ENT_COMPAT,'ISO-8859-1', true) . '</h4><br />' . esc_html($domainname) . '<br /><br />';

					$s='1';
					while($s <= 4 )
					{
						echo htmlentities($edit_domains->form_nameserver, ENT_COMPAT,'ISO-8859-1', true) . ' ' . esc_html ($s) .': &nbsp; ' . get_post_meta( $product_id, 'nameserver0'.esc_html($s), true );
						echo '<br />';$s++;$tempdomainname = $product_id;
					}
			?><br /><br />
			<?php
			echo '<form method="post" action="' .esc_attr ($path) . '">' ; ?>
			<?php wp_nonce_field('wh_checkns'); ?>
			<input type="hidden" name="product_name" value=<?php echo esc_html($domainname);?> >
			<input type="hidden" name="product_id" value="<?php echo $product_id;?>" >
			<input type="hidden" name="order_id" value="<?php echo $order_id;?>" >
			<input type="hidden" name="wh_run_checkns" value="yes" >
			<table>
			<tr>
			<th style="border:0px;">
			<p><?php echo htmlentities($edit_domains->form_nameserver_01, ENT_COMPAT,'ISO-8859-1', true);?> * </p><p><input type="text" name="ns1" pattern="[a-z0-9.-]+\.[a-z]{2,3}$"></p>
			</th>
			<th style="border:0px;">
			<p><?php echo htmlentities($edit_domains->form_nameserver_02, ENT_COMPAT,'ISO-8859-1', true);?> *</p><input type="text" name="ns2" pattern="[a-z0-9.-]+\.[a-z]{2,3}$"></p>
			</th>
			</tr>
			<tr>
			<th style="border:0px;">
			<p><?php echo htmlentities($edit_domains->form_nameserver_03, ENT_COMPAT,'ISO-8859-1', true);?> </p><input type="text" name="ns3" pattern="[a-z0-9.-]+\.[a-z]{2,3}$"></p>
			</th>
			<th style="border:0px;">
			<p><?php echo htmlentities($edit_domains->form_nameserver_04, ENT_COMPAT,'ISO-8859-1', true);?> </p><input type="text" name="ns4" pattern="[a-z0-9.-]+\.[a-z]{2,3}$"></p>
			</th>
			</tr>
			<tr>
			<th style="border:0px;padding-top:10px;">
			<input type="submit" name="checkns" value="<?php echo htmlentities($edit_domains->change, ENT_COMPAT,'ISO-8859-1', true);?>"/>
			</th>
			</tr>
			</table>
			</form>
			<?php

		}

	


			if (isset($domainaction) && ($domainaction == '2'))
			{
				$domainname = sanitize_text_field ($_POST['product_name']);
				echo '<h3>' . htmlentities($edit_domains->my_account_domain, ENT_COMPAT,'ISO-8859-1', true) . '</h3>';
				echo htmlentities($edit_domains->my_account_domain, ENT_COMPAT,'ISO-8859-1', true) . ': ' . esc_html($domainname);
				$product_name = $domainname;
				domain_secret_api($product_name);
			}

			if (isset($domainaction) && ($domainaction == '3'))
			{
				$domainname = sanitize_text_field ($_POST['product_name']);
				echo '<h3>Domain</h3>';
				echo 'Domain: ' . esc_html($domainname);
				$product_name = $domainname;
				$lock='disable';
				unlock_domain_api($lock);
			}

			if (isset($domainaction) && ($domainaction == '4'))
			{
				$domainname = sanitize_text_field ($_POST['product_name']);
				echo '<h3>Domain</h3>';
				echo 'Domain: ' . esc_html($domainname);
				$product_name = $domainname;
				$lock='enable';
				unlock_domain_api($lock);
			}

	} // end of isset($_POST['select']))


	


	

	$domains_array = array(

	'' => null,

	'' => null,

	);

	$hosting_array = array(

	'' => null,

	'' => null,

	);

	$ssl_array = array(

	'' => null,

	'' => null,

	);

	$my_account_home_url = get_permalink( get_option('woocommerce_myaccount_page_id') );

		
		?>
		
		<div class="myaccountpage">
		<br />
		<a href="<?php echo $my_account_home_url; ?>">&lArr; <?php echo htmlentities ($extra_fields->my_account, ENT_COMPAT,'ISO-8859-1', true) ; ?></a>
		<div class="my-account-menu">
		<ul style ="list-style-type: none;float:right;">
		<li style ="display: inline;padding-left:10px;"><a href="#domains"><?php echo htmlentities($extra_fields->menu_domains, ENT_COMPAT,'ISO-8859-1', true);?> </a></li>
		<li style ="display: inline;padding-left:10px;"><a href="#hosting"><?php echo htmlentities($extra_fields->menu_hosting, ENT_COMPAT,'ISO-8859-1', true);?></a></li>
		<li style ="display: inline;padding-left:10px;"><a href="#addons"><?php echo htmlentities($extra_fields->menu_add_ons, ENT_COMPAT,'ISO-8859-1', true);?></a></li>
		<?php

		if( wh_woocommerce_version_check() ) {}

		else

		{

			?>
			<li style ="display: inline;padding-left:10px;"><a href="#orders"><?php echo htmlentities($extra_fields->my_account_orders, ENT_COMPAT,'ISO-8859-1', true);?></a></li>
			<?php

		}

	?>
	</ul><br /><br />
	</div>
	<div class="my-account-layout-hosting">
	<div class="my-account-firstname">
	<?php
		$customer_id = get_current_user_id();
		if (current_user_can('customer') || (current_user_can('administrator') ))
		{
			$firstname = get_user_meta( $customer_id, 'first_name', true ) ;
			echo '<br />' . htmlentities($extra_fields->my_account_message_1, ENT_COMPAT,'ISO-8859-1', true) . '<b> ' . $firstname . '</b>' . ' ' . htmlentities($extra_fields->my_account_message_2, ENT_COMPAT,'ISO-8859-1', true);
			echo '<br /><br /><br />';

		?>
		</div>
		<div class="package-names">
		<?php
		$wh_resellerclub_id = get_user_meta( $customer_id, 'resellerclub_id', true );
			if (isset($wh_resellerclub_id) && ($wh_resellerclub_id <> ''))
			{
				?>
				<a href="http://sale591380.myorderbox.com/customer"><?php echo htmlentities($extra_fields->resellerclub_account_number, ENT_COMPAT,'ISO-8859-1', true);?></a>
				<?php echo esc_html ($wh_resellerclub_id) . '<br />';
				?>
				</div>
				<?php

			}

				$path = site_url();
				$cpanelimg = content_url('/plugins/web-hosting/images/cpanel54x26.png' , __FILE__ );
				if($whm_servername) {$cpanel_address = $whm_servername; } else {$cpanel_address = $whm_ip_address;}
				$customer_orders = wc_get_orders(array(
												'limit'    => -1,
												'customer' => get_current_user_id(),
												) );

				if($customer_orders)
				{
					foreach ( $customer_orders as $value)
					{
						$order_id = $value->get_id();
						
						
						
						$order = wc_get_order( $order_id );
						$paid = $order->get_status();

							foreach ( $order->get_items() as $item_id => $item )
							{
								$product = apply_filters( 'woocommerce_order_item_product', $item->get_product(), $item );
								if($product)
								{
									$product_name = $product->get_name();
									$product_id = $product->get_id();
									$parent_id = $product->get_parent_id();
									$check_if_its_an_old_order = get_post_meta( $order_id,$product_id . ' ' . $product_name,true);

									if (!$check_if_its_an_old_order) 
									{
										$check_if_its_an_old_order = get_post_meta( $order_id,'wh_order_processed',true);
									}

									if($parent_id >0)
									{
										$product_item = get_post_meta( $parent_id, 'package',true);
									}

									else

									{
										$product_item = get_post_meta( $product_id, 'package',true);
									}

							//	}	
								
							// ************ DOMAINS *****************************************************************	
								// check if a domain product has been deleted
										if ( is_a($product, 'WC_Product')) 
									{
										
									//	echo "yes";
									//}
										if (($product_item == "domain") || ($product_item == "domain-renew") )
									{
										$havedomain = true;
										$you_have_got_a_domain = true;

										if (in_array($product_id, $domains_array))
										{
										$domaininarray = true;

										}

										array_push($domains_array,$product_id);

										if($domaininarray === false)

										{
										//	$domainreg = get_post_meta($order_id,'_' . $product_name . '_domain-registered',true);
										//	if(!$domainreg){$domainreg = get_post_meta($product_id,'domain-registered',true);} //backward compatibility
										//	if($domainreg == 'yes'){$domainreg = 'Active';}//backward compatibility
										//	if($domainreg == 'no'){$domainreg = 'Not active';}//backward compatibility


										// add code to get domain info from resellerclub

											$data = wh_get_domain_order_details($product_name, $data);
											
											$result = json_decode($data, TRUE);
										/*	?><pre><?php print_r($result);?></pre><?php */
												if(isset($result['status']))
												{
												$status = $result['status'];
											
												$message = $result['message'];
												}
												if(isset($result['currentstatus']) && ($result['currentstatus'] == 'Active'))
										{
											
												$have_got_domains = true;
												$domainreg = $result['currentstatus'];
												if(isset($result ['actiontypedesc']))
												{
												$actiontypedesc = $result ['actiontypedesc'];
												$actionstatusdesc = $result['actionstatusdesc'];
												}
												$endtime = $result["endtime"];
												if(isset($endtime) && ($endtime >1))
												{
													if (ctype_digit($endtime))
													{
													$date = date("F j, Y", $endtime);
													$expirydate = $date;
													
													}
												}

												//$expirydate = get_post_meta($order_id,'_' . $product_name . '_domainexpiry',true);
												//if(!$expirydate){$expirydate = get_post_meta($product_id,'domainexpiry',true);} //backward compatibility
												//$actiontypedesc = get_post_meta($order_id,'_' . $product_name . '_actiontypedesc',true);
												//$actionstatusdesc = get_post_meta( $product_id, 'transfer message',true );

												//if(!$actiontypedesc){$actiontypedesc = 'Pending';}

												$domain_string .= '<tr><td>' . htmlentities($extra_fields->my_account_domain_name, ENT_COMPAT,'ISO-8859-1', true) . ': &nbsp; ' . esc_html ($product_name) . '  &nbsp;' . htmlentities($extra_fields->my_account_domain_expires, ENT_COMPAT,'ISO-8859-1', true) . ': ' . $expirydate . '</td></tr>';
												$domain_string .= '<tr><td>' . htmlentities($extra_fields->my_account_domain_registered, ENT_COMPAT,'ISO-8859-1', true) . ':  ' . $domainreg . '</td></tr>';
												if($actionstatusdesc)
												{
												$domain_string .= '<tr><td> actionstatusdesc = ' . $actionstatusdesc . '</td></tr>';
												}
											
											if(isset($domainreg) && ($domainreg == 'Active'))

											{
												
												domain_edits($product_name,$domainreg,$output_string2);
												$domain_string .= "<tr><td>" . $output_string2 . "</td></tr><tr><th></th></tr>";
												$domainreg = '';
												
											}

											else

											{
												$domain_string .= "<tr><td>" . htmlentities($extra_fields->my_account_domain_status, ENT_COMPAT,'ISO-8859-1', true) . ': ' . $actiontypedesc . "</td></tr><tr><th></th></tr>";
												if($actionstatusdesc)
												{
													$domain_string .= "<tr><td>" . htmlentities($extra_fields->my_account_transfer_domain_status, ENT_COMPAT,'ISO-8859-1', true) . ': ' . $actionstatusdesc . "</td></tr><tr><th></th></tr>";
												}
											}
										}
										else{
											if($status == 'ERROR')
											{
											if ($message == "Website doesn't exist for " . $product_name)
											{
											update_post_meta($product_id,'domain-registered','no');	
											$query = array(
												'ID' => $product_id,
												'post_status' => 'publish',
												);
												wp_update_post( $query, true );
											}
											}
											$havedomain = false;
											$you_have_got_a_domain = false;
											
											
											
											}
										}				// end of if($domaininarray == false)

									//$have_got_domains = true;

								} // end of if (isset($domain) && ($domain == "domain") || ($domain == "domain-renew") )
				}
					
					
					
					// ********* HOSTING ************************************************************
					
					// ***** get domain name associated with hosting package here ***********************
					
					if ($product_item == "hosting")
					{
						$hostinginarray = false;
						
						$hosting_domain = wc_get_order_item_meta( $item_id, 'custom_option', true );  
									if(empty($hosting_domain))
									{
									$hosting_domain = wc_get_order_item_meta( $item_id, 'custom_option_text', true );  	
									}
						if(!empty($hosting_domain))
										{
											
									//	$hosting_domain_string .= '<tr><td>' . htmlentities($extra_fields->my_account_hosting_package, ENT_COMPAT,'ISO-8859-1', true) . ' ' . esc_html ($product_name) . ' Domain ' . $hosting_domain . '</td></tr>';
											
										}
						
						
						//$hosting_string .= '<tr><td>' . htmlentities($extra_fields->my_account_hosting_package, ENT_COMPAT,'ISO-8859-1', true) . ' ' . esc_html ($product_name) . '<a href="https://' . esc_html ($cpanel_address) . ':' . esc_html ($whm_cp_port) . '">&nbsp;&nbsp;<b>CPanel</b></a></td></tr>';
									
						if (in_array($product_id, $hosting_array))

						{
							//$hostinginarray = true;
						}

						array_push($hosting_array,$product_id);
						$havehosting = true;
						$have_got_hosting = true;
					//	$have_got_no_hosting = true;

							if($hostinginarray == false)
							{
								
								if(($check_if_its_an_old_order == 'processed' ) || ($check_if_its_an_old_order >=0))
								{

									if ($paid == 'completed')

									{
										
										
										
										
										
										
										
										$hosting_string .= '<tr><td>' . htmlentities($extra_fields->my_account_hosting_package, ENT_COMPAT,'ISO-8859-1', true) . ' ' . esc_html ($product_name) . ' Domain ' . $hosting_domain . '</td></tr>';
										$cpanel_string = '<tr><td>Log into <a href="https://' . esc_html ($cpanel_address) . ':' . esc_html ($whm_cp_port) . '">&nbsp;&nbsp;<b>CPanel</b></a></td></tr>';
							
									}

										else
										{
											$hosting_string .= '<tr><td>' . htmlentities($extra_fields->my_account_hosting_package, ENT_COMPAT,'ISO-8859-1', true) . ' ' . esc_html ($product_name) . ' ' . htmlentities($extra_fields->my_account_hosting_package_awaiting_payment, ENT_COMPAT,'ISO-8859-1', true) . '</tr></td>';
										}

								}

							}

					}

						$addon = false;
						$addons = '';

							
							
							
							
					// ********** ADDONS *******************************************************************************
							
							if (($product_item == "addon") || ($product_item == "ssl"))
							{
								$sslinarray = false;
								$haveaddons = true;
								//$ssl_domain = get_post_meta($order_id, 'domain-name',true);
								
								$ssl_domain = wc_get_order_item_meta( $item_id, 'custom_option', true );  
									if(empty($ssl_domain))
									{
									$ssl_domain = wc_get_order_item_meta( $item_id, 'custom_option_text', true );  	
									}

								if (in_array($product_id, $ssl_array))
								{
									$sslinarray = true;
								}

									array_push($ssl_array,$product_id);

									if($sslinarray == false)
									{
										if(($check_if_its_an_old_order == 'processed' ) || ($check_if_its_an_old_order >=0))
										{
											if ($paid == 'completed')
											{
												$addons_string .= '<tr><td>' . htmlentities($extra_fields->my_account_add_on, ENT_COMPAT,'ISO-8859-1', true) . ' ' . esc_html ($product_name)  . ' ' . htmlentities($extra_fields->my_account_domain, ENT_COMPAT,'ISO-8859-1', true) . ': ' . esc_html ($ssl_domain) . '</td></tr>';
											}

												else
												{
													$addons_string .= '<tr><td>' . htmlentities($extra_fields->my_account_add_on, ENT_COMPAT,'ISO-8859-1', true) . ' ' . esc_html ($product_name) . ' ' . htmlentities($extra_fields->my_account_awaitng_payment, ENT_COMPAT,'ISO-8859-1', true) . '</tr></td>';
												}
										}
									}
							}
							
							
							
											$product_count++;
					} // end of if($product)
						} 						//end of foreach($order->get_items() as $item)
											$same_product_id = '';
							
											$order_count++;
					} 							// end of foreach ( $customer_orders as $value)
											



					?>
					<hr>
					<br />
					<A NAME="orders"></a>
					<?php

					if ($have_got_domains == true)
					{
						?><A NAME="domains"></a>
						<h5><?php echo htmlentities($extra_fields->my_account_domains, ENT_COMPAT,'ISO-8859-1', true);?> </h5>
						<?php
						echo '<div class= "domain_table_container"><table><tbody>';
						echo $domain_string;
						echo '<tr> </tr></tbody></table></div>';
					}

						if($havehosting == true)
						{
							?><A NAME="hosting"></a>
							<h5><?php echo htmlentities($extra_fields->my_account_hosting, ENT_COMPAT,'ISO-8859-1', true); ?></h5>
							<?php
							echo '<div class= "domain_table_container"><table><tbody>';
							echo '<tr><td>Your Packages</td></tr>';
							echo $hosting_domain_string;
							echo $hosting_string;
							echo $cpanel_string;
							echo '<tr> </tr></tbody></table></div>';
						}

							if($haveaddons == true)
							{
							?><A NAME="addons"></a>
							<br /><br />
							<h5><?php echo htmlentities($extra_fields->my_account_add_ons, ENT_COMPAT,'ISO-8859-1', true); ?> </h5>
							<?php
							
								echo '<div class= "domain_table_container"><table><tbody>';
								echo $addons_string;
								echo '<tr> </tr></tbody></table></div>';
							}
							
							?></div></div><?php

				} // end of if(customer_orders)

				if ($have_got_domains === false)
				{
					$wh_domainspage = get_option( 'wh_domainsformpage',true );
		
					echo '<table><tbody>';
					echo '<h5>' . htmlentities($extra_fields->my_account_domains) . "</h5><br>" ;
					if(!empty($wh_domainspage))
					{
						
						?><A NAME="domains"></a><br /><tr><td><?php echo htmlentities($extra_fields->my_account_have_no_domain, ENT_COMPAT,'ISO-8859-1', true); ?><a href="<?php echo esc_attr ($siteurl) . esc_html($wh_domainspage); ?>"><div class="wh_button"><?php echo htmlentities($extra_fields->my_account_order_button, ENT_COMPAT,'ISO-8859-1', true); ?> </a></div></td></tr><?php
					}
						else
						{
							echo '<A NAME="domains"></a><tr><td><h5>' . htmlentities($extra_fields->my_account_domains) . "</h5><br>" . htmlentities($extra_fields->my_account_have_no_domain, ENT_COMPAT,'ISO-8859-1', true) . '</td></tr>';
						}
						echo '</tbody></table>';
				}

					if ($have_got_hosting == false)
					{
						$wh_hostingpage = get_option( 'wh_hostingpage',true );
						echo '<table><tbody>';
						echo '<h5>' . htmlentities($extra_fields->my_account_hosting) . "</h5><br>" ;
						if(!empty($wh_hostingpage))
						{
							?><?php echo '<tr><td>' . htmlentities($extra_fields->my_account_have_no_hosting, ENT_COMPAT,'ISO-8859-1', true); ?>  <a href="<?php echo esc_attr ($siteurl) . esc_html ($wh_hostingpage); ?>"><div class="wh_button"><?php echo htmlentities($extra_fields->my_account_order_button, ENT_COMPAT,'ISO-8859-1', true); ?></a></div></td></tr><?php
						}
							else
							{
								echo '<tr><td>' . htmlentities($extra_fields->my_account_have_no_hosting, ENT_COMPAT,'ISO-8859-1', true) . '</td></tr><br />';
							}
							echo '</tbody></table>';
					}

						if ($haveaddons == false)
						{
							$wh_addonspage = get_option( 'wh_addonspage',true );
							echo '<table><tbody>';
							echo '<h5>' . htmlentities($extra_fields->my_account_add_ons) . "</h5><br>" ;
							if(!empty($wh_addonspage))
							{
								?><?php echo '<tr><td>' . htmlentities($extra_fields->my_account_have_no_add_on, ENT_COMPAT,'ISO-8859-1', true); ?>  <a href="<?php echo esc_attr ($siteurl) . esc_html($wh_addonspage); ?>"><div class="wh_button"><?php echo htmlentities($extra_fields->my_account_order_button, ENT_COMPAT,'ISO-8859-1', true); ?></a></div></td></tr><?php
							}
								else
								{
									echo '<tr><td>' . htmlentities($extra_fields->my_account_have_no_add_on, ENT_COMPAT,'ISO-8859-1', true) . '</td></tr>';
								}
							echo '</tbody></table>';
						}

		} // end of if (current_user_can()

	} // end if if user is logged in
	else 
		{
			echo htmlentities($edit_domains->my_account_login_to_view_this_page, ENT_COMPAT,'ISO-8859-1', true);

			if (! is_user_logged_in() )	
			{
				?>
				<a href="<?php echo wp_login_url( home_url() ); ?>" title="Log In"> Log In</a>
				<?php
			}
		}

} // end of function
add_shortcode('wh_extra_fields', 'wh_extra_fields');

function update_nameservers_api($product_id)
{
 global $product_id,$api_key,$domainname,$ns1,$ns2,$ns3,$ns4,$errormessage,$url,
 $entityid,$order_id,$httpResponse,$str,$method,$product_name, $x, $nameserver_array;
	$domainname = ''; $ordernumber = '';
	
	$lang='';
	$update_names = new lang($lang);
	$order_array = array();
	$api_user_id = get_option( "wh_reseller_id",true);
	$api_key = get_option( "wh_reseller_api",true);
	$rc_url = get_option( "wh_checkbox",true);
	if ($rc_url == "yes"){$rc_url = "test.";}

	$ns1 = $nameserver_array['ns1'];
	$ns2 = $nameserver_array['ns2'];
	$ns3 = $nameserver_array['ns3'];
	$ns4 = $nameserver_array['ns4'];
	$product_id = $nameserver_array['product_id'];
	$order_id = $nameserver_array['order_id'];

		if ($ns1 == true && $ns2 == true)
		{
			$domainname = get_the_title($product_id);
			$domainname = substr($domainname,9);
			$customer_id = get_current_user_id();
			$order_array = array();
			$order_array = get_post_meta($order_id,'_' . $domainname . '_domain_details', true);
			$ordernumber = $order_array['orderid'];
			

			if ($ns4 && $ns3)
			{
				$nameserver = '&ns=' . $ns1 . '&ns=' . $ns2 . '&ns=' . $ns3 . '&ns=' . $ns4;
			}

			if ($ns3 && $ns4 == '')
			{
				$nameserver = '&ns=' . $ns1 . '&ns=' . $ns2 . '&ns=' . $ns3;
			}

			if ($ns2 && $ns3 == '')
			{
				$nameserver = '&ns=' . $ns1 . '&ns=' . $ns2;
			}

RETRY2:

				$url1 = 'https://' . $rc_url . 'httpapi.com/api/domains/modify-ns.json?';
				$str= 'auth-userid=' . $api_user_id . '&api-key=' . $api_key . '&order-id=' . $ordernumber  . $nameserver;
				$url = $url1 . $str;
//				echo "url " . $url; 
				$data = '';
				$data = CallDomainAPI('POST', $url, $data);
				$datajson = json_decode($data, TRUE);
				$status = ($datajson["status"]);
				
			

					if ($status == 'Success')
					{

					update_post_meta( $product_id, 'nameserver01', $ns1 );

					update_post_meta( $product_id, 'nameserver02', $ns2 );

					update_post_meta( $product_id, 'nameserver03', $ns3 );

					update_post_meta( $product_id, 'nameserver04', $ns4 );

					echo htmlentities($update_names->resellerclub_nameserver_for, ENT_COMPAT,'ISO-8859-1', true) . ' ' . esc_html ($domainname) . ' ' . htmlentities($update_names->resellerclub_nameserver_has_been_completed, ENT_COMPAT,'ISO-8859-1', true);

					}

		} // end of ($ns1 == true)

			else {$errormessage = 'ns1 is empty';}

			if ($errormessage){echo htmlentities($update_names->resellerclub_nameserver_error_6, ENT_COMPAT,'ISO-8859-1', true) . '<br />' . esc_html ($errormessage);}

}

add_action('update_nameservers_api', 'update_nameservers_api');


function domain_secret_api($product_name)
{
	global $data, $product_name;
	$lang='';
	$domain_secret = new lang($lang);
	wh_get_domain_order_details($product_name,$data="");
	$result = json_decode($data, TRUE);
	$secret = $result['domsecret'];
	if ($secret)	
	{
		echo '<br /><b>' . htmlentities($domain_secret->my_account_domain_secret, ENT_COMPAT,'ISO-8859-1', true) . '</b><br /> ' . esc_html ($secret) . '<br />' . htmlentities($domain_secret->my_account_domain_secret_message_2, ENT_COMPAT,'ISO-8859-1', true) . '<br /><br />';
	}

}

add_action('domain_secret_api','domain_secret_api');

function wh_account_menu_items( $items ) {

if( wh_woocommerce_version_check() )

{

$lang='';

$wh_control = new lang($lang);

$items['control-panel'] = __(  htmlentities ( $wh_control->control_panel , ENT_COMPAT,'ISO-8859-1', true ), 'wh' );

return $items;

}

}

add_filter( 'woocommerce_account_menu_items', 'wh_account_menu_items', 10, 1 );


