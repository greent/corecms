<?php

// variables definition array(s)
// array key 'name' is actually same as field name in mysql database
// array key 'type' is type, defined in defines.php file. behavior and new types can be added through change of functions.php file and adding appropriate code for it
// array value for key 'type' hidden is special control type and is parsed through html form type 'hidden'. currently available values for hidden values are
// id
// tableName
// those values actually does not need definition below as they are processed internaly as id key and tableName identifiers
// in case of option type (T_OPT), key with name opt_display is required as it fetches foreign key table value with field name assigned to this variable.

include_once('translation.php');		//includes file for translating display terms

include_once('defines.php');			//includes defines for type key


$fl_language = array(
	'type' => T_TXT,
	'name' => 'fl_language',
	'display' => $transl['fl_language'],
	);

$brandshop = array(
	array(
		'type' => T_TXT,
		'name' => 'brandname',
		'display' => $transl['brandname'],
	),
	array(
		'type' => T_TXT,
		'name' => 'brandname_order',
		'display' => $transl['brandname_order'],
	),
);

$product_group = array(
	array(
		'type' => T_TXT,
		'name' => 'group_name',
		'display' => $transl['group_name'],
	),
	array(
		'type' => T_TXT,
		'name' => 'group_order',
		'display' => $transl['group_order'],
	),
);

$product_type = array(
	array(
		'type' => T_TXT,
		'name' => 'typename',
		'display' => $transl['typename'],
	),
	array(
		'type' => T_OPT,
		'name' => 'product_group',
		'optdisplay' => 'group_name',
		'display' => $transl['product_group'],
	),

);

$product = array(
	array(
		'type' => T_OPT,
		'name' => 'product_type',
		'optdisplay' => 'typename',
		'display' => $transl['product_type'],
	),
	array(
		'type' => T_OPT,
		'name' => 'brandshop',
		'optdisplay' => 'brandname',
		'display' => $transl['brandname'],
	),
	array(
		'type' => T_TXT,
		'name' => 'model',
		'display' => $transl['model'],
	),
	array(
		'type' => T_TXT,
		'name' => 'price',
		'display' => $transl['price'],
	),
	array(
		'type' => T_TXT,
		'name' => 'diskont_price',
		'display' => $transl['diskont_price'],
	),
	array(
		'type' => T_TXT,
		'name' => 'delivery',
		'display' => $transl['delivery'],
	),
	array(
		'type' => T_TXT,
		'name' => 'lager',
		'display' => $transl['lager'],
	),
	array(
		'type' => T_TA,
		'name' => 'descr1',
		'display' => $transl['description1'],
	),
	array(
		'type' => T_TA,
		'name' => 'descr2',
		'display' => $transl['description2'],
	),
	array(
		'type' => T_TA,
		'name' => 'chars',
		'display' => $transl['chars'],
	),
);

$photo = array (
	array(
		'type' => T_OPT,
		'name' => 'product',
		'optdisplay' => 'model',
		'display' => $transl['product'],
	),
	array(
		'type' => T_IMG,
		'name' => 'image1',
		'display' => $transl['image1'],
	),
	array(
		'type' => T_IMG,
		'name' => 'image2',
		'display' => $transl['image2'],
	),
	array(
		'type' => T_IMG,
		'name' => 'image3',
		'display' => $transl['image3'],
	),
);
	


?>
