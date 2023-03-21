<?php

$options = get_option('aesirx_bi_plugin_options');

echo "<h1>AesirX Dasboard</h1>";

?>

<script>
    window.env = [];
    window.env.REACT_APP_CLIENT_ID = "<?php echo $options['aesirx_bi_domain_react_app_client_id'] ?>";
    window.env.REACT_APP_CLIENT_SECRET = "<?php echo $options['aesirx_bi_domain_react_app_client_secret'] ?>";
    window.env.REACT_APP_ENDPOINT_URL = "<?php echo $options['aesirx_bi_domain_react_app_endpoint_url'] ?>";
    window.env.REACT_APP_LICENSE = "<?php echo $options['aesirx_bi_domain_react_app_license'] ?>";
    window.env.REACT_APP_DATA_STREAM = "<?php echo $options['aesirx_bi_domain_react_app_data_stream'] ?>";
</script>