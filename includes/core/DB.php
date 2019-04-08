<?php

/**
 * Database commands
 * @author : Mohamed Eid
 */

 // TODO: ADD basic functions of database like create table etc.

class DB
{

  private $connection;
  private $last; //last query;

  public function __construct()
  {
    $this->dbconnect();
    $this->Execute('SET NAMES utf8');
  }

  public function dbconnect()
  {
      $this->connection = new mysqli(HOSTNAME,USERNAME,PASSWORD,DBNAME);
      if($this->connection)
        return TRUE;
      return FALSE;
  }

  public function Execute($query)
  {
    $result = $this->connection->query($query);
    if($result)
    {
      $this->last = $result;
      return TRUE;
    }
    return FALSE;
  }

  public function Execute_Multi($query)
  {
    if($this->connection->multi_query($query))
    {
      $this->last = $this->connection->multi_query($query);
      return TRUE;
    }
    return FALSE;
  }

  public function GetRows()
  {
      $result = array();
      $rows   = $this->AffectedRows();
      for($i = 0;$i<$rows;$i++)
      {
          $result[] = $this->last->fetch_assoc();
      }
      if(count($result) > 0)
          return $result;

      $this->last->free();

      return NULL;
  }

  public function GetRow()
 {
     $result = array();
     $rows   = $this->AffectedRows();
     for($i = 0;$i<$rows;$i++)
     {
         $result[] = $this->last->fetch_assoc();
     }
     if(count($result) > 0)
         return $result[0];

     $this->last->free();

     return NULL;
 }

  public function AffectedRows()
  {
    return mysqli_affected_rows($this->connection);
    //return $this->last->num_rows;
  }



  /**
   * Count Results in a Table
   * @param type $table
   */
  public function Select_Count($table)
  {
      $this->Execute("SELECT COUNT(*) FROM `$table`");
      $count = $this->GetRow();
      return $count['COUNT(*)'];
  }

/**
 * Inserting record into database
 * @param string $table
 * @param array $data
 * @return Boolean
 */
public function Insert($table,$data)
{
  // variables for fields and VALUES
  $fields = '';
  $values = '';

  //populate the last 2 variables
  foreach ($data as $key => $value) {
    $fields .= "`$key`,";
    $values .= (is_numeric($value) && (intval($value) == $value) ) ? $value."," : "'$value',";
  }
  //remove the last "," in the end of variables
  $fields = substr($fields, 0,-1);
  $values = substr($values, 0, -1);

  $query = "INSERT INTO `{$table}` ({$fields}) VALUES({$values})";

  //echo $query;

  if($this->Execute($query))
    return TRUE;

  return FALSE;
}

/**
 * @param string $from => table
 * @param string $where => condition
 * @return boolean
 */
public function Delete($from,$where)
{
  $query = sprintf('DELETE FROM `%s` %s',$from,$where);

  if($this->Execute($query) && ($this->AffectedRows()>0))
    return TRUE;

  return FALSE;
}


/**
 *
 * @param string $table
 * @param string $array
 * @return Boolean
 */
public function Update($table,$data,$where='')
{
    //set $key = $value :)

    $query  = '';
    foreach ($data as $f => $v) {
       (is_numeric($v) && intval($v) == $v || is_float($v))? $v."," : "'$v' ,";
        $query  .= "`$f` = '{$v}' ,";
    }

    //Remove trailing ,
    $query = substr($query, 0,-1);

    $query = "UPDATE `{$table}` SET {$query} {$where}";
    //echo $query;
    if($this->Execute($query))
        return TRUE;

    return FALSE;
}


public function Last()
{
    return $this->connection->insert_id;
}

 /**
 * Deconstructor :)
 */
public function __destruct() {
    $this->connection->close();
}

}



 ?>
