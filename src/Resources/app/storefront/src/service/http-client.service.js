HttpClient.prototype._registerOnLoaded = function (request, callback) {
    __superFunc.call(this, request, callback);
    request.addEventListener('loadend', () => {
        if (!window.hasOwnProperty('dataLayer')) {
            return;
        }

        var response = request.responseText;
        var domParser = new DOMParser();
        var parsedResponse = domParser.parseFromString(response, 'text/html');
        var element = DomAccess.querySelector(parsedResponse, '#wbm-data-layer', false);

        if (element && window.dataLayer) {
            const dataLayers = JSON.parse(element.innerHTML);

            for (const key in dataLayers) {
                if (!dataLayers.hasOwnProperty(key) || dataLayers[key].length === 0) {
                    continue;
                }

                var dataLayer = JSON.parse(dataLayers[key]);

                // 🔥 Filter out 'free-product-' entries
                if (dataLayer.ecommerce && dataLayer.ecommerce.items) {
                    dataLayer.ecommerce.items = dataLayer.ecommerce.items.filter(item =>
                        !item.item_id.includes('free-product-')
                    );
                }

                if (key === 'default') {
                    window.dataLayer.push(dataLayer);
                } else {
                    WbmDataLayer.push(dataLayer);
                }
            }
        }
    });
};
