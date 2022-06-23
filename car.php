<?php
/**
Template Name: Car
 Template post type: post, page
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package wl-test-theme
 */

get_header();
?>

<?php





$args = array( 'post_type' => 'car', 'posts_per_page' => 15);
$loop = new WP_Query($args);
while ($loop->have_posts() ) : $loop->the_post(); ?>

	<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>

	<?php echo '<div>';
		the_content();
		echo '<div>';
			endwhile;


$terms = get_terms( array(
 'taxonomy' => 'car_model',
 'hide_empty' => false, ));

$output = '';
foreach($terms as $term){
	$output .= $term->name . '<br />';
}

echo $output;
 ?>

<?php

get_footer();