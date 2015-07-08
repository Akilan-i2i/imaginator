<?php
class acf_field_small_icon extends acf_field {


    /*
    *  __construct
    *
    *  This function will setup the field type data
    *
    *  @type	function
    *  @date	5/03/2014
    *  @since	5.0.0
    *
    *  @param	n/a
    *  @return	n/a
    */

    function __construct() {

        /*
        *  name (string) Single word, no spaces. Underscores allowed
        */

        $this->name = 'small_icon';


        /*
        *  label (string) Multiple words, can include spaces, visible when selecting a field type
        */

        $this->label = __('Small icon', 'outdoor');


        /*
        *  category (string) basic | content | choice | relational | jquery | layout | CUSTOM GROUP NAME
        */

        $this->category = 'content';


        /*
        *  defaults (array) Array of default settings which are merged into the field object. These are used later in settings
        */

        $this->defaults = array(
            'icon_name'	=> '',
        );


        /*
        *  l10n (array) Array of strings that are used in JavaScript. This allows JS strings to be translated in PHP and loaded via:
        *  var message = acf._e('FIELD_NAME', 'error');
        */

        $this->l10n = array(
            'error'	=> __('Error! Please enter a higher value', 'outdoor'),
        );


        // do not delete!
        parent::__construct();

    }


    /*
    *  render_field_settings()
    *
    *  Create extra settings for your field. These are visible when editing a field
    *
    *  @type	action
    *  @since	3.6
    *  @date	23/01/13
    *
    *  @param	$field (array) the $field being edited
    *  @return	n/a
    */

    function render_field_settings( $field ) {

        /*
        *  acf_render_field_setting
        *
        *  This function will create a setting for your field. Simply pass the $field parameter and an array of field settings.
        *  The array of settings does not require a `value` or `prefix`; These settings are found from the $field array.
        *
        *  More than one setting can be added by copy/paste the above code.
        *  Please note that you must also have a matching $defaults value for the field name (font_size)
        */

//        acf_render_field_setting( $field, array(
//            'label'			=> __('Icon','outdoor'),
//            'instructions'	=> __('Customise the input font size','outdoor'),
//            'type'			=> 'text',
//            'name'			=> 'icon_name',
//            'prepend'		=> '',
//        ));
    }



    /*
    *  render_field()
    *
    *  Create the HTML interface for your field
    *
    *  @param	$field (array) the $field being rendered
    *
    *  @type	action
    *  @since	3.6
    *  @date	23/01/13
    *
    *  @param	$field (array) the $field being edited
    *  @return	n/a
    */

