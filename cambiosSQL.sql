// Se crea catalogo de tipo de registro inicial
// 14--1-19

CREATE TABLE `dev2gom_2gom-yiibase`.`base_cat_type_sing_up` (
	`id_type_singup` INT(11) UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
	`uudi` VARCHAR(100) NOT NULL DEFAULT '',
	`txt_nombre` VARCHAR(100) NOT NULL DEFAULT '',
	`txt_decripcion` VARCHAR(100) NULL DEFAULT NULL,
	`b_configurado` INT(10) UNSIGNED NOT NULL DEFAULT '0'
)
 COLLATE 'utf8_general_ci' ENGINE=InnoDB ROW_FORMAT=Dynamic;


INSERT INTO `base_cat_type_sing_up` (`id_type_sing_up`, `uudi`, `txt_nombre`, `txt_decripcion`, `b_configurado`) VALUES 
(1, 'basic', 'basic', 'Formulario basico de registro', 1),
(2, 'code', 'code', 'Formulario con campo de codigo', 1),
(3, 'contest', 'contest', 'Formulario para concursos', 1);
