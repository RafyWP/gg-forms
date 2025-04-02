<?php defined( 'ABSPATH' ) || exit;

$story_id      = ! empty( $attributes['storyId'] ) ? esc_html( $attributes['storyId'] ) : '';
$video_url     = empty( $attributes['videoUrl'] ) ? '' : esc_url( $attributes['videoUrl'] );
$aspect_ratio  = ! empty( $attributes['aspectRatio'] ) ? floatval( $attributes['aspectRatio'] ) : 1.777;
$thumbnail     = empty( $attributes['thumbnail'] ) ? '' : esc_url( $attributes['thumbnail'] );
$question      = ! empty( $attributes['transitionQuestion'] ) ? esc_html( $attributes['transitionQuestion'] ) : '';
$show_minute   = isset( $attributes['showMinute'] ) ? intval( $attributes['showMinute'] ) : 0;
$show_second   = isset( $attributes['showSecond'] ) ? intval( $attributes['showSecond'] ) : 0;
$target_time   = ($show_minute * 60) + $show_second;
?>

<div id="<?php echo $story_id; ?>" <?php echo get_block_wrapper_attributes(['class' => 'swiper-slide']); ?>>
	<?php if ( $video_url ) : ?>
		<video
			class="ggf-story-video"
			src="<?php echo $video_url; ?>"
			poster="<?php echo $thumbnail; ?>"
			data-target-time="<?php echo esc_attr( $target_time ); ?>"
			style="width: 100%; aspect-ratio: <?php echo esc_attr( $aspect_ratio ); ?>;"
			disablePictureInPicture
		></video>

		<?php if ( ! empty( $attributes['playIcon'] ) ) : ?>
			<button class="ggf-play-button">
				<img src="<?php echo esc_url( $attributes['playIcon'] ); ?>" alt="Play" />
			</button>
		<?php else : ?>
			<button class="ggf-play-button">▶ Play</button>
		<?php endif; ?>

		<?php if ( $question ) : ?>
			<div class="ggf-question-slide">
				<?php echo $question; ?>
				<?php echo $content; ?>
			</div>
		<?php endif; ?>
	<?php else : ?>
		<p><?php esc_html_e( 'No video selected.', 'gg-forms' ); ?></p>
	<?php endif; ?>
</div>