    function render_field( $field ) {


        /*
        *  Review the data of $field.
        *  This will show what data is available
        */

        /*
        *  Create a simple text input using the 'font_size' setting.
        */

        $value = $field['value'];
        $icon_name = ( $value != '' ) ? $value : '';
        $select_btn_text = ( $value != '' ) ? __( 'Change icon', 'outdoor' ) : __( 'Select icon', 'outdoor' );
        $rm_btn_class = ( $value != '' ) ? 'visible' : '';
        $sm_icons = array('commerce-sm-icon1','commerce-sm-icon10','commerce-sm-icon11','commerce-sm-icon12','commerce-sm-icon13',
            'commerce-sm-icon14','commerce-sm-icon15','commerce-sm-icon16','commerce-sm-icon17','commerce-sm-icon18',
            'commerce-sm-icon19','commerce-sm-icon2','commerce-sm-icon20','commerce-sm-icon21','commerce-sm-icon22',
            'commerce-sm-icon23','commerce-sm-icon24','commerce-sm-icon25','commerce-sm-icon26','commerce-sm-icon27',
            'commerce-sm-icon28','commerce-sm-icon29','commerce-sm-icon3','commerce-sm-icon30','commerce-sm-icon4',
            'commerce-sm-icon5','commerce-sm-icon6','commerce-sm-icon7','commerce-sm-icon8','commerce-sm-icon9',
            'control-sm-icon1','control-sm-icon10','control-sm-icon11','control-sm-icon12','control-sm-icon13',
            'control-sm-icon14','control-sm-icon15','control-sm-icon16','control-sm-icon17','control-sm-icon18',
            'control-sm-icon19','control-sm-icon2','control-sm-icon20','control-sm-icon21','control-sm-icon22',
            'control-sm-icon23','control-sm-icon24','control-sm-icon3','control-sm-icon4','control-sm-icon5',
            'control-sm-icon6','control-sm-icon7','control-sm-icon8','control-sm-icon9','device-sm-icon1',
            'device-sm-icon10','device-sm-icon2','device-sm-icon3','device-sm-icon4','device-sm-icon5',
            'device-sm-icon6','device-sm-icon7','device-sm-icon8','device-sm-icon9','docs-sm-icon1',
            'docs-sm-icon10','docs-sm-icon11','docs-sm-icon12','docs-sm-icon13','docs-sm-icon14',
            'docs-sm-icon15','docs-sm-icon16','docs-sm-icon17','docs-sm-icon18','docs-sm-icon19',
            'docs-sm-icon2','docs-sm-icon20','docs-sm-icon21','docs-sm-icon22','docs-sm-icon23',
            'docs-sm-icon24','docs-sm-icon25','docs-sm-icon26','docs-sm-icon27','docs-sm-icon28',
            'docs-sm-icon29','docs-sm-icon3','docs-sm-icon30','docs-sm-icon31','docs-sm-icon32',
            'docs-sm-icon33','docs-sm-icon34','docs-sm-icon35','docs-sm-icon36','docs-sm-icon37',
            'docs-sm-icon38','docs-sm-icon39','docs-sm-icon4','docs-sm-icon40','docs-sm-icon5',
            'docs-sm-icon6','docs-sm-icon7','docs-sm-icon8','docs-sm-icon9','food-sm-icon1',
            'food-sm-icon10','food-sm-icon11','food-sm-icon12','food-sm-icon13','food-sm-icon14',
            'food-sm-icon15','food-sm-icon16','food-sm-icon17','food-sm-icon18','food-sm-icon19',
            'food-sm-icon2','food-sm-icon20','food-sm-icon3','food-sm-icon4','food-sm-icon5',
            'food-sm-icon6','food-sm-icon7','food-sm-icon8','food-sm-icon9','logo-sm-icon1',
            'logo-sm-icon10','logo-sm-icon11','logo-sm-icon12','logo-sm-icon13','logo-sm-icon14',
            'logo-sm-icon15','logo-sm-icon16','logo-sm-icon17','logo-sm-icon18','logo-sm-icon19',
            'logo-sm-icon2','logo-sm-icon20','logo-sm-icon21','logo-sm-icon22','logo-sm-icon23',
            'logo-sm-icon24','logo-sm-icon25','logo-sm-icon26','logo-sm-icon27','logo-sm-icon28',
            'logo-sm-icon29','logo-sm-icon3','logo-sm-icon30','logo-sm-icon31','logo-sm-icon32',
            'logo-sm-icon33','logo-sm-icon34','logo-sm-icon35','logo-sm-icon36','logo-sm-icon37',
            'logo-sm-icon38','logo-sm-icon39','logo-sm-icon4','logo-sm-icon40','logo-sm-icon5',
            'logo-sm-icon6','logo-sm-icon7','logo-sm-icon8','logo-sm-icon9','misc-sm-icon1',
            'misc-sm-icon10','misc-sm-icon11','misc-sm-icon12','misc-sm-icon13','misc-sm-icon14',
            'misc-sm-icon15','misc-sm-icon16','misc-sm-icon17','misc-sm-icon18','misc-sm-icon19',
            'misc-sm-icon2','misc-sm-icon20','misc-sm-icon21','misc-sm-icon22','misc-sm-icon23',
            'misc-sm-icon24','misc-sm-icon25','misc-sm-icon26','misc-sm-icon27','misc-sm-icon28',
            'misc-sm-icon29','misc-sm-icon3','misc-sm-icon30','misc-sm-icon31','misc-sm-icon32',
            'misc-sm-icon33','misc-sm-icon34','misc-sm-icon35','misc-sm-icon36','misc-sm-icon37',
            'misc-sm-icon38','misc-sm-icon39','misc-sm-icon4','misc-sm-icon40','misc-sm-icon41',
            'misc-sm-icon42','misc-sm-icon43','misc-sm-icon44','misc-sm-icon45','misc-sm-icon46',
            'misc-sm-icon47','misc-sm-icon48','misc-sm-icon49','misc-sm-icon5','misc-sm-icon50',
            'misc-sm-icon51','misc-sm-icon52','misc-sm-icon53','misc-sm-icon54','misc-sm-icon55',
            'misc-sm-icon56','misc-sm-icon57','misc-sm-icon58','misc-sm-icon59','misc-sm-icon6',
            'misc-sm-icon60','misc-sm-icon61','misc-sm-icon62','misc-sm-icon63','misc-sm-icon64',
            'misc-sm-icon65','misc-sm-icon66','misc-sm-icon67','misc-sm-icon68','misc-sm-icon69',
            'misc-sm-icon7','misc-sm-icon70','misc-sm-icon71','misc-sm-icon72','misc-sm-icon73',
            'misc-sm-icon74','misc-sm-icon75','misc-sm-icon76','misc-sm-icon77','misc-sm-icon78',
            'misc-sm-icon79','misc-sm-icon8','misc-sm-icon80','misc-sm-icon81','misc-sm-icon82',
            'misc-sm-icon83','misc-sm-icon84','misc-sm-icon85','misc-sm-icon86','misc-sm-icon87',
            'misc-sm-icon88','misc-sm-icon89','misc-sm-icon9','misc-sm-icon90','misc-sm-icon91',
            'misc-sm-icon92','misc-sm-icon93','misc-sm-icon94','misc-sm-icon95','misc-sm-icon96',
            'misc-sm-icon97','misc-sm-icon98','misc-sm-icon99','sport-sm-icon1','sport-sm-icon10',
            'sport-sm-icon2','sport-sm-icon3','sport-sm-icon4','sport-sm-icon5','sport-sm-icon6',
            'sport-sm-icon7','sport-sm-icon8','sport-sm-icon9','weather-sm-icon1','weather-sm-icon10',
            'weather-sm-icon11','weather-sm-icon12','weather-sm-icon13','weather-sm-icon14','weather-sm-icon15',
            'weather-sm-icon16','weather-sm-icon17','weather-sm-icon18','weather-sm-icon19','weather-sm-icon2',
            'weather-sm-icon20','weather-sm-icon3','weather-sm-icon4','weather-sm-icon5','weather-sm-icon6',
            'weather-sm-icon7','weather-sm-icon8','weather-sm-icon9');
        ?>
        <div class="od-small-icons-wrap">
            <div class="od-current-small-icon" data-icon-name="<?php echo $icon_name; ?>"></div>
            <a class="acf-button blue od-choose-small-icon" href="#"><?php echo $select_btn_text; ?></a>
            <a class="button od-remove-small-icon <?php echo $rm_btn_class; ?>" href="#"><?php _e( 'Remove icon', 'outdoor' ); ?></a>
            <div class="od-small-icons-box">
                <?php foreach( $sm_icons as $icon ) : ?>
                    <?php $current = ( $icon_name == $icon ) ? 'class="current"' : ''; ?>
                    <span <?php echo $current; ?> data-icon-name="<?php echo $icon; ?>"><img src="<?php echo OUTDOOR_ASSETS_URI; ?>/images/small-icons/<?php echo $icon; ?>.svg" alt="<?php echo $icon; ?>"></span>
                <?php endforeach; ?>
            </div>
            <input type="hidden" name="<?php echo esc_attr($field['name']) ?>" value="<?php echo esc_attr($field['value']) ?>">
        </div>
    <?php
    }


