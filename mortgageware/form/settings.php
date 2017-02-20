<form method="post" action="options.php">
    <h1>MortgageWare <?=MW_VERSION?> Configuration</h1>
    <?php
        if (isset($_REQUEST['settings-updated'])) {?>
            <div style="background: #5cb85c; padding: 5px 20px; -webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px; color: #fff; margin-top: 10px; ">Configuration Saved!</div>
    <?php
        }
    ?>
    <hr>
    <?php settings_fields( 'mortgageware-settings-group' ); ?>
    <?php do_settings_sections( 'mortgageware-settings-group' ); ?>
    <h2 style="text-decoration: underline">API Settings</h2>
    <table class="form-table" style="width: 100%;">
<?php
/*
        <tr valign="top">
            <th scope="row">Site ID</th>
            <td><input type="text" style="width: 100%" name="mw_site_id" value="<?php echo esc_attr( get_option('mw_site_id') ); ?>" /></td>
        </tr>
        <tr valign="top">
            <th scope="row">Loan Officer ID</th>
            <td><input type="text" style="width: 100%" name="mw_loan_officer_id" value="<?php echo esc_attr( get_option('mw_loan_officer_id') ); ?>" /></td>
        </tr>
*/
?>
        <tr valign="top">
            <th scope="row">Debugging Enabled?<br><span style="color: #aaaaaa;">(Webmax Admin Only)</span></th>
            <td><input type="checkbox" name="mw_api_debugging" value="1" <?=esc_attr( get_option('mw_api_debugging') ) == 1?'checked':'' ?> /></td>
        </tr>
        <tr valign="top">
            <th scope="row">Loan Officer ID</th>
            <td><input type="text" style="width: 100%" name="mw_loan_officer_id" value="<?php echo esc_attr( get_option('mw_loan_officer_id') ); ?>" onkeyup="changeShortCode()" /></td>
        </tr>
        <tr valign="top">
            <th scope="row">Loan Officer Site ID</th>
            <td><input type="text" style="width: 100%" name="mw_site_id" value="<?php echo esc_attr( get_option('mw_site_id') ); ?>" onkeyup="changeShortCode()" /></td>
        </tr>
        <tr valign="top">
            <th scope="row">URL</th>
            <td><input type="text" style="width: 100%" name="mw_api_url" value="<?php echo esc_attr( get_option('mw_api_url') ); ?>" /></td>
        </tr>

        <tr valign="top">
            <th scope="row">API Key</th>
            <td><input type="text" style="width: 100%" name="mw_api_key" value="<?php echo esc_attr( get_option('mw_api_key') ); ?>" /></td>
        </tr>

        <tr valign="top">
            <th scope="row">Client ID</th>
            <td><input type="text" style="width: 100%" name="mw_client_id" value="<?php echo esc_attr( get_option('mw_client_id') ); ?>" /></td>
        </tr>

        <tr valign="top">
            <th scope="row">Client Secret</th>
            <td><input type="text" style="width: 100%" name="mw_client_secret" value="<?php echo esc_attr( get_option('mw_client_secret') ); ?>" /></td>
        </tr>

        <tr valign="top">
            <th scope="row">Grant Type</th>
            <td><input type="text" style="width: 100%" name="mw_grant_type" value="<?php echo esc_attr( get_option('mw_grant_type') ); ?>" /></td>
        </tr>
    </table>
    <h2 style="text-decoration: underline">Layout Settings</h2>
    <table class="form-table" style="width: 40%;">
        <tr valign="top">
            <th scope="row">Theme Sidebar Enabled?<br><span style="color: #aaaaaa;">(enables smaller text)</span></th>
            <td><input type="checkbox" name="mw_has_sidebar" value="1" <?=esc_attr( get_option('mw_has_sidebar') ) == 1?'checked':'' ?> /></td>
        </tr>

    </table>
    <hr>
    <?php submit_button(); ?>


</form>
<script>
    function changeShortCode() {
        document.getElementById('mw_shortcode').innerHTML = '[mw-1003 lo='+ document.getElementsByName('mw_loan_officer_id')[0].value + ' site=' + document.getElementsByName('mw_site_id')[0].value + ']';
    }
</script>
Copy/paste this shortcode on a blank page to display the Loan Application<br><br>
<code id="mw_shortcode">
[mw-1003 lo=<?php echo esc_attr( get_option('mw_loan_officer_id') ); ?> site=<?php echo esc_attr( get_option('mw_site_id') ); ?>]
</code>