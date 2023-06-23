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


/*******************************************************Custom code 22-6-23**********************************************************/

function custom_js_css_files() {
    wp_enqueue_style( 'jquery_min_cc',get_stylesheet_directory_uri() . '/assets/css/bootstrap.min.css' );
    wp_enqueue_style( 'custom_css',get_stylesheet_directory_uri() . '/assets/css/custom.css' );
    wp_enqueue_script('jquery_min_js',get_stylesheet_directory_uri() . '/assets/js/jquery.min.js',array('jquery'));
    wp_enqueue_script('bootstrap_min_js',get_stylesheet_directory_uri() . '/assets/js/bootstrap.min.js',array('jquery'));
    wp_enqueue_script('custom_js',get_stylesheet_directory_uri() . '/assets/js/custom.js',array('jquery'));
}

add_action( 'wp_enqueue_scripts', 'custom_js_css_files' );


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
/*Input Text Field*/
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
        echo "<b>General Input:</b> ";
        echo $text_feld;
    }else
    {
        echo "Not set custom Field Value";
    }
}
add_action('woocommerce_single_product_summary','woocommerce_add_custom_input_text_field_general_section_display_field');


/************************************** Add custom Select Field in General Section   ***************************************/
/*Input Select Field*/
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
    echo "<b>General Select:</b> ";
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
function woocommerce_save_custom_text_area_general_section_single_product($post_id){

     $product = wc_get_product( $post_id );
     $title = isset( $_POST['costom_add_general_text_area_field'] ) ? $_POST['costom_add_general_text_area_field'] : '';
     $product->update_meta_data( 'costom_add_general_text_area_field', sanitize_text_field( $title ));
     $product->save();
}
add_action('woocommerce_process_product_meta','woocommerce_save_custom_text_area_general_section_single_product');
/*Display*/
function woocommerce_display_custom_text_area_field_general_section(){

    global $product,$post,$woocommerce;
    echo "<br>";
    $product_id=get_the_ID();
    $text_area_field=get_post_meta($product_id,'costom_add_general_text_area_field',true);
    echo "<b>General Textarea:</b> ";
    print_r($text_area_field);
}
add_action('woocommerce_single_product_summary','woocommerce_display_custom_text_area_field_general_section');

/************************************** Add custom Check Box Field in General Section**************************************/
/*Check Box Field*/
/*ADD*/
function woocommerce_add_custom_checkbox_general_section_single_product(){
    woocommerce_wp_checkbox(array(
        'id'=>'costom_add_general_checkbox_field',
        'label'=>__('Additional Fields:<br>(checkbox) :','woocommerce'),
        'class'=>'checkbox_class',
    ));
}
add_action('woocommerce_product_options_general_product_data','woocommerce_add_custom_checkbox_general_section_single_product');

/*Save*/
function woocommerce_save_custom_checkbox_general_section_single_product($post_id){

    $super = isset( $_POST[ 'costom_add_general_checkbox_field' ] ) && 'yes' === $_POST[ 'costom_add_general_checkbox_field' ] ? 'yes' : 'no';
    update_post_meta( $post_id, 'costom_add_general_checkbox_field', $super );    
}
add_action('woocommerce_process_product_meta','woocommerce_save_custom_checkbox_general_section_single_product');
/*Display*/
function woocommerce_display_custom_checkbox_field_general_section(){
    global $post,$product,$woocommerce;
    echo "<br>";
    $product_id=get_the_ID();
    $checkbox_field=get_post_meta($product_id,'costom_add_general_checkbox_field',true);
    echo "<b>General Checkbox:</b> ";
    print_r($checkbox_field);
}
add_action('woocommerce_single_product_summary','woocommerce_display_custom_checkbox_field_general_section');

/************************************** Add custom Redio Button Field in General Section**************************************/
/*Radio Field*/
/*ADD*/
function woocommerce_add_custom_radio_button_general_section_single_product(){
    woocommerce_wp_radio(array(
        'id'=>'costom_add_general_radio_button_field',
        //'label'=>__('Additional Fields:<br>(Radio Botton) :','woocommerce'),
        'class'=>'radio_class',
        'options' => array(
                '10 days'    => '10 days',
                '15 days'    => '15 days',
                '30 days'    => '30 days',
             ),
    ));
}
add_action('woocommerce_product_options_general_product_data','woocommerce_add_custom_radio_button_general_section_single_product');
/*Save*/
function woocommerce_save_custom_radio_button_general_section_single_product($post_id){

    $product = wc_get_product( $post_id );
    $title = isset( $_POST['costom_add_general_radio_button_field'] ) ? $_POST['costom_add_general_radio_button_field'] : '';
    $product->update_meta_data( 'costom_add_general_radio_button_field', sanitize_text_field( $title ));
    $product->save();
}
add_action('woocommerce_process_product_meta','woocommerce_save_custom_radio_button_general_section_single_product');

/*Display*/
function woocommerce_display_custom_radio_btn_field_general_section(){
    global $post,$woocommerce,$product;
    echo "<br>";
    $product_id=get_the_ID();
    $radio_btn_value=get_post_meta($product_id,'costom_add_general_radio_button_field',true);
    echo "<b>General Redio:</b> ";
    print_r($radio_btn_value);
}
add_action('woocommerce_single_product_summary','woocommerce_display_custom_radio_btn_field_general_section');


