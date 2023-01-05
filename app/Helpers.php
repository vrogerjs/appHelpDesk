<?php

use Illuminate\Support\Facades\Auth;

function accesoUser($array = [])
{
    foreach ($array as $key) {
        if ($key == Auth::user()->tipouser_id) {
            return true;
        }
    }
    return false;
}