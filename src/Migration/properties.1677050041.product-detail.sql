/* search page */
INSERT IGNORE INTO wbm_data_layer_properties (id, module, parent_id, after_id, child_count, name, value, created_at, updated_at, on_event, event_name)
VALUES (X'156A24CB503A42428650AA0E4715372A', 'frontend.detail.page', X'31EC4F665C2C4C0E90166D6FC8DC88A5', X'93BBCB64906A4A589B63A1223E43809D', 0, 'value', '{{ page.product.calculatedPrice.unitPrice }}', '2023-02-22 15:09:26.826', '2023-02-22 15:10:21.190', 0, '');


UPDATE wbm_data_layer_properties SET name = 'currency' WHERE id = X'93BBCB64906A4A589B63A1223E43809D';
UPDATE wbm_data_layer_properties SET on_event = 1, event_name = 'view_item' WHERE id = X'31EC4F665C2C4C0E90166D6FC8DC88A5';
UPDATE wbm_data_layer_properties SET name = 'items', parent_id = X'31EC4F665C2C4C0E90166D6FC8DC88A5' WHERE id = X'429B3E9FB14E4050B8E8A09833435E48';
UPDATE wbm_data_layer_properties SET name = 'item_id' WHERE id = X'A7C489982C8844E085A357CA9D044E22';
UPDATE wbm_data_layer_properties SET name = 'item_name' WHERE id = X'BCC208BEFA844CC09E957FE5DFCC3C17';
UPDATE wbm_data_layer_properties SET name = 'item_brand' WHERE id = X'43891D271A5C448EAD514D9AC01E3ACF';
UPDATE wbm_data_layer_properties SET name = 'item_category' WHERE id = X'0367DAC34F8A4E08B23CF9F70C43B854';
UPDATE wbm_data_layer_properties SET name = 'item_variant' WHERE id = X'E95AA62D68834A17B0BC4383BB26BE40';
UPDATE wbm_data_layer_properties SET name = 'item_list_name', after_id = X'29BFB3FD2FBC40C8A4018028F4E93FC4' WHERE id = X'97E504D8F2114420A451B7551FBEB764';

DELETE FROM wbm_data_layer_properties WHERE id IN (X'AB05C795585A472FA7084396F258BEBF', X'333BB971C7C8412AA709F903372CDA58', X'CE89DE16AA6C450E9044D7AAFFAA759F');