    /*
    *  input_admin_enqueue_scripts()
    *
    *  This action is called in the admin_enqueue_scripts action on the edit screen where your field is created.
    *  Use this action to add CSS + JavaScript to assist your render_field() action.
    *
    *  @type	action (admin_enqueue_scripts)
    *  @since	3.6
    *  @date	23/01/13
    *
    *  @param	n/a
    *  @return	n/a
    */
    /*

    function input_admin_enqueue_scripts() {

        $dir = plugin_dir_url( __FILE__ );


        // register & include JS
        wp_register_script( 'acf-input-FIELD_NAME', "{$dir}js/input.js" );
        wp_enqueue_script('acf-input-FIELD_NAME');


        // register & include CSS
        wp_register_style( 'acf-input-FIELD_NAME', "{$dir}css/input.css" );
        wp_enqueue_style('acf-input-FIELD_NAME');


    }

    */


    /*
    *  input_admin_head()
    *
    *  This action is called in the admin_head action on the edit screen where your field is created.
    *  Use this action to add CSS and JavaScript to assist your render_field() action.
    *
    *  @type	action (admin_head)
    *  @since	3.6
    *  @date	23/01/13
    *
    *  @param	n/a
    *  @return	n/a
    */
    /*

    function input_admin_head() {



    }

    */


