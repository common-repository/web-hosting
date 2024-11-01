<?php
/*

Version 1.5.4

*/

function clear_unused_domain_names()
{
global $woocommerce,$wpdb,$product,$x,$product_name;

$x=0;$data="";$id="";$message="";


									
	
	$args = array(
			'post_type' => 'product',
			'page_id' => '',
			'posts_per_page' => -1
			);
			
			$loop = new WP_Query( $args );
			$xx=0;$taxonomy = 'product_cat';
			if ( $loop->have_posts() ) {
			while ( $loop->have_posts() ) : $loop->the_post();
				
				$posts = $loop->posts;
				$product_id = $posts[$xx]->ID;
				
				
				
							$producttype = get_post_meta( $product_id, 'package',true);
							if (isset($producttype) && ($producttype == "domain"))
							{
								$product = wc_get_product( $product_id );
								$domain_registered = get_post_meta( $product_id, 'domain-registered',true);
								
								
								if ($domain_registered == "Active")
								{
								$product_name = $product->get_title();	
								//echo $product_name . "<br>";
								$data = wh_get_domain_order_details($product_name, $data);
								$result = json_decode($data, TRUE);
								if(isset($result['message']))
								{
								$message = $result['message'];
								}
								
									if ($message == "Website doesn't exist for " . $product_name)
									{
									update_post_meta( $product_id, 'domain-registered',"no");
									$domain_registered = "no";
									}
								
								}
								
								
								
								
								
								
								
								if ($domain_registered == "no")
								{
									$domain_in_cart = get_post_meta( $product_id, 'in_cart',true);
									if($domain_in_cart <>"yes")
									{
									
										// *************** add code to check if product is in the cart before removing it *****************
									
										foreach ( $woocommerce->cart->get_cart() as $cart_item_key => $values )
										{
											$_product = $values['data'];
											$id = $_product->get_id();
											if ($id == $product_id){break;}
										}
											if ($id <> $product_id)
											{												
										
												$time = date( 'U', strtotime( $product->get_date_created() ));
												$time_now = date('U');
												$php_time = date('H:i:s');
												$difference = $time_now - $time;
													if ($difference >3600)
													{
													wh_deleteProduct($product_id,true);
													}
											}
										
									}
								}
								
								
									
								
								
							}
							
						
			
				
				
				
				
				
			
				$xx++;
			endwhile;
		}
		
		wp_reset_postdata();
}
add_shortcode("clear_unused_domain_names","clear_unused_domain_names");










function wh_deleteProduct($product_id, $force = FALSE)
{
    $product = wc_get_product($product_id);

    if(empty($product))
        return new WP_Error(999, sprintf(__('No %s is associated with #%d', 'woocommerce'), 'product', $product_id));

    // If we're forcing, then delete permanently.
    if ($force)
    {
        if ($product->is_type('variable'))
        {
            foreach ($product->get_children() as $child_id)
            {
                $child = wc_get_product($child_id);
                $child->delete(true);
            }
        }
        elseif ($product->is_type('grouped'))
        {
            foreach ($product->get_children() as $child_id)
            {
                $child = wc_get_product($child_id);
                $child->set_parent_id(0);
                $child->save();
            }
        }

        $product->delete(true);
        $result = $product->get_id() > 0 ? false : true;
    }
    else
    {
        $product->delete();
        $result = 'trash' === $product->get_status();
    }

    if (!$result)
    {
        return new WP_Error(999, sprintf(__('This %s cannot be deleted', 'woocommerce'), 'product'));
    }

    // Delete parent product transients.
    if ($parent_id = wp_get_post_parent_id($product_id))
    {
        wc_delete_product_transients($parent_id);
    }
    return true;
}
function test()
{
$a = current_time( 'd-m-Y h:i:s');
echo $a;	
}
add_shortcode("test","test");