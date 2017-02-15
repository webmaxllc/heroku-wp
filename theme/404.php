<?php
/**
 * The template for displaying pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other "pages" on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */
$sidebar=bravo_get_sidebar();
$sidebar_pos=$sidebar['position'];
get_header();
?>
    <div class="no_banner"></div>
    <div class="primary-content page_404">
        <div class="blog">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-md-12">
                        <div class="row grid-blog">
                            <div class="col-md-12 text-center">
                                <div class="section_header">
                                    <h1><?php esc_html_e( "Oops! That page can't be found.", "bizone" ); ?></h1>
                                    <p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try a search?', "bizone"); ?></p>
                                </div>
                                <?php get_search_form(); ?>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- E: .blog -->
    </div>


<?php
get_footer();