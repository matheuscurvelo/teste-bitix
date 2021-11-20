<?php 

namespace App\Controllers;

use App\Models\Plano;

class PlanoController
{

    public static function get(int $codigo = null)
    {
        if (isset($codigo)) {
            return Plano::get($codigo);
        } else {
            return Plano::all();
        }
    }

}
