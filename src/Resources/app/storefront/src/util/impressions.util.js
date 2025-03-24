export default class ImpressionsUtil {
    items = null;

    static setImpressions(dataLayer) {
        if (dataLayer) {
            this.items = dataLayer.ecommerce.items;
        }

        if (this.items === null || this.items.length === 0) {
            console.info('no items found in dataLayer');
        }
    }

    static getProductFromImpressions(productNo) {
        const product = this.items.find((value, index) => {
            return value.item_id === productNo;
        });

        if (product === undefined) {
            throw new InvalidImpressionsError('product not found in items');
        }

        return product
    }
}

class InvalidImpressionsError extends Error {
    constructor(message) {
        super(message);
        this.name = 'InvalidImpressionsError';
    }
}