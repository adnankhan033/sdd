jQuery(document).ready(function($) {
    $('.copy-link').on('click', function(e) {
      e.preventDefault();
      var text = $(this).data('link');
  
      // Copy to clipboard
      var tempInput = $('<input>');
      $('body').append(tempInput);
      tempInput.val(text).select();
      document.execCommand('copy');
      tempInput.remove();
  
      // Show popup
      $('.copy-popup').fadeIn(200).delay(1200).fadeOut(400);
    });
  });