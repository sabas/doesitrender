<?php
//load carto stylesheet and select all filters

$xml=simplexml_load_file("xml/carto.xml");
$path=$xml->xpath("/Map/Style/Rule/Filter");    
$archive=array();

foreach ($path as $line)
{
	$r=explode(" and ",$line); //split and rules: other logical operators are possible
	$pat="/\[(\w+)\]\s*([=<>]{1,2})\s*'(\w+)'/i"; //k,v with different operators (=,<=,>=)

	foreach ($r as $rul)
	{
		$arr=array();
		preg_match_all($pat,$rul,$arr);
		if(count($arr[1])==0)continue;
		$k=$arr[1][0];
		$op=$arr[2][0];
		$v=$arr[3][0];
		if (isset($archive[$k])&&in_array($v,$archive[$k])) continue;
		if ($op=='=') $archive[$k][]=$v;
	}
}

if(isset($archive['feature']))
{
	foreach($archive['feature'] as $feature)
	{
		list($k,$v)=explode('_',$feature,2);
		if (isset($archive[$k])&&in_array($v,$archive[$k])) continue;
		$archive[$k][]=$v;
	}
	unset($archive['feature']);
}

header("Content-Type: text/javascript; charset=utf-8");
header('Content-Disposition: attachment; filename="mapnikcarto.js"');
echo "var objCarto=".json_encode($archive);
?>
