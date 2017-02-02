<?php
/**
 * Team single post template
 * 
 * @package vogue
 * @since 1.0.0
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

global $post;
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php

	do_action( 'presscore_before_post_content' );

	the_content();

	do_action( 'presscore_after_post_content' );

	?>

	<div class="testeACF">
	<ul>
		<li><strong>empresa:</strong> <?php the_field('empresa'); ?></li>
	</ul>
</div>

<br/>

<div class="testeACF">
<?php the_field('teste_de_grade_do_vc'); ?>
</div>

<br/>

<div class="gradeACF">
<?php the_field('grade_composer'); ?>
</div>


</article><!-- #post-<?php the_ID(); ?> -->