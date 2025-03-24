/* search page */
INSERT IGNORE INTO wbm_data_layer_properties (id, module, parent_id, after_id, child_count, name, value, created_at, updated_at, on_event, event_name)
VALUES
    (X'28E9D7F48849419CA45B37DE7C1403EC', 'frontend.search.page', X'76C30827A11A43808140C8425979EC89', null, 0, 'item_list_id', 'search', '2023-02-22 12:47:25.706', '2023-02-22 12:48:03.903', 0, ''),
    (X'E2DED709E2BD4C37A945B3A8220F3428', 'frontend.search.page', X'76C30827A11A43808140C8425979EC89', X'28E9D7F48849419CA45B37DE7C1403EC', 0, 'item_list_name', 'Search', '2023-02-22 12:47:31.035', '2023-02-22 12:48:10.589', 0, ''),
    (X'29BFB3FD2FBC40C8A4018028F4E93FC4', 'frontend.search.page', X'583E88515EDE4359B4D7EBE2592BF09C', X'6C23BAB95A79489DA881ED3A3671D6C3', 0, 'item_list_id', 'search', '2023-02-22 12:47:50.116', '2023-02-22 12:47:56.315', 0, '');

UPDATE wbm_data_layer_properties SET name = 'search_term' WHERE id = X'62A1C1831F78431DBEAE4B508B4CFEA2';
UPDATE wbm_data_layer_properties SET on_event = 1, event_name = 'view_item_list' WHERE id = X'76C30827A11A43808140C8425979EC89';
UPDATE wbm_data_layer_properties SET name = 'items', after_id = X'E2DED709E2BD4C37A945B3A8220F3428' WHERE id = X'583E88515EDE4359B4D7EBE2592BF09C';
UPDATE wbm_data_layer_properties SET name = 'item_id' WHERE id = X'7FBB23633E434694903E73DA85DA889E';
UPDATE wbm_data_layer_properties SET name = 'item_name' WHERE id = X'A55470F533CC4E0A814B3723E0C08E93';
UPDATE wbm_data_layer_properties SET name = 'index' WHERE id = X'39C88DA666AE4B948A2E0624CB5D1C5C';
UPDATE wbm_data_layer_properties SET name = 'item_brand' WHERE id = X'3DB6E471D7B542AAB513C317C98933EE';
UPDATE wbm_data_layer_properties SET name = 'item_category' WHERE id = X'BD7730C13B7448D4AA1CF7B9F6DA28C9';
UPDATE wbm_data_layer_properties SET name = 'item_variant' WHERE id = X'6C23BAB95A79489DA881ED3A3671D6C3';
UPDATE wbm_data_layer_properties SET name = 'item_list_name', after_id = X'29BFB3FD2FBC40C8A4018028F4E93FC4' WHERE id = X'97E504D8F2114420A451B7551FBEB764';

DELETE FROM wbm_data_layer_properties WHERE id IN (X'43EBFE29631F446FBCFA13122EB92364', X'E246DC78C8CD4E0490CF1D8EFA81EDA4');
