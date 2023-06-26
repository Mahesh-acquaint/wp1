<?php
/**
 * Storefront engine room
 *
 * @package storefront
 */

/**
 * Assign the Storefront version to a var
 */
$theme              = wp_get_theme( 'storefront' );
$storefront_version = $theme['Version'];

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 980; /* pixels */
}

$storefront = (object) array(
	'version'    => $storefront_version,

	/**
	 * Initialize all the things.
	 */
	'main'       => require 'inc/class-storefront.php',
	'customizer' => require 'inc/customizer/class-storefront-customizer.php',
);

require 'inc/storefront-functions.php';
require 'inc/storefront-template-hooks.php';
require 'inc/storefront-template-functions.php';
require 'inc/wordpress-shims.php';

if ( class_exists( 'Jetpack' ) ) {
	$storefront->jetpack = require 'inc/jetpack/class-storefront-jetpack.php';
}

if ( storefront_is_woocommerce_activated() ) {
	$storefront->woocommerce            = require 'inc/woocommerce/class-storefront-woocommerce.php';
	$storefront->woocommerce_customizer = require 'inc/woocommerce/class-storefront-woocommerce-customizer.php';

	require 'inc/woocommerce/class-storefront-woocommerce-adjacent-products.php';

	require 'inc/woocommerce/storefront-woocommerce-template-hooks.php';
	require 'inc/woocommerce/storefront-woocommerce-template-functions.php';
	require 'inc/woocommerce/storefront-woocommerce-functions.php';
}

if ( is_admin() ) {
	$storefront->admin = require 'inc/admin/class-storefront-admin.php';

	require 'inc/admin/class-storefront-plugin-install.php';
}

/**
 * NUX
 * Only load if wp version is 4.7.3 or above because of this issue;
 * https://core.trac.wordpress.org/ticket/39610?cversion=1&cnum_hist=2
 */
if ( version_compare( get_bloginfo( 'version' ), '4.7.3', '>=' ) && ( is_admin() || is_customize_preview() ) ) {
	require 'inc/nux/class-storefront-nux-admin.php';
	require 'inc/nux/class-storefront-nux-guided-tour.php';
	require 'inc/nux/class-storefront-nux-starter-content.php';
}

/**
 * Note: Do not add any custom code here. Please use a custom plugin so that your customizations aren't lost during updates.
 * https://github.com/woocommerce/theme-customisations
 */


function blog_post_filter_vai_cat_function(){ ?>
   <style type="text/css">
    .loader
    {
        display: none;
        height: 8%;
        width: 8%;
    }
   </style> 
<div class="page-content">
    <div class="showcategory-page-section">
        <div class="container">
            <div class="blogpost-img">
                <?php 
                        $defult_arg = array(
                            'post_type'      =>'product',
                            'posts_per_page' =>9,
                            'orderby'        => 'name',
                            'order'          => 'ASC',
                            'paged'=>1,
                        );
                        $default_posts=new WP_Query($defult_arg);
                        ?>
                        <div class="category_response_show" id="category_response_show" data-count='<?php echo ceil($default_posts->found_posts/2); ?>'>
                               <div class="main-blog-box row">
                                <?php
                                if($default_posts->have_posts()){
                                    while($default_posts->have_posts()){
                                        $default_posts->the_post();
                                        $url = wp_get_attachment_url( get_post_thumbnail_id($post->ID), 'full' );
                                        ?> 
                                        <div class="three-blog col-4">
                                            <div class="inner-blogs">
                                                <div class="postbg-img" style="background-image:url('<?php echo $url; ?>')"></div>
                                                <div class="blog-content">
                                                    <h2><a href="<?php the_permalink(); ?>"><?php echo get_the_title(); ?></a></h2>
                                                </div>
                                            </div>
                                        </div>  <?php                                      
                                    }
                                }
                                wp_reset_postdata();
                            ?>
                            </div>
                        </div>
            </div>

            <div class="btn-group text-center loadmore-btndiv">
                <button class="btn btn-primary load_more" id="load_more">Load More</button>
            </div>  
        </div>
    </div> 
</div>

<!-- LOAD More Blog Script----------------------------------------------------- -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script type="text/javascript" >
    jQuery(document).ready(function($) {
            page=4;  
            var post_count=jQuery('#category_response_show').data('count');
            var aj_urlx='<?php echo admin_url('admin-ajax.php'); ?>';

        jQuery('.load_more').click(function (){
        	//alert('ok');
            jQuery.ajax({
              url  :aj_urlx,
              type : 'POST',
              data: 
              {
                'action':'my_loadmore_action',
                'page':page
              },
              beforeSend:function()
                          {
                                //jQuery('.loader').show();
                          },
              success: function(load_more_res) {
               jQuery('#category_response_show').append(load_more_res);
                   if(post_count == page){
                    jQuery('.load_more').hide();
                   }
                   page++;
                   jQuery('.loader').hide();
                   
              },
            });
         });
    });
</script> 

    <?php
}
add_shortcode('blog_post_filter_vai_cat','blog_post_filter_vai_cat_function'); 


add_action( 'wp_ajax_my_loadmore_action','my_loadmore_action_function' );
add_action( 'wp_ajax_nopriv_my_loadmore_action','my_loadmore_action_function');

function my_loadmore_action_function(){
    $page_more=$_POST['page'];
    $load_arg = array(
                       'post_type'=>'product',
                       'posts_per_page' => 3,
                       'paged'=>$page_more ,
                       'orderby'   => 'name',
                       'order'  => 'ASC',

                      );
                    $load_arg_posts=new WP_Query($load_arg);
                   echo '<div class="main-blog-box row">';     
                    if($load_arg_posts->have_posts()){
                        while($load_arg_posts->have_posts()){
                            $load_arg_posts->the_post();
                            $loadimage = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );
                             ?>
                            <div class="three-blog col-4">
                                <div class="inner-blogs">
                                    <div class="postbg-img" style="background-image: url('<?php echo $loadimage[0]; ?>');"></div>
                                    <div class="blog-content">
                                        <h2><a href="<?php the_permalink(); ?>"><?php echo get_the_title(); ?><br></a></h2>
                                    
                                    </div>
                                 </div>
                            </div>
                            <?php
                        }
                        wp_reset_postdata();
                    }
                    echo '</div> ';
    die();
}


?>