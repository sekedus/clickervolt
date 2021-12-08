<?php

/**
 * @return string
 */
function getLiveChatJSONSettings()
{
    $liveChatProps = [
        'attributes' => []
    ];

    $user = wp_get_current_user();
    if ($user && $user->user_login) {
        if ($user->user_firstname) {
            $liveChatProps['name'] = $user->user_firstname;
            if ($user->user_lastname) {
                $liveChatProps['name'] .= ' ' . $user->user_lastname;
            }
        } else {
            $liveChatProps['name'] = $user->user_login;
        }
        $liveChatProps['email'] = $user->user_email;

        $liveChatProps['attributes']['cvolt_user_registered_at'] = strtotime($user->user_registered);
        $liveChatProps['attributes']['cvolt_user_login'] = $user->user_login;

        $dbVersion = get_option(\ClickerVolt\DB::OPTION_VERSION);
        $liveChatProps['attributes']['cvolt_version_file'] = \ClickerVolt\DB::VERSION;
        $liveChatProps['attributes']['cvolt_version_db'] = $dbVersion ? $dbVersion : "0";
    }

    return json_encode($liveChatProps);
}

/**
 * 
 * @return string
 */
function getLiveChatScript($jsonSettings = null)
{
    if ($jsonSettings === null) {
        $jsonSettings = getLiveChatJSONSettings();
    }

    $js = <<<SCRIPT
    <!-- Customerly Integration Code -->
    <script>
        try {
            window.customerlySettings = JSON.parse('{$jsonSettings}');
        } catch(error) {
            window.customerlySettings = {};
        }
        window.customerlySettings['app_id'] = '92a343eb';
        !function(){function e(){var e=t.createElement("script");
        e.type="text/javascript",e.async=!0,
        e.src="https://widget.customerly.io/widget/92a343eb";
        var r=t.getElementsByTagName("script")[0];r.parentNode.insertBefore(e,r)}
        var r=window,t=document,n=function(){n.c(arguments)};
        r.customerly_queue=[],n.c=function(e){r.customerly_queue.push(e)},
        r.customerly=n,r.attachEvent?r.attachEvent("onload",e):r.addEventListener("load",e,!1)}();
    </script>
SCRIPT;

    return $js;
}
