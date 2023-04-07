<?php

add_action('admin_init', function () {
  register_setting('aesirx_bi_plugin_options', 'aesirx_bi_plugin_options', function ($value) {
    return $value;
  });
  add_settings_section(
    'aesirx_bi_settings',
    'Aesirx BI',
    function () {
      echo '<p>' .
        __('Here you can set all the options for using the AesirX BI', 'aesirx-bi') .
        '</p>';
    },
    'aesirx_bi_plugin'
  );

  add_settings_field(
    'aesirx_bi_domain_react_app_endpoint_url',
    __('REACT_APP_ENDPOINT_URL', 'aesirx-bi'),
    function () {
      $options = get_option('aesirx_bi_plugin_options', []);
      echo "<input id='aesirx_bi_domain' name='aesirx_bi_plugin_options[aesirx_bi_domain_react_app_endpoint_url]' type='text' value='" .
        esc_attr($options['aesirx_bi_domain_react_app_endpoint_url'] ?? '') .
        "' />";
    },
    'aesirx_bi_plugin',
    'aesirx_bi_settings'
  );

  add_settings_field(
    'aesirx_bi_domain_react_app_data_stream',
    __('REACT_APP_DATA_STREAM', 'aesirx-bi'),
    function () {
      $options = get_option('aesirx_bi_plugin_options', []);

      echo '<table width="100%" border="0" id="asirx_bi_wp_setting_table" cellspacing="0">
                <tr>
                    <th width="50%">' .
        __('STREAM_NAME', 'aesirx-bi') .
        '</th>
                    <th width="50%">' .
        __('STREAM_DOMAIN', 'aesirx-bi') .
        '</th>
                </tr>';

      $rowNumber = 0;

      if (empty(esc_attr($options['aesirx_bi_domain_react_app_data_stream']))) { ?>
            <tr>
                <td>
                    <input class="regular-text ltr" id='aesirx_bi_plugin_options_stream_name_0' name='aesirx_bi_plugin_options[aesirx_bi_domain_react_app_data_stream][stream0][name]' type='text' value='' />
                </td>
                <td>
                    <input class="regular-text ltr" id='aesirx_bi_plugin_options_stream_domain_0' name='aesirx_bi_plugin_options[aesirx_bi_domain_react_app_data_stream][stream0][domain]' type='text' value='' />
                </td>
            </tr>
            <?php $rowNumber++;} else {foreach (
          $options['aesirx_bi_domain_react_app_data_stream']
          as $key => $data
        ) { ?>
                <tr>
                    <td>
                        <input
                                id='aesirx_bi_plugin_options_stream_name_<?php echo $rowNumber; ?>'
                                name='aesirx_bi_plugin_options[aesirx_bi_domain_react_app_data_stream][stream<?php echo $rowNumber; ?>][name]'
                                type='text'
                                class="regular-text ltr"
                                value='<?php echo esc_attr($data['name'] ?? ''); ?>'
                        />
                    </td>
                    <td>
                        <input
                                id='aesirx_bi_plugin_options_stream_domain_<?php echo $rowNumber; ?>'
                                name='aesirx_bi_plugin_options[aesirx_bi_domain_react_app_data_stream][stream<?php echo $rowNumber; ?>][domain]'
                                type='text'
                                class="regular-text ltr"
                                value='<?php echo esc_attr($data['domain'] ?? ''); ?>'
                        />
                    </td>
                    <td>
                        <button type="button" class="aesirx_bi_plugin_options_stream_delete">Delete</button>
                    </td>
                </tr>
                <?php $rowNumber++;}}

      echo '</table>';

      echo '<input type="hidden" name="row_number" id="aesirx_bi_setting_stream_row" value="' .
        $rowNumber .
        '" />';
      echo '<button type="button" onclick="addNewAesirxBISettingRow()" class="button button-secondary" name="aesirx_bi_stream_add_new_row" id="aesirx_bi_stream_add_new_row">' .
        __('ADD', 'aesirx-bi') .
        '</button>';
    },
    'aesirx_bi_plugin',
    'aesirx_bi_settings'
  );
});

