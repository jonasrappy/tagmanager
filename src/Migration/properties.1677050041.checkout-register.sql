/* checkout register page */
INSERT IGNORE INTO wbm_data_layer_properties (id, module, parent_id, after_id, child_count, name, value, created_at, updated_at, on_event, event_name)
VALUES
    (X'5DF274382FF444B6934F735A766A1A45', 'frontend.checkout.register.page', X'24D0D1C0400F42EE80AFDEC2AD68899B', X'A2A74EBB34CE4D9791EEB17D3CDE6CEE', 0, 'value', '{{ page.cart.price.totalPrice }}', '2023-02-28 07:20:15.974', '2023-02-28 07:21:05.712', 0, ''),
    (X'8D54746E40B8452286562712ACFA9920', 'frontend.checkout.register.page', X'24D0D1C0400F42EE80AFDEC2AD68899B', X'5DF274382FF444B6934F735A766A1A45', 0, 'coupon', '{% set promotions = \'\' %}{% for lineItem in page.cart.lineItems.elements|filter(lineItem => lineItem.type == \'promotion\') -%}{% set promotions = promotions ~ lineItem.payload.code %}{% if not loop.last %}{% set promotions = promotions ~ \',\' %}{% endif %}{% endfor %}{{ promotions }}', '2023-02-28 07:20:20.678', '2023-02-28 07:22:20.914', 0, '');

UPDATE wbm_data_layer_properties SET value = 'begin_checkout' WHERE id = X'C13E97B877884F96AFB84AF23616F261';
UPDATE wbm_data_layer_properties SET name = 'items', after_id = X'8D54746E40B8452286562712ACFA9920', parent_id = X'24D0D1C0400F42EE80AFDEC2AD68899B' WHERE id = X'8208991AFAD44475A3873326F3B54789';
UPDATE wbm_data_layer_properties SET name = 'item_id' WHERE id = X'95FA4ECF8B0249C1A05D88F7C2DDF803';
UPDATE wbm_data_layer_properties SET name = 'item_name' WHERE id = X'DA78598FED19491EA4FDC2B84091D5DF';
UPDATE wbm_data_layer_properties SET name = 'item_brand' WHERE id = X'C3DD51F7A24B47F995A55563E78DD609';
UPDATE wbm_data_layer_properties SET name = 'item_category' WHERE id = X'114ADFAC86C14FD2BB14B98345C1FB32';
UPDATE wbm_data_layer_properties SET name = 'item_variant' WHERE id = X'4E4C7E6541B442F99DBF7DB3F4E25537';
UPDATE wbm_data_layer_properties SET name = 'currency' WHERE id = X'A2A74EBB34CE4D9791EEB17D3CDE6CEE';

DELETE FROM wbm_data_layer_properties WHERE id IN (X'10C49D2977A54947B58621805B88213B', X'3C76388557F34BB1B99FEAB7D372A030', X'360739FB826149EDB278A88B8F614062');
