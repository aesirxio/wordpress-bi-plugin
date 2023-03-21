<?php

add_action('admin_init', function () {
    register_setting(
        'aesirx_bi_plugin_options',
        'aesirx_bi_plugin_options',
        function ($value) {
            return $value;
        });
    add_settings_section('aesirx_bi_settings', 'Aesirx BI', function () {
        echo '<p>' . __('Here you can set all the options for using the AesirX BI', 'aesirx-bi') . '</p>';
    }, 'aesirx_bi_plugin');

    add_settings_field('aesirx_bi_domain_react_app_client_id', __('REACT_APP_CLIENT_ID', 'aesirx-bi'), function () {
        $options = get_option('aesirx_bi_plugin_options', []);
        echo "<input id='aesirx_bi_domain' name='aesirx_bi_plugin_options[aesirx_bi_domain_react_app_client_id]' type='text' value='" . esc_attr($options['aesirx_bi_domain_react_app_client_id'] ?? '') . "' />";
    }, 'aesirx_bi_plugin', 'aesirx_bi_settings');

    add_settings_field('aesirx_bi_domain_react_app_client_secret', __('REACT_APP_CLIENT_SECRET', 'aesirx-bi'), function () {
        $options = get_option('aesirx_bi_plugin_options', []);
        echo "<input id='aesirx_bi_domain' name='aesirx_bi_plugin_options[aesirx_bi_domain_react_app_client_secret]' type='text' value='" . esc_attr($options['aesirx_bi_domain_react_app_client_secret'] ?? '') . "' />";
    }, 'aesirx_bi_plugin', 'aesirx_bi_settings');

    add_settings_field('aesirx_bi_domain_react_app_endpoint_url', __('REACT_APP_ENDPOINT_URL', 'aesirx-bi'), function () {
        $options = get_option('aesirx_bi_plugin_options', []);
        echo "<input id='aesirx_bi_domain' name='aesirx_bi_plugin_options[aesirx_bi_domain_react_app_endpoint_url]' type='text' value='" . esc_attr($options['aesirx_bi_domain_react_app_endpoint_url'] ?? '') . "' />";
    }, 'aesirx_bi_plugin', 'aesirx_bi_settings');

    add_settings_field('aesirx_bi_domain_react_app_license', __('REACT_APP_LICENSE', 'aesirx-bi'), function () {
        $options = get_option('aesirx_bi_plugin_options', []);
        echo "<input id='aesirx_bi_domain' name='aesirx_bi_plugin_options[aesirx_bi_domain_react_app_license]' type='text' value='" . esc_attr($options['aesirx_bi_domain_react_app_license'] ?? '') . "' />";
    }, 'aesirx_bi_plugin', 'aesirx_bi_settings');

    add_settings_field('aesirx_bi_domain_react_app_data_stream', __('REACT_APP_DATA_STREAM', 'aesirx-bi'), function () {
        $options = get_option('aesirx_bi_plugin_options', []);
        echo "<input id='aesirx_bi_domain' name='aesirx_bi_plugin_options[aesirx_bi_domain_react_app_data_stream]' type='text' value='" . esc_attr($options['aesirx_bi_domain_react_app_data_stream'] ?? '') . "' />";
    }, 'aesirx_bi_plugin', 'aesirx_bi_settings');
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
                do_settings_sections('aesirx_bi_plugin'); ?>
                <input name="submit" class="button button-primary" type="submit" value="<?php esc_attr_e('Save'); ?>"/>
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
            include ( 'dashboard.php');
        }
    );
});

add_action('admin_enqueue_scripts', function () {
    $options = get_option('aesirx_bi_plugin_options');
    ?>
    <script>
        window.env = {};
        window.env.REACT_APP_CLIENT_ID = "<?php echo $options['aesirx_bi_domain_react_app_client_id'] ?>";
        window.env.REACT_APP_CLIENT_SECRET = "<?php echo $options['aesirx_bi_domain_react_app_client_secret'] ?>";
        window.env.REACT_APP_ENDPOINT_URL = "<?php echo $options['aesirx_bi_domain_react_app_endpoint_url'] ?>";
        window.env.REACT_APP_LICENSE = "<?php echo $options['aesirx_bi_domain_react_app_license'] ?>";
        window.env.REACT_APP_DATA_STREAM = "<?php echo $options['aesirx_bi_domain_react_app_data_stream'] ?>";
    </script>
    <%= htmlWebpackPlugin.tags.headTags %>
    <?php
});
