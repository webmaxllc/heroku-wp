	</div><!-- End wrapper-->
	<!-- Footer-->
	<footer class="wow fadeInUp" data-wow-duration="500ms" data-wow-delay="300ms">
		<div class="container">
			<div class="row">
				<div class="col-md-12 text-center">
					<?php
					if(has_nav_menu('primary')){
						$args = array(
							'theme_location'  => 'footer_menu',
							'menu_class'      => 'breadcrumb',
							'container'=>'',
							'walker'          => new Bravo_Menu_Walker,
						);
						wp_nav_menu($args);
					}
					$tags=wp_kses_allowed_html('post');
					?>
					<div><p><?php echo wp_kses(bravo_get_option('footer_copyright'),$tags) ?></p></div>
				</div>
			</div>
		</div>
	</footer>
	<a href="#." class="go-top text-center"><i class="fa fa-angle-double-up"></i></a>
	<?php wp_footer();?>
	</body>
</html>