<?php
// core/View.php
class View
{
    public static function render($view, $data = [])
    {
        extract($data);
        include "views/layouts/main.php";
    }
}
