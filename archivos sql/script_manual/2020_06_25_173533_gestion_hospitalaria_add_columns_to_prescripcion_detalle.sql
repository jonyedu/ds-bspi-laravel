ALTER TABLE `siemprea_bspi_gestion_hospitalaria`.`prescripcion_detalle` 
DROP FOREIGN KEY `presc_deta_farmacia_cod_foregin`;
ALTER TABLE `siemprea_bspi_gestion_hospitalaria`.`prescripcion_detalle` 
DROP COLUMN `FARMACIA_COD`,
CHANGE COLUMN `PROD_DETA_COD` `PRODUCTO_DETALLE_COD` BIGINT UNSIGNED NOT NULL ,
ADD INDEX `presc_deta_producto_detalle_cod_foregin_idx` (`PRODUCTO_DETALLE_COD` ASC) VISIBLE,
DROP INDEX `presc_deta_farmacia_cod_foregin_idx` ;
;
ALTER TABLE `siemprea_bspi_gestion_hospitalaria`.`prescripcion_detalle` 
ADD CONSTRAINT `presc_deta_producto_detalle_cod_foregin`
  FOREIGN KEY (`PRODUCTO_DETALLE_COD`)
  REFERENCES `siemprea_bspi_gestion_hospitalaria`.`producto_detalle` (`PRODUCTO_DETALLE_COD`)
  ON DELETE RESTRICT
  ON UPDATE RESTRICT;