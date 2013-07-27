<?php
//load mapnik xml stylesheet
//as file because simplexml validates the file (didn't succeed in loading it)
$xml=file("osm.xml");

//creating db and table

$array=array();                       
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
				$k=$arr[1][$i];
				$v=$arr[2][$i];
				if (isset($array[$k])&&in_array($v,$array[$k])) continue;
				$array[$k][]=$v;
			}
		}
	}
}
header("Content-Type: text/javascript; charset=utf-8");
header('Content-Disposition: attachment; filename="mapnik.js"');
echo "var obj=".json_encode($array);
?>
