ALTER TABLE `siemprea_bspi_gestion_hospitalaria`.`diagnosticos` 
ADD COLUMN `CITA_COD` BIGINT UNSIGNED NOT NULL AFTER `DIAGNOSTICO_COD`,
ADD COLUMN `CIE_COD` BIGINT UNSIGNED NOT NULL AFTER `CITA_COD`,
CHANGE COLUMN `DIAGNOSTICO_NOM` `DIAGNOSTICO_PLAN` VARCHAR(255) CHARACTER SET 'utf8mb4' COLLATE 'utf8mb4_unicode_ci' NULL DEFAULT NULL ,
CHANGE COLUMN `DIAGNOSTICO_OBS` `DIAGNOSTICO_SIGNOS_SINTOMAS` VARCHAR(255) CHARACTER SET 'utf8mb4' COLLATE 'utf8mb4_unicode_ci' NULL DEFAULT NULL ,
ADD INDEX `diagnostico_cie_cod_foreign_idx` (`CIE_COD` ASC) VISIBLE,
ADD INDEX `diagnostico_cita_cod_foreign_idx` (`CITA_COD` ASC) VISIBLE,
DROP INDEX `DIAGNOSTICO_NOM_UNIQUE` ;
;
ALTER TABLE `siemprea_bspi_gestion_hospitalaria`.`diagnosticos` 
ADD CONSTRAINT `diagnostico_cie_cod_foreign`
  FOREIGN KEY (`CIE_COD`)
  REFERENCES `siemprea_bspi_gestion_hospitalaria`.`cie` (`CIE_COD`)
  ON DELETE RESTRICT
  ON UPDATE RESTRICT,
ADD CONSTRAINT `diagnostico_cita_cod_foreign`
  FOREIGN KEY (`CITA_COD`)
  REFERENCES `siemprea_bspi_gestion_hospitalaria`.`citas` (`CITA_COD`)
  ON DELETE RESTRICT
  ON UPDATE RESTRICT;
