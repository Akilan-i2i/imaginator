(function($){
  var icons_path_url = window.outdoor.theme_url + '/assets/images/small-icons/';

  $(document).ready(function(){
    var $icons_wrap = $('.od-small-icons-wrap'),
        $icons_box = $('.od-small-icons-box'),
        $remove_btn = $('.od-remove-small-icon'),
        $current_icon_box = $('.od-current-small-icon'),
        $current_icon_name = $current_icon_box.data('icon-name'),
        $input = $icons_wrap.children('input[type="hidden"]'),
        icons_loaded = false;

    if($current_icon_name != '') {
      $current_icon_box.css({
        height: '34px',
        width: '34px'
      }).html('<img src="' + icons_path_url + $current_icon_name + '.svg">');
    }

    $icons_wrap.on('click', '.od-choose-small-icon', function(e){
      e.preventDefault();

      if($icons_box.hasClass('active')) {
        $icons_box.removeClass('active');
      } else {
        $icons_box.addClass('active');
      }
    });

    $icons_box.on('click', 'span', function(){
      var $this = $(this),
          icon_name = $this.data('icon-name');

      $icons_box.children('span.current').removeClass('current');
      if(!$this.hasClass('current')) {
        $this.addClass('current');
        $current_icon_box.css({
          height: '34px',
          width: '34px'
        }).html($this.html());
        $remove_btn.addClass('visible');
        $input.val(icon_name);
        $('.od-choose-small-icon').text('Change icon');
        $icons_box.removeClass('active');
      }
    });

    $remove_btn.on('click', function(e){
      e.preventDefault();
      $input.val('');
      $('.od-current-small-icon').css({
        height: '0',
        width: '0'
      }).html('');
      $icons_box.children('span.current').removeClass('current');
      $remove_btn.removeClass('visible');
      $('.od-choose-small-icon').text('Select icon');
    });

    // Subscribers manage
    var $subscribers_wrap = $('#od-subscribers-wrap'),
        $new_email_field = $('#new-subscriber-email');

    $subscribers_wrap.on('click', '#od-add-subscribe', function(e){
      e.preventDefault();
      var new_email = $new_email_field.val();
      if( new_email == '' ) {
        alert('Enter a new email address!');
        return;
      }
      $.post(ajaxurl, {
        action: 'outdoor_add_subscriber',
        email: new_email
      }, function(response){
        response = $.parseJSON(response);
        if('success' === response.status) {
          window.location.reload();
//          $('#od-subscribers .not-found').remove();
//          $('#od-subscribers').prepend('<tr><td class="od-subscriber-id">' + response.data.id + '</td><td class="od-subscriber-email">' + response.data.email + '</td></tr>');
        } else if('fail' === response.status) {
          alert(response.error);
        }
      });
    });

    // Remove all subscribers
    $subscribers_wrap.on('click', '#od-remove-subscribers', function(e){
      e.preventDefault();
      var do_remove = confirm('Do you really want to do it?');
      if(do_remove == true) {
        $.post(ajaxurl, {
          action: 'outdoor_remove_subscribers'
        }, function(response){
          response = $.parseJSON(response);
          if('success' === response.status) {
            window.location.reload();
          } else if('fail' === response.status) {
            alert(response.error);
          }
        });
      }
    });
  });

})(jQuery);