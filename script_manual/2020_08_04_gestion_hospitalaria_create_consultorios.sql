
CREATE TABLE `consultorios` (
  `CONSULTORIO_COD` int(11) NOT NULL,
  `AREA_COD` bigint(20) NOT NULL,
  `JORNADATRABAJADOR_COD` bigint(20) NOT NULL,
  `CONSULTORIO_NOM` varchar(255) NOT NULL,
  `CONSULTORIO_OBS` varchar(255) DEFAULT NULL,
  `CONSULTORIO_LOGIC_ESTADO` char(1) NOT NULL,
  `US_COD_CREATED_UPDATED` bigint(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
ALTER TABLE `consultorios`
  ADD PRIMARY KEY (`CONSULTORIO_COD`);

ALTER TABLE `consultorios`
  MODIFY `CONSULTORIO_COD` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;
COMMIT;