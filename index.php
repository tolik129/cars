<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package wl-test-theme
 */

get_header();
?>

	


<?php

$terms = get_terms( array(
 'taxonomy' => 'car_model',
 'hide_empty' => false, ));

$output = '';
foreach($terms as $term){
	$output .= $term->name . '<br />';
}

echo $output;



$args = array( 'post_type' => 'car', 'posts_per_page' => 15);
$loop = new WP_Query($args);
while ($loop->have_posts() ) : $loop->the_post(); ?>

	<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>

	<?php echo '<div>';
		the_content();
		echo '<div>';
			endwhile; ?>

<?php

get_footer();
