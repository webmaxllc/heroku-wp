<?php
/**
 * Created by PhpStorm.
 * User: me664
 * Date: 3/1/15
 * Time: 6:18 PM
 */
get_header();
global $post;
$author_id = $post->post_author;
$bravo_sidebar=bravo_get_sidebar();
$bravo_sidebar_pos=$bravo_sidebar['position'];
$bravo_enable_head = bravo_get_option('enable_head_single_page');
$bravo_title = bravo_get_option('post_page_title');
$bravo_sub_title = bravo_get_option('post_page_sub_title');
$bravo_bg = bravo_get_option('page_background_image');

if($bravo_enable_head == 'on'){
	$class = BravoAssets::build_css(' background: url("'.esc_url($bravo_bg).'") no-repeat center center / cover ;')
	?>
	<section class="innerpage-banner <?php echo esc_attr($class) ?>">
		<div class="container">
			<div class="row">
				<div class="col-md-12 text-right">
					<h2><?php echo esc_html($bravo_title) ?></h2>
					<p class="tagline"><?php echo esc_html($bravo_sub_title) ?></p>
				</div>
			</div>
		</div>
	</section>
<?php }else{
	echo '<div class="no_banner"></div>';
} ?>

<?php
while(have_posts()){
	the_post();
	?>
	<div id="area-main" class="padding">
		<div class="container">
			<div class="row">
				<?php if($bravo_sidebar_pos=='left'){ get_sidebar(); }?>
				<div class="col-xs-12 <?php echo esc_html($bravo_sidebar_pos=='no'?'col-md-12':'col-md-8'); ?>">
					<div class="blog-item">
						<?php
						if(has_post_thumbnail()) {
							echo get_the_post_thumbnail(get_the_ID(),array(1100,600),array('class'=>'img-responsive'));
						}
						?>
						<div class="blog-content">
							<h3><?php the_title() ?></h3>
							<ul class="blog-author">
								<li><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ); ?>"><i class="fa fa-user"></i><?php esc_html_e("By ",'bizone') ?><?php the_author(); ?></a></li>
								<li><a href="#comment"><i class="fa fa-comment-o"></i><?php esc_html_e('Leave A Comment','bizone') ?></a></li>
								<li><a href="#" onclick="return false"><i class="fa fa-clock-o"></i> <?php echo get_the_time('j F Y') ?></a></li>
							</ul>
							<?php
							the_content();
							wp_link_pages( array(
								'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', "bizone" ) . '</span>',
								'after'       => '</div>',
								'link_before' => '<span>',
								'link_after'  => '</span>',
								'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', "bizone" ) . ' </span>%',
								'separator'   => '<span class="">, </span>',
							) );
							?>
						</div>
						<div class="content-comment">
							<?php
							if(comments_open()){
								comments_template();
							}?>
						</div>
					</div>
				</div>
				<?php if($bravo_sidebar_pos=='right'){ get_sidebar(); }?>
			</div>
		</div>
	</div>
	<?php
}
get_footer();