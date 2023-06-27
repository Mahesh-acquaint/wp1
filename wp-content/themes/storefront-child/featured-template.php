<?php 
/*Template Name:Featured Product Page */
?>
<?php get_header(); ?>

<?php 


$args = array(
          'post_type' => 'product',
          'posts_per_page'      => -1,
          'tax_query' => array(
          //'relation' => 'AND',
                array(
                'taxonomy' => 'product_visibility',
                'field' => 'name',
                'terms' => 'featured',
                'operator' => 'IN',
                ),
          ),
);
$query = new WP_Query($args);
if($query->have_posts()){
  while($query->have_posts()){
    $query->the_post();
    wc_get_template_part( 'content', 'product' );  
  }
  wp_reset_postdata();
}        

?>
<?php get_footer(); ?>