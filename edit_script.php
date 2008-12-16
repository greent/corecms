<?php

	connect();

	$tableName = $_POST['tableName'];	//promenljiva sa imenom tabele, koja se nalazi u svakoj formi u obliku hidden promenljive
	
	$id = $_POST['id'];					//id je kljuc za selekciju iz tabele	
	
	$action = $_POST['action'];			//akcija
	
	$input = $$tableName;				//poziv funkcije koja ima ime kao ime tabele gde je zapravo promenljiva $input matrica koja sadrzi nazive svih polja u tabeli
	
	$num = count($input);				//broj elementa u matrici
	
	for($cnt = 0; $cnt<$num; $cnt++){				//pocetak petlje koja pravi matricu sa vrednostima iz forme
			$values[] = $_POST[$input[$cnt]['name']];	//matrica
	}	//kraj gornje for petlje
	
	switch($action){		//switch kontrola za akciju
		
		case 'add':			//ako je akcija 'dodavanje' ...
			
			$insertString = sprintf("insert into %s set ", $tableName);		//pocetak formiranja stringa za query unosa
			for($cnt = 0; $cnt < $num; $cnt++){				//brojac za elemente u matrici
				
				$type = $input[$cnt]['type'];
				$name = $input[$cnt]['name'];
				
				if($type=='datetime'){
					
					$year = $_POST['year'];
					$month = $_POST['month'];
					$day = $_POST['day'];
					$hour = $_POST['hour'];
					$minute = $_POST['minute'];
					$second = $_POST['second'];
						
					$timest = mktime($hour, $minute, $second, $month, $day, $year);
						
					$outTimestamp=date("Y-m-d H:i:s", $timest);
					
					
					$tempString=sprintf("%s='%s', ", $input[$cnt]['name'], $outTimestamp);		//privremeni string koji dodeljuje vrednosti
				} else {
					if($input[$cnt]['name'] == 'password'){
						$values[$cnt] = md5($values[$cnt]);
					}				
					$tempString=sprintf("%s='%s', ", $input[$cnt]['name'], $values[$cnt]);		//privremeni string koji dodeljuje vrednosti
				}
				
				$insertString=$insertString.$tempString;		//insert string koji nadovezuje privremeni string na pocetni string
				
			}
			
			$insertString = rtrim($insertString, ", ");
			
			$insertQuery = mysql_query($insertString);
			
			echo $insertString;
			
			if(!$insertQuery){
				die('Insert unsuccessful');
			} else {
				echo 'Insert successful<br>';
			}
			
		break;
			
		case 'edit':
			
			$updateString = sprintf("update %s set ", $tableName);	//niz promenljivih koji formira konacni string za update tabele
			
			for($cnt = 0; $cnt<$num; $cnt++){		//petlja koja pravi niz [ime polja] = [vrednost]
				
				$type = $input[$cnt]['type'];
				$name = $input[$cnt]['name'];
				
				switch ($type){
					case 'datetime':
						$year = $_POST['year'];
						$month = $_POST['month'];
						$day = $_POST['day'];
						$hour = $_POST['hour'];
						$minute = $_POST['minute'];
						$second = $_POST['second'];
						
						$timest = mktime($hour, $minute, $second, $month, $day, $year);
						
						$outTimestamp=date("Y-m-d H:i:s", $timest);
						
						$updateString.=sprintf("%s='%s',", $name, $outTimestamp);
						
					break;
					
					case 'hidden':		//ako je tip hidden onda...
						;				//...onda nista se ne desava sa update stringom
					break;
					
					default:
						if($name == 'password'){
							$values[$cnt] = md5($values[$cnt]);
						}
						$updateString .= sprintf("%s='%s', ", $name, $values[$cnt]);		//...
				}		//kraj switch kontrole
			}		//kraj for petlje
			
			$updateString = rtrim($updateString, ", ");		//odsecanje zareza viska
			
			$whereString = sprintf(" where id=%s", $id);	//nastavak formiranja stringa
			
			$updateString = $updateString . $whereString;	//...
			
			//echo $updateString;
			
			$updateQuery = mysql_query($updateString);		//mysql upit  sa generisanim stringom
			
			if(!$updateQuery){		//provera jel sve u redu
				die ('Edit unsuccessful');
			} else {
				echo 'Edit successful<br>';
			}
			
		break;
		
		case 'delete':		//ako je akcija brisanje, izvrsava se dole....
			
			$deleteString = sprintf("delete from %s where id = %s", $tableName, $id);		//formiranje stringa za brisanje 
			
			$deleteQuery = mysql_query($deleteString);		//query za brisanje
			
			if(!$deleteQuery){							//ako je query neuspesan
				die('Delete unsuccessful<br>\n');		//poruka o neuspesnom brisanju
			}else{										//u suprotnom
				printf ("Delete successful<br>\n");		//ispis poruke da je brisanje uspesno
			}
			
		break;		// kraj kontrole ako je u pitanju brisanje
		
	}	//kraj switch kontrole za akciju
	
	disconnect();
	
?>
	