/*************************************** Add custom Text Input Field in Inventory Section ***************************************/
/*Input Text Field*/
/*Add*/
function woocommerce_product_options_inventory_section_add_input_field(){
    woocommerce_wp_text_input(array(
        'id'=>'costom_add_inventory_input_text_field',
        'label'=>__('Additional Fields:<br>(Input Field):','woocommerce'),
        'class'=>'inventory_input_field',
    ));
}
add_action('woocommerce_product_options_inventory_product_data','woocommerce_product_options_inventory_section_add_input_field');

/*Save*/
function woocommerce_add_custom_input_text_inventory_section_single_product_save($post_id){
    $product = wc_get_product( $post_id );
    $title = isset( $_POST['costom_add_inventory_input_text_field'] ) ? $_POST['costom_add_inventory_input_text_field'] : '';
    $product->update_meta_data( 'costom_add_inventory_input_text_field', sanitize_text_field( $title ));
    $product->save();
}
add_action('woocommerce_process_product_meta','woocommerce_add_custom_input_text_inventory_section_single_product_save');

/*Display*/
function woocommerce_display_custom_input_text_field_inventoy_section(){
    global $woocommerce, $product, $post;
    echo "<br>";
    $product_id=get_the_ID();
    $display_inventory_val=get_post_meta($product_id,'costom_add_inventory_input_text_field',true);
    echo "<b>Inventory Input Field :</b> ";
    print_r($display_inventory_val);
}
add_action('woocommerce_single_product_summary','woocommerce_display_custom_input_text_field_inventoy_section');

/*Input Select Field*/
function woocommerce_add_custom_select_field_inventory_section_single_product() {

    global $woocommerce, $post, $product;
    woocommerce_wp_select( array(
        'id'      => 'costom_add_inventory_select_field',
        'label'   => __( 'Additional Fields<br> (Select) : ', 'woocommerce'),
        'options' => array(
            'January' => 'January ',
            'February' => 'February',
            'March' => 'March',
            'April' => 'April',
            'May' => 'May',
            'June' => 'June',
            'July' => 'July',
            'August' => 'August',
            'September' => 'September',
            'October' => 'October',
            'November' => 'November',
            'December' => 'December',
        ),
    ) );
}
add_action( 'woocommerce_product_options_inventory_product_data', 'woocommerce_add_custom_select_field_inventory_section_single_product');

/*Save*/
function woocommerce_save_custom_input_text_inventory_section_single_product_save($post_id){
    $product = wc_get_product( $post_id );
    $title = isset( $_POST['costom_add_inventory_select_field'] ) ? $_POST['costom_add_inventory_select_field'] : '';
    $product->update_meta_data( 'costom_add_inventory_select_field', sanitize_text_field( $title ));
    $product->save();
}
add_action('woocommerce_process_product_meta','woocommerce_save_custom_input_text_inventory_section_single_product_save');
/*Display*/
function woocommerce_display_custom_select_field_inventoy_section(){
    global $woocommerce, $product, $post;
    echo "<br>";
    $product_id=get_the_ID();
    $display_inventory_val=get_post_meta($product_id,'costom_add_inventory_select_field',true);
    echo "<b>Month:</b> ";
    print_r($display_inventory_val);
}
add_action('woocommerce_single_product_summary','woocommerce_display_custom_select_field_inventoy_section');

/*Input Text Area Field*/

/*Add*/
function woocommerce_add_custom_text_area_inventory_section_single_product(){

    global $woocommerce, $product, $post;
    echo "<br>";
     woocommerce_wp_textarea_input(array(
             'id'=>'costom_add_inventory_text_area_field',
             'label'   => __( 'Additional Fields:<br>(Text Area) : ', 'woocommerce'),
             'placeholder' => 'Add Custom Text Contents',
             'class'=>'text_area_class',
         ),
     );
}
add_action('woocommerce_product_options_inventory_product_data','woocommerce_add_custom_text_area_inventory_section_single_product');

/*Save*/
function woocommerce_save_custom_text_area_inventory_section_single_product($post_id){

     $product = wc_get_product( $post_id );
     $title = isset( $_POST['costom_add_inventory_text_area_field'] ) ? $_POST['costom_add_inventory_text_area_field'] : '';
     $product->update_meta_data( 'costom_add_inventory_text_area_field', sanitize_text_field( $title ));
     $product->save();
}
add_action('woocommerce_process_product_meta','woocommerce_save_custom_text_area_inventory_section_single_product');
/*Display*/
function woocommerce_display_custom_text_area_field_inventory_section(){

    global $product,$post,$woocommerce;
    echo "<br>";
    $product_id=get_the_ID();
    $text_area_field=get_post_meta($product_id,'costom_add_inventory_text_area_field',true);
    echo "<b>Inventory Text Area:</b> ";
    print_r($text_area_field);
}
add_action('woocommerce_single_product_summary','woocommerce_display_custom_text_area_field_inventory_section');

/*Check Box Field*/

/*ADD*/
function woocommerce_add_custom_checkbox_inventory_section_single_product(){
    woocommerce_wp_checkbox(array(
        'id'=>'costom_add_inventoy_checkbox_field',
        'label'=>__('Additional Fields:<br>(checkbox) :','woocommerce'),
        'class'=>'checkbox_class',
    ));
}
add_action('woocommerce_product_options_inventory_product_data','woocommerce_add_custom_checkbox_inventory_section_single_product');

