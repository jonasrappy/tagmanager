/* listing update interaction */
INSERT IGNORE INTO wbm_data_layer_properties (id, module, parent_id, after_id, child_count, name, value, created_at, updated_at, on_event, event_name)
VALUES
    (X'C47C5AAD426F4A03BF6A630B4DBFACB8', 'frontend.cms.navigation.page', X'776B8B15B157472DBE607B34FEA416E8', null, 0, 'item_list_id', 'listing', '2023-02-22 13:45:19.729', '2023-02-22 13:47:14.972', 0, ''),
    (X'A7B62AD9F4F641D49EA24B52E51E11BF', 'frontend.cms.navigation.page', X'776B8B15B157472DBE607B34FEA416E8', X'C47C5AAD426F4A03BF6A630B4DBFACB8', 0, 'item_list_name', 'Listing', '2023-02-22 13:45:24.984', '2023-02-22 13:46:58.608', 0, ''),
    (X'24304E64B4AF4102BB4A3AECE1068293', 'frontend.cms.navigation.page', X'AEE42C38B30C42F489F692957F1FF991', X'F968C1DFF238499D9ABD643B10AE2927', 0, 'item_list_id', 'listing', '2023-02-22 13:45:38.888', '2023-02-22 13:47:34.824', 0, '');

UPDATE wbm_data_layer_properties SET on_event = 1, event_name = 'view_item_list' WHERE id = X'776B8B15B157472DBE607B34FEA416E8';
UPDATE wbm_data_layer_properties SET name = 'items', after_id = X'A7B62AD9F4F641D49EA24B52E51E11BF' WHERE id = X'AEE42C38B30C42F489F692957F1FF991';
UPDATE wbm_data_layer_properties SET name = 'item_id' WHERE id = X'903AE7A61D8043EBA19E41C14BE8A1FD';
UPDATE wbm_data_layer_properties SET name = 'item_name' WHERE id = X'A840F1EA73084DADAE2D277893340AB5';
UPDATE wbm_data_layer_properties SET name = 'index' WHERE id = X'136EBB5920E941929E5D796BBF87E998';
UPDATE wbm_data_layer_properties SET name = 'item_brand' WHERE id = X'12E16E89E9CB4F6A9D064409C9740F3D';
UPDATE wbm_data_layer_properties SET name = 'item_category' WHERE id = X'7D1CECA9EDFF4E8ABE3BB582E36679C2';
UPDATE wbm_data_layer_properties SET name = 'item_variant' WHERE id = X'F968C1DFF238499D9ABD643B10AE2927';
UPDATE wbm_data_layer_properties SET name = 'item_list_name', after_id = X'24304E64B4AF4102BB4A3AECE1068293' WHERE id = X'461F1C90944B427695EE9A7C3004ED7C';

DELETE FROM wbm_data_layer_properties WHERE id IN (X'AF2775ED13ED45B78F09E1F71728EF1B', X'20D95820B1DC493E862B117351338076');
