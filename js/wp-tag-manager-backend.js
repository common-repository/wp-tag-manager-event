jQuery(document).ready(function () {

  jQuery('#wptme_select').change(function () {

    if(jQuery('#wptme_select').val() === 'scroll') {
      jQuery('#wptme_category').attr('disabled', true);
      jQuery('#wptme_action').attr('disabled', true);
      jQuery('#wptme_label').attr('disabled', true);
    } else {
      jQuery('#wptme_category').attr('disabled', false);
      jQuery('#wptme_action').attr('disabled', false);
      jQuery('#wptme_label').attr('disabled', false);
    }
  });

});
