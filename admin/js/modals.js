// Look at http://craftpip.github.io/jquery-confirm/ for plugin options

class ClickerVoltModals {

    static getConfirmOptions(options) {
        return jQuery.extend({}, {
            boxWidth: '30%',
            useBootstrap: false,
            type: 'red',
            animation: 'none',
            closeAnimation: 'none',
            // theme: 'supervan',
        }, options);
    }

    static error(title, message) {
        ClickerVoltModals.message(title, message);
    }

    static message(title, message, onOK) {
        jQuery.confirm(ClickerVoltModals.getConfirmOptions({
            title: title,
            content: message,
            scrollToPreviousElement: false,
            buttons: {
                ok: {
                    text: 'OK',
                    btnClass: 'btn-blue btn-primary',
                    action: function () {
                        if (onOK) {
                            onOK();
                        }
                    }
                },
            }
        }));
    }

    static loaderStart(message) {
        var pluginUrl = clickerVoltVars.urls.plugin;
        var loadingImageUrl = pluginUrl + '/admin/images/icons/report-loading-18px.gif?v=2';

        ClickerVoltModals.jcLoader = jQuery.confirm(ClickerVoltModals.getConfirmOptions({
            title: false,
            content: `<div style='text-align: center;'><img src='${loadingImageUrl}'/><p>${message}</p></div>`,
            scrollToPreviousElement: false,
            buttons: {
                ok: {
                    isHidden: true,
                },
            }
        }));
    }

    static loaderStop() {
        if (ClickerVoltModals.jcLoader) {
            ClickerVoltModals.jcLoader.close();
            ClickerVoltModals.jcLoader = null;
        }
    }

    /**
     * 
     * @param {*} message 
     * @param {*} onConfirmed 
     */
    static confirm(message, onConfirmed, onCancelled, options) {

        var defaultOptions = {
            title: 'Confirmation Required',
            okButtonText: 'OK',
            okButtonClass: 'btn-blue btn-primary',
            cancelButtonText: 'Cancel',
            cancelButtonClass: 'btn-default',
        };

        if (!options) {
            options = {};
        }
        options = jQuery.extend({}, defaultOptions, options);

        jQuery.confirm(ClickerVoltModals.getConfirmOptions({
            title: options.title,
            content: message,
            scrollToPreviousElement: false,
            buttons: {
                ok: {
                    text: options.okButtonText,
                    btnClass: options.okButtonClass,
                    action: function () {
                        if (onConfirmed) {
                            onConfirmed();
                        }
                    }
                },
                cancel: {
                    text: options.cancelButtonText,
                    btnClass: options.cancelButtonClass,
                    keys: ['esc'],
                    action: function () {
                        if (onCancelled) {
                            onCancelled();
                        }
                    }
                }
            }
        }));
    }
}