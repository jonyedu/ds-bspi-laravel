CREATE TABLE `siemprea_bspi_gestion_hospitalaria`.`movimiento` (
  `MOVIMIENTO_COD` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `TIPOMOVIMIENTO_COD` BIGINT UNSIGNED NOT NULL,
  `MOVIMIENTO_FECHA` DATE NOT NULL,
  `MOVIMIENTO_FARMACIA_ORIGEN_COD` BIGINT NULL DEFAULT '0',
  `MOVIMIENTO_FARMACIA_DESTINO_COD` BIGINT NULL DEFAULT '0',
  `MOVIMIENTO_DESCRIPCION` VARCHAR(255) NULL,
  `MOVIMIENTO_LOGIC_ESTADO` CHAR(2) NOT NULL,
  `US_COD_CREATED_UPDATED` VARCHAR(10) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`MOVIMIENTO_COD`),
  INDEX `movimiento_tipomovimiento_cod_foregin_idx` (`TIPOMOVIMIENTO_COD` ASC) VISIBLE,
  CONSTRAINT `movimiento_tipomovimiento_cod_foregin`
    FOREIGN KEY (`TIPOMOVIMIENTO_COD`)
    REFERENCES `siemprea_bspi_gestion_hospitalaria`.`tipo_movimiento` (`TIPOMOVIMIENTO_COD`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT);
