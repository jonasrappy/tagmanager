UPDATE wbm_data_layer_properties SET value = '{{ pagecategory() }}' WHERE id = X'A197BB2E7F5343FF8ADF4166865E76CE';
UPDATE wbm_data_layer_properties SET value = '{{ pagecategory() }}' WHERE id = X'2B4FCD02FCCF47DDB92A5A47778D9F1C';

UPDATE wbm_data_layer_properties SET value = '{{ itembrand(product.id) }}' WHERE id = X'51B234AE8FCB424F89D4132A5AB7B1CD';
UPDATE wbm_data_layer_properties SET value = '{{ itembrand(product.id) }}' WHERE id = X'6E5D2B91458E475EB9DCCBEB9ED7F49C';
UPDATE wbm_data_layer_properties SET value = '{{ itembrand(product.id) }}' WHERE id = X'12E16E89E9CB4F6A9D064409C9740F3D';
UPDATE wbm_data_layer_properties SET value = '{{ itembrand(item.id) }}' WHERE id = X'5F82CD2464FE4DDF9F74BB7A31B27346';
UPDATE wbm_data_layer_properties SET value = '{{ itembrand(product_id) }}' WHERE id = X'203BE4E4D4684EA88CD530C8845C0C0E';
UPDATE wbm_data_layer_properties SET value = '{{ itembrand(lineItem.id) }}' WHERE id = X'A0879E23B2C448EEB36C8A766A41389B';
UPDATE wbm_data_layer_properties SET value = '{{ itembrand(product.id) }}' WHERE id = X'3DB6E471D7B542AAB513C317C98933EE';
UPDATE wbm_data_layer_properties SET value = '{{ itembrand(lineItem.id) }}' WHERE id = X'DD25DA53EABC4A58BBB29D1F58F54ACA';
UPDATE wbm_data_layer_properties SET value = '{{ itembrand(lineItem.id) }}' WHERE id = X'C3DD51F7A24B47F995A55563E78DD609';
UPDATE wbm_data_layer_properties SET value = '{{ itembrand(lineItem.id) }}' WHERE id = X'B3DD09B1AA5B41FBAAA878B0D7458438';
UPDATE wbm_data_layer_properties SET value = '{{ itembrand(lineItem.identifier) }}' WHERE id = X'B4A8DAC6B16542088B12CD5C09D87A66';

UPDATE wbm_data_layer_properties SET value = '{{ itemname(item.id) }}' WHERE id = X'C5D1EF93A50C417DB5053D2FF20418EA';
UPDATE wbm_data_layer_properties SET value = '{{ itemname(product_id) }}' WHERE id = X'BC0F72FEEF5A483C889D6E6C33451F2E';

UPDATE wbm_data_layer_properties SET value = '{{ itemnumber(item.id) }}' WHERE id = X'9C4927A0CB9B4255935B4AED4EF16FB4';
UPDATE wbm_data_layer_properties SET value = '{{ itemnumber(product_id) }}' WHERE id = X'675C37BFF6D949789BD9C4E26BE0DB18';

UPDATE wbm_data_layer_properties SET VALUE = '{{ itemcategory(product.id) }}' WHERE id = X'AD910BCB95F941BDBE7559B2FED36AEF';
UPDATE wbm_data_layer_properties SET VALUE = '{{ itemcategory(product.id) }}' WHERE id = X'920615EE20F748939B42087C3F714DDB';
UPDATE wbm_data_layer_properties SET VALUE = '{{ itemcategory(product.id) }}' WHERE id = X'0367DAC34F8A4E08B23CF9F70C43B854';
UPDATE wbm_data_layer_properties SET VALUE = '{{ itemcategory(product.id) }}' WHERE id = X'BD7730C13B7448D4AA1CF7B9F6DA28C9';
UPDATE wbm_data_layer_properties SET VALUE = '{{ itemcategory(product.id) }}' WHERE id = X'7D1CECA9EDFF4E8ABE3BB582E36679C2';
UPDATE wbm_data_layer_properties SET VALUE = '{{ itemcategory(item.id) }}' WHERE id = X'43CD39F741884A4B9832648B5B1EC95C';
UPDATE wbm_data_layer_properties SET VALUE = '{{ itemcategory(product_id) }}' WHERE id = X'77C90B874D894E039910FB43B034EACA';
UPDATE wbm_data_layer_properties SET VALUE = '{{ itemcategory(lineItem.id) }}' WHERE id = X'114ADFAC86C14FD2BB14B98345C1FB32';
UPDATE wbm_data_layer_properties SET VALUE = '{{ itemcategory(lineItem.id) }}' WHERE id = X'37B5A732B3B0459DB3AD5465FA066D17';
UPDATE wbm_data_layer_properties SET VALUE = '{{ itemcategory(lineItem.id) }}' WHERE id = X'461F6DA5370847A5801480AF1807B9C7';
UPDATE wbm_data_layer_properties SET VALUE = '{{ itemcategory(lineItem.id) }}' WHERE id = X'E9F26C2712CD4CDE8090297527E451AD';
UPDATE wbm_data_layer_properties SET VALUE = '{{ itemcategory(lineItem.identifier) }}' WHERE id = X'F150BE1E412940988AC7A690C165F667';

UPDATE wbm_data_layer_properties
SET VALUE = '{% set conversion = 0 %}{% for product_id in {0: getparam(''id'')} %}{% set conversion = conversion + (cartremoveprice(product_id) * cartremoveprice(product_id, true)) %}{% endfor %}{{ conversion }}'
WHERE id = X'D18D3B50937D4992B8FD021E3C38857C';