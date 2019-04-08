<?php

/**
 * Database commands
 * @author : Mohamed Eid
 */
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
    if($this->connection->query($query))
    {
      $this->last = $this->connection->query($query);
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
    return $this->last->num_rows;
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










}




 ?>
