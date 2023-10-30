<?php 
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

function fwp_add_facet_labels() {
    if ( !function_exists( 'facetwp_display' ) ) return false;
  ?>
    <script>
      (function($) {
        $(document).on('facetwp-loaded', function() {
          $('.facetwp-facet').each(function() {
            var facet = $(this);
            var facet_name = facet.attr('data-name');
            var facet_type = facet.attr('data-type');
            var facet_label = FWP.settings.labels[facet_name];
            if (facet_type !== 'pager' && facet_type !== 'sort' && facet_type !== 'search' && facet_type !== 'reset') {
              if (facet.closest('.facet-wrap').length < 1 && facet.closest('.facetwp-flyout').length < 1) {
                facet.wrap('<div class="facet-wrap"></div>');
                facet.before('<label class="facet-label">' + facet_label + '</label>');
              }
            }
          });
        });
      })(jQuery);
    </script>
  <?php
}
add_action( 'wp_head', 'fwp_add_facet_labels', 100 );

add_action( 'wp_head', function() { ?>

  <script>
      (function($) {
          $(document).on('facetwp-refresh', function() {
              if ( FWP.soft_refresh == true ) {
                  FWP.enable_scroll = true;
              } else {
                  FWP.enable_scroll = false;
              }
          });
          $(document).on('facetwp-loaded', function() {
              if ( FWP.enable_scroll == true ) {
                  $('html, body').animate({ scrollTop: 0 }, 500);
              }
          });
      })(jQuery);
  </script>

<?php } );

add_action( 'wp_head', function() {
    ?>
      <script>
        (function($) {
          $(function() {
            if ('object' != typeof FWP) return;
   
            /* Modify each facet's wrapper HTML */
            FWP.hooks.addFilter('facetwp/flyout/facet_html', function(facet_html) {
              return facet_html.replace('<h3>{label}</h3>', '<label>{label}</label>');
            });
          });
        })(jQuery);
      </script>
    <?php
  }, 100 );

  add_action( 'wp_footer', function() {
    ?>
      <script>
        (function($) {
          document.addEventListener('facetwp-loaded', function() {
            $.each(FWP.settings.num_choices, function(key, val) {
   
              // assuming each facet is wrapped within a "facet-wrap" container element
              // this may need to change depending on your setup, for example:
              // change ".facet-wrap" to ".widget" if using WP text widgets
   
              var $facet = $('.facetwp-facet-' + key);
              var $wrap = $facet.closest('.facet-wrap');
              var $flyout = $facet.closest('.flyout-row');
              if ($wrap.length || $flyout.length) {
                var $which = $wrap.length ? $wrap : $flyout;
                (0 === val) ? $which.hide() : $which.show();
              }
            });
          });
        })(jQuery);
      </script>
    <?php
  }, 100 );