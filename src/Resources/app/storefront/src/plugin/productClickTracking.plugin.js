import Plugin from 'src/plugin-system/plugin.class';
import DomAccess from 'src/helper/dom-access.helper';
import ImpressionsUtil from "../util/impressions.util";
import ProductUtil from "../util/product.util";

export default class ProductClickTracking extends Plugin {
    init() {
        if (typeof gtmIsTrackingProductClicks === 'undefined' || gtmIsTrackingProductClicks !== true) {
            return;
        }
        this._registerEvents();
    }

    _registerEvents() {
        const self = this;
        this.el.addEventListener('click', (event) => {
            self.onProductClicked(event);
        });
    }

    onProductClicked(event) {
        if (this.el.dataset.hasOwnProperty('addToWishlist') && this.el.dataset.addToWishlist) {
            return;
        }

        if (DomAccess.hasAttribute(this.el, 'href')) {
            event.preventDefault();
        }

        try {
            const product = this._getProduct();

            window.dataLayer.push({
                event: 'select_item',
                ecommerce: {
                    items: [product]
                }
            });
        } catch (e) {
            console.info(e);
        }

        if (this._shouldRedirect(event)) {
            document.location = DomAccess.getAttribute(this.el, 'href');
        }
    }

    _getProduct() {
        const productNo = ProductUtil.getProductNoFromProductBox(this.el);
        return ImpressionsUtil.getProductFromImpressions(productNo);
    }

    _shouldRedirect(event) {
        let redirect = false;

        // is there even a link?
        if (DomAccess.hasAttribute(this.el, 'href')) {
            redirect = true;
        }
        // is add to cart button
        if (event.target.classList.contains('btn-buy')) {
            redirect = false;
        }
        // enabled quickview feature of SwagCmsExtension?
        const quickviewSelector = '[data-swag-cms-extensions-quickview="true"]';
        if ((this.el.closest('.cms-section') !== null
            && this.el.closest('.cms-section').querySelector(quickviewSelector) !== null)
            || (document.body.classList.contains('is-ctl-search')
                && this.el.closest('.container-main') !== null
                && this.el.closest('.container-main').querySelector(quickviewSelector) !== null)
        ) {
            redirect = false;
        }

        return redirect;
    }
}