/*Save*/
function woocommerce_save_custom_checkbox_inventoy_section_single_product($post_id){

    $super = isset( $_POST[ 'costom_add_inventoy_checkbox_field' ] ) && 'yes' === $_POST[ 'costom_add_inventoy_checkbox_field' ] ? 'yes' : 'no';
    update_post_meta( $post_id, 'costom_add_inventoy_checkbox_field', $super );    
}
add_action('woocommerce_process_product_meta','woocommerce_save_custom_checkbox_inventoy_section_single_product');
/*Display*/
function woocommerce_display_custom_checkbox_field_inventory_section(){
    global $post,$product,$woocommerce;
    echo "<br>";
    $product_id=get_the_ID();
    $checkbox_field=get_post_meta($product_id,'costom_add_inventoy_checkbox_field',true);
    echo "<b>Inventory Checkbox :</b>";
    print_r($checkbox_field);
}
add_action('woocommerce_single_product_summary','woocommerce_display_custom_checkbox_field_inventory_section');

/*Radio Button Field*/

/*ADD*/
function woocommerce_add_custom_radio_button_inventory_section_single_product(){
    woocommerce_wp_radio(array(
        'id'=>'costom_add_inventory_radio_button_field',
        //'label'=>__('Additional Fields:<br>(Radio Botton) :','woocommerce'),
        'class'=>'radio_class',
        'options' => array(
                'Male'    => 'Male',
                'Female' => 'Female',
                'other' => 'Other',
             ),
    ));
}
add_action('woocommerce_product_options_inventory_product_data','woocommerce_add_custom_radio_button_inventory_section_single_product');

/*Save*/
function woocommerce_save_custom_radio_button_inventory_section_single_product($post_id){

    $product = wc_get_product( $post_id );
    $title = isset( $_POST['costom_add_inventory_radio_button_field'] ) ? $_POST['costom_add_inventory_radio_button_field'] : '';
    $product->update_meta_data( 'costom_add_inventory_radio_button_field', sanitize_text_field( $title ));
    $product->save();
}
add_action('woocommerce_process_product_meta','woocommerce_save_custom_radio_button_inventory_section_single_product');

/*Display*/
function woocommerce_display_custom_radio_btn_field_inventory_section(){
    global $post,$woocommerce,$product;
    echo "<br>";
    $product_id=get_the_ID();
    $radio_btn_value=get_post_meta($product_id,'costom_add_inventory_radio_button_field',true);
    echo "<b>Inventory Redio : </b>";
    print_r($radio_btn_value);
}
add_action('woocommerce_single_product_summary','woocommerce_display_custom_radio_btn_field_inventory_section');


/*************************************** Add custom Text Input Field in Linked Products ***************************************/
/*Input Text Field*/
/*Add*/
function woocommerce_add_custom_field_link_product_section_single_product(){
    global $woocommerce, $post;
    
    //Custom Product Text Field
    woocommerce_wp_text_input(
        array(
            'id'          => 'costom_add_link_product_input_field',
            'label'       => __('Additional Fields<br> (input Field) : ', 'woocommerce'),
            'placeholder' => 'Add Custom custom text',
            'desc_tip'    => 'true'
        )
    );
}
add_action('woocommerce_product_options_related', 'woocommerce_add_custom_field_link_product_section_single_product');

/*Save*/
function woocommerce_save_custom_input_text_product_link_section_single_product($post_id){

    $product = wc_get_product( $post_id );
    $title = isset( $_POST['costom_add_link_product_input_field'] ) ? $_POST['costom_add_link_product_input_field'] : '';
    $product->update_meta_data( 'costom_add_link_product_input_field', sanitize_text_field( $title ));
    $product->save();
}
add_action('woocommerce_process_product_meta','woocommerce_save_custom_input_text_product_link_section_single_product');

/*Display*/
function woocommerce_display_custom_input_field_link_product_section(){
    global $post,$woocommerce,$product;
    echo "<br>";
    $product_id=get_the_ID();
    $radio_btn_value=get_post_meta($product_id,'costom_add_link_product_input_field',true);
    echo "<b>Link Product Input  : </b>";
    print_r($radio_btn_value);
}
add_action('woocommerce_single_product_summary','woocommerce_display_custom_input_field_link_product_section');

/*Select Field*/
function woocommerce_add_custom_select_field_linked_product_section_single_product() {

    global $woocommerce, $post, $product;
    woocommerce_wp_select( array(
        'id'      => 'costom_add_linked_product_select_field',
        'label'   => __( 'Additional Fields<br> (Select) : ', 'woocommerce'),
        'options' => array(
            'January' => 'January ',
            'February' => 'February',
            'March' => 'March',
            'April' => 'April',
            'May' => 'May',
            'June' => 'June',
            'July' => 'July',
            'August' => 'August',
            'September' => 'September',
            'October' => 'October',
            'November' => 'November',
            'December' => 'December',
        ),
    ) );
}
add_action( 'woocommerce_product_options_related', 'woocommerce_add_custom_select_field_linked_product_section_single_product');

