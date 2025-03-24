/* cart page */
INSERT IGNORE INTO wbm_data_layer_properties (id, module, parent_id, after_id, child_count, name, value, created_at, updated_at, on_event, event_name)
VALUES
    (X'DCC86CB2611F402C91040041A73E59A1', 'frontend.checkout.cart.page', X'0BB498EBA28B447D8AF9BF5A46E317D2', X'D324250808674EDDBFB2E95A1CED8E2A', 0, 'value', '{{ page.cart.price.totalPrice }}', '2023-02-24 15:22:30.160', '2023-02-24 15:28:32.085', 0, ''),
    (X'005BD1EC38594F789895EB7C38EBFF4E', 'frontend.checkout.cart.page', X'86ACA3F98C824A368D862F19E3ABFAFA', X'292E49BEDC77461BABB88E4188521234', 0, 'index', '{{ loop.index }}', '2023-02-24 15:34:51.824', '2023-02-24 15:34:56.100', 0, '');

UPDATE wbm_data_layer_properties SET parent_id = X'0BB498EBA28B447D8AF9BF5A46E317D2', after_id = X'DCC86CB2611F402C91040041A73E59A1' WHERE id = X'191F05BDD5624CDF8A839FBC8E75B8C0';
UPDATE wbm_data_layer_properties SET on_event = 1, event_name = 'view_cart' WHERE id = X'0BB498EBA28B447D8AF9BF5A46E317D2';
UPDATE wbm_data_layer_properties SET name = 'items', after_id = X'DCC86CB2611F402C91040041A73E59A1', parent_id = X'0BB498EBA28B447D8AF9BF5A46E317D2' WHERE id = X'86ACA3F98C824A368D862F19E3ABFAFA';
UPDATE wbm_data_layer_properties SET name = 'item_id' WHERE id = X'F32504F756ED4837A8ED231AC54368DB';
UPDATE wbm_data_layer_properties SET name = 'item_name' WHERE id = X'F771A6711AB04FEB8D962C045B721F6D';
UPDATE wbm_data_layer_properties SET name = 'item_brand' WHERE id = X'DD25DA53EABC4A58BBB29D1F58F54ACA';
UPDATE wbm_data_layer_properties SET name = 'item_category' WHERE id = X'461F6DA5370847A5801480AF1807B9C7';
UPDATE wbm_data_layer_properties SET name = 'item_variant' WHERE id = X'76802ADF624E41CABE447158F697A4D9';
UPDATE wbm_data_layer_properties SET name = 'currency' WHERE id = X'D324250808674EDDBFB2E95A1CED8E2A';

DELETE FROM wbm_data_layer_properties WHERE id IN (X'2A5047CBD1A24ABD950E5B0BF00D27F7', X'F480F06232C84B5A8F40032633B3BA46', X'5C5AC132232F4D9EBBB070AC4E5A10DC', X'CDD2039D124A477EA741E687C383F35A');
