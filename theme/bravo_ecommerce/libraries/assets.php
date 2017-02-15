<?php
/**
 * Created by PhpStorm.
 * User: me664
 * Date: 2/28/15
 * Time: 9:12 PM
 */

if(!class_exists('BravoAssets'))
{
    class BravoAssets
    {
        static $asset_url;

        static $inline_css;
        static $current_css_id;
        static $prefix_class="bt_";

        static function _init()
        {
            self::$current_css_id=time();
            add_action('wp_footer',array(__CLASS__,'_action_footer_css'));


            self::$asset_url=BravoConfig::get('asset_url');
        }

        static function url($file=false)
        {
            return self::$asset_url.'/'.$file;
        }

        static function build_css($string=false,$effect = false){
            self::$current_css_id++;
            self::$inline_css.="
                .".self::$prefix_class.self::$current_css_id.$effect."{
                    {$string}
                }
        ";
            return self::$prefix_class.self::$current_css_id;
        }

        static function add_css($string=false){
            self::$inline_css.=$string;

        }

        static function _action_footer_css(){
            wp_enqueue_style('bravo_custom');
            wp_add_inline_style( 'bravo_custom',  self::$inline_css );
        }

        static function array_to_css($array=array()){
            return self::_get_output_item_css($array);
        }
        static function  _get_output_item_css($value)
        {


            if ( is_array( $value ) ) {



                /* Measurement */
                if ( isset( $value[0] ) && isset( $value[1] ) ) {

                    /* set $value with measurement properties */
                    $value = $value[0].$value[1];

                    /* Border */
                } else if ( ot_array_keys_exists( $value, array( 'width', 'unit', 'style', 'color' ) ) && ! ot_array_keys_exists( $value, array( 'top', 'right', 'bottom', 'left', 'height', 'inset', 'offset-x', 'offset-y', 'blur-radius', 'spread-radius' ) ) ) {
                    $border = array();

                    $unit = ! empty( $value['unit'] ) ? $value['unit'] : 'px';

                    if ( ! empty( $value['width'] ) )
                        $border[] = $value['width'].$unit;

                    if ( ! empty( $value['style'] ) )
                        $border[] = $value['style'];

                    if ( ! empty( $value['color'] ) )
                        $border[] = $value['color'];

                    /* set $value with border properties or empty string */
                    $value = ! empty( $border ) ? implode( ' ', $border ) : '';

                    /* Box Shadow */
                } else if ( ot_array_keys_exists( $value, array( 'inset', 'offset-x', 'offset-y', 'blur-radius', 'spread-radius', 'color' ) ) && ! ot_array_keys_exists( $value, array( 'width', 'height', 'unit', 'style', 'top', 'right', 'bottom', 'left' ) ) ) {

                    /* set $value with box-shadow properties or empty string */
                    $value = ! empty( $value ) ? implode( ' ', $value ) : '';

                    /* Dimension */
                } else if ( ot_array_keys_exists( $value, array( 'width', 'height', 'unit' ) ) && ! ot_array_keys_exists( $value, array( 'style', 'color', 'top', 'right', 'bottom', 'left' ) ) ) {
                    $dimension = array();

                    $unit = ! empty( $value['unit'] ) ? $value['unit'] : 'px';

                    if ( ! empty( $value['width'] ) )
                        $dimension[] = $value['width'].$unit;

                    if ( ! empty( $value['height'] ) )
                        $dimension[] = $value['height'].$unit;

                    /* set $value with dimension properties or empty string */
                    $value = ! empty( $dimension ) ? implode( ' ', $dimension ) : '';

                    /* Spacing */
                } else if ( ot_array_keys_exists( $value, array( 'top', 'right', 'bottom', 'left', 'unit' ) ) && ! ot_array_keys_exists( $value, array( 'width', 'height', 'style', 'color' ) ) ) {
                    $spacing = array();

                    $unit = ! empty( $value['unit'] ) ? $value['unit'] : 'px';

                    if ( ! empty( $value['top'] ) )
                        $spacing[] = $value['top'].$unit;

                    if ( ! empty( $value['right'] ) )
                        $spacing[] = $value['right'].$unit;

                    if ( ! empty( $value['bottom'] ) )
                        $spacing[] = $value['bottom'].$unit;

                    if ( ! empty( $value['left'] ) )
                        $spacing[] = $value['left'].$unit;

                    /* set $value with spacing properties or empty string */
                    $value = ! empty( $spacing ) ? implode( ' ', $spacing ) : '';

                    /* typography */
                } else if ( ot_array_keys_exists( $value, array( 'font-color', 'font-family', 'font-size', 'font-style', 'font-variant', 'font-weight', 'letter-spacing', 'line-height', 'text-decoration', 'text-transform' ) ) ) {

                    $font = array();

                    if ( ! empty( $value['font-color'] ) )
                        $font[] = "color: " . $value['font-color'] . ";";

                    if ( ! empty( $value['font-family'] ) ) {
//                        foreach ( ot_recognized_font_families( $marker ) as $key => $v ) {
//                            if ( $key == $value['font-family'] ) {
//                                $font[] = "font-family: " . $v . ";";
//                            }
//                        }
                    }

                    if ( ! empty( $value['font-size'] ) )
                        $font[] = "font-size: " . $value['font-size'] . ";";

                    if ( ! empty( $value['font-style'] ) )
                        $font[] = "font-style: " . $value['font-style'] . ";";

                    if ( ! empty( $value['font-variant'] ) )
                        $font[] = "font-variant: " . $value['font-variant'] . ";";

                    if ( ! empty( $value['font-weight'] ) )
                        $font[] = "font-weight: " . $value['font-weight'] . ";";

                    if ( ! empty( $value['letter-spacing'] ) )
                        $font[] = "letter-spacing: " . $value['letter-spacing'] . ";";

                    if ( ! empty( $value['line-height'] ) )
                        $font[] = "line-height: " . $value['line-height'] . ";";

                    if ( ! empty( $value['text-decoration'] ) )
                        $font[] = "text-decoration: " . $value['text-decoration'] . ";";

                    if ( ! empty( $value['text-transform'] ) )
                        $font[] = "text-transform: " . $value['text-transform'] . ";";


                    /* set $value with font properties or empty string */
                    $value = ! empty( $font ) ? implode( "\n", $font ) : '';


                    /* background */
                } else if ( ot_array_keys_exists( $value, array( 'background-color', 'background-image', 'background-repeat', 'background-attachment', 'background-position', 'background-size' ) ) ) {
                    $bg = array();

                    if ( ! empty( $value['background-color'] ) )
                        $bg[] = $value['background-color'];

                    if ( ! empty( $value['background-image'] ) ) {

                        /* If an attachment ID is stored here fetch its URL and replace the value */
                        if ( wp_attachment_is_image( $value['background-image'] ) ) {

                            $attachment_data = wp_get_attachment_image_src( $value['background-image'], 'original' );

                            /* check for attachment data */
                            if ( $attachment_data ) {

                                $value['background-image'] = $attachment_data[0];

                            }

                        }

                        $bg[] = 'url("' . $value['background-image'] . '")';

                    }

                    if ( ! empty( $value['background-repeat'] ) )
                        $bg[] = $value['background-repeat'];

                    if ( ! empty( $value['background-attachment'] ) )
                        $bg[] = $value['background-attachment'];

                    if ( ! empty( $value['background-position'] ) )
                        $bg[] = $value['background-position'];

                    if ( ! empty( $value['background-size'] ) )
                        $size = $value['background-size'];

                    /* set $value with background properties or empty string */
                    $value = ! empty( $bg ) ? 'background: ' . implode( " ", $bg ) . ';' : '';

                    if ( isset( $size ) ) {

                        $value.= "background-size: $size;";
                    }



                }

            }

            return "\r\n
                $value
            \r\n";
        }
    }

    BravoAssets::_init();
}