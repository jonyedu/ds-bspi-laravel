ALTER TABLE `siemprea_bspi_gestion_hospitalaria`.`antecedentes` 
ADD COLUMN `ANTECEDENTE_EVOLUCION` VARCHAR(255) NULL DEFAULT NULL AFTER `ANTECEDENTE_ENFERMEDAD_ACTUAL_PROBLEMA`;