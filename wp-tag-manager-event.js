window.addEventListener('unload', function() {

  console.log(jQuery("meta[name='wp_tag_scroll']").attr("content"));

  if( window.google_tag_manager == true ) {
    gtag(
      'event', 'scroll', {
      'event_category': 'scroll max',
      'event_label': 'The user has scrolled this percentage of the page: ' + jQuery("meta[name='wp_tag_scroll']").attr("content"),
      'value': 1
    });
  }

  if( window.google_tag_manager == false && window.analitycs == true ) {
    ga('send', 'event', 'scroll max', 'scroll', 'The user has scrolled this percentage of the page: ' + jQuery("meta[name='wp_tag_scroll']").attr("content"), 1);
  }

});

jQuery(document).ready(function () {

  window.addEventListener('load', function () {
		if(window.ga && ga.create) {
			window.analitycs = true;
		} else {
			window.analitycs = false;
		}

		if(window.google_tag_manager) {
			window.google_tag_manager = true;
		} else {
			window.google_tag_manager = false;
		}
	}, false);

  var tags = jQuery('meta[name=wp_tag]');

  jQuery('meta[name=wp_tag]').each(function(index,node) {
    var selector = jQuery(node).attr('data-selector');
    var element = jQuery(node).attr('data-element');
    var eventCategory = jQuery(node).attr('data-eventcategory');
    var eventAction = jQuery(node).attr('data-eventaction');
    var eventLabel = jQuery(node).attr('data-eventlabel');

    if(selector == 'class') {
      jQuery('.' + element.toString()).on('click', function () {
        console.log('detected - click on link and selector is class: ', eventCategory + ' ' + eventAction + ' ' + eventLabel);

        if( window.google_tag_manager == true ) {
          gtag(
            'event', eventAction, {
            'event_category': eventCategory,
            'event_label': eventLabel,
            'value': 1
          });
        }

        if( window.google_tag_manager == false && window.analitycs == true ){
          ga('send', 'event', eventCategory, eventAction, eventLabel, 1);
        }

      });
    }else if (selector == 'id') {
      jQuery('#'+element.toString()).on('click', function(){
        console.log('detected - click on link and selector is id: ', eventCategory + ' ' + eventAction + ' ' + eventLabel);

        if( window.google_tag_manager == true ){
          gtag('event', eventAction, {
            'event_category': eventCategory,
            'event_label': eventLabel,
            'value': 1
          });
        }

        if( window.google_tag_manager == false && window.analitycs == true ) {
          ga('send', 'event', eventCategory, eventAction, eventLabel, 1);
        }
      });
    } else if (selector == 'text') {

      jQuery('a').on('click', function(){
        if( jQuery(this).text().toLowerCase().indexOf(element.toLowerCase()) !== -1 ) {
          console.log('detected - click on link and selector is text: ', eventCategory + ' ' + eventAction + ' ' + eventLabel);

          if( window.google_tag_manager == true ) {
            gtag(
              'event', eventAction, {
              'event_category': eventCategory,
              'event_label': eventLabel,
              'value': 1
            });
          }

          if( window.google_tag_manager == false && window.analitycs == true ) {
            ga('send', 'event', eventCategory, eventAction, eventLabel, 1);
          }
        }
      });

      jQuery('input[type="submit"]').on('click', function () {
        if( jQuery(this).val().toLowerCase().indexOf(element.toLowerCase()) !== -1 ) {
          console.log('detected - click on submit and selector is text: ', eventCategory + ' ' + eventAction + ' ' + eventLabel);

          if( window.google_tag_manager == true ) {
            gtag(
              'event', eventAction, {
              'event_category': eventCategory,
              'event_label': eventLabel,
              'value': 1
            });
          }

          if( window.google_tag_manager == false && window.analitycs == true ) {
            ga('send', 'event', eventCategory, eventAction, eventLabel, 1);
          }
        }
      });

      jQuery('button').on('click', function () {
        if( jQuery(this).val().toLowerCase().indexOf(element.toLowerCase()) !== -1 ) {
          console.log('detected - click on button and selector is text: ', eventCategory + ' ' + eventAction + ' ' + eventLabel);

          if( window.google_tag_manager == true ) {
            gtag(
              'event', eventAction, {
              'event_category': eventCategory,
              'event_label': eventLabel,
              'value': 1
            });
          }

          if( window.google_tag_manager == false && window.analitycs == true ) {
            ga('send', 'event', eventCategory, eventAction, eventLabel, 1);
          }
        }
      });
    } else if (selector == 'scroll') {

      jQuery(window).scroll(function(e) {
        var docHeight = jQuery(document).height();
        var winHeight = jQuery(window).height();
				var scrollTop = jQuery(window).scrollTop();
				var scrollPercent = ( scrollTop / docHeight ) *100;

        if (scrollPercent > 75 && scrollPercent < 100) {
          jQuery("meta[name='wp_tag_scroll']").attr("content", '75-100 %');
        }else if(scrollPercent > 50 && scrollPercent < 75) {
          jQuery("meta[name='wp_tag_scroll']").attr("content", '50-75 %');
        }else if(scrollPercent > 25 && scrollPercent < 50) {
          jQuery("meta[name='wp_tag_scroll']").attr("content", '25-50 %');
        }else if(scrollPercent > 0 && scrollPercent < 25) {
          jQuery("meta[name='wp_tag_scroll']").attr("content", '0-25 %');
        }else if(scrollPercent == 0) {
          jQuery("meta[name='wp_tag_scroll']").attr("content", '0 %');
        }
      });
    }
  })
  return false;
})
