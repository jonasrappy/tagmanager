import ImpressionsUtil from './impressions.util';

export default class WbmDataLayer {
    static event = '';

    static push(dataLayer) {
        // 🔥 Filter out 'free-product-' entries
        if (dataLayer.ecommerce && dataLayer.ecommerce.items) {
            dataLayer.ecommerce.items = dataLayer.ecommerce.items.filter(item =>
                !item.item_id.includes('free-product-')
            );
        }

        window.dataLayer.push({ ecommerce: null });

        if (
            !dataLayer.hasOwnProperty('ecommerce') ||
            !dataLayer.ecommerce.hasOwnProperty('items') ||
            !dataLayer.hasOwnProperty('event')
        ) {
            window.dataLayer.push(dataLayer);
            return;
        }

        ImpressionsUtil.setImpressions(dataLayer);

        WbmDataLayer.event = dataLayer.event;
        const size = (new TextEncoder().encode(JSON.stringify(dataLayer)).length) / 1024;

        if (Math.ceil(size) <= 7) {
            window.dataLayer.push(dataLayer);
            return;
        }

        const items = dataLayer.ecommerce.items;
        const ecommerce = dataLayer.ecommerce;
        let subset = 1;
        let newDataLayer = WbmDataLayer.createEmptyDataLayer(ecommerce, subset);
        let splitItems = [];

        for (let i = 0; i < items.length; i++) {
            splitItems.push(items[i]);

            if ((i + 1) % 8 === 0) {
                WbmDataLayer.pushSubset(newDataLayer, splitItems);
                subset++;
                newDataLayer = WbmDataLayer.createEmptyDataLayer(ecommerce, subset);
                splitItems = [];
            }
        }

        if (splitItems.length > 0) {
            // push leftovers
            WbmDataLayer.pushSubset(newDataLayer, splitItems);
        }
    }

    static pushSubset(dataLayer, splittedItems) {
        dataLayer.ecommerce.items = splittedItems;
        window.dataLayer.push(dataLayer);
    }

    static createEmptyDataLayer(ecommerce, subset) {
        const dataLayer = {};
        dataLayer.event = WbmDataLayer.event;
        dataLayer.ecommerce = ecommerce;
        dataLayer.ecommerce.subset = subset;
        dataLayer.ecommerce.items = [];

        return dataLayer;
    }
}
