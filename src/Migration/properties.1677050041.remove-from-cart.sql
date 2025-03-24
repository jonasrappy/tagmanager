/* remove from cart interaction */
INSERT IGNORE INTO wbm_data_layer_properties (id, module, parent_id, after_id, child_count, name, value, created_at, updated_at, on_event, event_name)
VALUES (X'D18D3B50937D4992B8FD021E3C38857C', 'frontend.checkout.line-item.delete', X'5B1BE5D58C3941558FF81D1ED6246AA5', X'2209B59AF2BE4972B7351A3C88741865', 0, 'value', '{% set conversion = 0 %}{% for product_id in {0: getparam(\'id\')} %}{% set conversion = conversion + cartremoveprice(product_id) %}{% endfor %}{{ conversion }}', '2023-02-24 14:58:18.212', '2023-02-24 15:03:45.034', 0, '');

UPDATE wbm_data_layer_properties SET name = 'currency' WHERE id = X'2209B59AF2BE4972B7351A3C88741865';
UPDATE wbm_data_layer_properties SET value = 'remove_from_cart' WHERE id = X'674E2A20863E42F68132B0D93A4E423B';
UPDATE wbm_data_layer_properties SET name = 'items', parent_id = X'5B1BE5D58C3941558FF81D1ED6246AA5' WHERE id = X'B5C0D1BF64E54059B98BA2BB8E7C5D55';
UPDATE wbm_data_layer_properties SET name = 'item_id' WHERE id = X'675C37BFF6D949789BD9C4E26BE0DB18';
UPDATE wbm_data_layer_properties SET name = 'item_name' WHERE id = X'BC0F72FEEF5A483C889D6E6C33451F2E';
UPDATE wbm_data_layer_properties SET name = 'item_brand' WHERE id = X'203BE4E4D4684EA88CD530C8845C0C0E';
UPDATE wbm_data_layer_properties SET name = 'item_category' WHERE id = X'77C90B874D894E039910FB43B034EACA';
UPDATE wbm_data_layer_properties SET name = 'item_variant' WHERE id = X'C9FE1D46670B4F49853FD39788CFA410';

DELETE FROM wbm_data_layer_properties WHERE id = X'A5967CF48C1D4A869567BF9D607CE5F2';
