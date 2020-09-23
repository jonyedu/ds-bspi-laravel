<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CedulaValidator implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $iniciales = substr($value, 0, 9);
        $final = substr($value, 9, 10);
        $arrayCoeficientes = array(2, 1, 2, 1, 2, 1, 2, 1, 2);
        $digitoVerificador = (int) $final;
        $digitosIniciales = str_split($iniciales);
        $total = 0;
        foreach ($digitosIniciales as $key => $value) {
            $valorPosicion = ((int) $value * $arrayCoeficientes[$key]);
            if ($valorPosicion >= 10) {
                $valorPosicion = str_split($valorPosicion);
                $valorPosicion = array_sum($valorPosicion);
                $valorPosicion = (int) $valorPosicion;
            }
            $total = $total + $valorPosicion;
        }
        $residuo =  $total % 10;
        if ($residuo == 0) {
            $resultado = 0;
        } else {
            $resultado = 10 - $residuo;
        }
        if ($resultado != $digitoVerificador) {
            return false;
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'La cedula Ingresada es invalida.';
    }
}
