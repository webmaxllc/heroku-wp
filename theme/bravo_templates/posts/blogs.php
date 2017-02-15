<?php
/**
 * Created by PhpStorm.
 * User: me664
 * Date: 12/15/15
 * Time: 11:07 PM
 */
if ( ! get_post_format() and has_post_thumbnail() ) {
	$class = 'blog-img-hover';

} else {
	$class = '';
} ?>

<div class="blog-img <?php echo esc_attr( $class ); ?>">
	<div class="blog-date">
		<div class="blog-date-day"><?php echo get_the_date('d');?></div>
		<?php echo get_the_date('F');?>
	</div>
	<?php
	if ( ! get_post_format() and has_post_thumbnail() ) {
		the_post_thumbnail( 'full', array('class' => 'img-responsive') );
	}
	?>
	<?php switch ( get_post_format() ) {
		case"image":
			the_post_thumbnail( 'full', array('class' => 'img-responsive') );

			break;

		case "video":
			if ( $media_url = get_post_meta( get_the_ID(), 'media_url', true ) ) {
				?>
				<div class="blog-featured-item">
				</div>
				<div class="embed-responsive embed-responsive-16by9">
					<?php echo wp_oembed_get( $media_url ) ?>
				</div>
				<?php
			}
			break;
		case "audio":
			if ( $media_url = get_post_meta( get_the_ID(), 'media_url', true ) ) {
				?>
				<div class="blog-featured-item">
					<?php echo wp_oembed_get( $media_url ) ?>
				</div>
				<?php
			}
			break;
		case "gallery":
			if ( $gallery = get_post_meta( get_the_ID(), 'gallery', true ) ) {
				$gallery = explode( ',', $gallery );

				if ( ! empty( $gallery ) ) {
					?>
					<div class="single-slider-v2"
					     id="single-slider-<?php echo get_the_ID(); ?>"> \
						<?php foreach ( $gallery as $key => $value ) {
							$img = wp_get_attachment_thumb_url( $value );

							echo '<a href="' . esc_url($img) . '" data-lightbox="blog-item3-images">'.wp_get_attachment_image($value).'</a>';
						} ?>

					</div>

					<?php
				}
			}
			break;
		case "quote": ?>
			<?php the_post_thumbnail( 'full',array('class' => 'img-responsive' ) );; ?>
			<div class="blog-img-detail">
				<div class="blog-img-detail-inner">
					<div class="blog-img-detail-content">
						<div class="row">
							<div class="col-xxxl-12 col-xxxl-offset-0 col-md-8 col-md-offset-2">
								<?php the_content(); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php
			break;
	}
	?>
</div>

