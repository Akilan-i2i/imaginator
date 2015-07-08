<?php

/**
  ReduxFramework Sample Config File
  For full documentation, please visit: https://docs.reduxframework.com
 * */

if (!class_exists('admin_folder_Redux_Framework_config')) {

    class admin_folder_Redux_Framework_config {

        public $args        = array();
        public $sections    = array();
        public $theme;
        public $ReduxFramework;

        public function __construct() {

            if (!class_exists('ReduxFramework')) {
                return;
            }

            // This is needed. Bah WordPress bugs.  ;)
            if ( true == Redux_Helpers::isTheme( __FILE__ ) ) {
                $this->initSettings();
            } else {
                add_action('plugins_loaded', array($this, 'initSettings'), 10);
            }

        }

        public function initSettings() {

            // Just for demo purposes. Not needed per say.
            $this->theme = wp_get_theme();

            // Set the default arguments
            $this->setArguments();

            // Set a few help tabs so you can see how it's done
            $this->setHelpTabs();

            // Create the sections and fields
            $this->setSections();

            if (!isset($this->args['opt_name'])) { // No errors please
                return;
            }

            // If Redux is running as a plugin, this will remove the demo notice and links
            add_action( 'redux/loaded', array( $this, 'remove_demo' ) );
            
            // Function to test the compiler hook and demo CSS output.
            // Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.
            //add_filter('redux/options/'.$this->args['opt_name'].'/compiler', array( $this, 'compiler_action' ), 10, 2);
            
            // Change the arguments after they've been declared, but before the panel is created
            //add_filter('redux/options/'.$this->args['opt_name'].'/args', array( $this, 'change_arguments' ) );
            
            // Change the default value of a field after it's been set, but before it's been useds
            //add_filter('redux/options/'.$this->args['opt_name'].'/defaults', array( $this,'change_defaults' ) );
            
            // Dynamically add a section. Can be also used to modify sections/fields
            //add_filter('redux/options/' . $this->args['opt_name'] . '/sections', array($this, 'dynamic_section'));

            $this->ReduxFramework = new ReduxFramework($this->sections, $this->args);
        }

        /**

          This is a test function that will let you see when the compiler hook occurs.
          It only runs if a field	set with compiler=>true is changed.

         * */
        function compiler_action($options, $css) {
            //echo '<h1>The compiler hook has run!';
            //print_r($options); //Option values
            //print_r($css); // Compiler selector CSS values  compiler => array( CSS SELECTORS )

            /*
              // Demo of how to use the dynamic CSS and write your own static CSS file
              $filename = dirname(__FILE__) . '/style' . '.css';
              global $wp_filesystem;
              if( empty( $wp_filesystem ) ) {
                require_once( ABSPATH .'/wp-admin/includes/file.php' );
              WP_Filesystem();
              }

              if( $wp_filesystem ) {
                $wp_filesystem->put_contents(
                    $filename,
                    $css,
                    FS_CHMOD_FILE // predefined mode settings for WP files
                );
              }
             */
        }

        /**

          Custom function for filtering the sections array. Good for child themes to override or add to the sections.
          Simply include this function in the child themes functions.php file.

          NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
          so you must use get_template_directory_uri() if you want to use any of the built in icons

         * */
        function dynamic_section($sections) {
            //$sections = array();
            $sections[] = array(
                'title' => __('Section via hook', 'redux-framework-demo'),
                'desc' => __('<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'redux-framework-demo'),
                'icon' => 'el-icon-paper-clip',
                // Leave this as a blank section, no options just some intro text set above.
                'fields' => array()
            );

            return $sections;
        }

        /**

          Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.

         * */
        function change_arguments($args) {
            //$args['dev_mode'] = true;

            return $args;
        }

        /**

          Filter hook for filtering the default value of any given field. Very useful in development mode.

         * */
        function change_defaults($defaults) {
            $defaults['str_replace'] = 'Testing filter hook!';

            return $defaults;
        }

        // Remove the demo link and the notice of integrated demo from the redux-framework plugin
        function remove_demo() {

            // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
            if (class_exists('ReduxFrameworkPlugin')) {
                remove_filter('plugin_row_meta', array(ReduxFrameworkPlugin::instance(), 'plugin_metalinks'), null, 2);

                // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
                remove_action('admin_notices', array(ReduxFrameworkPlugin::instance(), 'admin_notices'));
            }
        }

        public function setSections() {

            /**
              Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
             * */
            // Background Patterns Reader
            $sample_patterns_path   = ReduxFramework::$_dir . '../sample/patterns/';
            $sample_patterns_url    = ReduxFramework::$_url . '../sample/patterns/';
            $sample_patterns        = array();

            if (is_dir($sample_patterns_path)) :

                if ($sample_patterns_dir = opendir($sample_patterns_path)) :
                    $sample_patterns = array();

                    while (( $sample_patterns_file = readdir($sample_patterns_dir) ) !== false) {

                        if (stristr($sample_patterns_file, '.png') !== false || stristr($sample_patterns_file, '.jpg') !== false) {
                            $name = explode('.', $sample_patterns_file);
                            $name = str_replace('.' . end($name), '', $sample_patterns_file);
                            $sample_patterns[]  = array('alt' => $name, 'img' => $sample_patterns_url . $sample_patterns_file);
                        }
                    }
                endif;
            endif;

            ob_start();

            $ct             = wp_get_theme();
            $this->theme    = $ct;
            $item_name      = $this->theme->get('Name');
            $tags           = $this->theme->Tags;
            $screenshot     = $this->theme->get_screenshot();
            $class          = $screenshot ? 'has-screenshot' : '';

            $customize_title = sprintf(__('Customize &#8220;%s&#8221;', 'redux-framework-demo'), $this->theme->display('Name'));
            
            ?>
            <div id="current-theme" class="<?php echo esc_attr($class); ?>">
            <?php if ($screenshot) : ?>
                <?php if (current_user_can('edit_theme_options')) : ?>
                        <a href="<?php echo wp_customize_url(); ?>" class="load-customize hide-if-no-customize" title="<?php echo esc_attr($customize_title); ?>">
                            <img src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview'); ?>" />
                        </a>
                <?php endif; ?>
                    <img class="hide-if-customize" src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview'); ?>" />
                <?php endif; ?>

                <h4><?php echo $this->theme->display('Name'); ?></h4>

                <div>
                    <ul class="theme-info">
                        <li><?php printf(__('By %s', 'redux-framework-demo'), $this->theme->display('Author')); ?></li>
                        <li><?php printf(__('Version %s', 'redux-framework-demo'), $this->theme->display('Version')); ?></li>
                        <li><?php echo '<strong>' . __('Tags', 'redux-framework-demo') . ':</strong> '; ?><?php printf($this->theme->display('Tags')); ?></li>
                    </ul>
                    <p class="theme-description"><?php echo $this->theme->display('Description'); ?></p>
            <?php
            if ($this->theme->parent()) {
                printf(' <p class="howto">' . __('This <a href="%1$s">child theme</a> requires its parent theme, %2$s.') . '</p>', __('http://codex.wordpress.org/Child_Themes', 'redux-framework-demo'), $this->theme->parent()->display('Name'));
            }
            ?>

                </div>
            </div>

            <?php
            $item_info = ob_get_contents();

            ob_end_clean();

            /***************************************************************************************
             * Outdoor sections
             **************************************************************************************/

            // General
            $this->sections[] = array(
                'title'   => __( 'General', 'outdoor' ),
                'icon'    => 'el-icon-cogs',
                'heading' => 'General theme options',
                'desc'    => '',
                'fields'  => array(
                    array(
                        'id'    => 'od-logo',
                        'type'  => 'media',
                        'title' => __( 'Site logo', 'outdoor' ),
                        'url'   => true,
                        'default'  => array(
                            'url'   => OUTDOOR_ASSETS_URI . '/images/outdoor-logo.svg'
                        )
                    ),
                    array(
                        'id'    => 'od-favicon',
                        'type'  => 'media',
                        'title' => __( 'Favicon', 'outdoor' ),
                        'url'   => true,
                        'default'  => array(
                            'url'   => OUTDOOR_ASSETS_URI . '/images/favicon.ico'
                        )
                    ),
                    array(
                        'id'       => 'od-nav-position',
                        'type'     => 'select',
                        'title'    => __( 'Menu position', 'outdoor' ),
                        'subtitle' => '',
                        'desc'     => '',
                        'options'  => array(
                            'right' => __( 'Right', 'outdoor' ),
                            'left'  => __( 'Left', 'outdoor' )
                        ),
                        'default'  => 'right',
                    ),
                    array(
                        'id'            => 'od-nav-bg-color',
                        'type'          => 'color',
                        'title'         => __( 'Menu background color', 'outdoor' ),
                        'default'       => '#cd3333',
                        'transparent'   => false
                    ),
                    array(
                        'id'            => 'od-nav-link-color',
                        'type'          => 'color',
                        'title'         => __( 'Menu link color', 'outdoor' ),
                        'default'       => '',
                        'transparent'   => false
                    ),
                    array(
                        'id'            => 'od-nav-link-act-color',
                        'type'          => 'color',
                        'title'         => __( 'Menu link color (active el.)', 'outdoor' ),
                        'default'       => '',
                        'transparent'   => false
                    ),
                    array(
                        'id'            => 'od-nav-plus-color',
                        'type'          => 'color',
                        'title'         => __( 'Menu collapse color', 'outdoor' ),
                        'default'       => '#E66E6E',
                        'transparent'   => false
                    ),
                    array(
                        'id'            => 'od-show-preloader',
                        'type'          => 'switch',
                        'title'         => __( 'Show preloader', 'outdoor' ),
                        'default'       => true
                    ),
                    array(
                        'id'            => 'od-retina-support',
                        'type'          => 'switch',
                        'title'         => __( 'Retina support', 'outdoor' ),
                        'default'       => false
                    ),
                ),
            );

            // Homepage
            $this->sections[] = array(
                'title'   => __( 'Homepage', 'outdoor' ),
                'icon'    => 'el-icon-home',
                'heading' => '',
                'desc'    => '',
                'fields'  => array(
                    // Slider section start
                    array(
                        'id'            => 'od-section-slider',
                        'type'          => 'section',
                        'title'         => __( 'Header', 'outdoor' ),
                        'indent'        => true,
                    ),
                    array(
                        'id'            => 'od-home-header-enable',
                        'type'          => 'switch',
                        'title'         => __( 'Header enable', 'outdoor' ),
                        'default'       => false
                    ),
                    array(
                        'id'            => 'od-home-header-style',
                        'type'          => 'button_set',
                        'title'         => __( 'Header style', 'outdoor' ),
                        'options' => array(
                            'style1' => 'Style 1',
                            'style2' => 'Style 2',
                            'style3' => 'Style 3',
                            'style4' => 'Style 4'
                        ),
                        'default'       => 'style1',
                        'required'      => array( 'od-home-header-enable', '=', '1' ),
                    ),
                    array(
                        'id'            => 'od-header-text',
                        'type'          => 'text',
                        'title'         => __( 'Header text', 'outdoor' ),
                        'default'       => 'OUTDOOR',
                        'required'      => array( 'od-home-header-enable', '=', '1' ),
                    ),
                    array(
                        'id'            => 'od-header-text-color',
                        'type'          => 'color',
                        'title'         => __( 'Header text color', 'outdoor' ),
                        'transparent'   => false,
                        'required'      => array(
                            array( 'od-home-header-enable', '=', '1' ),
                            array( 'od-home-header-style', '!=', 'style1' )
                        ),
                    ),
                    array(
                        'id'            => 'od-header-text-opacity',
                        'type'          => 'slider',
                        'title'         => __( 'Header text opacity', 'outdoor' ),
                        'default'       => .85,
                        'min'           => 0,
                        'step'          => .01,
                        'max'           => 1,
                        'resolution'    => 0.01,
                        'display_value' => 'text',
                        'required'      => array(
                            array( 'od-home-header-enable', '=', '1' ),
                            array( 'od-home-header-style', '!=', 'style1' )
                        ),
                    ),
                    array(
                        'id'            => 'od-header-socline-color',
                        'type'          => 'color',
                        'title'         => __( 'Header social line color', 'outdoor' ),
                        'transparent'   => false,
                        'required'      => array(
                            array( 'od-home-header-enable', '=', '1' ),
                            array( 'od-home-header-style', '!=', 'style1' )
                        ),
                    ),
                    array(
                        'id'            => 'od-header-socline-opacity',
                        'type'          => 'slider',
                        'title'         => __( 'Header social line opacity', 'outdoor' ),
                        'default'       => .85,
                        'min'           => 0,
                        'step'          => .01,
                        'max'           => 1,
                        'resolution'    => 0.01,
                        'display_value' => 'text',
                        'required'      => array(
                            array( 'od-home-header-enable', '=', '1' ),
                            array( 'od-home-header-style', '!=', 'style1' )
                        ),
                    ),
                    array(
                        'id'            => 'od-header-subtext',
                        'type'          => 'textarea',
                        'title'         => __( 'Header subtext', 'outdoor' ),
                        'default'       => 'We provide new Design Waves<br>for our customers',
                        'required'      => array( 'od-home-header-enable', '=', '1' ),
                    ),
                    array(
                        'id'            => 'od-header-subtext-color',
                        'type'          => 'color',
                        'title'         => __( 'Header subtext color', 'outdoor' ),
                        'transparent'   => false,
                        'required'      => array(
                            array( 'od-home-header-enable', '=', '1' ),
                        ),
                    ),
                    array(
                        'id'            => 'od-home-slides',
                        'type'          => 'slides',
                        'title'         => __( 'Slides', 'outdoor' ),
                        'required'      => array(
                            array( 'od-home-header-enable', '=', '1' ),
                            array( 'od-home-header-style', '!=', 'style4' )
                        ),
                    ),
                    array(
                        'id'            => 'od-header-video-mp4-url',
                        'type'          => 'media',
                        'mode'          => 'mp4',
                        'title'         => __( 'Video (.mp4)', 'outdoor' ),
                        'required'      => array(
                            array( 'od-home-header-enable', '=', '1' ),
                            array( 'od-home-header-style', '=', 'style4' )
                        ),
                    ),
                    array(
                        'id'            => 'od-header-video-ogg-url',
                        'type'          => 'media',
                        'mode'          => 'ogg',
                        'title'         => __( 'Video (.ogg)', 'outdoor' ),
                        'required'      => array(
                            array( 'od-home-header-enable', '=', '1' ),
                            array( 'od-home-header-style', '=', 'style4' )
                        ),
                    ),
                    array(
                        'id'            => 'od-header-video-webm-url',
                        'type'          => 'media',
                        'mode'          => 'webm',
                        'title'         => __( 'Video (.webm)', 'outdoor' ),
                        'required'      => array(
                            array( 'od-home-header-enable', '=', '1' ),
                            array( 'od-home-header-style', '=', 'style4' )
                        ),
                    ),
                    array(
                        'id'            => 'od-header-video-autoplay',
                        'type'          => 'switch',
                        'title'         => __( 'Video autoplay', 'outdoor' ),
                        'default'       => true,
                        'required'      => array(
                            array( 'od-home-header-enable', '=', '1' ),
                            array( 'od-home-header-style', '=', 'style4' )
                        ),
                    ),
                    array(
                        'id'            => 'od-header-video-loop',
                        'type'          => 'switch',
                        'title'         => __( 'Video loop', 'outdoor' ),
                        'default'       => true,
                        'required'      => array(
                            array( 'od-home-header-enable', '=', '1' ),
                            array( 'od-home-header-style', '=', 'style4' )
                        ),
                    ),
                    array(
                        'id'            => 'od-header-video-muted',
                        'type'          => 'switch',
                        'title'         => __( 'Video muted', 'outdoor' ),
                        'default'       => true,
                        'required'      => array(
                            array( 'od-home-header-enable', '=', '1' ),
                            array( 'od-home-header-style', '=', 'style4' )
                        ),
                    ),
                    // Contacts section start
                    array(
                        'id'            => 'od-section-slider',
                        'type'          => 'section',
                        'title'         => __( 'Contacts', 'outdoor' ),
                        'indent'        => true,
                    ),
                    array(
                        'id'            => 'od-map-enable',
                        'type'          => 'switch',
                        'title'         => __( 'Map enable', 'outdoor' ),
                        'default'       => false
                    ),
                    array(
                        'id'            => 'od-map-marker',
                        'type'          => 'media',
                        'title'         => __( 'Map marker', 'outdoor' ),
                        'url'           => true,
                        'default'       => array(
                            'url'       => OUTDOOR_ASSETS_URI . '/images/marker.png'
                        ),
                        'required'      => array( 'od-map-enable', '=', '1' ),
                    ),
                    array(
                        'id'            => 'od-map-coordinates',
                        'type'          => 'text',
                        'title'         => __( 'Map coordinates', 'outdoor' ),
                        'subtitle'      => __( 'Separated by comma. Ex: 40.756168,-73.978705', 'outdoor' ),
                        'default'       => '40.756168,-73.978705',
                        'required'      => array( 'od-map-enable', '=', '1' ),
                    ),
                    array(
                        'id'            => 'od-contact-text',
                        'type'          => 'textarea',
                        'title'         => __( 'Contact text', 'outdoor' ),
                        'default'       => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem ratione, nostrum culpa nulla totam cum tempore.',
                        'required'      => array( 'od-map-enable', '=', '1' ),
                    ),
                    array(
                        'id'            => 'od-contact-address',
                        'type'          => 'textarea',
                        'title'         => __( 'Address', 'outdoor' ),
                        'required'      => array( 'od-map-enable', '=', '1' ),
                    ),
                    array(
                        'id'            => 'od-contact-emails',
                        'type'          => 'multi_text',
                        'title'         => __( 'Emails', 'outdoor' ),
                        'add_text'      => __( 'Add email', 'outdoor' ),
                        'required'      => array( 'od-map-enable', '=', '1' ),
                    ),
                    array(
                        'id'            => 'od-contact-phones',
                        'type'          => 'multi_text',
                        'title'         => __( 'Phones', 'outdoor' ),
                        'add_text'      => __( 'Add phone', 'outdoor' ),
                        'required'      => array( 'od-map-enable', '=', '1' ),
                    ),
                    array(
                        'id'            => 'od-contact-form',
                        'type'          => 'text',
                        'title'         => __( 'Contact Form 7', 'outdoor' ),
                        'subtitle'      => __( 'Insert a contact form 7 shortcode', 'outdoor' ),
                        'required'      => array( 'od-map-enable', '=', '1' ),
                    ),
                    array(
                        'id'            => 'od-send-email',
                        'type'          => 'text',
                        'title'         => __( 'Send to email', 'outdoor' ),
                        'required'      => array( 'od-map-enable', '=', '1' ),
                    ),
                ),
            );

            // Blog
            $this->sections[] = array(
                'title'   => __( 'Blog', 'outdoor' ),
                'icon'    => 'el-icon-bold',
                'heading' => '',
                'desc'    => '',
                'fields'  => array(
                    array(
                        'id'            => 'od-blog-header',
                        'type'          => 'switch',
                        'title'         => __( 'Enable big header', 'outdoor' ),
                        'default'       => false
                    ),
                    array(
                        'id'            => 'od-blog-header-color',
                        'type'          => 'color',
                        'title'         => __( 'Background color', 'outdoor' ),
                        'transparent'   => false,
                        'required'      => array( 'od-blog-header', '=', '1' ),
                    ),
                    array(
                        'id'            => 'od-blog-header-img',
                        'type'          => 'media',
                        'title'         => __( 'Background image', 'outdoor' ),
                        'url'           => true,
                        'required'      => array( 'od-blog-header', '=', '1' ),
                    ),
                    array(
                        'id'            => 'od-blog-header-title',
                        'type'          => 'text',
                        'title'         => __( 'Blog title', 'outdoor' ),
                        'default'       => 'BLOG',
                        'required'      => array( 'od-blog-header', '=', '1' ),
                    ),
                    array(
                        'id'            => 'od-blog-sidebar-pos',
                        'type'          => 'select',
                        'title'         => __( 'Sidebar position', 'outdoor' ),
                        'subtitle'      => '',
                        'desc'          => '',
                        'options'       => array(
                            'without'       => __( 'Without sidebar', 'outdoor' ),
                            'right'         => __( 'Right', 'outdoor' ),
                            'left'          => __( 'Left', 'outdoor' )
                        ),
                        'default'       => 'right',
                    ),
                ),
            );

            // Typography
            $this->sections[] = array(
                'title'   => __( 'Typography', 'outdoor' ),
                'icon'    => 'el-icon-text-height',
                'heading' => 'Typography options',
                'desc'    => '',
                'fields'  => array(
                    array(
                        'id'            => 'od-typography-body',
                        'type'          => 'typography',
                        'title'         => __( 'Body', 'outdoor' ),
                        'text-align'    => false,
                        'line-height'   => false,
                        'units'         => '%',
                        'default'       => array(
                            'color'         => '#222',
                            'font-size'     => '100%',
                            'font-family'   => 'Raleway',
                            'font-weight'   => '400'
                        )
                    ),
                    array(
                        'id'            => 'od-typography-headings',
                        'type'          => 'typography',
                        'title'         => __( 'Headings', 'outdoor' ),
                        'subtitle'      => __( 'h1,h2,h3,h4,h5,h6 tags', 'outdoor' ),
                        'font-size'     => false,
                        'line-height'   => false,
                        'units'         => 'em',
                        'default'       => array(
                            'color'         => 'inherit',
                            'font-size'     => '2.95em',
                            'font-family'   => 'Raleway',
                            'font-weight'   => '700'
                        )
                    ),
                    array(
                        'id'            => 'od-typography-paragraph',
                        'type'          => 'typography',
                        'title'         => __( 'Paragraphs', 'outdoor' ),
                        'line-height'   => true,
                        'color'         => false,
                        'units'         => 'em',
                        'default'       => array(
                            'font-size'     => '0.9em',
                            'line-height'   => '1.72em',
                            'font-family'   => 'Raleway',
                            'font-weight'   => '400'
                        )
                    ),
                ),
            );

            // Footer
            $this->sections[] = array(
                'title'   => __( 'Footer', 'outdoor' ),
                'icon'    => 'el-icon-bookmark',
                'heading' => 'Footer options',
                'desc'    => '',
                'fields'  => array(
                    array(
                        'id'            => 'od-footer-gotop',
                        'type'          => 'switch',
                        'title'         => __( 'Show back to top button', 'outdoor' ),
                        'default'       => true
                    ),
                    array(
                        'id'            => 'od-footer-text',
                        'type'          => 'textarea',
                        'title'         => __( 'Footer text', 'outdoor' ),
                        'default'       => 'Thanks for your visit!'
                    ),
                    array(
                        'id'            => 'od-footer-subtext',
                        'type'          => 'textarea',
                        'title'         => __( 'Footer subtext', 'outdoor' ),
                        'default'       => 'Share us with social media:'
                    ),
                    array(
                        'id'            => 'od-footer-copyright',
                        'type'          => 'textarea',
                        'title'         => __( 'Footer copyright', 'outdoor' ),
                        'default'       => '&copy; ItemBridge llc, Outdoor Template on Themeforest, 2015'
                    ),
                ),
            );

            // WPML
            $this->sections[] = array(
                'title'   => __( 'WPML', 'outdoor' ),
                'icon'    => 'el-icon-cogs',
                'heading' => 'WPML options',
                'desc'    => '',
                'fields'  => array(
                    array(
                        'id'        => 'od-enable-switcher',
                        'type'      => 'switch',
                        'title'     => __( 'Show switcher in header', 'outdoor' ),
                        'subtitle'  => __( 'If wpml plugin activated', 'outdoor' ),
                        'default'   => false
                    ),
                ),
            );

            // Social
            $this->sections[] = array(
                'title'   => __( 'Social', 'outdoor' ),
                'icon'    => 'el-icon-linkedin',
                'heading' => 'Social settings',
                'desc'    => '',
                'fields'  => array(
                    array(
                        'id'        => 'od-social-in-slider',
                        'type'      => 'switch',
                        'title'     => __( 'Show social buttons in slider', 'outdoor' ),
                        'default'   => true
                    ),
                    array(
                        'id'        => 'od-social-in-menu',
                        'type'      => 'switch',
                        'title'     => __( 'Show social buttons in menu', 'outdoor' ),
                        'default'   => true
                    ),
                    array(
                        'id'        => 'od-social-in-blog-header',
                        'type'      => 'switch',
                        'title'     => __( 'Show social buttons in header on blog page', 'outdoor' ),
                        'default'   => true
                    ),
                    array(
                        'id'            => 'od-social-buttons',
                        'type'          => 'od_social_buttons',
                        'title'         => __( 'Social buttons', 'outdoor' ),
                        'default'       => ''
                    ),
                    array(
                        'id'            => 'od-getshare-buttons',
                        'type'          => 'get_share_buttons',
                        'title'         => __( 'Social share buttons', 'outdoor' ),
                        'default'       => ''
                    ),
                ),
            );

            // MailChimp settings
            $this->sections[] = array(
                'title'   => __( 'MailChimp', 'outdoor' ),
                'icon'    => 'el-icon-envelope',
                'heading' => 'MailChimp settings api',
                'desc'    => '',
                'fields'  => array(
                    array(
                        'id'        => 'od-mailchimp-enable',
                        'type'      => 'switch',
                        'title'     => __( 'Enable MailChimp integration', 'outdoor' ),
                        'default'   => false
                    ),
                    array(
                        'id'        => 'od-mailchimp-key',
                        'type'      => 'text',
                        'title'     => __( 'MailChimp api key', 'outdoor' ),
                        'default'   => '',
                        'required'  => array( 'od-mailchimp-enable', '=', '1' ),
                    ),
                    array(
                        'id'        => 'od-mailchimp-listid',
                        'type'      => 'text',
                        'title'     => __( 'MailChimp list id', 'outdoor' ),
                        'default'   => '',
                        'required'  => array( 'od-mailchimp-enable', '=', '1' ),
                    ),
                ),
            );

            // Custom css
            $this->sections[] = array(
                'icon'      => 'el-icon-css',
                'title'     => __( 'Custom css', 'outdoor' ),
                'desc'      => '',
                'fields'    => array(
                    array(
                        'id'        => 'od-custom-css',
                        'type'      => 'ace_editor',
                        'mode'      => 'css',
                        'title'     => __( 'Custom css', 'outdoor' ),
                        'default'   => "#mystyle {\nmargin: 0 auto;\n}"
                    ),
                ),
            );

            // Custom js
            $this->sections[] = array(
                'icon'      => 'el-icon-edit',
                'title'     => __( 'Custom js', 'outdoor' ),
                'desc'      => '',
                'fields'    => array(
                    array(
                        'id'        => 'od-custom-js',
                        'type'      => 'ace_editor',
                        'mode'      => 'javascript',
                        'title'     => __( 'Custom js', 'outdoor' ),
                        'default'   => "(function($){\n$(document).ready(function(){\n/*alert('test');*/\n});\n})(jQuery);"
                    )
                ),
            );

            // Theme information
            $this->sections[] = array(
                'icon'      => 'el-icon-info-circle',
                'title'     => __( 'Theme Information', 'outdoor' ),
                'desc'      => __('<p class="description">This is the Description. Again HTML is allowed</p>', 'outdoor'),
                'fields'    => array(
                    array(
                        'id'        => 'od-raw-info',
                        'type'      => 'raw',
                        'content'   => $item_info,
                    )
                ),
            );

            /***************************************************************************************
             * End Outdoor sections
             **************************************************************************************/
        }

        public function setHelpTabs() {

            // Custom page help tabs, displayed using the help API. Tabs are shown in order of definition.
            $this->args['help_tabs'][] = array(
                'id'        => 'redux-help-tab-1',
                'title'     => __('Theme Information 1', 'redux-framework-demo'),
                'content'   => __('<p>This is the tab content, HTML is allowed.</p>', 'redux-framework-demo')
            );

            $this->args['help_tabs'][] = array(
                'id'        => 'redux-help-tab-2',
                'title'     => __('Theme Information 2', 'redux-framework-demo'),
                'content'   => __('<p>This is the tab content, HTML is allowed.</p>', 'redux-framework-demo')
            );

            // Set the help sidebar
            $this->args['help_sidebar'] = __('<p>This is the sidebar content, HTML is allowed.</p>', 'redux-framework-demo');
        }

        /**

          All the possible arguments for Redux.
          For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments

         * */
        public function setArguments() {

            $theme = wp_get_theme(); // For use with some settings. Not necessary.

            $this->args = array(
                'opt_name' => 'outdoor_opt',
                'display_name' => 'Outdoor options',
                'display_version' => '1.0.0',
                'page_slug' => 'outdoor-options',
                'page_title' => 'Outdoor options page',
                'update_notice' => true,
                'intro_text' => '',
                'footer_text' => '',
                'admin_bar' => true,
                'menu_type' => 'menu',
                'menu_title' => 'Outdoor Options',
                'allow_sub_menu' => true,
                'page_parent_post_type' => 'your_post_type',
                'page_priority' => '50',
                'customizer' => true,
                'default_mark' => '*',
                'class' => 'outdoor-container',
                'hints' => 
                array(
                  'icon' => 'el el-question-sign',
                  'icon_position' => 'right',
                  'icon_size' => 'normal',
                  'tip_style' => 
                  array(
                    'color' => 'light',
                  ),
                  'tip_position' => 
                  array(
                    'my' => 'top left',
                    'at' => 'bottom right',
                  ),
                  'tip_effect' => 
                  array(
                    'show' => 
                    array(
                      'duration' => '500',
                      'event' => 'mouseover',
                    ),
                    'hide' => 
                    array(
                      'duration' => '500',
                      'event' => 'mouseleave unfocus',
                    ),
                  ),
                ),
                'output' => true,
                'output_tag' => true,
                'compiler' => true,
                'page_icon' => 'icon-themes',
                'page_permissions' => 'manage_options',
                'save_defaults' => true,
                'show_import_export' => true,
                'transient_time' => '3600',
                'network_sites' => true,
                'hide_reset' => false,
                'async_typography' => false,
                'dev_mode' => false
              );

            // SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.
            $this->args['share_icons'][] = array(
                'url'   => 'https://github.com/ReduxFramework/ReduxFramework',
                'title' => 'Visit us on GitHub',
                'icon'  => 'el-icon-github'
                //'img'   => '', // You can use icon OR img. IMG needs to be a full URL.
            );
            $this->args['share_icons'][] = array(
                'url'   => 'https://www.facebook.com/pages/Redux-Framework/243141545850368',
                'title' => 'Like us on Facebook',
                'icon'  => 'el-icon-facebook'
            );
            $this->args['share_icons'][] = array(
                'url'   => 'http://twitter.com/reduxframework',
                'title' => 'Follow us on Twitter',
                'icon'  => 'el-icon-twitter'
            );
            $this->args['share_icons'][] = array(
                'url'   => 'http://www.linkedin.com/company/redux-framework',
                'title' => 'Find us on LinkedIn',
                'icon'  => 'el-icon-linkedin'
            );

        }

    }
    
    global $reduxConfig;
    $reduxConfig = new admin_folder_Redux_Framework_config();
}

/**
  Custom function for the callback referenced above
 */
if (!function_exists('admin_folder_my_custom_field')):
    function admin_folder_my_custom_field($field, $value) {
        print_r($field);
        echo '<br/>';
        print_r($value);
    }
endif;

/**
  Custom function for the callback validation referenced above
 * */
if (!function_exists('admin_folder_validate_callback_function')):
    function admin_folder_validate_callback_function($field, $value, $existing_value) {
        $error = false;
        $value = 'just testing';

        /*
          do your validation

          if(something) {
            $value = $value;
          } elseif(something else) {
            $error = true;
            $value = $existing_value;
            $field['msg'] = 'your custom error message';
          }
         */

        $return['value'] = $value;
        if ($error == true) {
            $return['error'] = $field;
        }
        return $return;
    }
endif;