    /*
       *  input_form_data()
       *
       *  This function is called once on the 'input' page between the head and footer
       *  There are 2 situations where ACF did not load during the 'acf/input_admin_enqueue_scripts' and
       *  'acf/input_admin_head' actions because ACF did not know it was going to be used. These situations are
       *  seen on comments / user edit forms on the front end. This function will always be called, and includes
       *  $args that related to the current screen such as $args['post_id']
       *
       *  @type	function
       *  @date	6/03/2014
       *  @since	5.0.0
       *
       *  @param	$args (array)
       *  @return	n/a
       */

    /*

    function input_form_data( $args ) {



    }

    */


    /*
    *  input_admin_footer()
    *
    *  This action is called in the admin_footer action on the edit screen where your field is created.
    *  Use this action to add CSS and JavaScript to assist your render_field() action.
    *
    *  @type	action (admin_footer)
    *  @since	3.6
    *  @date	23/01/13
    *
    *  @param	n/a
    *  @return	n/a
    */
    /*

    function input_admin_footer() {



    }

    */


    /*
    *  field_group_admin_enqueue_scripts()
    *
    *  This action is called in the admin_enqueue_scripts action on the edit screen where your field is edited.
    *  Use this action to add CSS + JavaScript to assist your render_field_options() action.
    *
    *  @type	action (admin_enqueue_scripts)
    *  @since	3.6
    *  @date	23/01/13
    *
    *  @param	n/a
    *  @return	n/a
    */
    /*

    function field_group_admin_enqueue_scripts() {

    }

    */

    /*
    *  field_group_admin_head()
    *
    *  This action is called in the admin_head action on the edit screen where your field is edited.
    *  Use this action to add CSS and JavaScript to assist your render_field_options() action.
    *
    *  @type	action (admin_head)
    *  @since	3.6
    *  @date	23/01/13
    *
    *  @param	n/a
    *  @return	n/a
    */
    /*

    function field_group_admin_head() {

    }

    */
    /*
    *  load_value()
    *
    *  This filter is applied to the $value after it is loaded from the db
    *
    *  @type	filter
    *  @since	3.6
    *  @date	23/01/13
    *
    *  @param	$value (mixed) the value found in the database
    *  @param	$post_id (mixed) the $post_id from which the value was loaded
    *  @param	$field (array) the field array holding all the field options
    *  @return	$value
    */

