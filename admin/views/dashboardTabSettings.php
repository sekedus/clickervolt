<?php
require_once __DIR__ . '/fraudDetection.php';
require_once __DIR__ . '/../../utils/fileTools.php';
?>

<div id="tab-settings" class="tab-content">

    <form id="settings-form" method="post" novalidate="novalidate">

        <div class="settings-section">
            <h2>IP Detection</h2>
            <p class="description">For the majority of servers out there, we recommend to keep "Auto" selected to let ClickerVolt decide which header to use to determine visitor IPs.</p>
            <p class="description">On Hostgator, you must select the REMOTE_ADDR option, as Hostgator doesn't pass the X-Forwarded-For header to any PHP software, including WordPress. Some other hosting companies may have the same restriction in place, so if you notice all your traffic is reported as coming from the same IP, try using that setting too.</p>
            <select name="ip-detection">
                <option value="auto">Auto (Recommended)</option>
                <option value="REMOTE_ADDR">REMOTE_ADDR (Hostgator and similar)</option>
            </select>
        </div>

        <div class="settings-section">
            <h2>Default Fraud Detection Mode</h2>
            <div id="default-fraud-detection-container"></div>
        </div>

        <!--
        <div class="settings-section">
            <h2>IPN Secret Keys</h2>
            <p>
                <label>WarriorPlus:
                    <input type="text" name="ipn-key-warriorplus">
                </label>
            </p>
            <p>
                <label>Clickbank:
                    <input type="text" name="ipn-key-clickbank">
                </label>
            </p>
        </div>
        -->

        <div>
            <input type="submit" name="submit" class="save-settings button button-primary" value="Save Settings">
            <label id="saved-settings-confirmation-message" class="confirmation-message"></label>
        </div>

    </form>

    <div class="settings-section">
        <?php
        $GB = 1024 * 1024 * 1024;
        $freeSpace = round(disk_free_space(\ClickerVolt\FileTools::getAbsPath()) / $GB, 1);
        $usedSpaceString = "{$freeSpace}GB available";
        ?>
        <h2>Disk Space (<?= $usedSpaceString ?>)</h2>
        <p class="description">
            You can free up some disk space by clicking one of the 2 buttons below.
            <ul>
                <li>Purge All Stats: This will reset all your stats</li>
                <li>Purge RAW Clicks Only: This will delete all your raw clicks but will keep the stat summaries of all your links. RAW clicks are what takes the most space on disk.</li>
            </ul>
        </p>
        <button id="purge-all-stats" class="button button-secondary">PURGE ALL STATS</button>
        <button id="purge-raw-clicks" class="button button-secondary">PURGE RAW CLICKS ONLY</button>
    </div>

</div>

<script>
    jQuery(document).ready(function() {
        setupForm();

        var $select = jQuery('select[name=ip-detection]');
        ClickerVoltFunctions.addOptionToSelect($select, clickerVoltVars.const.CVSettings.VALUE_IP_DETECTION_TYPE_AUTO, 'Auto (Recommended)');
        ClickerVoltFunctions.addOptionToSelect($select, clickerVoltVars.const.CVSettings.VALUE_IP_DETECTION_TYPE_REMOTE_ADDR, 'REMOTE_ADDR (Hostgator and similar)');
        if (clickerVoltVars.settings.ipDetectionType) {
            $select.val(clickerVoltVars.settings.ipDetectionType);
        }

        var fd = new FraudDetectionHtml(jQuery('#default-fraud-detection-container'), clickerVoltVars.settings.fraudOptions);
        fd.setOnChangedCallback(function(newDetectionMode) {
            clickerVoltVars.settings.fraudOptions.mode = newDetectionMode;
        });

        jQuery('#purge-all-stats').on('click', function() {
            purgeStats('wp_ajax_clickervolt_purge_all_stats', 'Are you sure you want to purge all stats?', 'All your stats have been deleted');
        });

        jQuery('#purge-raw-clicks').on('click', function() {
            purgeStats('wp_ajax_clickervolt_purge_raw_clicks', 'Are you sure you want to purge all raw clicks?', 'All your raw clicks have been deleted');
        });
    });

    function purgeStats(ajaxFunctionName, questionMessage, confirmationMessage) {
        ClickerVoltModals.confirm(questionMessage, function() {
            ClickerVoltModals.loaderStart('Your stats are being cleared...');
            ClickerVoltFunctions.ajax(ajaxFunctionName, null, {
                data: {},
                success: function() {
                    ClickerVoltModals.loaderStop();
                    ClickerVoltModals.message('Purge complete', confirmationMessage, function() {
                        location.reload();
                    });
                },
                complete: function() {
                    ClickerVoltModals.loaderStop();
                }
            });
        });
    }

    /**
     * 
     */
    function setupForm() {

        // Using https://jqueryvalidation.org/

        var $form = jQuery("#settings-form");

        $form.validate({
            rules: {},

            submitHandler: function(form) {
                $form.find('input[type=submit].save-settings').prop('disabled', true);
                var data = {
                    'ipDetectionType': $form.find('select[name=ip-detection]').val(),
                    'fraudOptions': {
                        'mode': $form.find('select.bot-detection-type-select').val(),
                        'recaptcha3SiteKey': $form.find('input[name=recaptchav3-site-key]').val(),
                        'recaptcha3SecretKey': $form.find('input[name=recaptchav3-secret-key]').val(),
                        'recaptcha3HideBadge': $form.find('input[name=recaptchav3-hide-badge]').prop('checked'),
                    },
                };
                ClickerVoltFunctions.ajax('wp_ajax_clickervolt_save_settings', null, {
                    data: data,
                    success: function() {
                        ClickerVoltFunctions.showSavedConfirmation(jQuery('#saved-settings-confirmation-message'));
                        location.reload();
                    },
                    complete: function() {
                        $form.find('input[type=submit].save-settings').prop('disabled', false);
                    }
                });
            }
        });
    }
</script>