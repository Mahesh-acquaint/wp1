<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:

if ( !function_exists( 'chld_thm_cfg_locale_css' ) ):
    function chld_thm_cfg_locale_css( $uri ){
        if ( empty( $uri ) && is_rtl() && file_exists( get_template_directory() . '/rtl.css' ) )
            $uri = get_template_directory_uri() . '/rtl.css';
        return $uri;
    }
endif;
add_filter( 'locale_stylesheet_uri', 'chld_thm_cfg_locale_css' );

// END ENQUEUE PARENT ACTION


/*Custom code 22-6-23*/

function current_template_name() {
    global $template;
    print_r( $template );
  }
 add_action( 'wp_footer', 'current_template_name' );

 /***** Change Sale Text on Shop Page Product *****/ 

function ds_change_sale_text() {
    return '<span class="onsale"> Recent Sale! </span>';
}

add_filter('woocommerce_sale_flash', 'ds_change_sale_text');

/***** Change Add To cart Text on Shop Products Page  *****/ 

add_filter( 'woocommerce_product_add_to_cart_text', 'woocommerce_custom_product_add_to_cart_text' ); 

function woocommerce_custom_product_add_to_cart_text() {

    return __( 'Purchase Now', 'woocommerce' );

}

/***** Change Add To cart Text on Single Product Page *****/ 

add_filter( 'woocommerce_product_single_add_to_cart_text', 'woocommerce_custom_single_add_to_cart_text' );

function woocommerce_custom_single_add_to_cart_text() {

    return __( 'Buy Now', 'woocommerce' );
}

/***** Add custom Text After All Product Title   ******/

add_filter( 'the_title', 'add_custom_text_after_all_product_title', 10, 2 );
function add_custom_text_after_all_product_title( $title, $id ) {
   global $product;
   if('product' == get_post_type($id)){
        //$exclusive = get_field('exclusive', $id);   // pass the id into get_field
        $title = $title .', ' .'Custom Text added';
    }
    return $title;
}

/*************************************** Add custom Text Input Field in General Section ***************************************/

/*Add*/
function woocommerce_add_custom_field_general_section_single_product(){
    global $woocommerce, $post;
    
    //Custom Product Text Field
    woocommerce_wp_text_input(
        array(
            'id'          => 'costom_add_general_input_field',
            'label'       => __('Additional Fields<br> (input Field) : ', 'woocommerce'),
            'placeholder' => 'Add Custom custom text',
            'desc_tip'    => 'true'
        )
    );
}
add_action('woocommerce_product_options_general_product_data', 'woocommerce_add_custom_field_general_section_single_product');

/*Save*/
function woocommerce_add_custom_field_general_section_single_product_save_field($post_id){

    $product = wc_get_product( $post_id );

     $title = isset( $_POST['costom_add_general_input_field'] ) ? $_POST['costom_add_general_input_field'] : '';
     $product->update_meta_data( 'costom_add_general_input_field', sanitize_text_field( $title ) );
     $product->save();

}
add_action('woocommerce_process_product_meta', 'woocommerce_add_custom_field_general_section_single_product_save_field');

/*Display*/

function woocommerce_add_custom_input_text_field_general_section_display_field(){
    $Product_id=get_the_ID();
   
    $text_feld=get_post_meta($Product_id,'costom_add_general_input_field',true);
    if ($text_feld){
        echo $text_feld;
    }else
    {
        echo "Not set custom Field Value";
    }
}
add_action('woocommerce_single_product_summary','woocommerce_add_custom_input_text_field_general_section_display_field');


/************************************** Add custom Select Field in General Section   ***************************************/

/*Add*/

function woocommerce_add_custom_select_field_general_section_single_product() {

    global $woocommerce, $post, $product;
    woocommerce_wp_select( array(
        'id'      => 'costom_add_general_select_field',
        'label'   => __( 'Additional Fields<br> (Select) : ', 'woocommerce'),
        'options' => array(
            'Mon' => 'Monday',
            'Tue' => 'Tuesday',
            'Wed' => 'Wednesday',
            'Thu' => 'Thursday',
            'Fri' => 'Friday',
            'Sat' => 'Saturday',
            'Sun' => 'Sunday'
        ),
    ) );
}

add_action( 'woocommerce_product_options_general_product_data', 'woocommerce_add_custom_select_field_general_section_single_product' );

/*Save*/
function woo_add_custom_general_fields_save( $post_id ){

     $product = wc_get_product( $post_id );
     $title = isset( $_POST['costom_add_general_select_field'] ) ? $_POST['costom_add_general_select_field'] : '';
     $product->update_meta_data( 'costom_add_general_select_field', sanitize_text_field( $title ));
     $product->save();

}
add_action( 'woocommerce_process_product_meta', 'woo_add_custom_general_fields_save' ); 

/*Display*/

function woocommerce_add_custom_select_field_general_section(){

    global $product,$post,$woocommerce;
    echo "<br>";
    $product_id=get_the_ID();
    $select_field=get_post_meta($product_id,'costom_add_general_select_field',true);
    print_r($select_field);
}
add_action('woocommerce_single_product_summary','woocommerce_add_custom_select_field_general_section');


/************************************** Add custom Text Area Field in General Section**************************************/
/*Add*/
function woocommerce_add_custom_text_area_general_section_single_product(){

    global $woocommerce, $product, $post;
    echo "<br>";
     woocommerce_wp_textarea_input(array(
             'id'=>'costom_add_general_text_area_field',
             'label'   => __( 'Additional Fields:<br>(Text Area) : ', 'woocommerce'),
             'placeholder' => 'Add Custom Text Contents',
             'class'=>'text_area_class',
         ),
     );
}
add_action('woocommerce_product_options_general_product_data','woocommerce_add_custom_text_area_general_section_single_product');

/*Save*/
add_action('woocommerce_process_product_meta','woocommerce_save_custom_text_area_general_section_single_product');
function woocommerce_save_custom_text_area_general_section_single_product($post_id){

     $product = wc_get_product( $post_id );
     $title = isset( $_POST['costom_add_general_text_area_field'] ) ? $_POST['costom_add_general_text_area_field'] : '';
     $product->update_meta_data( 'costom_add_general_text_area_field', sanitize_text_field( $title ));
     $product->save();

}

/*Display*/
function woocommerce_add_custom_text_area_field_general_section(){

    global $product,$post,$woocommerce;
    echo "<br>";
    $product_id=get_the_ID();
    $select_field=get_post_meta($product_id,'costom_add_general_text_area_field',true);
    print_r($select_field);
}
add_action('woocommerce_single_product_summary','woocommerce_add_custom_text_area_field_general_section');

/************************************** Add custom Check Box Field in General Section**************************************/