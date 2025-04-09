<?php    
$name = "e_learning";
// pH7_Core.sql
// instagram
// martdevelopers_iLibrary
// rosariosis
// e_learning.sql
// some sql files to test

$lines = file("$name.sql");
$str = "";

$blocked_stm = [
"ALTER TABLE", "ADD PRIMARY KEY", "insert into", "START TRANSACTION", "--", "SET ", "MODIFY "
];

$datatypes = [
"varchar", "integer", "text", "datetim", "longtex", "timesta", "tinyint", "smallin", "decimal",
"medium"
];


$table = [];
foreach($lines as $line) {     
	$line = strtolower($line);
	
	foreach($blocked_stm as $block) {     
		if (str_contains($line, strtolower($block))) {
			$line = "";
		}
	}
	
	if($line) {
		$str .= $line;
	}
	
	$str = str_replace("`", "", $str);

	if (str_contains($line, ");")) {
		$pattern = '/(create table)+ (if not exists)?/'; 
		$replacement = '';		
		$str = preg_replace($pattern, $replacement, $str);
		
		$table = explode(" ", $str); //buggy tablenames don't always appear on position 1
		
		echo "<h1>table ".$table[1]."</h1>"; 
		
		//echo "<pre>";
		//print_r($table); // show array data
		//echo "</pre>";
		$str = "";
		
		foreach($table as $key=>$types){
			$sub = substr($types, 0,7);
			if (in_array($sub, $datatypes)) {
				echo "<b> column ".$table[$key-1]."</b>". " is of type ". $sub."<br>";
			}
		}
	}
}
?>
