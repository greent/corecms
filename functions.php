<?php
	
	require_once('variables.php');
	
	function defs(){
		$textarea_rows = 4;			//broj redova u textarea poljima
		$textarea_cols = 30;		//broj kolona u textarea poljim
	}
	
	
	///////////////////  podaci za konekciju. pre testiranja nakon postavljanja na host racunar promeniti donje podatke
	
	function connect(){
//		$link=mysql_connect('localhost', 'eprons', 'eprons1') or die ('died');		//ovde promeniti login podatke na mysql server
	$link=mysql_connect('127.0.0.1', 'root', 'root') or die ('died');		//ovde promeniti login podatke na mysql server
		
		mysql_select_db('fotodiskont') or die('greska sa bazom');		//ovde odabrati bazu koja se koristi. pozeljno je ostaviti isti naziv baze na razvojnoj masini kao i na serveru zbog kompatibilnosti. 
	}
	
	function disconnect(){
		
	//mysql_close($link);
		
	}

	
	function func_generate_string() {
		$auto_string = chr(mt_rand(ord('A'), ord('Z')));
		for ($i= 0; $i<8; $i++) {
			$ltr= mt_rand(1, 3);
			if ($ltr==1) $auto_password .= chr(mt_rand(ord('A'), ord('Z')));
			if ($ltr==2) $auto_password .= chr(mt_rand(ord('a'), ord('z')));
			if ($ltr==3) $auto_password .= chr(mt_rand(ord('0'), ord('9')));
		}
		return $auto_string;
	}

	

	/////////////////////// funkcije koje definisu promenljivu matricu
	/////////////////////// nazivi (name polje) su zapravo isti nazivi polja kao u tabeli baze
	
	//tipovi su  (text, textarea, option) i datetime ukoliko je u pitanju datetime tip polja u tabeli baze
	//ukoliko je tip promenljive hidden, koristiti definisane vrednosti zbog funkcija koje rade obradu podataka
	//rezervisana imena za hidden vrednosti su za sada
	//id
	//tableName
	//ostale vrednosti treba zaprvo treba definisati programski sta ce da cine u slucaju da postoje.
	//
	


	

//////////////////////////// dole se nalazi funkcija koja kreira formu za editovanje jednog polja u bazi ///////////////////////////////

