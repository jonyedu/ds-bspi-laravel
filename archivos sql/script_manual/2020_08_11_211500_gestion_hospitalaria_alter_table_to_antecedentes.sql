ALTER TABLE `siemprea_bspi_gestion_hospitalaria`.`antecedentes` 
ADD CONSTRAINT `antecedentes_cita_cod_foreign`
  FOREIGN KEY (`CITA_COD`)
  REFERENCES `siemprea_bspi_gestion_hospitalaria`.`citas` (`CITA_COD`)
  ON DELETE RESTRICT
  ON UPDATE RESTRICT;
