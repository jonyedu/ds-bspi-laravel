<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GestionHospitalariaFormularioMsp003 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql_gestion_hospitalaria')->hasTable('formulario_msp_003')) {
            Schema::connection('mysql_gestion_hospitalaria')->create('formulario_msp_003', function (Blueprint $table) {
                $table->BigIncrements('FORM_MSP_003_COD');
                $table->unsignedBigInteger('CITA_COD');
                $table->longText('FORM_MSP_003_MOTIVO_A')->nullable();
                $table->longText('FORM_MSP_003_MOTIVO_B')->nullable();
                $table->longText('FORM_MSP_003_MOTIVO_C')->nullable();
                $table->longText('FORM_MSP_003_MOTIVO_D')->nullable();
            
                $table->longText('FORM_MSP_003_ANTECEDENTE_VACUNA')->nullable();
                $table->longText('FORM_MSP_003_ANTECEDENTE_PERINATAL')->nullable();
                $table->longText('FORM_MSP_003_ANTECEDENTE_INFANCIA')->nullable();
                $table->longText('FORM_MSP_003_ANTECEDENTE_ADOLECENCIA')->nullable();
                $table->longText('FORM_MSP_003_ANTECEDENTE_ALERGICA')->nullable();
                $table->longText('FORM_MSP_003_ANTECEDENTE_CARDIACA')->nullable();
                $table->longText('FORM_MSP_003_ANTECEDENTE_RESPIRATORIA')->nullable();
                $table->longText('FORM_MSP_003_ANTECEDENTE_DIGESTIVA')->nullable();
                $table->longText('FORM_MSP_003_ANTECEDENTE_NEUROLOGICA')->nullable();
                $table->longText('FORM_MSP_003_ANTECEDENTE_METABOLICA')->nullable();
                $table->longText('FORM_MSP_003_ANTECEDENTE_HEMO_LINF')->nullable();
                $table->longText('FORM_MSP_003_ANTECEDENTE_URINARIA')->nullable();
                $table->longText('FORM_MSP_003_ANTECEDENTE_TRAUMATICA')->nullable();
                $table->longText('FORM_MSP_003_ANTECEDENTE_QUIRURGICA')->nullable();
                $table->longText('FORM_MSP_003_ANTECEDENTE_TENDENCIA_SEXUAL')->nullable();
                $table->longText('FORM_MSP_003_ANTECEDENTE_RIESGO_SOCIAL')->nullable();
                $table->longText('FORM_MSP_003_ANTECEDENTE_RIESGO_LABORAL')->nullable();
                $table->longText('FORM_MSP_003_ANTECEDENTE_RIESGO_FAMILIAR')->nullable();
                $table->longText('FORM_MSP_003_ANTECEDENTE_ACTIVIDAD_FISICA')->nullable();
                $table->longText('FORM_MSP_003_ANTECEDENTE_DIETA_Y_HABITOS')->nullable();
                $table->longText('FORM_MSP_003_ANTECEDENTE_RELIGION_Y_CULTURA')->nullable();
                $table->longText('FORM_MSP_003_ANTECEDENTE_OTRO')->nullable();

                $table->String('FORM_MSP_003_ANTECEDENTE_MENARQUIA_EDAD')->nullable();
                $table->String('FORM_MSP_003_ANTECEDENTE_MENOPAUSIA_EDAD')->nullable();
                $table->String('FORM_MSP_003_ANTECEDENTE_CICLOS')->nullable();
                $table->boolean('FORM_MSP_003_ANTECEDENTE_VIDA_SEXUAL_ACTIVA')->nullable();
                $table->integer('FORM_MSP_003_ANTECEDENTE_HIJOS_VIVOS')->nullable();
                $table->Date('FORM_MSP_003_ANTECEDENTE_FUM')->nullable();
                $table->Date('FORM_MSP_003_ANTECEDENTE_FUP')->nullable();
                $table->Date('FORM_MSP_003_ANTECEDENTE_FUC')->nullable();
                $table->boolean('FORM_MSP_003_ANTECEDENTE_BIOPSIA')->nullable();
                $table->String('FORM_MSP_003_ANTECEDENTE_METODO_DPF')->nullable();
                $table->boolean('FORM_MSP_003_ANTECEDENTE_TERAPIA_HORMONAL')->nullable();
                $table->boolean('FORM_MSP_003_ANTECEDENTE_COLPOSCOPIA')->nullable();
                $table->boolean('FORM_MSP_003_ANTECEDENTE_MAMOGRAFIA')->nullable();
                $table->longText('FORM_MSP_003_ANTECEDENTE_ENFERMEDAD_PROBLEMA_ACTUAL')->nullable();
                

                $table->integer('FORM_MSP_003_REVISION_ORGANOS_SIST_ORG_SENTIDOS')->default(0);
                $table->integer('FORM_MSP_003_REVISION_ORGANOS_SIST_ORG_SENTIDOS_DESC')->nullable();

                $table->integer('FORM_MSP_003_REVISION_ORGANOS_SIST_RESPIRATORIO')->default(0);
                $table->integer('FORM_MSP_003_REVISION_ORGANOS_SIST_ORGANOS_RESPIRATORIO_DESC')->nullable();

                $table->integer('FORM_MSP_003_REVISION_ORGANOS_SIST_CARDIOVASCULAR')->default(0);
                $table->integer('FORM_MSP_003_REVISION_ORGANOS_SIST_CARDIOVASCULAR_DESC')->nullable();

                $table->integer('FORM_MSP_003_REVISION_ORGANOS_SIST_DIGESTIVO')->default(0);
                $table->integer('FORM_MSP_003_REVISION_ORGANOS_SISTEMAS_DIGESTIVO_DESC')->nullable();

                $table->integer('FORM_MSP_003_REVISION_ORGANOS_SIST_GENITAL')->default(0);
                $table->integer('FORM_MSP_003_REVISION_ORGANOS_SIST_GENITAL_DESCRIPCION')->nullable();

                $table->integer('FORM_MSP_003_REVISION_ORGANOS_SIST_URINARIO')->default(0);
                $table->integer('FORM_MSP_003_REVISION_ORGANOS_SIST_URINARIO_DESC')->nullable();

                $table->integer('FORM_MSP_003_REVISION_ORGANOS_SIST_MUSCULO_ESQUELETICO')->default(0);
                $table->integer('FORM_MSP_003_REVISION_ORGANOS_SIST_MUSCULO_ESQUELETICO_DESC')->nullable();

                $table->integer('FORM_MSP_003_REVISION_ORGANOS_SIST_ENDOCRINO')->default(0);
                $table->integer('FORM_MSP_003_REVISION_ORGANOS_SIST_ENDOCRINO_DESC')->nullable();

                $table->integer('FORM_MSP_003_REVISION_ORGANOS_SIST_HEMO_LINFATICO')->default(0);
                $table->integer('FORM_MSP_003_REVISION_ORGANOS_SIST_HEMO_LINFATICO_DESC')->nullable();

                $table->integer('FORM_MSP_003_REVISION_ORGANOS_SIST_NERVIOSO')->default(0);
                $table->integer('FORM_MSP_003_REVISION_ORGANOS_SIST_NERVIOSO_DESC')->nullable();
                
                $table->integer('FORM_MSP_003_SIGNOS_VITALES_MED_FRECUENCIA_CARDIACA')->nullable();
                $table->integer('FORM_MSP_003_SIGNOS_VITALES_MED_FRECUENCIA_RESPIRA')->nullable();
                $table->integer('FORM_MSP_003_SIGNOS_VITALES_MED_TEMPERATURA_BUCAL')->nullable();
                $table->integer('FORM_MSP_003_SIGNOS_VITALES_MED_TEMPERATURA_AXILAR')->nullable();
                $table->integer('FORM_MSP_003_SIGNOS_VITALES_MED_INDICE_MASA_CORPORAL')->nullable();
                $table->integer('FORM_MSP_003_SIGNOS_VITALES_MED_PERIMETRO_CEFFALIC')->nullable();

                $table->integer('FORM_MSP_003_EXAMEN_FISICO_PIEL_FANERAS')->nullable();
                $table->integer('FORM_MSP_003_EXAMEN_FISICO_PIEL_FANERAS_DESC')->nullable();

                $table->integer('FORM_MSP_003_EXAMEN_FISICO_OJOS')->default(0);
                $table->integer('FORM_MSP_003_EXAMEN_FISICO_OJOS_DESC')->nullable();

                $table->integer('FORM_MSP_003_EXAMEN_FISICO_OIDOS')->default(0);
                $table->integer('FORM_MSP_003_EXAMEN_FISICO_OIDOS_DESC')->nullable();

                $table->integer('FORM_MSP_003_EXAMEN_FISICO_NARIZ')->default(0);
                $table->integer('FORM_MSP_003_EXAMEN_FISICO_NARIZ_DESC')->nullable();

                $table->integer('FORM_MSP_003_EXAMEN_FISICO_BOCA')->default(0);
                $table->integer('FORM_MSP_003_EXAMEN_FISICO_BOCA_DESC')->nullable();

                $table->integer('FORM_MSP_003_EXAMEN_FISICO_ORO_FARINGE')->default(0);
                $table->integer('FORM_MSP_003_EXAMEN_FISICO_ORO_FARINGE_DESC')->nullable();

                $table->integer('FORM_MSP_003_EXAMEN_FISICO_AXILAS_MAMAS')->default(0);
                $table->integer('FORM_MSP_003_EXAMEN_FISICO_AXILAS_MAMAS_DESC')->nullable();

                $table->integer('FORM_MSP_003_EXAMEN_FISICO_COLUMNA_VERTEBRAL')->default(0);
                $table->integer('FORM_MSP_003_EXAMEN_FISICO_COLUMNA_VERTEBRAL_DESC')->nullable();

                $table->integer('FORM_MSP_003_EXAMEN_FISICO_INGLE_PERINE')->default(0);
                $table->integer('FORM_MSP_003_EXAMEN_FISICO_INGLE_PERINE_DESC')->nullable();

                $table->integer('FORM_MSP_003_EXAMEN_FISICO_MIEMBROS_SUPERIORES')->default(0);
                $table->integer('FORM_MSP_003_EXAMEN_FISICO_MIEMBROS_SUPERIORES_DESC')->nullable();

                $table->integer('FORM_MSP_003_EXAMEN_FISICO_MIEMBROS_INFERIORES')->default(0);
                $table->integer('FORM_MSP_003_EXAMEN_FISICO_MIEMBROS_INFERIORES_DESC')->nullable();

                $table->integer('FORM_MSP_003_EXAMEN_FISICO_ORGANOS_SENTIDOS')->default(0);
                $table->integer('FORM_MSP_003_EXAMEN_FISICO_ORGANOS_SENTIDOS_DESC')->nullable();

                $table->integer('FORM_MSP_003_EXAMEN_FISICO_RESPIRATORIO')->default(0);
                $table->integer('FORM_MSP_003_EXAMEN_FISICO_RESPIRATORIO_DESC')->nullable();

                $table->integer('FORM_MSP_003_EXAMEN_FISICO_CARDIOVASCULAR')->default(0);
                $table->integer('FORM_MSP_003_EXAMEN_FISICO_CARDIOVASCULAR_DESC')->nullable();

                $table->integer('FORM_MSP_003_EXAMEN_FISICO_DIGESTIVO')->default(0);
                $table->integer('FORM_MSP_003_EXAMEN_FISICO_DIGESTIVO_DESC')->nullable();

                $table->integer('FORM_MSP_003_EXAMEN_FISICO_GENITAL')->default(0);
                $table->integer('FORM_MSP_003_EXAMEN_FISICO_GENITAL_DESC')->nullable();

                $table->integer('FORM_MSP_003_EXAMEN_FISICO_URINARIO')->default(0);
                $table->integer('FORM_MSP_003_EXAMEN_FISICO_URINARIO_DESC')->nullable();

                $table->integer('FORM_MSP_003_EXAMEN_FISICO_MUSCULO_ESQUELETICO')->default(0);
                $table->integer('FORM_MSP_003_EXAMEN_FISICO_MUSCULO_ESQUELETICO_DESC')->nullable();

                $table->integer('FORM_MSP_003_EXAMEN_FISICO_ENDOCRINO')->default(0);
                $table->integer('FORM_MSP_003_EXAMEN_FISICO_ENDOCRINO_DESC')->nullable();

                $table->integer('FORM_MSP_003_EXAMEN_FISICO_HEMOLINFATICO')->default(0);
                $table->integer('FORM_MSP_003_EXAMEN_FISICO_HEMOLINFATICO_DESC')->nullable();

                $table->integer('FORM_MSP_003_EXAMEN_FISICO_NEUROLOGICO')->default(0);
                $table->integer('FORM_MSP_003_EXAMEN_FISICO_NEUROLOGICO_DESC')->nullable();
                $table->time('FORM_MSP_003_HORA_FIN')->nullable();
                $table->time('FORM_MSP_003_HORA_INICIO')->nullable();
                $table->String('FORM_MSP_003_HORA_MEDICO')->nullable();
                $table->String('FORM_MSP_003_HORA_FIRMA')->nullable();

                $table->timestamps();
                $table->foreign('CITA_COD')->references('CITA_COD')->on('citas');
                $table->index('CITA_COD');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::connection('mysql_gestion_hospitalaria')->dropIfExists('formulario_msp_003');
    }
}
