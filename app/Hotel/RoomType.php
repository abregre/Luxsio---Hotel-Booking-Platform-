<?php

namespace Hotel;

use Hotel\BaseService;
use DateTime;

class RoomType extends BaseService
{
  //Multiple
  public function getRoomTypes()
  {
    return $this->fetchAll('SELECT * FROM room_type');
  }

}