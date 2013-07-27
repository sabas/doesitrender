<?php
//load mapnik xml stylesheet
//as file because simplexml validates the file (didn't succeed in loading it)
$xml=file("osm.xml");

//creating db and table
$file_db = new PDO('sqlite:dump.sqlite3');
    $file_db->setAttribute(PDO::ATTR_ERRMODE, 
                            PDO::ERRMODE_EXCEPTION);
     $file_db->exec("CREATE TABLE IF NOT EXISTS kv (
                    style TEXT, 
                    k TEXT, 
                    v TEXT,
                    PRIMARY KEY (k,v))");
                            
foreach ($xml as $line)
{
	//I need Filter tag only
	$p="$<Filter>(.*)</Filter>$";
	preg_match($p,$line,$mat);
	if(isset($mat[1]))
	{
		$sub=$mat[1];
		$pat="/\[(\w+)\]\s*=\s*'(\w+)'/i";
		$arr=array();
		preg_match_all($pat,$sub,$arr);
		//list of k,v in the two arrays, if size is equal, save each couple
		if (count($arr[1])==count($arr[2]))
		{
			$l=count($arr[1]);
			for ($i=0;$i<$l;$i++)
			{
				$file_db->exec("INSERT OR IGNORE INTO kv (style, k, v) 
					VALUES ('"."mapnik"."', '".$arr[1][$i]."', '".$arr[2][$i]."')"); 
			}
		}
	}
}
?>
