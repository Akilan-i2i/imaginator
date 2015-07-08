<?php
/***************************************************************************************
 * Create table subscribers if not exists
 **************************************************************************************/
function outdoor_create_subscribers_table() {
    global $wpdb;
    $new_table = $wpdb->prefix . 'outdoor_subscribers';

    if( $wpdb->get_var( "show tables like '{$new_table}'" ) !== $new_table ) {
        $sql =  "CREATE TABLE " . $new_table . " (
                  id int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                  email VARCHAR(255) NOT NULL UNIQUE,
                  PRIMARY KEY (id)) CHARACTER SET utf8 COLLATE utf8_general_ci;";

        $wpdb->query( $sql );
    }

    if ( !isset( $wpdb->od_subsribers ) ) {
        $wpdb->od_subscribers = $new_table;
        $wpdb->tables[] = str_replace($wpdb->prefix, '', $new_table);
    }
}
add_action( 'init', 'outdoor_create_subscribers_table' );

/***************************************************************************************
 * Add subscribers page
 **************************************************************************************/
function outdoor_add_subscribers_page(){
    add_menu_page( __( 'Subscribers', 'outdoor' ), __( 'Subscribers', 'outdoor' ), 'manage_options', 'od-subscribers', 'outdoor_subscribers_page_render', '', '21.7' );
}
add_action( 'admin_menu', 'outdoor_add_subscribers_page' );

function outdoor_subscribers_page_render() {
    global $wpdb;
    $subscribers = $wpdb->get_results("SELECT * FROM $wpdb->od_subscribers ORDER BY id DESC");
// End php code ?>

    <div id="od-subscribers-wrap" class="wrap">
        <h2><?php _e( 'Subscribers', 'outdoor' ) ?></h2>
        <table id="od-subscribers" class="wp-list-table widefat striped">

        <?php if( $subscribers ) : ?>

            <thead>
            <tr>
                <th class="manage-column" scope="col">id</th>
                <th class="manage-column" scope="col">E-mail</th>
            </tr>
            </thead>

            <?php foreach( $subscribers as $subscriber ) : ?>
                <tr>
                    <td class="subscriber-id"><?php echo $subscriber->id; ?></td>
                    <td class="subscriber-email"><?php echo $subscriber->email; ?></td>
                </tr>
            <?php endforeach; ?>

        <?php else: ?>
            <tr class="not-found"><td><p><?php _e( 'Subscribers not found!', 'outdoor' ) ?></p></td></tr>
        <?php endif; ?>

        </table>
        <p class="submit">
            <input id="new-subscriber-email" type="email" placeholder="<?php _e( 'Enter email address', 'outdoor' ) ?>">
            <a id="od-add-subscribe" class="button button-primary" href="javascript: void(0);"><?php _e( 'Add new subscriber', 'outdoor' ) ?></a>
            <a id="od-remove-subscribers" class="button" href="javascript: void(0);"><?php _e( 'Remove all subscribers', 'outdoor' ) ?></a>
        </p>
    </div>

<?php // Start php code
}

/***************************************************************************************
 * Add export subscribers page
 **************************************************************************************/
function outdoor_add_export_page(){
    add_submenu_page( 'od-subscribers', __( 'Export subscribers', 'outdoor' ), __( 'Export', 'outdoor' ), 'manage_options', 'od-export-subscribers', 'outdoor_export_page_render' );
}
add_action( 'admin_menu', 'outdoor_add_export_page' );

function outdoor_export_page_render() {
// End php code ?>

    <div class="wrap">
        <h2><?php _e( 'Export subscribers', 'outdoor' ) ?></h2>
        <form id="od-export-subscribers" action="" method="POST">
            <table class="form-table">
                <tbody>
                <tr>
                    <th scope="row"><label for="export_format"><?php _e( 'Format', 'outdoor' ) ?></label></th>
                    <td>
                        <select name="export_format" id="export_format">
                            <option value="csv" selected>CSV</option>
                        </select>
                    </td>
                </tr>
                </tbody>
            </table>
            <p class="submit">
                <input type="submit" value="<?php _e( 'Export', 'outdoor' ) ?>" class="button button-primary" id="od-export-btn" name="od_export">
            </p>
        </form>
    </div>

<?php // Start php code
}

/***************************************************************************************
 * Export .csv output
 **************************************************************************************/
function outputCSV( $data ) {
    $output = fopen( 'php://output', 'w' );
    foreach ( $data as $row ) {
        fputcsv( $output, $row, ',' );
    }
    fclose( $output );
}

add_action( 'admin_init', function(){
    global $wpdb;

    if( isset( $_POST['od_export'] ) ) {
        $filename = 'subscribers_' . time() . '.csv';
        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename={$filename}");
        header("Pragma: no-cache");
        header("Expires: 0");

        $subscribers = $wpdb->get_results("SELECT * FROM $wpdb->od_subscribers ORDER BY id DESC");
        $subscribers_list = array(
            array(
                'Email Address',
                'First Name',
                'Last Name'
            )
        );

        if( $subscribers ) {
            foreach( $subscribers as $subscriber ) {
                $subscribers_list[] = array(
                    'email' => $subscriber->email,
                    '',
                    ''
//                    'name'  => substr( $subscriber->email, 0, strpos( $subscriber->email, '@' ) )
                );
            }

            outputCSV( $subscribers_list );
            exit();
        }
    }
} );