add_action('admin_menu', function () {
  add_options_page(
    __('Aesirx BI', 'aesirx-bi'),
    __('Aesirx BI', 'aesirx-bi'),
    'manage_options',
    'aesirx-bi-plugin',
    function () {
      ?>
            <form action="options.php" method="post">
                <?php
                settings_fields('aesirx_bi_plugin_options');
                do_settings_sections('aesirx_bi_plugin');
                ?>
                <input name="submit" class="button button-primary" type="submit" value="<?php esc_attr_e(
                  'Save'
                ); ?>"/>
            </form>
            <?php
    }
  );

  add_menu_page(
    'AesirX BI Dashboard',
    'AesirX BI',
    'manage_options',
    'aesirx-bi-dashboard',
    function () {
      include 'dashboard.php';
    }
  );
});

add_action('admin_enqueue_scripts', function () {
  global $wp;
  $options = get_option('aesirx_bi_plugin_options');

  $streams = [];

  if (!empty($options['aesirx_bi_domain_react_app_data_stream'])) {
    foreach ($options['aesirx_bi_domain_react_app_data_stream'] as $key => $data) {
      $stream = [];
      $stream['name'] = $data['name'];
      $stream['domain'] = $data['domain'];

      $streams[] = $stream;
    }
  }
  ?>
    <script>
        window.env = {};
        window.env.REACT_APP_CLIENT_ID = "app";
        window.env.REACT_APP_CLIENT_SECRET = "secret";
        window.env.REACT_APP_ENDPOINT_URL = "<?php echo $options[
          'aesirx_bi_domain_react_app_endpoint_url'
        ]; ?>";
        window.env.REACT_APP_LICENSE = "LICENSE";
        window.env.REACT_APP_DATA_STREAM = JSON.stringify(<?php echo json_encode($streams); ?>);
        window.env.PUBLIC_URL="/wp-content/plugins/aesirx-bi";

        function addNewAesirxBISettingRow(){
            var table       = document.getElementById('asirx_bi_wp_setting_table');
            var rowNumber   = parseInt(document.getElementById('aesirx_bi_setting_stream_row').value);

            var row = table.insertRow();

            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            var cell3 = row.insertCell(2);

            var streamName = document.createElement("input");
            streamName.setAttribute("type", "text");
            streamName.setAttribute("class", "regular-text ltr");
            streamName.setAttribute("name", "aesirx_bi_plugin_options[aesirx_bi_domain_react_app_data_stream][stream"+ rowNumber +"][name]");
            streamName.setAttribute("id","aesirx_bi_plugin_options_stream_name_"+rowNumber);

            var streamDomain = document.createElement("input");
            streamDomain.setAttribute("type", "text");
            streamDomain.setAttribute("class", "regular-text ltr");
            streamDomain.setAttribute("name", "aesirx_bi_plugin_options[aesirx_bi_domain_react_app_data_stream][stream"+ rowNumber +"][domain]");
            streamDomain.setAttribute("id","aesirx_bi_plugin_options_stream_domain_"+rowNumber);

            var streamDelete = document.createElement("button");
            streamDelete.setAttribute("type", "button");
            streamDelete.setAttribute("class", "aesirx_bi_plugin_options_stream_delete");
            streamDelete.textContent = "Delete";

            streamDelete.addEventListener('click', function (e) {
                e.target.parentElement.parentElement.remove();
            })

            cell1.appendChild(streamName);
            cell2.appendChild(streamDomain);
            cell3.appendChild(streamDelete);

            rowNumber++;
            document.getElementById('aesirx_bi_setting_stream_row').value = rowNumber;
            return false;
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.aesirx_bi_plugin_options_stream_delete').forEach(function(button) {
                button.onclick = function(e) {
                    e.target.parentElement.parentElement.remove();
                }
            });
        });

    </script>
    <%= htmlWebpackPlugin.tags.headTags %>
    <?php
});
