
<?php

$table = $_GET['tablename'];		//ime tabele iz url-a

connect();							// konekcija na bazu

$selectString = sprintf("select * from %s", $table);	//selektuje sve iz gore odabrane tabele

$query = mysql_query($selectString);

$selection_num = mysql_num_rows($query);

$function = $$table;

$num = count($function);

//echo $selectString;

printf("<table class=\"tableEdit\">\n");

while($result = mysql_fetch_assoc($query)){
	printf("<tr height=\"16\">\n");
	for($fieldNum=1; $fieldNum <$num+1; $fieldNum++){		//$num+1 je NAJVEROVATNIJE (proveriti) zbog postojanja id key-a
		
		$fieldName = mysql_field_name($query, $fieldNum);		//ime polja rednog broja $fieldNum
		
		$type = $function[$fieldNum-1]['type'];			//tip vrednosti u bazi (text, textarea, option,..)
		
		switch($type){
			
			case 'option':
				
				$tableSelection = $function[$fieldNum-1]['name'];
				$idSelection = $result[$fieldName];
				$nameSelection = $function[$fieldNum-1]['optdisplay'];
				
				$selectionQueryString = sprintf("select %s from %s where id=%s", $nameSelection, $tableSelection, $idSelection);
				
				$selectionQuery = mysql_query($selectionQueryString);
				
				$selection = mysql_fetch_array($selectionQuery);
				
				if($global_type == 'user'){
					printf("<td class=\"outputfield\"><b><a href=\"tabledisplay.php?tablename=%s\">%s</a></b></td>\n", $tableSelection, $selection[0]);
				} else {
					printf("<td class=\"outputfield\"><b>%s=%s</b></td>\n", $tableSelection, $selection[0]);
				}
				
			break;	
			
			case 'image':	// ako je tip slika (type==image)
				
				printf("<td class=\"outputfield\"><img src=\"getimage.php?id=1&image=image%s\"></td>\n", $fieldNum);
				
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