/*Save*/
function woocommerce_save_custom_input_text_linked_product_section_single_product_save($post_id){
    $product = wc_get_product( $post_id );
    $title = isset( $_POST['costom_add_linked_product_select_field'] ) ? $_POST['costom_add_linked_product_select_field'] : '';
    $product->update_meta_data( 'costom_add_linked_product_select_field', sanitize_text_field( $title ));
    $product->save();
}
add_action('woocommerce_process_product_meta','woocommerce_save_custom_input_text_linked_product_section_single_product_save');
/*Display*/
function woocommerce_display_custom_select_field_linked_product_section(){
    global $woocommerce, $product, $post;
    echo "<br>";
    $product_id=get_the_ID();
    $display_inventory_val=get_post_meta($product_id,'costom_add_linked_product_select_field',true);
    echo "<b>Linked Product Select:</b> ";
    print_r($display_inventory_val);
}
add_action('woocommerce_single_product_summary','woocommerce_display_custom_select_field_linked_product_section');


/*Input Text Area Field*/

/*Add*/
function woocommerce_add_custom_text_area_linked_product_section_single_product(){

    global $woocommerce, $product, $post;
    echo "<br>";
     woocommerce_wp_textarea_input(array(
             'id'=>'costom_add_linked_text_area_field',
             'label'   => __( 'Additional Fields:<br>(Text Area) : ', 'woocommerce'),
             'placeholder' => 'Add Custom Text Contents',
             'class'=>'text_area_class',
         ),
     );
}
add_action('woocommerce_product_options_related','woocommerce_add_custom_text_area_linked_product_section_single_product');

/*Save*/
function woocommerce_save_custom_text_area_linked_product_section_single_product($post_id){

     $product = wc_get_product( $post_id );
     $title = isset( $_POST['costom_add_linked_text_area_field'] ) ? $_POST['costom_add_linked_text_area_field'] : '';
     $product->update_meta_data( 'costom_add_linked_text_area_field', sanitize_text_field( $title ));
     $product->save();
}
add_action('woocommerce_process_product_meta','woocommerce_save_custom_text_area_linked_product_section_single_product');
/*Display*/
function woocommerce_display_custom_text_area_field_linked_product_section(){

    global $product,$post,$woocommerce;
    echo "<br>";
    $product_id=get_the_ID();
    $text_area_field=get_post_meta($product_id,'costom_add_linked_text_area_field',true);
    echo "<b>Linked Product Text Area:</b> ";
    print_r($text_area_field);
}
add_action('woocommerce_single_product_summary','woocommerce_display_custom_text_area_field_linked_product_section');

/*Check Box Field*/

/*ADD*/
function woocommerce_add_custom_checkbox_linked_product_section_single_product(){
    woocommerce_wp_checkbox(array(
        'id'=>'costom_add_linked_product_checkbox_field',
        'label'=>__('Additional Fields:<br>(checkbox) :','woocommerce'),
        'class'=>'checkbox_class',
    ));
}
add_action('woocommerce_product_options_related','woocommerce_add_custom_checkbox_linked_product_section_single_product');
/*Save*/
function woocommerce_save_custom_checkbox_linked_product_section_single_product($post_id){

    $super = isset( $_POST[ 'costom_add_linked_product_checkbox_field' ] ) && 'yes' === $_POST[ 'costom_add_linked_product_checkbox_field' ] ? 'yes' : 'no';
    update_post_meta( $post_id, 'costom_add_linked_product_checkbox_field', $super );    
}
add_action('woocommerce_process_product_meta','woocommerce_save_custom_checkbox_linked_product_section_single_product');
/*Display*/
function woocommerce_display_custom_checkbox_field_linked_product_section(){
    global $post,$product,$woocommerce;
    echo "<br>";
    $product_id=get_the_ID();
    $checkbox_field=get_post_meta($product_id,'costom_add_linked_product_checkbox_field',true);
    echo "<b>Linked Product Checkbox :</b>";
    print_r($checkbox_field);
}
add_action('woocommerce_single_product_summary','woocommerce_display_custom_checkbox_field_linked_product_section');

/*Radio Button Field*/

/*ADD*/
function woocommerce_add_custom_radio_button_linked_product_section_single_product(){
    woocommerce_wp_radio(array(
        'id'=>'costom_add_linked_radio_button_field',
        //'label'=>__('Additional Fields:<br>(Radio Botton) :','woocommerce'),
        'class'=>'radio_class',
        'options' => array(
                'India'    => 'India',
                'Mp' => 'Mp',
                'Mh' => 'Mh',
                'Dhl'=>'Dhl'
             ),
    ));
}
add_action('woocommerce_product_options_related','woocommerce_add_custom_radio_button_linked_product_section_single_product');

/*Save*/
function woocommerce_save_custom_radio_button_linked_product_section_single_product($post_id){

    $product = wc_get_product( $post_id );
    $title = isset( $_POST['costom_add_linked_radio_button_field'] ) ? $_POST['costom_add_linked_radio_button_field'] : '';
    $product->update_meta_data( 'costom_add_linked_radio_button_field', sanitize_text_field( $title ));
    $product->save();
}
add_action('woocommerce_process_product_meta','woocommerce_save_custom_radio_button_linked_product_section_single_product');

/*Display*/
function woocommerce_display_custom_radio_btn_field_linked_section(){
    global $post,$woocommerce,$product;
    echo "<br>";
    $product_id=get_the_ID();
    $radio_btn_value=get_post_meta($product_id,'costom_add_linked_radio_button_field',true);
    echo "<b>Linked Product Redio : </b>";
    print_r($radio_btn_value);
}
add_action('woocommerce_single_product_summary','woocommerce_display_custom_radio_btn_field_linked_section');



