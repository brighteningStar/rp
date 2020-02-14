<?php
/**
 * Created by PhpStorm.
 * User: fakhar
 * Date: 13/12/2016
 * Time: 3:27 PM
 */

namespace App\Services;

use App\Models\Color;

class ColorService extends ServiceAbstract
{

    public function model()
    {
        return Color::class;
    }


}