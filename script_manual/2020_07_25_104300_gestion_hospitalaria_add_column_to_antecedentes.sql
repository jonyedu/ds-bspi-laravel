ALTER TABLE `siemprea_bspi_gestion_hospitalaria`.`antecedentes` 
ADD COLUMN `CITA_COD` BIGINT UNSIGNED NOT NULL AFTER `USER_ID`,
ADD INDEX `antecedentes_cita_cod_foreing_idx` (`CITA_COD` ASC) VISIBLE;
;
ALTER TABLE `siemprea_bspi_gestion_hospitalaria`.`antecedentes` 
ADD CONSTRAINT `antecedentes_cita_cod_foreing`
  FOREIGN KEY (`CITA_COD`)
  REFERENCES `siemprea_bspi_gestion_hospitalaria`.`citas` (`CITA_COD`)
  ON DELETE RESTRICT
  ON UPDATE RESTRICT;