/*************************************** Add custom Text Input Field in Attributes Section ***************************************/
/*Input Text Field*/
/*Add*/
function woocommerce_add_custom_field_attributes_section_single_product(){
    global $woocommerce, $post;
    
    //Custom Product Text Field
    woocommerce_wp_text_input(
        array(
            'id'          => 'costom_add_attributes_input_field',
            'label'       => __('Additional Fields<br> (input Field) : ', 'woocommerce'),
            'placeholder' => 'Add Custom custom text',
            'desc_tip'    => 'true'
        )
    );
}
add_action('woocommerce_product_options_attributes', 'woocommerce_add_custom_field_attributes_section_single_product');
/*Save*/
function woocommerce_save_custom_input_text_attributes_section_single_product($post_id){

    $product = wc_get_product( $post_id );
    $title = isset( $_POST['costom_add_attributes_input_field'] ) ? $_POST['costom_add_attributes_input_field'] : '';
    $product->update_meta_data( 'costom_add_attributes_input_field', sanitize_text_field( $title ));
    $product->save();
}
add_action('woocommerce_process_product_meta','woocommerce_save_custom_input_text_attributes_section_single_product');
/*Display*/
function woocommerce_display_custom_input_text_field_attributes_section(){
    global $post,$woocommerce,$product;
    echo "<br>";
    $product_id=get_the_ID();
    $radio_btn_value=get_post_meta($product_id,'costom_add_attributes_input_field',true);
    echo "<b>Attributes Input : </b>";
    print_r($radio_btn_value);
}
add_action('woocommerce_single_product_summary','woocommerce_display_custom_input_text_field_attributes_section');

/*Select Field*/
function woocommerce_add_custom_select_field_attribute_section_single_product() {

    global $woocommerce, $post, $product;
    woocommerce_wp_select( array(
        'id'      => 'costom_add_attribute_select_field',
        'label'   => __( 'Additional Fields<br> (Select) &nbsp; : ', 'woocommerce'),
        'options' => array(
            'Summer' => 'Summer ',
            'Moonsoon' => 'Moonsoon',
            'Winter' => 'Winter',
        ),
    ) );
}
add_action( 'woocommerce_product_options_attributes', 'woocommerce_add_custom_select_field_attribute_section_single_product');
/*Save*/
function woocommerce_save_custom_attributes_select_section_single($post_id){
    $product = wc_get_product( $post_id );
    $title = isset( $_POST['costom_add_attribute_select_field'] ) ? $_POST['costom_add_attribute_select_field'] : '';
    $product->update_meta_data( 'costom_add_attribute_select_field', sanitize_text_field( $title ));
    $product->save();
}
add_action('woocommerce_process_product_meta','woocommerce_save_custom_attributes_select_section_single');
/*Display*/
function woocommerce_display_custom_select_field_attribute_section(){
    global $woocommerce, $product, $post;
    echo "<br>";
    $product_id=get_the_ID();
    $display_inventory_val=get_post_meta($product_id,'costom_add_attribute_select_field',true);
    echo "<b>Attributes Select:</b> ";
    print_r($display_inventory_val);
}
add_action('woocommerce_single_product_summary','woocommerce_display_custom_select_field_attribute_section');

/*Input Text Area Field*/

/*Add*/
function woocommerce_add_custom_text_area_attribute_section_single_product(){

    global $woocommerce, $product, $post;
    echo "<br>";
     woocommerce_wp_textarea_input(array(
             'id'=>'costom_add_attributes_text_area_field',
             'label'   => __( 'Additional Fields:<br>(Text Area) : ', 'woocommerce'),
             'placeholder' => 'Add Custom Text Contents',
             'class'=>'text_area_class',
         ),
     );
}
add_action('woocommerce_product_options_attributes','woocommerce_add_custom_text_area_attribute_section_single_product');

/*Save*/
function woocommerce_save_custom_text_area_attaribute_section_single_product($post_id){

     $product = wc_get_product( $post_id );
     $title = isset( $_POST['costom_add_attributes_text_area_field'] ) ? $_POST['costom_add_attributes_text_area_field'] : '';
     $product->update_meta_data( 'costom_add_attributes_text_area_field', sanitize_text_field( $title ));
     $product->save();
}
add_action('woocommerce_process_product_meta','woocommerce_save_custom_text_area_attaribute_section_single_product');
/*Display*/
function woocommerce_display_custom_text_area_field_attributes_section(){

    global $product,$post,$woocommerce;
    echo "<br>";
    $product_id=get_the_ID();
    $text_area_field=get_post_meta($product_id,'costom_add_attributes_text_area_field',true);
    if ($text_area_field) {
      echo "<b>Attributes Text Area:</b> ";
      print_r($text_area_field); 
    }
}
add_action('woocommerce_single_product_summary','woocommerce_display_custom_text_area_field_attributes_section');

/*Check Box Field*/

