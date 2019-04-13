<?php
require_once 'includes/core/config.php';
require_once 'includes/core/DB.php';


$db = new DB();
$table = 'departments';


$data = $db->GetAll($table);
for($i=0;$i<count($data);$i++)
{
  foreach ($data[$i] as $key => $value) {
    echo $key." : ".$value."<br>";
  }
}


echo"<pre>";
print_r($data);
?>
