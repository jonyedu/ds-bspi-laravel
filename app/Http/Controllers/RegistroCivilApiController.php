<?php

namespace App\Http\Controllers;
use Exception;
use Illuminate\Http\Request;
use App\Helpers\RegistroCivilApi\RegistroCivil;


class RegistroCivilApiController extends Controller
{
    public function getPerson(Request $request)
    {
        $id='0922571856';
        return RegistroCivil::getFromRegistroCivil($id);
    }
    

}