/*ADD*/
function woocommerce_add_custom_checkbox_attributes_section_single_product(){
    woocommerce_wp_checkbox(array(
        'id'=>'costom_add_attributes_checkbox_field',
        'label'=>__('Additional Fields:<br>(checkbox) :','woocommerce'),
        'class'=>'checkbox_class',
    ));
}
add_action('woocommerce_product_options_attributes','woocommerce_add_custom_checkbox_attributes_section_single_product');
/*Save*/
function woocommerce_save_custom_checkbox_attributes_section_single_product($post_id){
    $super = isset( $_POST[ 'costom_add_attributes_checkbox_field' ] ) && 'yes' === $_POST[ 'costom_add_attributes_checkbox_field' ] ? 'yes' : 'no';
    update_post_meta( $post_id, 'costom_add_attributes_checkbox_field', $super );    
}
add_action('woocommerce_process_product_meta','woocommerce_save_custom_checkbox_attributes_section_single_product');
/*Display*/
function woocommerce_display_custom_checkbox_field_attributes_section(){
    global $post,$product,$woocommerce;
    echo "<br>";
    $product_id=get_the_ID();
    $checkbox_field=get_post_meta($product_id,'costom_add_attributes_checkbox_field',true);
    if ($checkbox_field) {
        echo "<b>Attributes Checkbox :</b>";
        print_r($checkbox_field);
    }
}
add_action('woocommerce_single_product_summary','woocommerce_display_custom_checkbox_field_attributes_section');

/*Radio Button Field*/

/*ADD*/
function woocommerce_add_custom_radio_button_attributes_section_single_product(){
    woocommerce_wp_radio(array(
        'id'=>'costom_add_attributes_radio_button_field',
        'label'=>__('Additional Fields:<br>(Radio Botton) :','woocommerce'),
        'class'=>'radio_class',
        'options' => array(
                'India'    => 'India',
                'Mp' => 'Mp',
                'Mh' => 'Mh',
                'Dhl'=>'Dhl'
             ),
    ));
}
add_action('woocommerce_product_options_attributes','woocommerce_add_custom_radio_button_attributes_section_single_product');

/*Save*/
function woocommerce_save_custom_radio_button_attributes_section_single_product($post_id){

    $product = wc_get_product( $post_id );
    $title = isset( $_POST['costom_add_attributes_radio_button_field'] ) ? $_POST['costom_add_attributes_radio_button_field'] : '';
    $product->update_meta_data( 'costom_add_attributes_radio_button_field', sanitize_text_field( $title ));
    $product->save();
}
add_action('woocommerce_process_product_meta','woocommerce_save_custom_radio_button_attributes_section_single_product');

/*Display*/
function woocommerce_display_custom_radio_btn_field_attributes_section(){
    global $post,$woocommerce,$product;
    echo "<br>";
    $product_id=get_the_ID();
    $radio_btn_value=get_post_meta($product_id,'costom_add_attributes_radio_button_field',true);
    if($radio_btn_value){
       echo "<b>Attributes Redio : </b>";
       print_r($radio_btn_value);
    }
}
add_action('woocommerce_single_product_summary','woocommerce_display_custom_radio_btn_field_attributes_section');


/*************************************** Add custom Text Input Field in Advanced Section ***************************************/

/*Input Text Field*/
/*Add*/
function woocommerce_add_custom_input_field_advanced_section_single_product(){
    global $woocommerce, $post;
    
    //Custom Product Text Field
    woocommerce_wp_text_input(
        array(
            'id'          => 'costom_add_advanced_input_field',
            'label'       => __('Additional Fields<br> (input Field) : ', 'woocommerce'),
            'placeholder' => 'Add Custom custom text',
            'desc_tip'    => 'true'
        )
    );
}
add_action('woocommerce_product_options_advanced', 'woocommerce_add_custom_input_field_advanced_section_single_product');

/*Save*/
function woocommerce_save_custom_advanced_select_section_single($post_id){
    $product = wc_get_product( $post_id );
    $title = isset( $_POST['costom_add_advanced_input_field'] ) ? $_POST['costom_add_advanced_input_field'] : '';
    $product->update_meta_data( 'costom_add_advanced_input_field', sanitize_text_field( $title ));
    $product->save();
}
add_action('woocommerce_process_product_meta','woocommerce_save_custom_advanced_select_section_single');

/*Display*/
function woocommerce_display_custom_select_field_advanced_section(){
    global $woocommerce, $product, $post;
    echo "<br>";
    $product_id=get_the_ID();
    $display_advanced_val=get_post_meta($product_id,'costom_add_advanced_input_field',true);
    echo "<b>Addvanced Input:</b> ";
    print_r($display_advanced_val);
}
add_action('woocommerce_single_product_summary','woocommerce_display_custom_select_field_advanced_section');

// /*Select Field*/
/*Add*/
function woocommerce_add_custom_select_field_advanced_section_single_product() {

    global $woocommerce, $post, $product;
    woocommerce_wp_select( array(
        'id'      => 'costom_add_advanced_select_field',
        'label'   => __( 'Additional Fields<br> (Select) &nbsp; : ', 'woocommerce'),
        'options' => array(
            'HP' => 'HP ',
            'Lenovo' => 'Lenovo',
            'MAC' => 'MAC',
            'Dell' => 'Dell',
        ),
    ) );
}
add_action( 'woocommerce_product_options_advanced', 'woocommerce_add_custom_select_field_advanced_section_single_product');
/*Save*/
function woocommerce_save_custom_advanced_select_section($post_id){
    $product = wc_get_product( $post_id );
    $title = isset( $_POST['costom_add_advanced_select_field'] ) ? $_POST['costom_add_advanced_select_field'] : '';
    $product->update_meta_data( 'costom_add_advanced_select_field', sanitize_text_field( $title ));
    $product->save();
}
add_action('woocommerce_process_product_meta','woocommerce_save_custom_advanced_select_section');
/*Display*/
function woocommerce_display_custom_select_field_in_advanced_section(){
    global $woocommerce, $product, $post;
    echo "<br>";
    $product_id=get_the_ID();
    $display_inventory_val=get_post_meta($product_id,'costom_add_advanced_select_field',true);
    if($display_inventory_val) {
        echo "<b>Advanced Select:</b> ";
        print_r($display_inventory_val);
    }
}
add_action('woocommerce_single_product_summary','woocommerce_display_custom_select_field_in_advanced_section');

