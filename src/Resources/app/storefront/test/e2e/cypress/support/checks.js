export const checkDataLayerItems = (dataLayerObject, expectedDataLayer) => {
    for (let i = 0; i < dataLayerObject.ecommerce.items.length; i++) {
        checkDataLayerItem(dataLayerObject.ecommerce.items[i], expectedDataLayer.ecommerce.items[i])
    }
};

export const checkDataLayerItem = (dataLayerObjectItem, expectedDataLayerItem) => {
    expect(dataLayerObjectItem.index).to.equal(expectedDataLayerItem.index);
    expect(dataLayerObjectItem.item_id).to.equal(expectedDataLayerItem.item_id);
    expect(dataLayerObjectItem.item_name).to.equal(expectedDataLayerItem.item_name);
    expect(dataLayerObjectItem.item_variant).to.equal(expectedDataLayerItem.item_variant);
    expect(dataLayerObjectItem.item_category).to.equal(expectedDataLayerItem.item_category);
    expect(dataLayerObjectItem.item_brand).to.equal(expectedDataLayerItem.item_brand);
    expect(dataLayerObjectItem.item_list_name).to.equal(expectedDataLayerItem.item_list_name);
    expect(dataLayerObjectItem.item_list_id).to.equal(expectedDataLayerItem.item_list_id);
    expect(dataLayerObjectItem.price).to.equal(expectedDataLayerItem.price);
}
