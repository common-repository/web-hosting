<?php
/*
version 1.5.4
*/
function wh_transfer_domain_form()
{
	ob_start();

	global $wh_global;
						
				$lang = '';
				$trans = new lang($lang);
				$domain_page = $wh_global['admin']['wh_domainspage'];
				$siteurl = get_home_url();
				$number_of_tld = get_option( 'tlds',true);
				$number_of_tld++;

		?>
		<form action="<?php echo esc_attr ($siteurl) . esc_attr ($domain_page);?>" method="post">
		<?php wp_nonce_field('wh_transfer_form'); ?>
		<table class="transferdomainname">
		<thead>
		<tr>
		<th><?php echo $trans->transfer_domain_name; ?></th>
		</tr>
		<tr>
		<th style="width:50%"><input name="domain" placeholder="mydomain.com" type="text" pattern="[a-z0-9.-]+\.[a-z]{2,3,14}$" value="" required /></th>
		
		<td>		<select name="years"><option value="0"><?php echo htmlentities($trans->number_of_years, ENT_COMPAT,'ISO-8859-1', true); ?></option>
		<option value="1"><?php echo $trans->transfer_1year; ?></option>
		<option value="2"><?php echo $trans->transfer_2years; ?></option>
		<option value="3" ><?php echo $trans->transfer_3years; ?></option>
		<option value="4"><?php echo $trans->transfer_4years; ?></option>
		<option value="5"><?php echo $trans->transfer_5years; ?></option>
		<option value="6"><?php echo $trans->transfer_6years; ?></option>
		<option value="7"><?php echo $trans->transfer_7years; ?></option>
		<option value="8"><?php echo $trans->transfer_8years; ?></option>
		<option value="9"><?php echo $trans->transfer_9years; ?></option>
		<option value="10"><?php echo $trans->transfer_10years; ?></option>
		</select></td>
		</tr>
		<tr>
		<td style="width:50%">
		<?php echo htmlentities($trans->authcodetext, ENT_COMPAT,'ISO-8859-1', true); ?>
		</td>
		<td style="width:20%"><input name="authcode" type="text" placeholder="<?php echo htmlentities($trans->authcode, ENT_COMPAT,'ISO-8859-1', true); ?>" value="" /></td>
		


		<td style="width:10%">
		<select name="tld"><option>TLDs</option>

			<?php

			$count = 1;
				do
				{		
					$tld = get_option( 'wh_tld' . $count, true);
					?> <option> <?php echo $tld; ?> </option><?php
					$count++;


				}
				while ($count < $number_of_tld);




?>



</select>
</td>
</tr>
<tr>
<td>
<input name="transfercheck" type="submit" value="<?php echo $trans->buttontext; ?>" />
</td><td>
</td>
<td></td>

</tr>
</tbody>
</table>
</form>
<?php

$output_string=ob_get_contents();
ob_end_clean();
return $output_string; ob_start();
}
add_shortcode('wh_transfer_domain_form','wh_transfer_domain_form');




function wh_domain_form()
{
	global $wh_global;
	ob_start();
	$lang = '';
	$reg_domain = new lang($lang);
if(isset($wh_global['admin']['wh_domainspage'])){
	$domain_page = $wh_global['admin']['wh_domainspage'];
}

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
	<option value ="1"><?php echo $reg_domain->_1year; ?></option>
	<option value ="2"><?php echo $reg_domain->_2years; ?></option>
	<option value ="3"><?php echo $reg_domain->_3years; ?></option>
	<option value ="4"><?php echo $reg_domain->_4years; ?></option>
	<option value ="5"><?php echo $reg_domain->_5years; ?></option>
	<option value ="6"><?php echo $reg_domain->_6years; ?></option>
	<option value ="7"><?php echo $reg_domain->_7years; ?></option>
	<option value ="8"><?php echo $reg_domain->_8years; ?></option>
	<option value ="9"><?php echo $reg_domain->_9years; ?></option>
	<option value ="10"><?php echo $reg_domain->_10years; ?></option>
	</select>

	</th><th>
	<input name="check" type="submit" value="<?php echo htmlentities ($reg_domain->check, ENT_COMPAT,'ISO-8859-1', true); ?> "/>
	</th>
	<th>
	</th></tr>
	</thead>
	</table>
	</form>
	<?php
	$output_string=ob_get_contents();
	ob_end_clean();
	return $output_string;
}
add_shortcode('wh_domain_form','wh_domain_form');











