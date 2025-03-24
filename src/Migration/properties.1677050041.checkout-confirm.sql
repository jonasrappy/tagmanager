/* checkout confirm page */
INSERT IGNORE INTO wbm_data_layer_properties (id, module, parent_id, after_id, child_count, name, value, created_at, updated_at, on_event, event_name)
VALUES
    (X'ADA65721D4454BB5BFCCD772725E63DC', 'frontend.checkout.confirm.page', X'647E531700884C7B80AAB4ACBDE8659F', X'211F468FE3084E90A75A534F9A5F68FC', 0, 'index', '{{ loop.index }}', '2023-02-28 12:34:05.658', '2023-02-28 12:34:24.046', 0, ''),
    (X'A7FAB819415449D3BF9827181AFDDEF0', 'frontend.checkout.confirm.page', X'3211918B260B4E8E92C09B5F1C20471C', X'A8EB44C3B49748ACACE79D76F8296EDB', 0, 'value', '{{ page.cart.price.totalPrice }}', '2023-02-28 12:33:23.905', '2023-02-28 12:33:52.500', 0, ''),
    (X'C3F70E976ED74404A67E7FDAEC87C86A', 'frontend.checkout.confirm.page', X'3211918B260B4E8E92C09B5F1C20471C', X'A8EB44C3B49748ACACE79D76F8296EDB', 0, 'payment_type', '{{ context.paymentMethod.distinguishableName }}', '2023-04-28 09:17:13.214', '2023-04-28 09:27:04.122', 0, '');

UPDATE wbm_data_layer_properties SET value = 'add_payment_info' WHERE id = X'E46E625B258549909E577C6E07B26827';
UPDATE wbm_data_layer_properties SET name = 'currency' WHERE id = X'A8EB44C3B49748ACACE79D76F8296EDB';
UPDATE wbm_data_layer_properties SET parent_id = X'3211918B260B4E8E92C09B5F1C20471C', after_id = X'A7FAB819415449D3BF9827181AFDDEF0' WHERE id = X'13FEDF27E2D7412094EBFD3E7F5FE3CC';
UPDATE wbm_data_layer_properties SET name = 'payment_type', parent_id = X'3211918B260B4E8E92C09B5F1C20471C' WHERE id = '305D5E81880C430DBEEF4F00938E3145';
UPDATE wbm_data_layer_properties SET name = 'items', after_id = X'A8EB44C3B49748ACACE79D76F8296EDB', parent_id = X'3211918B260B4E8E92C09B5F1C20471C' WHERE id = X'647E531700884C7B80AAB4ACBDE8659F';
UPDATE wbm_data_layer_properties SET name = 'item_id' WHERE id = X'BF516282B6694E949EE110B7992DDC9B';
UPDATE wbm_data_layer_properties SET name = 'item_name' WHERE id = X'BD50856C81A84E00927B98B9AD5FFC09';
UPDATE wbm_data_layer_properties SET name = 'item_brand' WHERE id = X'B3DD09B1AA5B41FBAAA878B0D7458438';
UPDATE wbm_data_layer_properties SET name = 'item_category' WHERE id = X'E9F26C2712CD4CDE8090297527E451AD';
UPDATE wbm_data_layer_properties SET name = 'item_variant' WHERE id = X'632753ACA5B745D8A9A7D01AD5E51E37';

DELETE FROM wbm_data_layer_properties WHERE id IN (X'77813EDB782B4656954EA3EAD2CDEF59', X'F798E7553CFD43218529C35EAD52FB50', X'643161D38B3E47B080400C891338007A');