/*Input Text Area Field*/

// /*Add*/
function woocommerce_add_custom_text_area_advanced_section_single_product(){

    global $woocommerce, $product, $post;
    echo "<br>";
     woocommerce_wp_textarea_input(array(
             'id'=>'costom_add_addvanced_text_area_field',
             'label'   => __( 'Additional Fields:<br>(Text Area) : ', 'woocommerce'),
             'placeholder' => 'Add Custom Text Contents',
             'class'=>'text_area_class',
         ),
     );
}
add_action('woocommerce_product_options_advanced','woocommerce_add_custom_text_area_advanced_section_single_product');

// /*Save*/
function woocommerce_save_custom_text_area_advanced_section_single_product($post_id){

     $product = wc_get_product( $post_id );
     $title = isset( $_POST['costom_add_addvanced_text_area_field'] ) ? $_POST['costom_add_addvanced_text_area_field'] : '';
     $product->update_meta_data( 'costom_add_addvanced_text_area_field', sanitize_text_field( $title ));
     $product->save();
}
add_action('woocommerce_process_product_meta','woocommerce_save_custom_text_area_advanced_section_single_product');
/*Display*/
function woocommerce_display_custom_text_area_field_advanced_section(){

    global $product,$post,$woocommerce;
    echo "<br>";
    $product_id=get_the_ID();
    $text_area_field=get_post_meta($product_id,'costom_add_addvanced_text_area_field',true);
    if ($text_area_field) {
      echo "<b>Advanced Text Area:</b> ";
      print_r($text_area_field); 
    }
}
add_action('woocommerce_single_product_summary','woocommerce_display_custom_text_area_field_advanced_section');

// /*Check Box Field*/

/*ADD*/
function woocommerce_add_custom_checkbox_advanced_section_single_product(){
    woocommerce_wp_checkbox(array(
        'id'=>'costom_add_advanced_checkbox_field',
        'label'=>__('Additional Fields:<br>(checkbox) :','woocommerce'),
        'class'=>'checkbox_class',
    ));
}
add_action('woocommerce_product_options_advanced','woocommerce_add_custom_checkbox_advanced_section_single_product');
/*Save*/
function woocommerce_save_custom_checkbox_advanced_section_single_product($post_id){
    $super = isset( $_POST[ 'costom_add_advanced_checkbox_field' ] ) && 'yes' === $_POST[ 'costom_add_advanced_checkbox_field' ] ? 'yes' : 'no';
    update_post_meta( $post_id, 'costom_add_advanced_checkbox_field', $super );    
}
add_action('woocommerce_process_product_meta','woocommerce_save_custom_checkbox_advanced_section_single_product');
/*Display*/
function woocommerce_display_custom_checkbox_field_advanced_section(){
    global $post,$product,$woocommerce;
    echo "<br>";
    $product_id=get_the_ID();
    $checkbox_field=get_post_meta($product_id,'costom_add_advanced_checkbox_field',true);
    if ($checkbox_field){
        echo "<b>Attributes Checkbox :</b>";
        print_r($checkbox_field);
    }
}
add_action('woocommerce_single_product_summary','woocommerce_display_custom_checkbox_field_advanced_section');

/*Radio Button Field*/

/*ADD*/
function woocommerce_add_custom_radio_button_advanced_section_single_product(){
    woocommerce_wp_radio(array(
        'id'=>'costom_add_advanced_radio_button_field',
       // 'label'=>__('Additional Fields:<br>(Radio Botton) :','woocommerce'),
        'class'=>'radio_class',
        'options' => array(
                'Kasol'    => 'Kasol',
                'Simla' => 'Simla',
                'Manali' => 'Manali',
                'Leh'=>'Leh'
             ),
    ));
}
add_action('woocommerce_product_options_advanced','woocommerce_add_custom_radio_button_advanced_section_single_product');

/*Save*/
function woocommerce_save_custom_radio_button_advanced_section_single_product($post_id){

    $product = wc_get_product( $post_id );
    $title = isset( $_POST['costom_add_advanced_radio_button_field'] ) ? $_POST['costom_add_advanced_radio_button_field'] : '';
    $product->update_meta_data( 'costom_add_advanced_radio_button_field', sanitize_text_field( $title ));
    $product->save();
}
add_action('woocommerce_process_product_meta','woocommerce_save_custom_radio_button_advanced_section_single_product');

/*Display*/
function woocommerce_display_custom_radio_btn_field_advanced_section(){
    global $post,$woocommerce,$product;
    echo "<br>";
    $product_id=get_the_ID();
    $radio_btn_value=get_post_meta($product_id,'costom_add_advanced_radio_button_field',true);
    if($radio_btn_value){
       echo "<b>Attributes Redio : </b>";
       print_r($radio_btn_value);
    }
}
add_action('woocommerce_single_product_summary','woocommerce_display_custom_radio_btn_field_advanced_section');


/*************************************** Add New Custom Tab Section (Custom Panel) ***************************************/

