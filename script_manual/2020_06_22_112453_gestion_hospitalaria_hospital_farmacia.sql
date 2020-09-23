CREATE TABLE `siemprea_bspi_gestion_hospitalaria`.`hospital_farmacia` (
  `HOSP_FARM_COD` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `HOSPITAL_COD` BIGINT UNSIGNED NOT NULL,
  `FARMACIA_COD` BIGINT UNSIGNED NOT NULL,
  `HOSP_FARM_LOGIC_ESTADO` CHAR(2) NOT NULL,
  `US_COD_CREATED_UPDATED` VARCHAR(10) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`HOSP_FARM_COD`),
  INDEX `hosp_farm_farmacia_cod_foregin_idx` (`FARMACIA_COD` ASC) VISIBLE,
  INDEX `hosp_farm_hospital_cod_foregin_idx` (`HOSPITAL_COD` ASC) VISIBLE,
  CONSTRAINT `hosp_farm_farmacia_cod_foregin`
    FOREIGN KEY (`FARMACIA_COD`)
    REFERENCES `siemprea_bspi_gestion_hospitalaria`.`farmacia` (`FARMACIA_COD`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT,
  CONSTRAINT `hosp_farm_hospital_cod_foregin`
    FOREIGN KEY (`HOSPITAL_COD`)
    REFERENCES `siemprea_bspi_gestion_hospitalaria`.`hospital` (`HOSPITAL_COD`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT);