function formCreate($input, $tableName, $tableDisplay, $id, $action, $user_id){	//pocetak funkcije koja pravi formu
	
	$textarea_rows = 4;			//broj redova u textarea poljima
	$textarea_cols = 30;		//broj kolona u textarea poljima
	

//	$inputTextSize = 14;
	
	$num = count($input);	//broj elemenata u matrici
	
//$width = 50 / $num;

	printf("<form method=\"post\" action=\"edit.php\">\n<table border=\"0\" class=\"tableEdit\">\n");	//zaglavlje tabele i forme (uraditi parsing za method i action)
		
	printf("<tr>\n<td align=\"center\" colspan=\"%s\">%s</td>\n</tr>\n", $num, $tableName);		//ispis imena tabele

	
/*

	echo "<tr>\n";		//pocetak zaglavlja tabele
		
	for($cnt = 0; $cnt<$num; $cnt++){
		if($input[$cnt]['type']=='hidden'){				//ako je tip = hidden onda 
			echo "";									//se prikazuje praznina
		} else {
			printf("<td width=%s%%>%s</td>\n", $width, $input[$cnt]['display']);	//ispis zaglavlja tabele
		}
	}
	echo "</tr>\n";								//kraj zaglavlja tabele

*/
	
	$queryString = sprintf("select * from %s where id=%s", $tableName, $id);		//formira string za odabir svih polja iz unete promenljive $tableName
	
	$query = mysql_query($queryString);							//izvrsavanje upita
		
	$result = mysql_fetch_assoc($query);		//rezultat umesto petlje
			
	
			
	for($cnt = 0; $cnt<$num; $cnt++){					//pocetak ispisa vrednosti
	
		echo "<tr>\n";
		
		$type=$input[$cnt]['type'];						//alias promenljive za tip
		
		$name = $input[$cnt]['name'];					//alias za ime
		
		$field = $input[$cnt]['optdisplay'];			//alias za referentno polje u select meniju
		
		$display = $input[$cnt]['display'];
		
		switch($type) {		//pocetak switch kontrole
			
			case "hidden":		//ako je tip hidden onda se vrednost ne ispisuje u obliku polja u tabeli
				
				if($action=='add'){
					echo $type;
					printf("<input type=\"%s\" name=\"%s\">\n", $input[$cnt]['type'], $input[$cnt]['name']); //ispis u slucaju hiddena
				} else {
					printf("<input type=\"%s\" name=\"%s\" value=\"%s\" \>\n", $input[$cnt]['type'], $input[$cnt]['name'], $input[$cnt]['value']); //ispis u slucaju hiddena
				}
			
			break;
			
			case "option":		//slucaj ako je tip = option
				
				$fieldName=$input[$cnt]['name'];		//ime select forme
				
				$profile_name = $global_type . "_profile";
				
				if($fieldName == $global_type && $global_type != 'user'){
				
					echo "<input type=\"hidden\" name=\"$fieldName\" value=\"$id\">";
					
				} else {

				
					printf("<td class=\"outputfieldRight\" width=%s%%>%s</td>\n", $width, $input[$cnt]['display']);
					
					
					printf("<td class=\"outputfieldLeft\" width=%s%%>\n<select name=\"%s\"", $width, $fieldName);		//ispis select zaglavlja
					
					if($action=='delete'){			//ako je akcija 'brisanje'
						printf(" disabled>\n");		//polje ce biti disableovano
					} else {						//ako nije
						printf(">\n");				//zatvara se tag
					}								//kraj gornje if petlje
					
					if ($fieldName == $profile_name){					
						$optionString=sprintf("select * from %s where %s=%s", $profile_name, $global_type, $user_id);		//string koji kreira select upit za bazu za tabelu
					} else {
						$optionString=sprintf("select * from %s", $input[$cnt]['name']);		//string koji kreira select upit za bazu za tabelu
					}
					
					//echo $optionString;
					
					$optionQuery=mysql_query($optionString);		//izvrsavanje upita
					$numFields = mysql_num_fields($optionQuery);	//broj polja u biranoj tabeli
					while($optionResult=mysql_fetch_assoc($optionQuery)){		//petlja koja ispisuje opcije
						printf("<option value=\"%s\"", $optionResult['id']);	//ispis opcije sa id-om
						if($result[$fieldName] == $optionResult['id']){			//formiranje "selected" vrednosti za select tip polja
							printf(" selected>");
						} else {
						printf(">");											//zatvaranje option tag-a
						}
						
						printf("%s", $optionResult[$field]);
				
					
					
					
					
					
//					for($nameNum=1;$nameNum < $numFields;$nameNum++){			//for petlja za dobavljanje imena polja u tabeli.
//						$resultName = mysql_field_name($optionQuery, $nameNum);		//
//						printf("%s | ", $optionResult[$resultName]);			//ispis rezultata
//					}
					echo "</option>\n";				//kraj opcije
					}			
				printf("</select>\n</td>\n");		//kraj select forme
			}	
			break;
			
			case "textarea":	//slucaj ako je tip = textarea
				if($action=='add'){
					printf("<td class=\"outputfieldLeft\"width=%s%%>%s</td>\n", $width, $input[$cnt]['display']);
					printf("<td class=\"outputfieldRight\"><textarea name=\"%s\" rows=%u cols=%u></textarea></td>\n", $name, $textarea_rows, $textarea_cols);	//ispis inputa sa vrednoscu iz tabele
				} elseif($action=='delete'){
					printf("<td width=%s%%>%s</td>\n", $width, $input[$cnt]['display']);
					
					printf("<td><textarea disabled name=\"%s\" rows=%u cols=%u>%s</textarea></td>\n", $name, $textarea_rows, $textarea_cols, $result[$name]);	//ispis inputa sa vrednoscu iz tabele
				} else {
					printf("<td width=%s%%>%s</td>\n", $width, $input[$cnt]['display']);
					
					printf("<td><textarea name=\"%s\" rows=%u cols=%u>%s</textarea></td>\n", $name, $textarea_rows, $textarea_cols, $result[$name]);	//ispis inputa sa vrednoscu iz tabele
				}
			break;
			
			case "datetime":	//slucaj ako je tip == datetime(odnosno, ako unosimo datum)
				printf("<td class=\"outputfieldRight\" width=%s%%>%s</td>\n", $width, $input[$cnt]['display']);
				if($action=='add'){
					$today = date('Y-m-d G:i:s');
					datetime_form($today, $action);					
				} else {				
				
				datetime_form($result[$name], $action);
				}
			break;
			
			//slucaj ako je tip == file, odnosno, file handling rutina za ispis
			//dovrsiti
			
			case "image":	
				if($action=='add'){
					printf("<td class=\"outputfieldRight\" width=%s%%>%s</td>\n", $width, $display);
				}
			break;
			
			// kraj rutine za ispis fajla
			
			
			
			default:		//slucaj ako je tip == text, tj ovo je zapravo 'obicno' tekstualno polje
				//$nameRef = $input[$cnt]['name'];		//referenca za mysql rezultat
				
				switch($name){
				
					case 'driving_licence':
					case 'mobility':					
					case 'family_status':					
						selections($width, $input[$cnt]['display'], $nameRef);
					break;
					
					
					
					default:
						
						if($action=='add'){
							printf("<td class=\"outputfieldRight\" width=%s%%>%s</td>\n", $width, $input[$cnt]['display']);
							printf("<td width=%s class=\"outputfieldLeft\"><input name=\"%s\" type=\"%s\" size=%s></td>\n", $width, $name, $input[$cnt]['type'], $inputTextSize);	//ispis inputa sa vrednoscu iz tabele
						} elseif($action=='delete'){
							printf("<td class=\"outputfieldRight\" width=%s%%>%s</td>\n", $width, $input[$cnt]['display']);
							printf("<td class=\"outputfieldLeft\"><input disabled name=\"%s\" type=\"%s\" value=\"%s\" /></td>\n", $name, $input[$cnt]['type'], $result[$name]);	//ispis inputa sa vrednoscu iz tabele
						}				
						elseif($action=='edit'){
							printf("<td class=\"outputfieldRight\" width=%s%%>%s</td>\n", $width, $input[$cnt]['display']);
							printf("<td class=\"outputfieldLeft\" width=%s%%><input name=\"%s\" type=\"%s\" value=\"%s\" size=%s/></td>\n", $width, $name, $input[$cnt]['type'], $result[$name], $inputTextSize);	//ispis inputa sa vrednoscu iz tabele
						}
				}
				
		} //kraj switch kontrole
		
		echo "</tr>\n";
		
	}	//kraj for petlje za ispis vrednosti
	

	printf("<input type=\"hidden\" name=\"tableName\" value=\"%s\" \>\n", $tableName);		//hidden imena tabele. predefinisana konstanta
	printf("<input type=\"hidden\" name=\"id\" value=\"%s\" \>\n", $id);		//hidden indentifikatora. predefinisana konstanta
	printf("<input type=\"hidden\" name=\"action\" value=\"%s\" \>\n", $action);
	printf("<tr><td align=\"center\" colspan=\"%s\"><input type=\"submit\" value=\"%s\"></td>\n", $num,  $action);		//submit polje
	echo "</table>\n";		//kraj tabele
	
	//printf("<a href=tabledisplay.php?tablename=%s>nazad</a>", $tableName);
	
	}	//kraj funkcije


