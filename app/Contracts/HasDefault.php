<?php
namespace App\Contracts;


interface HasDefault
{
    public static function getDefault(): HasDefault;
}
