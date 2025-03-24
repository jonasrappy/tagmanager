/* cart interaction */
INSERT IGNORE INTO wbm_data_layer_properties (id, module, parent_id, after_id, child_count, name, value, created_at, updated_at, on_event, event_name)
VALUES
    (X'C9BD70CCBC344A44960EC040A9D54377', 'frontend.cart.offcanvas', X'BDBDD6D8D91E46879AA3818629E58436', X'786EFA905F4342789B62089ADFA59A43', 0, 'index', '{{ loop.index }}', '2023-02-28 06:50:28.692', '2023-02-28 06:50:41.329', 0, ''),
    (X'54E50684DD114EB6BE383F12F5026208', 'frontend.cart.offcanvas', X'A32B10B0CA1741308F66AF4A894D84A0', X'E92955D0BED643519AB1256ECFCF678A', 0, 'value', '{{ page.cart.price.totalPrice }}', '2023-02-28 06:51:24.142', '2023-02-28 06:51:44.184', 0, '');

UPDATE wbm_data_layer_properties SET parent_id = X'A32B10B0CA1741308F66AF4A894D84A0', after_id = X'54E50684DD114EB6BE383F12F5026208' WHERE id = X'E3CD07419DC948A4BE57F3FBF2558FE9';
UPDATE wbm_data_layer_properties SET value = 'view_cart' WHERE id = X'B2DC3F7F93974017BCC7D5F189E0856B';
UPDATE wbm_data_layer_properties SET name = 'items', after_id = X'E3CD07419DC948A4BE57F3FBF2558FE9', parent_id = X'A32B10B0CA1741308F66AF4A894D84A0' WHERE id = X'BDBDD6D8D91E46879AA3818629E58436';
UPDATE wbm_data_layer_properties SET name = 'item_id' WHERE id = X'EEE33ABF79D34A8B9638F7FAB49249C9';
UPDATE wbm_data_layer_properties SET name = 'item_name' WHERE id = X'03724AC0F49149B59B630EB17A11578E';
UPDATE wbm_data_layer_properties SET name = 'item_brand' WHERE id = X'A0879E23B2C448EEB36C8A766A41389B';
UPDATE wbm_data_layer_properties SET name = 'item_category' WHERE id = X'37B5A732B3B0459DB3AD5465FA066D17';
UPDATE wbm_data_layer_properties SET name = 'item_variant' WHERE id = X'C20286CFFC4B4BC199B7A7850F6F9F33';
UPDATE wbm_data_layer_properties SET name = 'currency' WHERE id = X'E92955D0BED643519AB1256ECFCF678A';

DELETE FROM wbm_data_layer_properties WHERE id IN (X'BE71C9E3C86B4461A3DFF18D237B6375', X'8AC984CD94CF45B385766C200CA3AC8D', X'4BE1CEC34DD34EE2A79F21EF81EA7459');
