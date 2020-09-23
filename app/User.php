<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use App\Notifications\UserResetPassword;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'email', 'password', 'US_COD', 'US_FOTO', 'US_CEDULA_PDF',
        'US_MSP_PDF', 'US_CONADIS_PDF', 'US_ALIAS', 'US_APELL', 'US_APELL1', 'US_APELL2', 'US_NOM', 'US_NOM1',
        'US_NOM2', 'US_FNAC', 'US_LNACIMIENTO', 'PAIS_COD', 'PARR_COD', 'US_DIR', 'US_URB_O_RURAL', 'US_TELF', 'US_CONTACTO_EMERG', 'US_TELF_EMERG', 'US_CEL', 'US_EMAIL', 'US_EMAIL2', 'US_WEB', 'US_WSPAISAREA', 'US_WSCEL',
        'US_SEXO', 'US_ECIVIL', 'TSANGRE_COD', 'RELIGION_COD', 'US_PORC_DISCAPACIDAD', 'US_CONADIS_DISCAPACIDAD', 'US_MSP_DISCAPACIDAD', 'US_ESTATURA_METROS', 'US_PESO_KG', 'TALLACAMISA_COD', 'TALLAPANTALON_COD', 'TALLAZAPATO_COD', 'MOVILIZACION_COD',
        'CASA_COD', 'TIPOCASA_COD', 'US_REFERENCIA_DOMICILIO', 'US_LATITUD', 'US_LONGITUD', 'US_ZOOM', 'US_ACTIVO', 'US_TRABAJADOR_BSPI',
        'US_CLAVE', 'US_OBS', 'FECHA', 'HORA', 'TIPO', 'USUARIO', 'GCULTURAL_COD', 'US_ULTIMO_ANIO_APROBADO', 'US_BARRIO', 'USER_LOGIC_ESTADO, US_HISTORIACLINICA' , 'US_FECHA_CAMBIO_CLAVE'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    protected $appends = [
        'IMAGEN_PERFIL_URL', 'FULL_NAME', 'FULL_NAME_IDENTIFICATION', 'FULL_IDENTIFICATION'
    ];
    public function getIMAGENPERFILURLattribute()
    {
        return $this->US_FOTO;
    }
    public function getFULLNAMEattribute()
    {
        return $this->US_NOM . ' ' . $this->US_APELL;
    }
    public function getFULLNAMEIDENTIFICATIONattribute()
    {
        $identificaciones = $this->identificaciones;
        $identificacionNum = '';
        $identificacionTipo = '';
        foreach ($identificaciones as $key => $identificacion) {
            if ($identificacion->ID_COD == 'CEDULA') {
                $identificacionTipo = 'CED:';
                $identificacionNum = $identificacion->USID_CODIGO;
            }
        }
        if ($identificacionNum == '' || $identificacionNum == null) {
            foreach ($identificaciones as $key => $identificacion) {
                if ($identificacion->ID_COD == 'PASAPORTE') {
                    $identificacionTipo = 'PAS:';
                    $identificacionNum = $identificacion->USID_CODIGO;
                }
            }
        }
        if ($identificacionNum == '' || $identificacionNum == null) {
            foreach ($identificaciones as $key => $identificacion) {
                if ($identificacion->ID_COD == '17-DIGITOS') {
                    $identificacionTipo = '17D:';
                    $identificacionNum = $identificacion->USID_CODIGO;
                }
            }
        }

        return $this->US_NOM . ' ' . $this->US_APELL . ' ' . $identificacionTipo . $identificacionNum;
    }
    public function getFULLIDENTIFICATIONattribute()
    {
        $identificaciones = $this->identificaciones;
        $identificacionNum = '';
        $identificacionTipo = '';
        foreach ($identificaciones as $key => $identificacion) {
            if ($identificacion->ID_COD == 'CEDULA') {
                $identificacionTipo = 'CED:';
                $identificacionNum = $identificacion->USID_CODIGO;
            }
        }
        if ($identificacionNum == '' || $identificacionNum == null) {
            foreach ($identificaciones as $key => $identificacion) {
                if ($identificacion->ID_COD == 'PASAPORTE') {
                    $identificacionTipo = 'PAS:';
                    $identificacionNum = $identificacion->USID_CODIGO;
                }
            }
        }
        if ($identificacionNum == '' || $identificacionNum == null) {
            foreach ($identificaciones as $key => $identificacion) {
                if ($identificacion->ID_COD == '17-DIGITOS') {
                    $identificacionTipo = '17D:';
                    $identificacionNum = $identificacion->USID_CODIGO;
                }
            }
        }

        return $identificacionTipo . $identificacionNum;
    }
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new UserResetPassword($token));
    }

    public function gestiones()
    {
        return $this->hasMany('App\DatosGenerales\Generalidades\GestionesYUsuario', 'US_COD', 'US_COD')->where('gestiones_y_usuarios.GESTIONUSUARIO_LOGIC_ESTADO', 'A');
    }
    public function identificaciones()
    {
        return $this->hasMany('App\DatosGenerales\Generalidades\IdentificacionesYUsuario', 'US_COD', 'US_COD')->where('identificaciones_y_usuarios.IDENTIFICACIONESUSUARIO_LOGIC_ESTADO', 'A');
    }

    public function organismoYContacto()
    {
        return $this->hasOne('App\DatosGenerales\Generalidades\OrganismosYContactos', 'US_COD', 'US_COD')->where('organismos_y_contactos.ORG_Y_CON_LOGIC_ESTADO', 'A');
    }
    public function tipoSangre()
    {
        return $this->hasOne('App\DatosGenerales\Usuarios\TiposDeSangre', 'TSANGRE_COD', 'TSANGRE_COD')->where('tipos_de_sangre.TSANGRE_LOGIC_ESTADO', 'A');
    }
    public function religion()
    {
        return $this->hasOne('App\DatosGenerales\Usuarios\Religion', 'RELIGION_COD', 'RELIGION_COD')->where('religiones.RELIGION_LOGIC_ESTADO', 'A');
    }

    public function grupoCultural()
    {
        return $this->hasOne('App\DatosGenerales\Usuarios\GruposCulturales', 'GCULTURAL_COD', 'GCULTURAL_COD')->where('grupos_culturales.GCULTURAL_LOGIC_ESTADO', 'A');
    }
    public function pais()
    {
        return $this->hasOne('App\DatosGenerales\Generalidades\Paises', 'PAIS_COD', 'PAIS_COD')->where('paises.PAIS_LOGIC_ESTADO', 'A');
    }
    public function tipoCasa()
    {
        return $this->hasOne('App\DatosGenerales\Usuarios\TiposDeCasa', 'TIPOCASA_COD', 'TIPOCASA_COD')->where('tipos_de_casa.TIPOCASA_LOGIC_ESTADO', 'A');
    }
    public function movilizacion()
    {
        return $this->hasOne('App\DatosGenerales\Usuarios\Movilizacion', 'MOVILIZACION_COD', 'MOVILIZACION_COD')->where('movilizaciones.MOVILIZACION_LOGIC_ESTADO', 'A');
    }
    public function discapacidad()
    {
        return $this->hasOne('App\DatosGenerales\Usuarios\Discapacidad', 'DISCAPACIDAD_COD', 'DISCAPACIDAD_COD')->where('discapacidades.DISCAPACIDAD_LOGIC_ESTADO', 'A');
    }
    public function tallaCamisa()
    {
        return $this->hasOne('App\DatosGenerales\Usuarios\TallaCamisa', 'TALLACAMISA_NOM', 'TALLACAMISA_COD')->where('talla_camisa.TALLACAMISA_LOGIC_ESTADO', 'A');
    }
    public function tallaPantalon()
    {
        return $this->hasOne('App\DatosGenerales\Usuarios\TallaPantalon', 'TALLAPANTALON_NOM', 'TALLAPANTALON_COD')->where('talla_pantalon.TALLAPANTALON_LOGIC_ESTADO', 'A');
    }
    public function tallaZapato()
    {
        return $this->hasOne('App\DatosGenerales\Usuarios\TallaZapato', 'TALLAZAPATO_NOM', 'TALLAZAPATO_COD')->where('talla_zapato.TALLAZAPATO_LOGIC_ESTADO', 'A');
    }
    public function polizas()
    {
        return $this->hasMany('App\GestionHospitalaria\Pacientes\Poliza', 'USER_ID', 'id');
    }
    public function trabajadorPersonalSalud()
    {
        return $this->hasOne('App\GestionHospitalaria\PersonalMedico\TrabajadorPersonalSalud', 'USER_ID', 'id');
    }
}
