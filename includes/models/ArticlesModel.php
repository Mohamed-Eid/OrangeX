<?php


class ArticlesModel
{
  private $table = 'articles';
  public function Get($extra='')
  {
    $articles = array();

    System::Get('db')->Execute("SELECT * FROM `$table` {$extra}");
    if(System::Get('db')->AffectedRows() > 0)
        $articles = System::Get('db')->GetRows();

    return $articles;
  }

  public function GetById($id)
  {
      $id = (int)$id;
      return $this->Get("WHERE `id`=$id")[0];
  }

  public function GetByCat($cid)
  {
    $cid = (int)$cid;
    return $this->Get("WHERE `cid`=$cid");
  }



  public function Add($data)
  {
    if(System::Get('db')->Insert($this->$table,$data))
      return TRUE;
    return FALSE;
  }



  public function Update($id,$data)
  {
    $id = (int)$id;
    if(System::Get('db')->Update($this->$table,$data,"WHERE `id`=$id"))
      return TRUE;
    return FALSE;
  }

  public function Delete($id)
  {
    $id = (int)$id;
    if(System::Get('db')->Delete($this->$table,"WHERE `id`=$id"))
      return TRUE;
    return FALSE;
  }

}



 ?>
