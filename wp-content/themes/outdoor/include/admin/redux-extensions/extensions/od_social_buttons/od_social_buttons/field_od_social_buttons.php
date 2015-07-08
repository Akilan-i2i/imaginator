<?php
/**
 * Redux Framework is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * Redux Framework is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Redux Framework. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package     ReduxFramework
 * @author      Dovy Paukstys
 * @version     3.1.5
 */
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;
// Don't duplicate me!
if( !class_exists( 'ReduxFramework_od_social_buttons' ) ) {
    /**
     * Main ReduxFramework_custom_field class
     *
     * @since       1.0.0
     */
    class ReduxFramework_od_social_buttons extends ReduxFramework {

        /**
         * Field Constructor.
         *
         * Required - must call the parent constructor, then assign field and value to vars, and obviously call the render field function
         *
         * @since       1.0.0
         * @access      public
         * @return      void
         */
        function __construct( $field = array(), $value ='', $parent ) {

            $this->parent = $parent;
            $this->field = $field;
            $this->value = $value;
            if ( empty( $this->extension_dir ) ) {
                $this->extension_dir = trailingslashit( str_replace( '\\', '/', dirname( __FILE__ ) ) );
                $this->extension_url = site_url( str_replace( trailingslashit( str_replace( '\\', '/', ABSPATH ) ), '', $this->extension_dir ) );
            }
            // Set default args for this field to avoid bad indexes. Change this to anything you use.
            $defaults = array(
                'options'           => array(),
                'stylesheet'        => '',
                'output'            => true,
                'enqueue'           => true,
                'enqueue_frontend'  => true
            );
            $this->field = wp_parse_args( $this->field, $defaults );

        }
        /**
         * Field Render Function.
         *
         * Takes the vars and outputs the HTML for the field in the settings
         *
         * @since       1.0.0
         * @access      public
         * @return      void
         */
        public function render() {

            $next_custom_icon_id = 0;
            $value = ( isset( $this->value ) && is_array( $this->value ) ) ? $this->value : array();
            $icons = array(
                'facebook'      => 'Facebook',
                'twitter'       => 'Twitter',
                'google-plus'   => 'Google plus',
                'pinterest'     => 'Pinterest',
                'linkedin'      => 'Linkedin',
                'instagram'     => 'Instagram',
                'vk'            => 'Vkontakte',
                'youtube'       => 'Youtube'
            );
        ?>
            <div class="od-social-buttons-wrap">
                <div id="social-field-list" class="social-fields">

                    <?php if( $value ) : ?>

                        <?php foreach( $value as $icon_name => $val ) : ?>
                            <?php
                            $hidden_fields  = '';
                            $remove_btn     = '';
                            $url            = $val['url'];
                            if( ( 'custom' == substr( $icon_name, 0, 6 ) ) ) {
                                $label  = $val['label'];
                                $icon   = '<img src="' . $val['img_url'] . '">';
                                $hidden_fields  = '<input type="hidden" name="outdoor_opt[od-social-buttons][' . $icon_name . '][label]" value="' . $label .  '">';
                                $hidden_fields .= '<input type="hidden" name="outdoor_opt[od-social-buttons][' . $icon_name . '][img_url]" value="' . $val['img_url'] .  '">';
                                $remove_btn = '<span class="remove-custom-icon" data-id="od-field-' . $icon_name . '"><i class="fa fa-close"></i></span>';
                                $next_custom_icon_id++;
                            } else {
                                $label  = $icons[$icon_name];
                                $icon   = '<i class="fa fa-' . $icon_name . '"></i>';
                            }
                            ?>
                            <div id="od-field-<?php echo $icon_name; ?>" class="social-field">
                                <span class="social-icon <?php echo $icon_name; ?>">
                                    <?php echo $icon; ?>
                                </span>
                                <span class="label"><?php echo $label; ?></span>
                                <?php echo $hidden_fields; ?>
                                <input class="regular-text" type="text" name="outdoor_opt[od-social-buttons][<?php echo $icon_name; ?>][url]" value="<?php echo $url; ?>">
                                <?php echo $remove_btn; ?>
                            </div>
                        <?php endforeach; ?>

                    <?php else: ?>

                        <?php foreach( $icons as $icon_name => $title ) : ?>
                            <div id="od-field-<?php echo $icon_name; ?>" class="social-field">
                                <span class="social-icon <?php echo $icon_name; ?>">
                                    <i class="fa fa-<?php echo $icon_name; ?>"></i>
                                </span>
                                <span class="label"><?php echo $title; ?></span>
                                <input class="regular-text" type="text" name="outdoor_opt[od-social-buttons][<?php echo $icon_name; ?>][url]">
                            </div>
                        <?php endforeach; ?>

                    <?php endif; ?>

                </div>
                <h4><?php _e( 'Add custom icon:', 'outdoor' ); ?></h4>
                <div class="custom-icon" data-custom-icon-id="<?php echo $next_custom_icon_id + 1; ?>">
                    <div class="row">
                        <span id="icon-preview"></span>
                        <span id="social-icon-upload" class="button media_upload_button"><?php _e( 'Upload icon', 'outdoor' ); ?></span>
                        <input id="custom-icon-url" type="hidden" name="icon_img_url" value="">
                    </div>
                    <div class="row">
                        <span class="label"><?php _e( 'Icon name', 'outdoor' ); ?></span>
                        <input id="icon-name" class="regular-text" type="text" name="icon_name">
                    </div>
                    <div class="row">
                        <span class="label"><?php _e( 'Url:', 'outdoor' ); ?></span>
                        <input id="icon-url" class="regular-text" type="text" name="icon_url">
                    </div>
                    <a id="add-social-icon" class="button button-primary" href="javascript: void(0);"><?php _e( 'Add custom icon', 'outdoor' ); ?></a>
                </div>
            </div>

        <?php
        }

        /**
         * Enqueue Function.
         *
         * If this field requires any scripts, or css define this function and register/enqueue the scripts/css
         *
         * @since       1.0.0
         * @access      public
         * @return      void
         */
        public function enqueue() {
            $extension = ReduxFramework_extension_od_social_buttons::getInstance();

            wp_enqueue_script(
                'redux-field-social-buttons-js',
                $this->extension_url . 'field_od_social_buttons.js',
                array( 'jquery' ),
                time(),
                true
            );
            wp_enqueue_style(
                'font-awesome',
                OUTDOOR_ASSETS_URI . '/css/font-awesome.css',
                time(),
                true
            );
            wp_enqueue_style(
                'redux-field-social-buttons-css',
                $this->extension_url . 'field_od_social_buttons.css',
                time(),
                true
            );

        }

        /**
         * Output Function.
         *
         * Used to enqueue to the front-end
         *
         * @since       1.0.0
         * @access      public
         * @return      void
         */
        public function output() {
            if ( $this->field['enqueue_frontend'] ) {
            }

        }

    }
}