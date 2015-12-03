<?php
$sliderCont = '';
$sliderColors = '';
while ($pq -> have_posts()) : $pq -> the_post();
	$slide = '';
	$post = $pq->post;
	$post_data = get_post($post->ID, ARRAY_A);
	$slug = $post_data['post_name'];
	$color = get_post_meta($post->ID, 'color_post_color', true);

	$sliderColors .= '<span class="color" data-color="'.$color.'" style="background-color:'.$color.';"></span>';

	if ( has_post_thumbnail() ) {
		$slide .= '
<div class="imageContainer">
	<span>'.get_the_post_thumbnail().'</span>
</div>';
	}
	$slide .= '
<header class="header">
	<h3 id="'.$slug.'" name="'.$slug.'" class="title" style="background-color:'.$color.';">'.get_the_title().'</h2>
</header>';
	$slide .= '<div class="content">'.get_the_content().'</div>';

	$sliderCont .= '<div class="colorPost" data-color="'.$color.'">'.$slide.'</div>';

	//echo '<pre>'.print_r($post, true).'</pre>';
endwhile;
?>

<div class="colorPostSlider">
	<div class="colorPosts"><?php echo $sliderCont; ?></div>
	<div class="colors"><?php echo $sliderColors; ?></div>
</div>