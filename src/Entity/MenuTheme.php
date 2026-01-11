<?php

namespace App\Entity;

class MenuTheme
{
    private int $menu_id;
    private int $theme_id;

    public function __construct() {}

    public function getMenuId(): int
    {
        return $this->menu_id;
    }
    public function getThemeId(): int
    {
        return $this->theme_id;
    }

    public function setMenuId(int $menue_id): void
    {
        $this->menu_id = $menue_id;
    }
    public function setThemeId(int $theme_id): void
    {
        $this->theme_id = $theme_id;
    }
}
