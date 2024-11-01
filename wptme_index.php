  <?php

    if(isset($_POST['wptme_nonce']) && wp_verify_nonce($_POST['wptme_nonce'], 'wptme-create_tag'))
    {
      if(isset($_POST['submit']) && ($_POST['submit'] == 'Aggiungi Tag' || $_POST['submit'] == 'Add Tag') && $_GET['page'] == 'wptme-page')
      {
        $selector = sanitize_text_field($_POST['selector']);
        $element = sanitize_text_field($_POST['element']);
        $eventCategory = sanitize_text_field($_POST['eventCategory']);
        $eventAction = sanitize_text_field($_POST['eventAction']);
        $eventLabel = sanitize_text_field($_POST['eventLabel']);

        $GLOBALS['WpTme']->save($selector, $element, $eventCategory, $eventAction, $eventLabel);
      }
    }

    if(isset($_GET['wptme_nonce']) && wp_verify_nonce($_GET['wptme_nonce'], 'wptme-create_tag'))
    {
      if(isset($_GET['comando']) && $_GET['comando'] == 'remove' && $_GET['page'] == 'wptme-page' && is_numeric($_GET['id']))
      {
        $id = sanitize_text_field($_GET['id']);
        $GLOBALS['WpTme']->delete($id);
      }
    }

    $results = $GLOBALS['WpTme']->all();
  ?>

  <script type="text/javascript">
      var selectFunction = function(select) {
          if(select.value == 'scroll') {
            document.getElementsByClassName("element")[0].placeholder  = "<?php _e('Indicates the Page to Monitor', 'wptme') ?>";
          } else {
            document.getElementsByClassName("element")[0].placeholder  = "<?php _e('Indicates the Label to Trace', 'wptme') ?>";
          }
      };
  </script>

  <style>
    table { width: 100%; text-align: left;}
    table tbody tr td,th{ padding:10px; }
    table tbody tr:nth-child(odd){
      background-color: #dedede;
    }
  </style>

  <div class="wrap">
    <h1> Wp Tag Manager List </h1>
    <div class="wrap">
      <div class="icon32" id="icon-options-general"><br /></div>
    </div>
    <form method="post" action="?page=wptme-page">
      <?php if(function_exists('wp_nonce_field')) {
        wp_nonce_field('wptme-create_tag', 'wptme_nonce');
      } ?>
      <p class="submit">
        <select id="wptme_select" name="selector" class="selector" onchange="selectFunction(this)" style="margin-top:-6px; height: 41px;">
          <option value="id">ID</option>
          <option value="class"><?php _e('Class', 'wptme'); ?></option>
          <option value="text"><?php _e('Text', 'wptme'); ?></option>
          <option value="scroll">Scroll</option>
        </select>
        <input id="wptme_category" class="all-options categoria" type="text" name="eventCategory" placeholder="<?php _e('Indicates the Category to Trace', 'wptme'); ?>" style="padding: 11px; " />
        <input id="wptme_action" class="all-options action" type="text" name="eventAction" placeholder="<?php _e('Indicates the Action to Trace', 'wptme'); ?>"  style="padding: 11px; " />
        <input id="wptme_label" class="all-options label" type="text" name="eventLabel"  placeholder="<?php _e('Indicates the Label to Trace', 'wptme'); ?>" style="padding: 11px; " />
        <input id="wptme_element" class="all-options element" type="text" name="element" placeholder="<?php _e('Indicates the Element to Trace', 'wptme'); ?>" style="padding: 11px; " />
        <input type="submit" name="submit" id="submit" class="button button-primary" value="<?php _e('Add Tag', 'wptme'); ?>" style="height: 40px; top:-2px; margin-top: 1%; position:relative;"  />
        <hr/>
      </p>
    </form>

    <table>
      <thead>
        <tr>
          <th> #                                 </th>
          <th> <?php _e('Category', 'wptme'); ?> </th>
          <th> <?php _e('Action', 'wptme'); ?>   </th>
          <th> <?php _e('Label', 'wptme'); ?>    </th>
          <th> <?php _e('Selector', 'wptme'); ?> </th>
          <th> <?php _e('Element', 'wptme'); ?>  </th>
          <th> &nbsp;                            </th>
        </tr>
      </thead>

      <tbody>
        <?php foreach ($results as $key => $value) { ?>
          <tr>
            <td valign="top"><b>#<?php echo $value->id; ?></b></td>
            <td valign="top"><b><?php echo $value->eventCategory; ?></b></td>
            <td valign="top"><b><?php echo $value->eventAction; ?></b></td>
            <td valign="top"><b><?php echo $value->eventLabel; ?></b></td>
            <td valign="top"><b><?php echo $value->selector; ?></b></td>
            <td valign="top"><b><?php echo ($value->selector == 'scroll' ? esc_url($value->element) : $value->element); ?></b></td>
            <td valign="top"><a style=" color: #404040; text-decoration: none; " href="<?php echo (function_exists('wp_nonce_url') ? wp_nonce_url(admin_url("options-general.php?page=wptme-page&comando=remove&id={$value->id}"), 'wptme-create_tag', 'wptme_nonce') : "?page=wptme-page&comando=remove&id={$value->id}"); ?>"> <span class="dashicons dashicons-trash"></span> </a></td>
          </tr>
        <?php } ?>
      </tbody>
    </table>

    <div style="margin-top: 4%; font-style: italic; color: #555d66; font-size: 15px">
      <?php _e('For support or specific requests contact:', 'wptme'); ?> <a href="mailto:assistenza@wp-love.it">assistenza@wp-love.it</a>
    </div>

  </div>
