<?php
/**
 * Created by PhpStorm.
 * User: me664
 * Date: 12/15/15
 * Time: 11:07 PM
 */
if ( get_post_format()=='image' or (! get_post_format() and has_post_thumbnail() )) {
	$class = 'blog-img-hover';

} else {
	$class = '';
} ?>

<div class="blog-img <?php echo esc_attr( $class ); ?>">

	<?php switch(get_post_format()){
			case "video":
			case "audio":
				if ( get_post_meta( get_the_ID(), 'media_url', true ) or get_post_meta( get_the_ID(), 'media_selfhost', true ) ) {
					?>
					<div class="blog-date">
						<div class="blog-date-day"><?php echo get_the_date('d');?></div>
						<?php echo get_the_date('F');?>
					</div>
					<?php
				};

			break;

			case "gallery":
				if ( $gallery = get_post_meta( get_the_ID(), 'gallery', true ) ) {
					?>
					<div class="blog-date">
						<div class="blog-date-day"><?php echo get_the_date('d');?></div>
						<?php echo get_the_date('F');?>
					</div>
					<?php
				}

			break;

			case "image":
			default :
				if(has_post_thumbnail()){
					?>
					<div class="blog-date">
						<div class="blog-date-day"><?php echo get_the_date('d');?></div>
						<?php echo get_the_date('F');?>
					</div>
					<?php
				}
			break;
		?>

		<?php
	} ?>
	<?php
	if ( get_post_format()=='image' or (! get_post_format() and has_post_thumbnail() )) {
		the_post_thumbnail( array(470,243), array('class' => 'img-responsive') ); ?>
		<div class="blog-img-detail">
			<div class="blog-img-detail-inner">
				<div class="blog-img-detail-content">
					<a class="icon-circle"
					   href="<?php echo get_the_post_thumbnail_url( get_the_ID() ); ?>"
					   data-lightbox="blog-item1-images"><i class="fa fa-search"></i></a>
					<a class="icon-circle"
					   href="<?php the_permalink(); ?>"><i class="fa fa-link"></i></a>
				</div>
			</div>
		</div>
	<?php }
	?>
	<?php switch ( get_post_format() ) {
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
			}else{
				the_post_thumbnail(array(470,234));
				if($media_selfhost=get_post_meta(get_the_ID(),'media_selfhost',true)){

				?>
				<div class="blog-img-detail">
					<<?php echo get_post_format()?> controls class="post-audio">
					<source src="<?php echo esc_attr($media_selfhost) ?>" type="audio/mpeg">
					<?php esc_html_e('Your browser does not support the audio element.',"bizone")?>
				</<?php echo get_post_format()?>>
			</div>
			<?php
			}
			}
			break;
		case "gallery":
			if ( $gallery = get_post_meta( get_the_ID(), 'gallery', true ) ) {
				$gallery = explode( ',', $gallery );

				if ( ! empty( $gallery ) ) {
					?>
					<div class="single-slider-v2"
					     id="single-slider-<?php echo get_the_ID(); ?>">
						<?php foreach ( $gallery as $key => $value ) {
							$img = wp_get_attachment_image( $value, array(470,243));
							$url=wp_get_attachment_image_src($value,'full');

							echo '<a href="' . esc_url($url[0]) . '" data-lightbox="blog-item3-images">'.do_shortcode($img).'</a>';
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
								<p class="blog-img-quote">
								"<?php echo get_post_meta(get_the_ID(),'quote_content',true) ?>"
								</p>
								<?php if($author=get_post_meta(get_the_ID(),'author_name',true)){echo '&copy; '.esc_html($author);} ?>
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

