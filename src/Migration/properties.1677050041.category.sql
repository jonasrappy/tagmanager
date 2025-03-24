/* category page */
INSERT IGNORE INTO wbm_data_layer_properties (id, module, parent_id, after_id, child_count, name, value, created_at, updated_at, on_event, event_name)
VALUES
    (X'D91ABB66BFA64DCB99AFF6458668D1B1', 'frontend.navigation.page', X'162B9A16867D4A50BE7FBFDBBB1DEDD3', null, 0, 'item_list_id', 'category_{{ page.header.navigation.active.id }}', '2023-02-22 10:25:43.024', '2023-02-22 10:44:08.528', 0, ''),
    (X'222AF84795104EACAC2D919E5170D7A4', 'frontend.navigation.page', X'162B9A16867D4A50BE7FBFDBBB1DEDD3', X'D91ABB66BFA64DCB99AFF6458668D1B1', 0, 'item_list_name', 'Category: {{ page.header.navigation.active.translated.name }}', '2023-02-22 10:25:50.321', '2023-02-22 10:34:33.167', 0, ''),
    (X'8FF79283B962494DA9717D8412A41667', 'frontend.navigation.page', X'7046D21DA6F444C4A2A41F1954DF6C98', X'9747160478314B23B831AD3A680F196F', 0, 'item_list_id', 'category_{{ page.header.navigation.active.id }}', '2023-02-22 12:26:16.355', '2023-02-22 12:26:32.665', 0, '');

UPDATE wbm_data_layer_properties SET on_event = 1, event_name = 'view_item_list' WHERE id = X'162B9A16867D4A50BE7FBFDBBB1DEDD3';
UPDATE wbm_data_layer_properties SET name = 'items', after_id = X'222AF84795104EACAC2D919E5170D7A4' WHERE id = X'7046D21DA6F444C4A2A41F1954DF6C98';
UPDATE wbm_data_layer_properties SET name = 'item_id' WHERE id = X'6DF4A784650744C5A83AF1A8940D7612';
UPDATE wbm_data_layer_properties SET name = 'item_name' WHERE id = X'9259118AA85941D4B79BC0194332FAFB';
UPDATE wbm_data_layer_properties SET name = 'index' WHERE id = X'1880C84DABF642A099179B34C129204C';
UPDATE wbm_data_layer_properties SET name = 'item_brand' WHERE id = X'6E5D2B91458E475EB9DCCBEB9ED7F49C';
UPDATE wbm_data_layer_properties SET name = 'item_category', value = '{{ page.header.navigation.active.translated.name }}' WHERE id = X'920615EE20F748939B42087C3F714DDB';
UPDATE wbm_data_layer_properties SET name = 'item_variant' WHERE id = X'9747160478314B23B831AD3A680F196F';
UPDATE wbm_data_layer_properties SET name = 'item_list_name', after_id = X'8FF79283B962494DA9717D8412A41667', value = 'Category: {{ page.header.navigation.active.translated.name }}' WHERE id = X'B081FDD19EE3404F9A0E94A9C9B96CF0';

DELETE FROM wbm_data_layer_properties WHERE id = X'5EB6BCB881B74B179E0EF2E627EB7335';
