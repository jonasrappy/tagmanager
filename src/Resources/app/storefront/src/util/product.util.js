import DomAccess from 'src/helper/dom-access.helper';

export default class DomAccessUtil {
    static getProductNoFromProductDetail() {
        const span = DomAccess.querySelector(document, '[itemprop="sku"]');
        return span.innerText;
    }

    static getProductNoFromProductBox(element) {
        const parent = element.closest('.product-box');
        const inputField = DomAccess.querySelector(parent, '[name="sku"]');
        return inputField.value;
    }
}