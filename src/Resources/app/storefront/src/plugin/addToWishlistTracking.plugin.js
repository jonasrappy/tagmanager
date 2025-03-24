import Plugin from 'src/plugin-system/plugin.class';
import ProductUtil from "../util/product.util";
import ImpressionsUtil from "../util/impressions.util";

export default class AddToWishlistTrackingPlugin extends Plugin {

    init() {
        if (typeof gtmIsTrackingAddToWishlistClicks === 'undefined' || gtmIsTrackingAddToWishlistClicks !== true) {
            return;
        }
        this._registerEvents();
        this.el.dataset.isAdded = this.el.classList.contains('product-wishlist-added').toString();
    }

    _registerEvents() {
        const self = this;
        this.el.addEventListener('click', (event) => {
            self._onAddToWishlistClicked(event);
        });
    }

    _onAddToWishlistClicked() {
        try {
            if (this.el.classList.contains('product-wishlist-not-added')) {
                return;
            }

            const product = this._getProduct();

            window.dataLayer.push({
                event: 'add_to_wishlist',
                ecommerce: {
                    items: [product]
                }
            });
        } catch (e) {
            console.info(e);
        }
    }

    _getProduct() {
        const isProductDetail = document.body.classList.contains('is-ctl-product');
        const productNo = isProductDetail
            ? ProductUtil.getProductNoFromProductDetail()
            : ProductUtil.getProductNoFromProductBox(this.el);
        return ImpressionsUtil.getProductFromImpressions(productNo);
    }
}