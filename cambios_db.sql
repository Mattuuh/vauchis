
DROP TABLE IF EXISTS `pagos_mercadopago_response`;
CREATE TABLE `pagos_mercadopago_response` (
  `pmr_id` int(11) NOT NULL AUTO_INCREMENT,
  `op_id` int(11) DEFAULT NULL COMMENT 'Entidad',
  `cliente_id` int(11) DEFAULT NULL COMMENT 'Cliente',
  `preference_data` text COMMENT 'preferencias de pagos utilizadas en la operación',
  `pmr_get` text,
  `pmr_post` text,
  `collection_id` varchar(200) DEFAULT NULL,
  `external_reference` varchar(50) DEFAULT NULL,
  `merchant_order_id` varchar(200) DEFAULT NULL,
  `collection_status` varchar(50) DEFAULT NULL,
  `payment_type` varchar(50) DEFAULT NULL,
  `pmr_json` text,
  `pmr_obs` text,
  `pmr_exec` varchar(200) DEFAULT NULL COMMENT 'nombre script sobre el que se ejecuta inserción de entrada',
  `merchant_order_info` text,
  `payment_info` text,
  `pmr_usu_alta` int(11) DEFAULT NULL,
  `pmr_fecha_alta` datetime DEFAULT NULL,
  `pmr_usu_mod` int(11) DEFAULT NULL,
  `pmr_fecha_mod` datetime DEFAULT NULL,
  `pmr_usu_baja` int(11) DEFAULT NULL,
  `pmr_fecha_baja` datetime DEFAULT NULL,
  PRIMARY KEY (`pmr_id`),
  KEY `idx_op_id` (`op_id`),
  KEY `idx_cliente_id` (`cliente_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `pagos_mercadopago`;
CREATE TABLE `pagos_mercadopago` (
  `pmp_id` int NOT NULL AUTO_INCREMENT,
  `op_id` int(11) DEFAULT NULL COMMENT 'Orden de pago',
  `cliente_id` int(11) DEFAULT NULL COMMENT 'Cliente',
  `pmp_fecha` date DEFAULT NULL,
  `pmp_mes` int DEFAULT NULL,
  `pmp_anio` int DEFAULT NULL,
  `payment_id` varchar(50) DEFAULT NULL,
  `merchant_order_id` varchar(50) DEFAULT NULL,
  `transaction_amount` decimal(24,4) DEFAULT NULL,
  `collection_id` varchar(50) DEFAULT NULL,
  `payment_type` varchar(50) DEFAULT NULL,
  `pmp_descripcion` varchar(255) DEFAULT NULL,
  `pmp_monto_total` decimal(24,4) NOT NULL DEFAULT '0.0000' COMMENT 'Monto, precio recperado de tablas en momento de alta de transaccion, antes del pago',
  `pmp_estado` int NOT NULL DEFAULT '1' COMMENT 'Estado general del registro; 1: pago vigente/activo - 0: pago anulado por generación de nuevo registro, por pago pendiente, o por cancelación durante proceso de pago',
  `pmp_estado_envio` varchar(255) DEFAULT NULL COMMENT 'LIBERADO - ENVIAR|LIBERADO - SIN ENVIO|NO LIBERADO',
  `pmp_estado_transaccion` varchar(255) DEFAULT NULL COMMENT 'PAGADO|NO PAGADO',
  `pmp_observaciones` text,
  `pmp_ambiente` varchar(20) DEFAULT NULL COMMENT 'PRODUCCION|SANDBOX',
  `pmp_script` varchar(20) DEFAULT NULL,
  `pmp_fecha_alta` datetime DEFAULT NULL,
  `pmp_usu_alta` int DEFAULT NULL,
  `pmp_fecha_mod` datetime DEFAULT NULL,
  `pmp_usu_mod` int DEFAULT NULL,
  `pmp_fecha_baja` datetime DEFAULT NULL,
  `pmp_usu_baja` int DEFAULT NULL,
  PRIMARY KEY (`pmp_id`),
  KEY `idx_op_id` (`op_id`),
  KEY `idx_cliente_id` (`cliente_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COMMENT='Registro de pagos con mercadopago';


DROP TABLE IF EXISTS `mercadopago_response_log`;
CREATE TABLE `mercadopago_response_log` (
  `mpl_id` int(11) NOT NULL AUTO_INCREMENT,
  `ent_id` int(11) DEFAULT NULL COMMENT 'Entidad',
  `vou_id` int(11) DEFAULT NULL COMMENT 'Voucher',
  `cliente_id` int(11) DEFAULT NULL COMMENT 'Cliente',
  `preference_data` text COMMENT 'preferencias de pagos utilizadas en la operación',
  `mpl_get` text,
  `mpl_post` text,
  `collection_id` varchar(200) DEFAULT NULL,
  `external_reference` varchar(50) DEFAULT NULL,
  `merchant_order_id` varchar(200) DEFAULT NULL,
  `collection_status` varchar(50) DEFAULT NULL,
  `payment_type` varchar(50) DEFAULT NULL,
  `mpl_json` text,
  `mpl_obs` text,
  `mpl_exec` varchar(200) DEFAULT NULL COMMENT 'nombre script sobre el que se ejecuta inserción de entrada',
  `mpl_usu_alta` int(11) DEFAULT NULL,
  `mpl_fecha_alta` datetime DEFAULT NULL,
  `mpl_usu_mod` int(11) DEFAULT NULL,
  `mpl_fecha_mod` datetime DEFAULT NULL,
  `mpl_usu_baja` int(11) DEFAULT NULL,
  `mpl_fecha_baja` datetime DEFAULT NULL,
  PRIMARY KEY (`mpl_id`),
  KEY `idx_ent_id` (`ent_id`),
  KEY `idx_vou_id` (`vou_id`),
  KEY `idx_cliente_id` (`cliente_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `ordenes_pagos`;
CREATE TABLE `ordenes_pagos` (
  `op_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `sucursal_id` int UNSIGNED DEFAULT NULL,
  `caja_id` int UNSIGNED DEFAULT NULL,
  `pasla_id` int UNSIGNED DEFAULT NULL COMMENT 'ID de la pasarela usada para confeccionar la orden de pago',
  `ent_id` int DEFAULT NULL,
  `vou_id` int DEFAULT NULL,
  `cliente_id` int DEFAULT NULL,
  `op_cliente_denominacion` varchar(50) DEFAULT NULL,
  `op_cliente_domicilio` varchar(50) DEFAULT NULL,
  `tipo_resp_id` int UNSIGNED DEFAULT '4',
  `tipo_doc_id` int UNSIGNED DEFAULT NULL,
  `op_cliente_documento` varchar(14) DEFAULT NULL,
  `op_fecha` datetime DEFAULT NULL,
  `tipo_comp_id` int UNSIGNED DEFAULT NULL,
  `ptovta_id` int UNSIGNED DEFAULT NULL,
  `op_numero` int DEFAULT NULL,
  `op_neto_0` decimal(24,4) DEFAULT '0.0000',
  `op_iva_0` decimal(24,4) DEFAULT '0.0000',
  `op_total_0` decimal(24,4) DEFAULT '0.0000',
  `op_neto_105` decimal(24,4) DEFAULT '0.0000',
  `op_iva_105` decimal(24,4) DEFAULT '0.0000',
  `op_total_105` decimal(24,4) DEFAULT '0.0000',
  `op_neto_21` decimal(24,4) DEFAULT '0.0000',
  `op_iva_21` decimal(24,4) DEFAULT '0.0000',
  `op_total_21` decimal(24,4) DEFAULT '0.0000',
  `op_neto_27` decimal(24,4) DEFAULT '0.0000',
  `op_iva_27` decimal(24,4) DEFAULT '0.0000',
  `op_total_27` decimal(24,4) DEFAULT '0.0000',
  `op_neto_gravado` decimal(24,4) DEFAULT '0.0000' COMMENT 'comp_neto_gravado=comp_neto_0+comp_neto_105+comp_neto_21+comp_neto_27',
  `op_iva` decimal(24,4) DEFAULT '0.0000' COMMENT 'comp_iva=comp_iva_0+comp_iva_105+comp_iva_21+comp_iva_27',
  `op_neto_no_gravado` decimal(24,4) DEFAULT '0.0000',
  `op_neto_exento` decimal(24,4) DEFAULT '0.0000',
  `op_total_original` decimal(24,4) NOT NULL DEFAULT '0.0000' COMMENT 'total original (suma de los precios de articulos',
  `op_total_desc` decimal(24,4) DEFAULT '0.0000' COMMENT 'total 1, puede haber sido afectado por un descuento aplicado manualmente',
  `op_total` decimal(24,4) DEFAULT '0.0000' COMMENT 'comp_total=comp_neto_gravdo+comp_iva+comp_neto_no_gravado+comp_neto_exento',
  `op_total_conceptos` decimal(24,4) DEFAULT NULL,
  `boucher_id` int UNSIGNED DEFAULT NULL COMMENT 'indica si el descuento efectuado fue o no por un voucher y muestra su respectivo ID ',
  `op_desc_m` decimal(24,4) DEFAULT '0.0000',
  `op_desc_p` decimal(24,4) DEFAULT '0.0000',
  `op_desc_m_voucher` decimal(24,4) DEFAULT '0.0000' COMMENT 'monto de descuento aplicado por voucher sobre el total o sobre el total con descuento ',
  `op_desc_p_voucher` decimal(24,4) DEFAULT '0.0000' COMMENT 'porcentaje de descuento aplicado por voucher sobre el total o sobre el total con descuento ',
  `op_rec_m` decimal(24,4) DEFAULT '0.0000',
  `op_rec_p` decimal(24,4) DEFAULT '0.0000',
  `op_observaciones` text,
  `op_observaciones_internas` text,
  `op_estado` varchar(3) DEFAULT NULL,
  `op_estado2` varchar(3) DEFAULT NULL,
  `op_estado3` varchar(4) DEFAULT NULL COMMENT 'Ref. anulacion',
  `op_ref_id_pago` int DEFAULT NULL,
  `op_fecha_pago` datetime DEFAULT NULL,
  `op_ref_pago` text,
  `op_fecha_alta` datetime DEFAULT NULL,
  `op_usu_alta` int DEFAULT NULL,
  `op_fecha_mod` datetime DEFAULT NULL,
  `op_usu_mod` int DEFAULT NULL,
  `op_fecha_baja` datetime DEFAULT NULL,
  `op_usu_baja` int DEFAULT NULL, 
  PRIMARY KEY (`op_id`),
  KEY `sucursal_id` (`sucursal_id`),
  KEY `tipo_comp_id` (`tipo_comp_id`),
  KEY `idx_ent_id` (`ent_id`),
  KEY `idx_vou_id` (`vou_id`),
  KEY `idx_cliente_id` (`cliente_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `ordenes_pagos_detalles`;
CREATE TABLE `ordenes_pagos_detalles` (
  `op_det_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `op_id` int UNSIGNED DEFAULT NULL,
  `vd_id` int DEFAULT NULL,
  `op_det_pucosto_neto` decimal(24,4) NOT NULL DEFAULT '0.0000',
  `op_det_pucosto_iva` decimal(24,4) NOT NULL DEFAULT '0.0000',
  `op_det_pucosto_bruto` decimal(24,4) NOT NULL DEFAULT '0.0000',
  `op_det_puventa_neto` decimal(24,4) NOT NULL DEFAULT '0.0000' COMMENT 'valor original de lista de precios',
  `op_det_puventa_iva` decimal(24,4) NOT NULL DEFAULT '0.0000',
  `op_det_puventa_total` decimal(24,4) NOT NULL DEFAULT '0.0000',
  `op_det_desc` decimal(24,4) NOT NULL DEFAULT '0.0000' COMMENT 'Porcentaje descuento, por defecto % 0.00',
  `op_det_mto_con_desc` decimal(24,4) DEFAULT '0.0000' COMMENT 'monto afectado por descuento (no voucher)',
  `op_det_pu_neto` decimal(24,4) NOT NULL DEFAULT '0.0000' COMMENT 'valor editable, puede o no coincidir con lista de precios',
  `op_det_pu_iva` decimal(24,4) NOT NULL DEFAULT '0.0000',
  `op_det_pu_total` decimal(24,4) NOT NULL DEFAULT '0.0000',
  `op_det_desc_porc_voucher` decimal(24,4) DEFAULT '0.0000' COMMENT 'Porcentaje descuento por voucher ',
  `op_det_desc_mto_voucher` decimal(24,4) DEFAULT '0.0000' COMMENT ' 	monto de descuento aplicado por voucher ',
  `op_det_neto` decimal(24,4) DEFAULT '0.0000',
  `op_det_iva` decimal(24,4) DEFAULT '0.0000',
  `op_det_subtotal` decimal(24,4) DEFAULT '0.0000',
  `rel_comp_id` int DEFAULT NULL COMMENT 'ID de comprobante que relaciona',
  `rel_comp_det_id` int DEFAULT NULL COMMENT 'ID de detalle linea que relaciona',
  `op_det_cuota_json` text, 
  PRIMARY KEY (`op_det_id`),
  KEY `idx_op_id` (`op_id`),
  KEY `idx_vd_id` (`vd_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



CREATE TABLE `tipos_archivos` (
  `tipo_archivo_id` int NOT NULL AUTO_INCREMENT,
  `tipo_archivo_nombre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipo_archivo_observacion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `tipo_archivo_estado` int NOT NULL DEFAULT '1',
  `tipo_archivo_fecha_alta` datetime DEFAULT NULL,
  `tipo_archivo_usu_alta` int DEFAULT NULL,
  `tipo_archivo_fecha_mod` datetime DEFAULT NULL,
  `tipo_archivo_usu_mod` int DEFAULT NULL,
  `tipo_archivo_fecha_baja` datetime DEFAULT NULL,
  `tipo_archivo_usu_baja` int DEFAULT NULL,
  PRIMARY KEY (`tipo_archivo_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


INSERT INTO `tipos_archivos` (`tipo_archivo_id`, `tipo_archivo_nombre`, `tipo_archivo_observacion`, `tipo_archivo_estado`, `tipo_archivo_fecha_alta`, `tipo_archivo_usu_alta`, `tipo_archivo_fecha_mod`, `tipo_archivo_usu_mod`, `tipo_archivo_fecha_baja`, `tipo_archivo_usu_baja`) VALUES 
(NULL, 'LOGO', 'LOGO', '1', '1900-01-01 00:00:00', '1', NULL, NULL, NULL, NULL),
(NULL, 'BANNER', 'BANNER', '1', '1900-01-01 00:00:00', '1', NULL, NULL, NULL, NULL),
(NULL, 'FONDO', 'FONDO', '1', '1900-01-01 00:00:00', '1', NULL, NULL, NULL, NULL);


DROP TABLE `accesos_web`;

CREATE TABLE `accesos_web` (
  `acc_web_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `usu_web_id` int UNSIGNED DEFAULT NULL,
  `usu_web_nick` varchar(50) DEFAULT NULL,
  `acc_web_sesion_id` varchar(255) DEFAULT NULL,
  `acc_web_login_fecha` datetime DEFAULT NULL,
  `acc_web_logout_fecha` datetime DEFAULT NULL,
  `acc_web_ip` varchar(50) DEFAULT NULL,
  `acc_web_observacion` text DEFAULT NULL,
  `acc_web_browser` text DEFAULT NULL,
  `acc_web_fecha_alta` datetime DEFAULT NULL,
  PRIMARY KEY (`acc_web_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;



.inetsi_castur2026

CREATE USER 'inetsi'@'localhost'
IDENTIFIED BY '.2026inetsi_@394';

GRANT ALL PRIVILEGES
ON vauchis.*
TO 'inetsi'@'localhost';



ALTER TABLE `rubros` ADD `cv_id` INT NULL DEFAULT NULL COMMENT 'Ref a la categoria' AFTER `rub_id`;