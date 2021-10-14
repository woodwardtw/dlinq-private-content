<?php 
/*
Plugin Name: DLINQ -Private Content
Plugin URI:  https://github.com/
Description: Anything with the category "private" is accessible only to authors or greater on the view side
Version:     1.0
Author:      DLINQ
Author URI:  https://dlinq.middcreate.net
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Domain Path: /languages
Text Domain: my-toolset

*/
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );


function dlinq_private_eyes_only($content){
   $category_id = get_cat_ID('Private');
   if(in_category($category_id) && !current_user_can( 'edit_posts' )){
      return '<p>This content is not yet publicly available. Please check back later.</p>';
   } 
    if(in_category($category_id) && current_user_can( 'edit_posts' )){
      return '<div class="alert" style="border: 2px solid red; margin: 20px; padding: 10px;">You can see this because you are special. Remove the "Private" category to make it visible to the public.</div>' . $content;
    }
   else {
      return $content;
   }

}

add_filter( 'the_content', 'dlinq_private_eyes_only', 1 );


function dlinq_auto_cat_private($new_status, $old_status, $post){
   $category_id = get_cat_ID('Private');
    if('publish' === $new_status && 'publish' !== $old_status ) {
       wp_set_post_categories($post->ID, $category_id, true);
  }
}

add_action('transition_post_status', 'dlinq_auto_cat_private', 10, 3);



// function add_categories_to_pages() {
// register_taxonomy_for_object_type( 'category', 'page' );
// }
// add_action( 'init', 'add_categories_to_pages' );

//LOGGER -- like frogger but more useful

if ( ! function_exists('write_log')) {
   function write_log ( $log )  {
      if ( is_array( $log ) || is_object( $log ) ) {
         error_log( print_r( $log, true ) );
      } else {
         error_log( $log );
      }
   }
}

  //print("<pre>".print_r($a,true)."</pre>");