function datetime_form($datetime, $action){		//funkcija koja vadi vrednosti iz mysql timestamp-a i poziva funkciju koja pravi select forme

	$year = substr($datetime,0,4); 		//godina iz timestamp-a
	$month = substr($datetime,5,2);		//mesec iz timestamp-a
	$day = substr($datetime,8,2);		//dan iz timestamp-a
	$hour = substr($datetime,11,2);		//sat iz timestamp-a
	$minute = substr($datetime,14,2);	//minut iz timestamp-a
	$second = substr($datetime,17,2); 	//sekunde iz timestamp-a
	
	printf("<td>");			//pocetak table polja
	
	/////////////////// donji pozivi funkcije su sve pozivi iste funkcije sa razlicitim parametrima

	dateForm('year', 2008, 2010, $year, $action);		//poziv funkcije za ispis godine
	
	dateForm('month', 1, 12, $month, $action);			//poziv funkcije za ispis meseca
	
	dateForm('day', 1, 31, $day, $action);				//poziv funkcije za ispis dana
	
	dateForm('hour', 0, 23, $hour, $action);				//poziv funkcije za ispis sata
	
	dateForm('minute', 0, 59, $minute, $action);			//poziv funkcije za ispis minute
	
	dateForm('second', 0, 59, $second, $action);			//poziv funkcije za ispis sekunde
	
}		//kraj funkcije


function dateForm($name, $min, $max, $actual, $action){		//funkcija za ispis vremena (datum+vreme). prosledjenje vrednosti su naziv, minimalna vrednost, maksimalna vrednost i trenutna vrednost za selected property
	
	printf("%s:<select name='%s'", $name, $name);			//select zaglavlje
	if($action=='delete'){
		printf(" disabled>\n");
	} else {
		printf(">");
	}
	
	
	for($count=$min; $count<=$max; $count++){		//for petlja koja broji vrednosti od min do max
		printf("<option");							//opcija
		if($count==$actual){						//ako je vrednost brojaca == trenutna vrednost
			printf(" selected");					//ispis selected propertija
		}
		printf(">%s</option>\n", $count);			//kraj opcije
	}
	printf("</select>\n");				//kraj select zaglavlja

}		//kraj funkcije za ispis vremena

function fetchResult($tableName, $tableField){

$query_string=sprintf("select %s from %");

}

function selections($width, $display, $name){

	printf("<td class=\"outputfieldRight\" width=%s%%>%s</td>\n", $width, $display);
	printf("<td width=%s class=\"outputfieldLeft\"><select name=\"%s\">\n", $width, $name);	//ispis inputa sa vrednoscu iz tabele
	switch($name){
		case 'driving_licence':
		case 'mobility':
			printf("<option value=\"no\">No</option>\n");
			printf("<option value=\"yes\">Yes</option>\n");
		break;
		
		case 'family_status':
			printf("<option value=\"single\">Single</option>\n");
			printf("<option value=\"married\">Married</option>\n");
		break;
	
	}
	
	printf("</select></td>\n");
	
}



?>