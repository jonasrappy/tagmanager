/* add to cart interaction */
INSERT IGNORE INTO wbm_data_layer_properties (id, module, parent_id, after_id, child_count, name, value, created_at, updated_at, on_event, event_name)
VALUES (X'9E638C4107C548B0B17E8D1C7FA77FE9', 'frontend.checkout.line-item.add', X'2B2B9040D93D4C3DB3CA6C936DB0F2B8', X'84E10417F92A457E8B64524C1760CFE0', 0, 'value', '{{ cartaddprice() }}', '2023-02-23 12:45:09.695', '2023-02-24 08:52:48.183', 0, '');

UPDATE wbm_data_layer_properties SET name = 'currency' WHERE id = X'84E10417F92A457E8B64524C1760CFE0';
UPDATE wbm_data_layer_properties SET value = 'add_to_cart' WHERE id = X'2B6BB8927EE44754BFC33026629785A5';

UPDATE wbm_data_layer_properties SET name = 'items', parent_id = X'2B2B9040D93D4C3DB3CA6C936DB0F2B8' WHERE id = X'58DE079C37644299BD52BA35E298C509';
UPDATE wbm_data_layer_properties SET name = 'item_id' WHERE id = X'9C4927A0CB9B4255935B4AED4EF16FB4';
UPDATE wbm_data_layer_properties SET name = 'item_name' WHERE id = X'C5D1EF93A50C417DB5053D2FF20418EA';
UPDATE wbm_data_layer_properties SET name = 'item_brand' WHERE id = X'5F82CD2464FE4DDF9F74BB7A31B27346';
UPDATE wbm_data_layer_properties SET name = 'item_category' WHERE id = X'43CD39F741884A4B9832648B5B1EC95C';
UPDATE wbm_data_layer_properties SET name = 'item_variant' WHERE id = X'204572EA063943D4A845672F6DCD1478';

DELETE FROM wbm_data_layer_properties WHERE id = X'7BE32CBFCAE947BDB5569C36038E5BA1';
