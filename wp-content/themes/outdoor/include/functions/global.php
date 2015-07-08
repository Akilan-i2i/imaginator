<?php
/***************************************************************************************
 * Convert color hex to rgb format
 **************************************************************************************/
function outdoor_hex_to_rgb( $hex = null ) {

    if( !$hex || strlen( $hex ) != 7 )
        return;

    $hex = ltrim( $hex, '#' );
    $return = hexdec( $hex[0] . $hex[1] );
    $return .= ',' . hexdec( $hex[2] . $hex[3] );
    $return .= ',' . hexdec( $hex[4] . $hex[5] );
    return $return;
}

/***************************************************************************************
 * Remove default image size
 **************************************************************************************/
function outdoor_filter_image_sizes( $sizes ) {
    unset( $sizes['medium'] );
    unset( $sizes['large'] );
    return $sizes;
}
add_filter( 'intermediate_image_sizes_advanced', 'outdoor_filter_image_sizes' );

/***************************************************************************************
 * Enable support upload .svg format
 **************************************************************************************/
function outdoor_media_mime_types( $mimes ) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter( 'upload_mimes', 'outdoor_media_mime_types' );

/***************************************************************************************
 * Create @2x image if retina support enabled
 **************************************************************************************/
global $outdoor_opt;
$retina_support = ( isset( $outdoor_opt['od-retina-support'] ) ) ? $outdoor_opt['od-retina-support'] : false;

if( $retina_support ) :
function outdoor_create_retina_images( $data ) {
    $path = $data['file'];
    $origin_img = wp_get_image_editor( $path );

    if( is_wp_error( $origin_img ) )
        return $data;

    $img_info = pathinfo( $path );
    $dir = $img_info['dirname'] . '/';
    $ext = $img_info['extension'];
    $name = $img_info['filename'];
    $new_img_path = $dir . $name . '@2x' . '.' . $ext;

    if( copy( $path, $new_img_path ) ) {
        $origin_img_size = $origin_img->get_size();
        $origin_img->resize( $origin_img_size['width'] / 2, $origin_img_size['height'] / 2 );
        $origin_img->save( $path );
    }

    return $data;
}
add_filter( 'wp_handle_upload', 'outdoor_create_retina_images', 10 );

function outdoor_make_retina_size( $file, $width, $height, $crop = false ) {

    if( !$file || !$width || !$height )
        return false;

    $resized_file = wp_get_image_editor( $file );
    if ( !is_wp_error( $resized_file ) ) {
        $resized_file->resize( $width*2, $height*2, $crop );
        $filename = $resized_file->generate_filename( $width . 'x' . $height . '@2x'  );
        $resized_file->save($filename);
    }

    if ( !is_wp_error($resized_file) && $resized_file && $info = getimagesize( $filename ) ) {
        return array(
            'file' => wp_basename( $filename ),
            'width' => $info[0],
            'height' => $info[1],
        );
    }
}

function outdoor_add_retina_image_metadata( $metadata, $attachment_id ) {
    $file           = get_attached_file( $attachment_id );
    $old_metadata   = $metadata;

    foreach ( $metadata as $k => $v ) {
        if ( is_array( $v ) ) {
            foreach ( $v as $key => $val ) {
                if ( is_array( $val ) ) {
                    outdoor_make_retina_size( $file, $val['width'], $val['height'], true );
                }
            }
        }
    }
    return $old_metadata;
}
add_filter( 'wp_generate_attachment_metadata', 'outdoor_add_retina_image_metadata', 10, 2 );

function outdoor_delete_retina_images( $attachment_id ) {
    $metas = wp_get_attachment_metadata( $attachment_id );
    $path = pathinfo( $metas['file'] );
    $path_name = $path['dirname'];
    $updir = wp_upload_dir();

    // Remove @2x origin image
    $img_origin_filename = $updir['basedir'] . '/' . $metas['file'];
    $img_x2_filename = substr_replace( $img_origin_filename, '@2x.', strrpos( $img_origin_filename, '.' ), strlen( '.' ) );
    if ( file_exists( $img_x2_filename ) ) {
        unlink( $img_x2_filename );
    }

    // Remove @2x other sizes image
    foreach ( $metas as $meta => $meta_val ) {
        if ( $meta === "sizes" && $meta_val ) {
            foreach ( $meta_val as $sizes => $size ) {
                $original_filename = $updir['basedir'] . '/' . $path_name . '/' . $size['file'];
                $x2_filename = substr_replace( $original_filename, '@2x.', strrpos( $original_filename, '.' ), strlen( '.' ) );
                if ( file_exists( $x2_filename ) ) {
                    unlink( $x2_filename );
                }
            }
        }
    }
}
add_filter( 'delete_attachment', 'outdoor_delete_retina_images' );
endif; // if $retina_support