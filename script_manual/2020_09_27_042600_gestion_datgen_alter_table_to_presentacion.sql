ALTER TABLE `siemprea_bspi_gestion_hospitalaria`.`prescripciones` 
ADD COLUMN `PRESCRIPCION_SIMBOLO` VARCHAR(10) NOT NULL AFTER `PRESCRIPCION_CANTIDAD`,
CHANGE COLUMN `PRESCRIPCION_UNIDAD` `PRESCRIPCION_CANTIDAD` DECIMAL(8,2) NOT NULL ;
