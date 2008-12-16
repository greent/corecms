<?php

require_once('functions.php');

connect();

$table_list_s = sprintf("select distinct group_name from table_names");

$table_list_q = mysql_query($table_list_s);

$num_group = 0;

while($table_list_res=mysql_fetch_array($table_list_q)){
		$group_name[$num_group] = $table_list_res[0];
		$num_group++;

	}
	
	

	for($group_id=0; $group_id<$num_group; $group_id++){
	
		$group_sel_s = sprintf("select * from table_names where group_name = '%s' order by display_order", $group_name[$group_id]);
			
			printf("<div class=\"tableMenu\">\n");
			echo "<table class=\"table_layout\" border=0 align=center>\n";
			echo "<tr><td>". $group_name[$group_id]. "</td></tr>\n";
			
			$group_sel_q = mysql_query($group_sel_s);
			
			while($group_sel_res = mysql_fetch_assoc($group_sel_q)){
				printf("<tr><td><a href=\"tabledisplay.php?tablename=%s\">%s</a></td></tr>\n", $group_sel_res['table_name'], $group_sel_res['table_display']);
			}
			echo "</table>\n";
			printf("</div>\n");
		
	}
		

	
	
disconnect();


?>