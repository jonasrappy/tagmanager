/* eslint-disable import/no-unresolved */
import PluginManager from 'src/plugin-system/plugin.manager';
import ProductClickTracking from './plugin/productClickTracking.plugin';
import AddToWishlistTracking from './plugin/addToWishlistTracking.plugin';
import Promotions from './plugin/promotions.plugin';

import './listener/windowLoad.listener';
import './service/http-client.service';
import './subscriber/cookieConfigurationUpdate.subscriber';

PluginManager.register('ProductClickTracking', ProductClickTracking, '.product-box a', { parent: '.product-box' });
PluginManager.register('ProductClickTracking', ProductClickTracking, '.product-box button', { parent: '.product-box' });
PluginManager.register('AddToWishlistTracking', AddToWishlistTracking, '[data-add-to-wishlist]');
PluginManager.register('Promotions', Promotions);

// Necessary for the webpack hot module reloading server
if (module.hot) {
    module.hot.accept();
}