    /*

    function load_value( $value, $post_id, $field ) {

        return $value;

    }

    */


    /*
    *  update_value()
    *
    *  This filter is applied to the $value before it is saved in the db
    *
    *  @type	filter
    *  @since	3.6
    *  @date	23/01/13
    *
    *  @param	$value (mixed) the value found in the database
    *  @param	$post_id (mixed) the $post_id from which the value was loaded
    *  @param	$field (array) the field array holding all the field options
    *  @return	$value
    */

    /*

    function update_value( $value, $post_id, $field ) {

        return $value;

    }

    */


    /*
    *  format_value()
    *
    *  This filter is appied to the $value after it is loaded from the db and before it is returned to the template
    *
    *  @type	filter
    *  @since	3.6
    *  @date	23/01/13
    *
    *  @param	$value (mixed) the value which was loaded from the database
    *  @param	$post_id (mixed) the $post_id from which the value was loaded
    *  @param	$field (array) the field array holding all the field options
    *
    *  @return	$value (mixed) the modified value
    */

    /*

    function format_value( $value, $post_id, $field ) {

        // bail early if no value
        if( empty($value) ) {

            return $value;

        }


        // apply setting
        if( $field['font_size'] > 12 ) {

            // format the value
            // $value = 'something';

        }


        // return
        return $value;
    }

    */


    /*
    *  validate_value()
    *
    *  This filter is used to perform validation on the value prior to saving.
    *  All values are validated regardless of the field's required setting. This allows you to validate and return
    *  messages to the user if the value is not correct
    *
    *  @type	filter
    *  @date	11/02/2014
    *  @since	5.0.0
    *
    *  @param	$valid (boolean) validation status based on the value and the field's required setting
    *  @param	$value (mixed) the $_POST value
    *  @param	$field (array) the field array holding all the field options
    *  @param	$input (string) the corresponding input name for $_POST value
    *  @return	$valid
    */

    /*

    function validate_value( $valid, $value, $field, $input ){

        // Basic usage
        if( $value < $field['custom_minimum_setting'] )
        {
            $valid = false;
        }


        // Advanced usage
        if( $value < $field['custom_minimum_setting'] )
        {
            $valid = __('The value is too little!','outdoor'),
        }


        // return
        return $valid;

    }

    */


    /*
    *  delete_value()
    *
    *  This action is fired after a value has been deleted from the db.
    *  Please note that saving a blank value is treated as an update, not a delete
    *
    *  @type	action
    *  @date	6/03/2014
    *  @since	5.0.0
    *
    *  @param	$post_id (mixed) the $post_id from which the value was deleted
    *  @param	$key (string) the $meta_key which the value was deleted
    *  @return	n/a
    */

    /*

    function delete_value( $post_id, $key ) {



    }

    */


    /*
    *  load_field()
    *
    *  This filter is applied to the $field after it is loaded from the database
    *
    *  @type	filter
    *  @date	23/01/2013
    *  @since	3.6.0
    *
    *  @param	$field (array) the field array holding all the field options
    *  @return	$field
    */

    /*

    function load_field( $field ) {

        return $field;

    }

    */


    /*
    *  update_field()
    *
    *  This filter is applied to the $field before it is saved to the database
    *
    *  @type	filter
    *  @date	23/01/2013
    *  @since	3.6.0
    *
    *  @param	$field (array) the field array holding all the field options
    *  @return	$field
    */

    /*

    function update_field( $field ) {

        return $field;

    }

    */


    /*
    *  delete_field()
    *
    *  This action is fired after a field is deleted from the database
    *
    *  @type	action
    *  @date	11/02/2014
    *  @since	5.0.0
    *
    *  @param	$field (array) the field array holding all the field options
    *  @return	n/a
    */

    /*

    function delete_field( $field ) {



    }

    */


}
// create field
new acf_field_small_icon();
?>