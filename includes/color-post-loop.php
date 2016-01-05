<?php
defined( 'ABSPATH' ) or die();

$sliderCont = '';
$sliderColors = '';
while ($pq -> have_posts()) : $pq -> the_post();
	$slide = '';
	$post = $pq->post;
	$post_data = get_post($post->ID, ARRAY_A);
	$slug = $post_data['post_name'];
	$color = get_post_meta($post->ID, 'color_post_color', true);
	$colorFont = get_post_meta($post->ID, 'color_post_font', true);
        $thumbnail = $color_bg_img = '';
        $thumbnail = get_the_post_thumbnail();
//        if ( function_exists('has_post_thumbnail') && has_post_thumbnail($post->ID) ) {
//            $thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), full );
//        }
//        $color_bg_img = ($thumbnail[0])? 'background-image: url('.$thumbnail[0].');' : '';

        $sliderColors .= '<span class="color" data-color="'.$color.'" style="background-color:'.$color.';'.$color_bg_img.'">'.get_the_post_thumbnail().'</span>';

	if ( has_post_thumbnail() ) {
		$slide .= '
<div class="imageContainer" data-color="'.$color.'">
	<span>'.get_the_post_thumbnail().'</span>
</div>';
	}
	$slide .= '
<div class="header" data-color="'.$color.'">
	<h3 id="'.$slug.'" class="title" style="color:'.$colorFont.';background-color:'.$color.';">'.str_replace(array('[', ']'), array('<span>', '</span>'), get_the_title()).'</h3>
</div>';
	$slide .= '<div class="content">'.get_the_content().'</div>';

	$sliderCont .= '<div class="colorPost" data-color="'.$color.'">'.$slide.'</div>';

	//echo '<pre>'.print_r($post, true).'</pre>';
endwhile;
?>

<div class="colorPostSlider">
	<div class="colorPosts"><?php echo $sliderCont; ?></div>
	<div class="colors"><?php echo $sliderColors; ?></div>
</div>