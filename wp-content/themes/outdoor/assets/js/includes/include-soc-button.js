/* ---------------------- SOCIAL BUTTONS --------------------------*/
function socialLink(){
  var urlsoc = location.href;
  $('.shared-btn').each(function(){
    new GetShare({
      root: $(this),
      network: $(this).data('network'),
      button: {text: ""},
      share: {
        url: urlsoc,
        message: 'Link to '+urlsoc+' '
      }
    });
  });
}

socialLink();