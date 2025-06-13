<?php

class M_Rolusuario extends \DB\SQL\Mapper
{
  public function __construct()
  {
    parent::__construct(\Base::instance()->get('DB'), 'seg_tblrolusuario');
  }
  public function ObtieneRol(string $idusuario, string $Clave): bool
  {
    $this->load(["idrolusuario = $idusuario and estadoregistro=1"]);
    if ($this->loaded() > 0)
      return true;
    else
      return false;
  }
}
