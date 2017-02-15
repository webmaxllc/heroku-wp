<?php
if(empty($main_color)){
	$main_color=bravo_get_option('main_color','#01bab0');
	$bg_rgb = bravo_hex2rgb($main_color);
	$bg_rgb = implode(' , ',$bg_rgb);
}else{
	$bg_rgb = "__rgba__";
}
?>

.btn-green{
background: <?php echo esc_attr($main_color) ?> none repeat scroll 0 0;
}

.go-top {
background: <?php echo esc_attr($main_color) ?> none repeat scroll 0 0;
}

.r-test ul.r-feature li::before {
color:<?php echo esc_attr($main_color) ?>;
}

.work-filter ul li a.active {
background-color: <?php echo esc_attr($main_color) ?>;
border: 1px solid <?php echo esc_attr($main_color) ?>;
}

.overlay h4.base {
color: <?php echo esc_attr($main_color) ?>;
}
#testinomial h2 {
color: <?php echo esc_attr($main_color) ?>;
}

#publication-slider .item a.comment {
color: <?php echo esc_attr($main_color) ?>;
}
#publication-slider .item > a:hover {
color: <?php echo esc_attr($main_color) ?>;
}
#contact .center a {
color:  <?php echo esc_attr($main_color) ?>;
}
ul.social-link li a:hover span {
background: <?php echo esc_attr($main_color) ?> none repeat scroll 0 0;
border: 1px solid <?php echo esc_attr($main_color) ?>;
}

#testinomial-slider .owl-prev:hover,
#testinomial-slider .owl-next:hover ,
#publication-slider .owl-prev:hover ,
#publication-slider .owl-next:hover{
border:1px solid <?php echo esc_attr($main_color) ?>;
background-color:<?php echo esc_attr($main_color) ?>;
}


#btn_submit:hover{
background: <?php echo esc_attr($main_color) ?> !important;
border-color: <?php echo esc_attr($main_color) ?> !important;
}

.blog-item blockquote p{
color: <?php echo esc_attr($main_color) ?> !important;
}

.widget_tag_cloud .tagcloud a:hover{
background:  <?php echo esc_attr($main_color) ?> ;
}
.widget_categories ul.category2 li a:hover {
color: <?php echo esc_attr($main_color) ?>;
}
footer .breadcrumb li a:hover, footer .breadcrumb li a:focus{
color: <?php echo esc_attr($main_color) ?>;
}
.pricing_tenzin .pricing_list li::before {
color: <?php echo esc_attr($main_color) ?>;
}

.navbar-default .navbar-nav > .active a, .navbar-default .navbar-nav > .active a:hover, .navbar-default .navbar-nav > .active a:focus, #navigation.affix .navbar-default .navbar-nav > .active a, #navigation.affix .navbar-default .navbar-nav > .active a:hover, #navigation.affix .navbar-default .navbar-nav > .active a:focus {
background-color: transparent;
border-bottom: 3px solid <?php echo esc_attr($main_color) ?>;
}

.dot1 {
background-color: <?php echo esc_attr($main_color) ?>;
}

.nav .open > a, .nav .open > a:focus, .nav .open > a:hover{
border-color: <?php echo esc_attr($main_color) ?>;
}
#paralax-slider .owl-controls .owl-page span:hover, #paralax-slider .owl-controls .active span {
background: <?php echo esc_attr($main_color) ?> none repeat scroll 0 0;
}

ul.category li a:hover , ul.category li a:focus{
color:<?php echo esc_attr($main_color) ?>;
}

ul.category li a .date{
color:<?php echo esc_attr($main_color) ?>;
font-size:12px;
display:block;
}


#area-main ul.blog-author li a:hover, #area-main ul.blog-author li a:focus{
color:<?php echo esc_attr($main_color) ?>;
}

.morepost-wrap a:hover ,
.morepost-wrap2 a:hover{
color:<?php echo esc_attr($main_color) ?>;
}

.morepost-wrap2 .morepost:hover .fa-long-arrow-left,
.morepost-wrap .morepost:hover .fa-long-arrow-left{

color:<?php echo esc_attr($main_color) ?>;

}

.morepost-wrap2 .morepost:hover  .fa-long-arrow-right,
.morepost-wrap .morepost:hover .fa-long-arrow-right{


color:<?php echo esc_attr($main_color) ?>;

}

a:hover,
.main-navigation ul li a:hover,
.main-navigation ul li.current-menu-item> a,
.text-highlight,
/* Fix loi social icon o menu*/
 /*#menu .menu-bottom a, */
.section-page a, .section-page-dark a,
.blog-layout1 .blog-content a, .blog-layout2 .blog-content a, .blog-layout3 .blog-content a, .blog-layout-big .blog-content a, .blog-layout-single .blog-content a,
.post-small:hover .post-small-content,
.blog-layout-big .blog-content h4 a:hover,
.filter-list-alt li a:hover,
.main-navigation ul li.active > a, .main-navigation ul li.active > a:focus, .main-navigation ul li.current-menu-item > a,
.main-navigation ul li.current-menu-item > a:focus,
#all .list-catgs a:hover
{
    color:<?php echo esc_attr($main_color) ?>;
}


#all .button, #all .button-big, #all .button-border-light, #all .button-void,
.bravo-services-tabs.vc_tta-color-grey.vc_tta-style-classic .vc_tta-tab > a:hover,
.bravo-services-tabs.vc_tta-color-grey.vc_tta-style-classic .vc_tta-tab > a:focus,
.profile-short:hover .profile-short-job,
.main-navigation ul li.current-menu-item> a:after,
.main-navigation ul li a:hover:after,
input[type=submit],
.owl-carousel.top-small-arrows > .owl-controls .owl-next:hover, .owl-carousel.top-small-arrows > .owl-controls .owl-prev:hover,
html.csstransforms3d .pace .pace-progress,
.main-navigation ul li a:after,
#all .list-catgs a:after,
.page-numbers .current,
#all .button-long:hover
{
    background-color:<?php echo esc_attr($main_color) ?>;
}

.post-small .post-small-img:after,
.master-slider .ms-thumb-list.ms-dir-h .ms-thumb-frame.ms-thumb-frame-selected:after{
	border-color:<?php echo esc_attr($main_color) ?>;
}
#all .button-border:hover, #all .button-border-dark:hover, #all .button-border-light:hover, #all .button-simple:hover
{
	background-color: <?php echo esc_attr($main_color) ?>;
	border-color: <?php echo esc_attr($main_color) ?>;
}

.blog .post.sticky .blog-content{
	border:1px solid  <?php echo esc_attr($main_color) ?>;
	background: #dadada;
	padding: 30px 10px 30px;
	padding-top: 30px;
}

.blog .post.sticky .wp-post-image{
	margin-bottom:0px;
}