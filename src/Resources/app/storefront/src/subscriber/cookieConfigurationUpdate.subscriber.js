import { COOKIE_CONFIGURATION_UPDATE } from 'src/plugin/cookie/cookie-configuration.plugin';

function wbmTagMangerCookieEventCallback(updatedCookies) {
    if (typeof updatedCookies.detail['wbm-tagmanager-enabled'] !== 'undefined'
        && updatedCookies.detail['wbm-tagmanager-enabled']
        && !window.wbmScriptIsSet
    ) {
        const script = document.getElementById('wbmTagManger');
        if (typeof script === 'undefined') {
            return;
        }

        const newScript = document.createElement('script');
        const inlineScript = document.createTextNode(
            `(${window.googleTag})(window,document,'script','dataLayer', '${window.wbmGoogleTagmanagerId}');`
        );
        newScript.appendChild(inlineScript);

        script.parentNode.insertBefore(newScript, script.nextSibling);

        window.wbmScriptIsSet = true;
        window.googleTag = null;
    }
}
document.$emitter.subscribe(COOKIE_CONFIGURATION_UPDATE, wbmTagMangerCookieEventCallback);
