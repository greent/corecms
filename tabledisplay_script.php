<?php

$table = $_GET['tablename'];		//ime tabele iz url-a

connect();							// konekcija na bazu

$selectAllFromTableString = sprintf("SELECT * FROM %s", $table);	//selektuje sve iz gore odabrane tabele

$queryAllFromTable = mysql_query($selectAllFromTableString);

$selection_num = mysql_num_rows($queryAllFromTable);

$function = $$table;

$num = count($function);

//echo $selectString;

printf("<table class=\"tableEdit\">\n");

while($result = mysql_fetch_assoc($queryAllFromTable)){
	printf("<tr height=\"16\">\n");
	for($fieldNum=1; $fieldNum <$num+1; $fieldNum++){		//$num+1 je NAJVEROVATNIJE (proveriti) zbog postojanja id key-a
		
		$fieldName = mysql_field_name($queryAllFromTable, $fieldNum);		//ime polja rednog broja $fieldNum
		
		$type = $function[$fieldNum-1]['type'];			//tip vrednosti u bazi (text, textarea, option,..)
		
		switch($type){
			
			case 'option':
				
				$tableSelection = $function[$fieldNum-1]['name'];
				$idSelection = $result[$fieldName];
				$nameSelection = $function[$fieldNum-1]['optdisplay'];
				
				$selectionQueryString = sprintf("SELECT %s FROM %s WHERE id=%s", $nameSelection, $tableSelection, $idSelection);
				
				$selectionQuery = mysql_query($selectionQueryString);
				
				$selection = mysql_fetch_array($selectionQuery);
				
				if($global_type == 'user'){
					printf("<td class=\"outputfield\"><b><a href=\"tabledisplay.php?tablename=%s\">%s</a></b></td>\n", $tableSelection, $selection[0]);
				} else {
					printf("<td class=\"outputfield\"><b>%s=%s</b></td>\n", $tableSelection, $selection[0]);
				}
				
			break;	
			
			case 'image':	// ako je tip slika (type==image)
				
				printf("<td class=\"outputfield\"><img src=\"getimage.php?id=%s&image=%s\"></td>\n", $result['id'], $fieldName);
				
			break;
			
			default:
				
				printf("<td class=\"outputfield\">%s</td>\n", $result[$fieldName]);
			
		}
	
	}
	printf("<td><a href=form.php?table=%s&id=%s&action=edit><img src=\"images/edit01-mid.png\"  border=0></a></td>\n", $table, $result['id']);
	printf("<td><a href=form.php?table=%s&id=%s&action=delete><img src=\"images/delete01-mid.png\"  border=0></a></td>\n</tr>\n", $table, $result['id']);


}
	printf("<tr><td align=\"center\" colspan=\"%s\">",$num);
	
	if($global_type == 'user'){	
		printf("<a href=\"form.php?table=%s&id=%s&action=add\"><img src=\"images/add01-mid.png\"  border=0></a>\n", $table, $global_user_id);
		printf("<a href=main.php><img src=\"images/back01-mid.png\"  border=0></a></td>\n</tr>\n", $table);
		printf("</table>\n");
	} else {
		if($table == $global_type){
			printf("</table>\n");
		} elseif ($table == 'employee_profile' ){
			if($selection_num>=1){
			
				printf("</table>\n");
			} else {
				printf("<a href=\"form.php?table=%s&id=%s&action=add\"><img src=\"images/add01-mid.png\"  border=0></a>\n", $table, $global_user_id);
				printf("<a href=main.php><img src=\"images/back01-mid.png\"  border=0></a></td>\n</tr>\n", $table);
				printf("</table>\n");
			}
		} else {
			printf("<a href=\"form.php?table=%s&id=%s&action=add\"><img src=\"images/add01-mid.png\"  border=0></a>\n", $table, $global_user_id);
			printf("<a href=main.php><img src=\"images/back01-mid.png\"  border=0></a></td>\n</tr>\n", $table);
			printf("</table>\n");
		} 
		
	}


echo "\n";
	
disconnect();

?>
