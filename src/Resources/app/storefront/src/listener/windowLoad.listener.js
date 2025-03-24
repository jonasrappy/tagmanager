import WbmDataLayer from '../util/datalayer.util';

if (typeof onEventDataLayer !== 'undefined') {
    window.addEventListener('load', function () {
        WbmDataLayer.push(onEventDataLayer);
    });
}
