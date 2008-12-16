<?php

/////////////////////// funkcije koje definisu promenljivu matricu
	/////////////////////// nazivi (name polje) su zapravo isti nazivi polja kao u tabeli baze
	
	//tipovi su  (text, textarea, option) i datetime ukoliko je u pitanju datetime tip polja u tabeli baze
	//ukoliko je tip promenljive hidden, koristiti definisane vrednosti zbog funkcija koje rade obradu podataka
	//rezervisana imena za hidden vrednosti su za sada
	//id
	//tableName
	//ostale vrednosti treba zapravo treba definisati programski sta ce da cine u slucaju da postoje.
	//


include_once('translation_rs.php');

define("REVISION", 11);

define("IMAGE_NUM", 3);		//broj slika za proizvod, takodje i broj niza polja u photo tabeli sa imenom image1, image2, ... imageN

define("T_TXT",'text');
define("T_OPT", 'option');
define("T_DT", 'datetime');
define("T_TA", 'textarea');
define("T_IMG", 'image');
	
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
