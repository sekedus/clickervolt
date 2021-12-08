<div class="bot-detection-block" id="bot-detection-block-template" style="display: none;">

    <select class="bot-detection-type-select" name="bot-detection-type-mode">
        <option value="<?= ClickerVolt\Link::FRAUD_DETECTION_MODE_NONE ?>" selected="selected">Disabled</option>
        <option value="<?= ClickerVolt\Link::FRAUD_DETECTION_MODE_RECAPTCHA_V3 ?>">Google Recaptcha V3</option>
        <option value="<?= ClickerVolt\Link::FRAUD_DETECTION_MODE_HUMAN ?>">Advanced (Recommended)</option>
    </select>

    <div class="bot-detection-section <?= ClickerVolt\Link::FRAUD_DETECTION_MODE_RECAPTCHA_V3 ?>" style="display: none;">
        <p class="description">For detecting suspicious traffic, this mode use Google's AI with their invisible reCAPTCHA v3. Before it can work, you must get your site and secret keys <a href="https://www.google.com/recaptcha/admin/create#v3" target="_blank">here</a>. After entering your keys below, your traffic quality will be recorded for all pages embedding the AIDA script (or using the Cloaked redirect mode)</p>
        <table>
            <tbody>
                <tr>
                    <td>Site Key</td>
                    <td><input type="text" name="recaptchav3-site-key" class="input-as-change auto-resize" data-min-size="10"></td>
                </tr>
                <tr>
                    <td>Secret Key</td>
                    <td><input type="text" name="recaptchav3-secret-key" class="input-as-change auto-resize" data-min-size="10"></td>
                </tr>
                <tr>
                    <td>Hide Badge</td>
                    <td><input type="checkbox" name="recaptchav3-hide-badge"> (<span class="description">If you hide reCAPTCHA's badge, you must link to Google's <a href="https://policies.google.com/privacy" target="_blank">privacy</a> and <a href="https://policies.google.com/terms" target="_blank">terms</a> pages wherever you place the AIDA script)</span></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="bot-detection-section <?= ClickerVolt\Link::FRAUD_DETECTION_MODE_HUMAN ?>" style="display: none;">
        <p class="description">This suspicious traffic detection mode works backward. Instead of trying to detect the thousands and growing number of existing bots, it rather tags all traffic as suspicious except for visitors that are detected as being real humans. This is actually a much more simple task and gives extremely accurate results.</p>
        <p class="description">For this mode to work, <strong>it is mandatory</strong> to put the AIDA script on the page you are sending traffic to (or use the Cloaked redirect mode).</p>
    </div>

</div>

<script>
    class FraudDetectionHtml {

        constructor(container, fraudOptions) {
            this._container = container;

            this._divId = ClickerVoltFunctions.uuid();
            this._div = jQuery('#bot-detection-block-template').clone();
            this._div.attr('id', this._divId);

            if (container) {
                this._div.appendTo(container);
            }

            this._div.show();

            this._div.find('.bot-detection-type-select').on('change', {
                cmInstance: this
            }, function(event) {
                event.data.cmInstance._refreshBotDetection();
            });

            if (fraudOptions) {
                this.setOptions(fraudOptions);
            }
        }

        setOnChangedCallback(callback) {
            this._onChanged = callback;
        }

        setOptions(fraudOptions) {
            this._div.find('.bot-detection-type-select').val(fraudOptions.mode).trigger('change');

            this._div.find('input[name=recaptchav3-site-key]').val(fraudOptions.recaptcha3SiteKey).trigger('change');
            this._div.find('input[name=recaptchav3-secret-key]').val(fraudOptions.recaptcha3SecretKey).trigger('change');
            if (fraudOptions.recaptcha3HideBadge == 'yes') {
                this._div.find('input[name=recaptchav3-hide-badge]').prop('checked', true);
            } else {
                this._div.find('input[name=recaptchav3-hide-badge]').prop('checked', false);
            }
        }

        _refreshBotDetection() {
            var selected = this._div.find('.bot-detection-type-select').val();
            this._div.find('.bot-detection-section').hide();
            if (selected) {
                this._div.find(`.bot-detection-section.${selected}`).show();
            }
            if (this._onChanged) {
                this._onChanged(selected);
            }
        }
    }
</script>