<?php

namespace App\Entity;

class MenuRegime
{
    private int $menu_id;
    private int $regime_id;

    public function __construct() {}

    public function getMenuId(): int
    {
        return $this->menu_id;
    }
    public function getRegimeId(): int
    {
        return $this->regime_id;
    }

    public function setMenuId(int $menue_id): void
    {
        $this->menu_id = $menue_id;
    }
    public function setRegimeId(int $regime_id): void
    {
        $this->regime_id = $regime_id;
    }
}