function my_custom_tab_action() {
  ?>
  <li class="custom_tab">
    <a href="#the_custom_panel">
      <span><?php _e( 'My Additional Custom Tab', 'wp1' ); ?></span>
    </a>
  </li>
  <?php
}
add_action( 'woocommerce_product_write_panel_tabs', 'my_custom_tab_action' );

/*************************************** Add New Custom Tab Section Fileds ***************************************/
function custom_tab_panel() {
    global $woocommerce, $post, $product;
  ?>
  <div id="the_custom_panel" class="panel woocommerce_options_panel">
    <div class="options_group">
      <?php
         woocommerce_wp_text_input(array(
                'id'          => 'my_custom_tab_input_text_field',
                'label'       => __('Additional Fields<br> (input Field New Tab) : ', 'woocommerce'),
                'placeholder' => 'Add Custom custom text',
                'desc_tip'    => 'true'
            )
        );

        woocommerce_wp_select( array(
            'id'      => 'costom_add_new_custom_tab_select_field',
            'label'   => __( 'Additional Fields New Tab<br> (Select) &nbsp; : ', 'woocommerce'),
            'options' => array(
                'HR' => 'HR ',
                'Manager' => 'Manager',
                'TL' => 'TL',
                'Senior' => 'Senior',
            ),
        ) );
        echo "<br>";
        woocommerce_wp_textarea_input(array(
            'id'=>'costom_add_new_tab_text_area_field1',
            'label'   => __( 'Additional Fields:<br>(Text Area) : ', 'woocommerce'),
            'placeholder' => 'Add Custom Text Contents',
            'class'=>'text_area_class',
             ),
            );
        echo "<br>";
        woocommerce_wp_checkbox(array(
            'id'=>'costom_add_new_tab_checkbox_field',
            'label'=>__('Additional Fields:<br>(checkbox) :','woocommerce'),
            'class'=>'checkbox_class',
            ),
        );

        echo "<br>";
        woocommerce_wp_radio(array(
            'id'=>'costom_add_new_tab_radio_button_field',
            'label'=>__('Additional Fields:<br>(Radio Botton) :','woocommerce'),
            'class'=>'radio_class',
            'options' => array(
                'Pakistan'    => 'Pakistan',
                'Inida' => 'Inida',
                'USA' => 'USA',
                'UA'=>'UA'
             ),
        ));

      ?>
    </div>
  </div>
<?php
}
add_action( 'woocommerce_product_data_panels', 'custom_tab_panel' );

function woocommerce_save_custom_input_text_new_custom_tab_section_single_product($post_id){

    $product = wc_get_product( $post_id );
    $title = isset( $_POST['my_custom_tab_input_text_field'] ) ? $_POST['my_custom_tab_input_text_field'] : '';
    $product->update_meta_data( 'my_custom_tab_input_text_field', sanitize_text_field( $title ));
    $product->save();
   
    $title = isset( $_POST['costom_add_new_custom_tab_select_field'] ) ? $_POST['costom_add_new_custom_tab_select_field'] : '';
    $product->update_meta_data( 'costom_add_new_custom_tab_select_field', sanitize_text_field( $title ));
    $product->save();

   
    $title = isset( $_POST['costom_add_new_tab_text_area_field1'] ) ? $_POST['costom_add_new_tab_text_area_field1'] : '';
    $product->update_meta_data( 'costom_add_new_tab_text_area_field1', sanitize_text_field( $title ));
    $product->save();

    $super = isset( $_POST[ 'costom_add_new_tab_checkbox_field' ] ) && 'yes' === $_POST[ 'costom_add_new_tab_checkbox_field' ] ? 'yes' : 'no';
    update_post_meta( $post_id, 'costom_add_new_tab_checkbox_field', $super );

    
    $title = isset( $_POST['costom_add_new_tab_radio_button_field'] ) ? $_POST['costom_add_new_tab_radio_button_field'] : '';
    $product->update_meta_data( 'costom_add_new_tab_radio_button_field', sanitize_text_field( $title ));
    $product->save();

}
add_action('woocommerce_process_product_meta','woocommerce_save_custom_input_text_new_custom_tab_section_single_product');

/*Display*/
function woocommerce_display_custom_input_field_custom_tab_section(){
    global $post,$woocommerce,$product;
    echo "<br>";
    $product_id=get_the_ID();
    $input_value=get_post_meta($product_id,'my_custom_tab_input_text_field',true);
    if($input_value){
       echo "<b>Custom Tab Input : </b>";
       print_r($input_value);
    }
    echo "<br>";
    $select_value=get_post_meta($product_id,'costom_add_new_custom_tab_select_field',true);
    if($select_value){
       echo "<b>Custom Tab Input : </b>";
       print_r($select_value);
    }
    echo "<br>";
    $text_area_value=get_post_meta($product_id,'costom_add_new_tab_text_area_field1',true);
    if($text_area_value){
       echo "<b>Custom Tab Input : </b>";
       print_r($text_area_value);
    }
    echo "<br>";
    $checkbox_field=get_post_meta($product_id,'costom_add_new_tab_checkbox_field',true);
    if ($checkbox_field){
        echo "<b>Custom Tab Checkbox :</b>";
        print_r($checkbox_field);
    }
    echo "<br>";
    $radio_field=get_post_meta($product_id,'costom_add_new_tab_radio_button_field',true);
    if ($radio_field){
        echo "<b>Custom Tab Radio :</b>";
        print_r($radio_field);
    }
}
add_action('woocommerce_single_product_summary','woocommerce_display_custom_input_field_custom_tab_section');

