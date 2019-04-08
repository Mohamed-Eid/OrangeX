<?php
require_once 'includes/core/config.php';
require_once 'includes/core/DB.php';


$db = new DB();


echo $db->Select_Count('migrations');



function Insert($table,$data)
{

    // setup some variables for fields and values
  $fields  = '';
    $values = '';
    // populate them
    foreach ($data as $f => $v)
    {
        $fields  .= "`$f`,";
        $values .= ( is_numeric( $v ) && ( intval( $v ) == $v ) ) ? $v."," : "'$v',";
    }

    // remove our trailing ,
  $fields = substr($fields, 0, -1);
  // remove our trailing ,
  $values = substr($values, 0, -1);

  echo "fields : ".$fields;
  echo "values : ".$values;
    // $querystring = "INSERT INTO `{$table}` ({$fields}) VALUES({$values})";
    // //echo $querystring;
    // //Check If Row Inserted
    // if($this->Execute($querystring))
    //     return TRUE;
    //
    // return FALSE;
}

Insert("users",['user'=>'ahmed','id'=>2]);
?>
