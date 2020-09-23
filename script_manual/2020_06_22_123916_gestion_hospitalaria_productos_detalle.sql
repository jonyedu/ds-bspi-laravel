CREATE TABLE `siemprea_bspi_gestion_hospitalaria`.`productos_detalle` (
  `PROD_DETA_COD` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `FARMACIA_COD` BIGINT UNSIGNED NOT NULL,
  `PRODUCTO_COD` BIGINT UNSIGNED NOT NULL,
  `PROD_DETA_STOCK` BIGINT NOT NULL,
  `PROD_DETA_LOGIC_ESTADO` CHAR(2) NOT NULL,
  `US_COD_CREATED_UPDATED` VARCHAR(10) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`PROD_DETA_COD`),
  INDEX `prod_deta_farmacia_cod_foregin_idx` (`FARMACIA_COD` ASC) VISIBLE,
  INDEX `prod_deta_productos_cod_foregin_idx` (`PRODUCTO_COD` ASC) VISIBLE,
  CONSTRAINT `prod_deta_farmacia_cod_foregin`
    FOREIGN KEY (`FARMACIA_COD`)
    REFERENCES `siemprea_bspi_gestion_hospitalaria`.`farmacia` (`FARMACIA_COD`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT,
  CONSTRAINT `prod_deta_productos_cod_foregin`
    FOREIGN KEY (`PRODUCTO_COD`)
    REFERENCES `siemprea_bspi_gestion_hospitalaria`.`productos` (`PRODUCTO_COD`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT);
