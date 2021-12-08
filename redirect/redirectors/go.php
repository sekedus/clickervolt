<?php

namespace ClickerVolt;

require_once __DIR__ . '/redirector.php';
require_once __DIR__ . '/../dynamicTokens.php';
require_once __DIR__ . '/../../db/tableLinks.php';
require_once __DIR__ . '/../../utils/urlTools.php';
$url = hex2bin( $_GET['url'] );
$mode = $_GET['mode'];
$slug = ( isset( $_GET['slug'] ) ? $_GET['slug'] : null );

if ( $url ) {
    $options = [
        Redirector::OPTION_SLUG => $slug,
    ];
    switch ( $mode ) {
        case Link::REDIRECT_MODE_PERMANENT:
            require_once __DIR__ . '/301.php';
            $redirector = new Redirector301();
            break;
        case Link::REDIRECT_MODE_TEMPORARY:
            require_once __DIR__ . '/302.php';
            $redirector = new Redirector302();
            break;
        case Link::REDIRECT_MODE_DMR:
            require_once __DIR__ . '/dmr.php';
            $redirector = new RedirectorDMR();
            break;
        case Link::REDIRECT_MODE_CLOAKING:
            require_once __DIR__ . '/cloaked.php';
            $redirector = new RedirectorCloaked();
            break;
    }
    if ( !isset( $redirector ) ) {
        
        if ( !function_exists( '\\ClickerVolt\\cli_fs' ) ) {
            echo  "Redirect mode '{$mode}' not supported with fastest redirect URLs" ;
            exit;
        }
    
    }
    
    if ( isset( $redirector ) ) {
        $dynamicTokens = new DynamicTokens();
        $url = $dynamicTokens->replace( $url );
        $params = URLTools::getParams( $url, true );
        if ( !isset( $params[Session::URL_SESSION_KEY] ) ) {
            $url = URLTools::appendQueryParams( $url, 'session=' . Session::getSessionId() );
        }
        $redirector->redirectTo( $url, $options );
    }

}
