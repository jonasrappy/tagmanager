/* home page */
INSERT IGNORE INTO wbm_data_layer_properties (id, module, parent_id, after_id, child_count, name, value, created_at, updated_at, on_event, event_name)
VALUES
    (X'338144DE6AFD4C8CB58FBB3B2CC773CA', 'frontend.home.page', X'8CF7A306C91D41939A24F4DCFC82C160', X'00482CADE6974C859C0DD46DBB6F9918', 0, 'item_list_id', 'home', '2023-02-22 07:52:46.675', '2023-02-22 08:00:24.012', 0, ''),
    (X'6A25D6DF995F404C9573582D5A3C44FB', 'frontend.home.page', X'8CF7A306C91D41939A24F4DCFC82C160', X'338144DE6AFD4C8CB58FBB3B2CC773CA', 0, 'item_list_name', 'Home', '2023-02-22 07:52:52.343', '2023-02-22 08:00:29.946', 0, ''),
    (X'8B59AC81C4F640C68731F38B1FA28F34', 'frontend.home.page', X'E22439B57C48482EBB0EBDBCE1085388', X'D6DD588E55314B32B8DC4916AF1D6754', 0, 'item_list_id', 'home', '2023-02-22 07:53:24.063', '2023-02-22 07:53:32.573', 0, '');

UPDATE wbm_data_layer_properties SET on_event = 1, event_name = 'view_item_list' WHERE id = X'8CF7A306C91D41939A24F4DCFC82C160';
UPDATE wbm_data_layer_properties SET name = 'items', after_id = X'6A25D6DF995F404C9573582D5A3C44FB' WHERE id = X'E22439B57C48482EBB0EBDBCE1085388';
UPDATE wbm_data_layer_properties SET name = 'item_id' WHERE id = X'8F9874DD589F481C87720212877DCAA8';
UPDATE wbm_data_layer_properties SET name = 'item_name' WHERE id = X'D7B3B4A324A74152A768F5E090C4B0C8';
UPDATE wbm_data_layer_properties SET name = 'index' WHERE id = X'BDCFEAE64AF54AB48F9418A74C1A18B0';
UPDATE wbm_data_layer_properties SET name = 'item_brand' WHERE id = X'51B234AE8FCB424F89D4132A5AB7B1CD';
UPDATE wbm_data_layer_properties SET name = 'item_category' WHERE id = X'AD910BCB95F941BDBE7559B2FED36AEF';
UPDATE wbm_data_layer_properties SET name = 'item_variant' WHERE id = X'D6DD588E55314B32B8DC4916AF1D6754';
UPDATE wbm_data_layer_properties SET name = 'item_list_name', after_id = X'8B59AC81C4F640C68731F38B1FA28F34' WHERE id = X'718AF67A93BD4D449D33566C05EC4A57';

DELETE FROM wbm_data_layer_properties WHERE id = X'00482CADE6974C859C0DD46DBB6F9918';

UPDATE wbm_data_layer_properties
SET value = REPLACE (value, 'loop.index ', 'loop.index0 ')
WHERE value like '%loop.index %';
