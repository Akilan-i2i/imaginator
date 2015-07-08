(function($){
  var $buttons_wrap,
      $fields_wrap,
      $input_icon_url,
      $icon_preview,
      $input_icon_name,
      $input_social_url,
      custom_icon_id,
      media_frame;

  $(document).ready(function(){
    $buttons_wrap = $('.od-social-buttons-wrap');
    $fields_wrap = $('.social-fields');

    $input_icon_url = $buttons_wrap.find('#custom-icon-url');
    $icon_preview = $buttons_wrap.find('#icon-preview');
    $input_icon_name = $buttons_wrap.find('input#icon-name');
    $input_social_url = $buttons_wrap.find('input#icon-url');

    custom_icon_id = parseInt( $buttons_wrap.find('.custom-icon').data('custom-icon-id') ) || 1;

    reset_custom_icon_fields();

    // Upload social icon
    $buttons_wrap.on('click', '#social-icon-upload', function(){

      //If the frame already exists, reopen it
      if (typeof(media_frame) !== "undefined") {
        media_frame.close();
      }

      //Create WP media frame.
      media_frame = wp.media.frames.customHeader = wp.media({
        //Title of media manager frame
        title: "Add custom social icon",
        library: {
          type: 'image'
        },
        button: {
          //Button text
          text: "Select"
        },
        //Do not allow multiple files, if you want multiple, set true
        multiple: false
      });

      //callback for selected image
      media_frame.on('select', function() {
        var attachment = media_frame.state().get('selection').first().toJSON();

        $input_icon_url.val(attachment.url);
        $icon_preview.html('<img src="' + attachment.url + '">').css({
          display: 'inline-block'
        });
      });

      //Open modal
      media_frame.open();

    });

    // Add custom social icon
    $buttons_wrap.on('click', '#add-social-icon', function(e) {
      e.preventDefault();

      var icon_img_url = $input_icon_url.val(),
          icon_name = $input_icon_name.val(),
          icon_url = $input_social_url.val(),
          icon_system_name = 'custom_icon_' + custom_icon_id;

      if( icon_img_url == '' ) {
        alert('Icon is not selected!');
        return false;
      } else if( icon_name == '' ) {
        alert("Icon name don't must be empty!");
        return false;
      }

      $fields_wrap.append('<div id="od-field-' + icon_system_name + '" class="social-field">' +
        '<span class="social-icon"><img src="' + icon_img_url + '"></span>' +
        '<span class="label">' + icon_name + '</span>' +
        '<input class="regular-text" type="hidden" name="outdoor_opt[od-social-buttons][' + icon_system_name + '][label]" value="' + icon_name + '">' +
        '<input class="regular-text" type="hidden" name="outdoor_opt[od-social-buttons][' + icon_system_name + '][img_url]" value="' + icon_img_url + '">' +
        '<input class="regular-text" type="text" name="outdoor_opt[od-social-buttons][' + icon_system_name + '][url]" value="' + icon_url + '">' +
        '<span class="remove-custom-icon" data-id="od-field-' + icon_system_name + '"><i class="fa fa-close"></i></span></div>');

      reset_custom_icon_fields();
      custom_icon_id++;
    });

    $buttons_wrap.on('click', '.remove-custom-icon', function() {
      var $this = $(this),
          $field_block = $('#' + $this.data('id')),
          do_remove = false;

      if($field_block.length > 0) {
        do_remove = confirm('Do you want remove this icon?');
        if(do_remove)
          $field_block.remove();
      }


    });

    // Sortable the social fields
    $('#social-field-list').sortable();
  });

  function reset_custom_icon_fields() {
    $icon_preview.hide();
    $input_icon_url.val('');
    $input_icon_name.val('');
    $input_social_url.val('');
  }

})(jQuery);