<?php
//from sql tables

$x=simplexml_load_file('../xnl/carto.xml');

$filter=$x->xpath("//Layer/Datasource/Parameter[@name='table']");

foreach($filter as $f){
echo (string)$f."<br/>";
}
?>
