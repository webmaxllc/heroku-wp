<?php
/**
 * Created by PhpStorm.
 * User: me664
 * Date: 3/8/15
 * Time: 12:11 PM
 */

if(!class_exists('BravoAdminAuthorMeta'))
{
    class BravoAdminAuthorMeta
    {
        static $extra_fields=array();

        static function _init()
        {
            BravoConfig::load('author-meta');


            add_action( 'show_user_profile',array(__CLASS__,'show_user_profile')  );
            add_action( 'edit_user_profile', array(__CLASS__,'show_user_profile') );

            add_action( 'personal_options_update', array(__CLASS__,'personal_options_update') );
            add_action( 'edit_user_profile_update', array(__CLASS__,'personal_options_update') );
        }

        static function get_fields()
        {
            $fields=BravoConfig::get('author_meta');

            self::$extra_fields= apply_filters('bravo_author_meta_fields',$fields);

            return self::$extra_fields;
        }

        static function show_user_profile($user)
        {
            $extra_fields=self::get_fields();
            ?>
            <h3><?php echo esc_html__('Extra Profile Information',"bizone") ?></h3>

            <table class="form-table">
                <?php if(isset($extra_fields) and !empty($extra_fields)):
                    foreach($extra_fields as $key=>$value)
                    {

                        $default=array(
                            'type'      =>'text',
                            'desc'      =>'',
                            'label'     =>''
                        );

                        $value=wp_parse_args($value,$default);

                        ?>
                        <tr>
                            <th><label for="twitter"><?php echo balanceTags($value['label']) ?></label></th>
                            <td>
                                <?php if(method_exists(__CLASS__,'get_field_html_'.$value['type'])){
                                    $fnc='get_field_html_'.$value['type'];

                                    self::$fnc($key,$value,$user);
                                } ?>

                            </td>
                        </tr>
                    <?php
                    }

                endif;
                ?>

            </table>
            <?php
        }
        static function get_field_html_text($key,$value,$user)
        {

            ?>
            <input type="text" name="<?php echo esc_attr($key) ?>" id="<?php echo esc_attr($key) ?>" value="<?php echo  esc_attr( get_the_author_meta( $key, $user->ID ) ); ?>" class="regular-text" /><br />
            <span class="description"><?php echo balanceTags($value['desc']) ?></span>
            <?php
        }

        static function personal_options_update($user_id)
        {
            if ( !current_user_can( 'edit_user', $user_id ) )
                return false;

            $fields=self::get_fields();

            if(!empty($fields))
            {
                foreach($fields as $key=> $value)
                {
                    update_user_meta($user_id, $key, sanitize_text_field($_POST[$key]));
                }
            }
        }
    }
    BravoAdminAuthorMeta::_init();
}