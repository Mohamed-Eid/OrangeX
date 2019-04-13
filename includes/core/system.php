<?php
/**
 * Using Registry Design Pattern
 */

class System
{
  private static $objects = array();


  public static function Store($key,$val)
  {
    self::$objects[$key] = $val;
  }

  public static function Get($key)
  {
    return self::$objects[$key];
  }

}

?>
