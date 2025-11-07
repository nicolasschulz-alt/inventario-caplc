CREATE TABLE sistema (
	id int NOT NULL AUTO_INCREMENT,
  	nombre varchar(100) NOT NULL,
  	PRIMARY KEY (id)
);

CREATE TABLE rol (
	id int NOT NULL AUTO_INCREMENT,
  	nombre varchar(100) NOT NULL,
  	PRIMARY KEY (id)
);

CREATE TABLE permiso (
  id INT NOT NULL AUTO_INCREMENT,
  user_id BIGINT(20) UNSIGNED NOT NULL,
  rol_id INT NOT NULL,
  sistema_id INT NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (user_id) REFERENCES users(id),
  FOREIGN KEY (rol_id) REFERENCES rol(id),
  FOREIGN KEY (sistema_id) REFERENCES sistema(id)

);

CREATE TABLE proveedor (
	id int NOT NULL AUTO_INCREMENT,
  	nombre varchar(100) NOT NULL,
  	direccion varchar(100) DEFAULT NULL,
  	telefono varchar(100) DEFAULT NULL,
  	email varchar(100) DEFAULT NULL,
  	rut VARCHAR(50) DEFAULT NULL,
  	dv VARCHAR(50) DEFAULT NULL,
  	PRIMARY KEY (id)
);


-- orden de compra
CREATE TABLE orden_compra (
   id INT NOT NULL AUTO_INCREMENT,
   descripcion VARCHAR(100) NOT NULL,
   PRIMARY KEY (id)
);

-- tablas datos demograficos
CREATE TABLE localidad (
   id INT NOT NULL AUTO_INCREMENT,
   nombre VARCHAR(100) NOT NULL,
   PRIMARY KEY (id)
);

CREATE TABLE establecimiento (
    id INT NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    localidad_id INT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (localidad_id) REFERENCES localidad(id)
);

CREATE TABLE edificio (
  id INT NOT NULL AUTO_INCREMENT,
  nombre VARCHAR(100) NOT NULL,
  establecimiento_id INT NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (establecimiento_id) REFERENCES establecimiento(id)
);

CREATE TABLE piso (
  id INT NOT NULL AUTO_INCREMENT,
  nombre VARCHAR(100) NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE edificio_piso (
  id INT NOT NULL AUTO_INCREMENT,
  edificio_id INT NOT NULL,
  piso_id INT NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (edificio_id) REFERENCES edificio(id),
  FOREIGN KEY (piso_id) REFERENCES piso(id)
);

/*
CREATE TABLE sector (
  id INT NOT NULL AUTO_INCREMENT,
  nombre VARCHAR(100) NOT NULL,
  edificio_piso_id INT NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (edificio_piso_id) REFERENCES edificio_piso(id)
);
*/

CREATE TABLE sala (
  id INT NOT NULL AUTO_INCREMENT,
  numero_sala VARCHAR(100) NOT NULL,
  nombre_sala VARCHAR(100) NOT NULL,
  edificio_piso_id INT NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (edificio_piso_id) REFERENCES edificio_piso(id)
);



-- tablas usuario final o funcionario

CREATE TABLE estado_funcionario (
  id INT NOT NULL AUTO_INCREMENT,
  nombre VARCHAR(100) NOT NULL,
  PRIMARY KEY (id)
);
 
CREATE TABLE funcionario (
	id INT NOT NULL AUTO_INCREMENT,
	nombres VARCHAR(100) NOT NULL,
	apellido_pat VARCHAR(100) NOT NULL,
	apellido_mat VARCHAR(100) DEFAULT NULL,
	rut VARCHAR(50) DEFAULT NULL,
	dv VARCHAR(50) DEFAULT NULL,
	email VARCHAR(50) DEFAULT NULL,
	-- 	telefono_id VARCHAR(50) DEFAULT NULL,
	estado_id INT DEFAULT NULL,
	user_id BIGINT(20) UNSIGNED DEFAULT NULL, -- SE USO ESTE TIPO DE DATO POR EL TIPO DE DATO QUE TIENE EL PK USERS
	PRIMARY KEY (id),
	FOREIGN KEY (estado_id) REFERENCES estado_funcionario(id),
	FOREIGN KEY (user_id) REFERENCES users(id)
	
);




-- tablas reciclables

CREATE TABLE estado_dispositivo (
  id INT NOT NULL AUTO_INCREMENT,
  nombre VARCHAR(100) NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE tipo_dispositivo (
  id INT NOT NULL AUTO_INCREMENT,
  nombre VARCHAR(100) NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE marca_dispositivo (
  id INT NOT NULL AUTO_INCREMENT,
  nombre VARCHAR(100) NOT NULL,
  tipo_dispositivo_id INT DEFAULT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (tipo_dispositivo_id) REFERENCES tipo_dispositivo(id)
);

CREATE TABLE modelo_dispositivo (
  id INT NOT NULL AUTO_INCREMENT,
  nombre VARCHAR(100) NOT NULL,
  tipo_dispositivo_id INT NOT NULL,
  marca_dispositivo_id INT NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (tipo_dispositivo_id) REFERENCES tipo_dispositivo(id),
  FOREIGN KEY (marca_dispositivo_id) REFERENCES marca_dispositivo(id)
);


-- tablas de redes

/*CREATE TABLE aceess_point (
  id INT NOT NULL AUTO_INCREMENT,
  rotulo VARCHAR(50) NOT NULL,
  codigo_servicio VARCHAR(50) NOT NULL,
  mac VARCHAR(50) NOT NULL,
  marca VARCHAR(50) NOT NULL,
  modelo VARCHAR(50) NOT NULL,
  serie VARCHAR(50) NOT NULL,
  boca_pachpanel VARCHAR(50) NOT NULL,
  ssid VARCHAR(100) NOT NULL,
  ip_id INT DEFAULT NULL,
  establecimiento_id INT DEFAULT NULL,
  PRIMARY KEY (id)
  
  FOREIGN KEY (ip_id) REFERENCES ip(id),  
  FOREIGN KEY (establecimiento_id) REFERENCES establecimiento(id)
);*/

CREATE TABLE tipo_vlan (
  id INT NOT NULL AUTO_INCREMENT,
  nombre VARCHAR(50) NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE vlan (
  id INT NOT NULL AUTO_INCREMENT,
  nombre VARCHAR(50) NOT NULL,
  mascara VARCHAR(50) NOT NULL,
  tipo_vlan_id INT DEFAULT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (tipo_vlan_id) REFERENCES tipo_vlan(id)
);

CREATE TABLE segmento (
  id INT NOT NULL AUTO_INCREMENT,
  nombre VARCHAR(50) NOT NULL,
  vlan_dato_id INT DEFAULT NULL,
  vlan_voz_id INT DEFAULT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (vlan_dato_id) REFERENCES vlan(id),
  FOREIGN KEY (vlan_voz_id) REFERENCES vlan(id)
);

CREATE TABLE perfil_ip (
  id INT NOT NULL AUTO_INCREMENT,
  nombre VARCHAR(50) NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE ip (
  id INT NOT NULL AUTO_INCREMENT,
  direccion_ip VARCHAR(50) NOT NULL,
  segmento_id INT DEFAULT NULL,
  perfil_id INT DEFAULT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (segmento_id) REFERENCES segmento(id),
  FOREIGN KEY (perfil_id) REFERENCES perfil_ip(id)
);

CREATE TABLE categoria_anexo (
  id INT NOT NULL AUTO_INCREMENT,
  nombre VARCHAR(50) NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE anexo (
  id int NOT NULL AUTO_INCREMENT,
  anexo VARCHAR(50) DEFAULT NULL,
  identificador VARCHAR(50) DEFAULT NULL,
  num_inventario varchar(100) DEFAULT NULL,
  marca_id int DEFAULT NULL,
  modelo_id int DEFAULT NULL,
  serie varchar(100) NOT NULL,
  mac varchar(100) DEFAULT NULL,
  observaciones text,
  categoria_id int DEFAULT NULL,
  sala_id int DEFAULT NULL,
  funcionario_id INT DEFAULT NULL,
  estado_id int DEFAULT NULL,
  user_crea_id bigint(20) unsigned DEFAULT NULL,
  fecha_crea datetime DEFAULT NULL,
  user_mod_id bigint(20) unsigned DEFAULT NULL,
  fecha_mod datetime DEFAULT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (categoria_id) REFERENCES categoria_anexo(id),
  FOREIGN KEY (sala_id) REFERENCES sala(id),
  FOREIGN KEY (funcionario_id) REFERENCES funcionario(id),
  FOREIGN KEY (estado_id) REFERENCES estado_dispositivo(id),
  FOREIGN KEY (marca_id) REFERENCES marca_dispositivo(id),
  FOREIGN KEY (modelo_id) REFERENCES modelo_dispositivo(id),
  FOREIGN KEY (user_crea_id) REFERENCES users(id),
  FOREIGN KEY (user_mod_id) REFERENCES users(id)
);

-- monitores

CREATE TABLE monitor (
  id int NOT NULL AUTO_INCREMENT,
  num_inventario varchar(100) DEFAULT NULL,
  marca_id int DEFAULT NULL,
  modelo_id int DEFAULT NULL,
  serie varchar(100) NOT NULL,
  observaciones text,
  sala_id int DEFAULT NULL,
  funcionario_id INT DEFAULT NULL,
  estado_id int DEFAULT NULL,
  user_crea_id bigint(20) unsigned DEFAULT NULL,
  fecha_crea datetime DEFAULT NULL,
  user_mod_id bigint(20) unsigned DEFAULT NULL,
  fecha_mod datetime DEFAULT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (sala_id) REFERENCES sala(id),
  FOREIGN KEY (funcionario_id) REFERENCES funcionario(id),
  FOREIGN KEY (estado_id) REFERENCES estado_dispositivo(id),
  FOREIGN KEY (marca_id) REFERENCES marca_dispositivo(id),
  FOREIGN KEY (modelo_id) REFERENCES modelo_dispositivo(id),
  FOREIGN KEY (user_crea_id) REFERENCES users(id),
  FOREIGN KEY (user_mod_id) REFERENCES users(id)
);

CREATE TABLE huellero (
  id int NOT NULL AUTO_INCREMENT,
  num_inventario varchar(100) DEFAULT NULL,
  marca_id int DEFAULT NULL,
  modelo_id int DEFAULT NULL,
  serie varchar(100) NOT NULL,
  observaciones text,
  sala_id int DEFAULT NULL,
  funcionario_id INT DEFAULT NULL,
  estado_id int DEFAULT NULL,
  user_crea_id bigint(20) unsigned DEFAULT NULL,
  fecha_crea datetime DEFAULT NULL,
  user_mod_id bigint(20) unsigned DEFAULT NULL,
  fecha_mod datetime DEFAULT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (sala_id) REFERENCES sala(id),
  FOREIGN KEY (funcionario_id) REFERENCES funcionario(id),
  FOREIGN KEY (estado_id) REFERENCES estado_dispositivo(id),
  FOREIGN KEY (marca_id) REFERENCES marca_dispositivo(id),
  FOREIGN KEY (modelo_id) REFERENCES modelo_dispositivo(id),
  FOREIGN KEY (user_crea_id) REFERENCES users(id),
  FOREIGN KEY (user_mod_id) REFERENCES users(id)
);




-- tablas en relacion con pc

CREATE TABLE cpu_pc (
  id int NOT NULL AUTO_INCREMENT,
  nombre VARCHAR(100) NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE ram_pc (
  id int NOT NULL AUTO_INCREMENT,
  nombre VARCHAR(100) NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE tipo_disco_pc (
  id int NOT NULL AUTO_INCREMENT,
  nombre varchar(100) NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE disco_pc (
  id int NOT NULL AUTO_INCREMENT,
  nombre varchar(100) NOT NULL,
  tipo_disco_id INT NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (tipo_disco_id) REFERENCES tipo_disco_pc(id)
);

CREATE TABLE candado (
  id int NOT NULL AUTO_INCREMENT,
  nombre varchar(100) NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE corriente (
  id int NOT NULL AUTO_INCREMENT,
  nombre varchar(100) NOT NULL,
  PRIMARY KEY (id)
);
/*
CREATE TABLE sistema_operativo (
  id int NOT NULL AUTO_INCREMENT,
  nombre varchar(100) NOT NULL,
  PRIMARY KEY (id)
);
*/
CREATE TABLE tipo_pc (
  id int NOT NULL AUTO_INCREMENT,
  nombre varchar(100) NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE pc (
  id int NOT NULL AUTO_INCREMENT,
  serie VARCHAR(100) NOT NULL,
  num_inventario VARCHAR(100) DEFAULT NULL,
  ip_id int DEFAULT NULL,
  sala_id int DEFAULT NULL,
  nombre_equipo varchar(100) DEFAULT NULL,
  nombre_usuario_ad varchar(100) DEFAULT NULL,
  marca_id int DEFAULT NULL,
  modelo_id int DEFAULT NULL,
  tipo_id int DEFAULT NULL,
  cpu_id int DEFAULT NULL,
  ram_id int DEFAULT NULL,
  disco_id int DEFAULT NULL,
  correo varchar(100) DEFAULT NULL,
  candado_id int DEFAULT NULL,
  corriente_id int DEFAULT NULL,
  oc_id int DEFAULT NULL,
  observaciones text,
  estado_id int DEFAULT NULL,
  funcionario_id INT DEFAULT NULL,
  user_crea_id bigint(20) unsigned DEFAULT NULL,
  fecha_crea datetime DEFAULT NULL,
  user_mod_id bigint(20) unsigned DEFAULT NULL,
  fecha_mod datetime DEFAULT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (ip_id) REFERENCES ip(id), 
  FOREIGN KEY (sala_id) REFERENCES sala(id),
  FOREIGN KEY (marca_id) REFERENCES marca_dispositivo(id),
  FOREIGN KEY (modelo_id) REFERENCES modelo_dispositivo(id),
  FOREIGN KEY (tipo_id) REFERENCES tipo_pc(id),
  FOREIGN KEY (cpu_id) REFERENCES cpu_pc(id),
  FOREIGN KEY (ram_id) REFERENCES ram_pc(id),
  FOREIGN KEY (disco_id) REFERENCES disco_pc(id),
  FOREIGN KEY (oc_id) REFERENCES orden_compra(id),
  FOREIGN KEY (candado_id) REFERENCES candado(id),
  FOREIGN KEY (corriente_id) REFERENCES corriente(id),
  FOREIGN KEY (estado_id) REFERENCES estado_dispositivo(id),
  FOREIGN KEY (funcionario_id) REFERENCES funcionario(id),
  FOREIGN KEY (user_crea_id) REFERENCES users(id),
  FOREIGN KEY (user_mod_id) REFERENCES users(id)
);

CREATE TABLE so_app (
  id int NOT NULL AUTO_INCREMENT,
  nombre varchar(100) NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE categoria_app (
  id int NOT NULL AUTO_INCREMENT,
  nombre varchar(100) NOT NULL,
  PRIMARY KEY (id)
);

/* AGREGAR OFFICE Y ANTIVIRUS ENTRE OTRAS APPS  */
CREATE TABLE app (
  id int NOT NULL AUTO_INCREMENT,
  nombre varchar(100) NOT NULL,
  so_id int NOT NULL,
  categoria_id int NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (so_id) REFERENCES so_app(id),
  FOREIGN KEY (categoria_id) REFERENCES categoria_app(id)
);

CREATE TABLE pc_app (
  id int NOT NULL AUTO_INCREMENT,
  pc_id int NOT NULL,
  app_id int NOT NULL,
  tiene_licencia int NOT NULL, -- 0 = no tiene , 1 =  tiene licencia , 2 = no aplica
  licencia varchar(100) DEFAULT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (pc_id) REFERENCES pc(id),
  FOREIGN KEY (app_id) REFERENCES app(id)
);

-- CONSULTAS

/*
SELECT *
FROM edificio_piso ep 
	LEFT JOIN edificio e ON e.id = ep.edificio_id
	LEFT JOIN piso p ON p.id = ep.piso_id
	;*/


/*
SELECT 
	sa.nombre AS 'nombre_sala',
	se.nombre AS 'nombre_sector',
	p.nombre AS 'nombre_piso'
FROM sala sa
	LEFT JOIN sector se ON se.id = sa.sector_id
	LEFT JOIN edificio_piso ep ON ep.id = se.edificio_piso_id
	LEFT JOIN edificio e ON e.id = ep.edificio_id
	LEFT JOIN piso p ON p.id = ep.piso_id
	;
*/

/*
SELECT * 
FROM pc AS p
LEFT JOIN sala sa ON sa.id = p.sala_id
LEFT JOIN ubicacion ub ON ub.id = sa.ubicacion_id
LEFT JOIN piso pii ON pii.id = ub.piso_id
LEFT JOIN edificio ed ON ed.id = ub.edificio_id
;
*/

CREATE TABLE tipo_impresora (
  id int NOT NULL AUTO_INCREMENT,
  nombre varchar(100) NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE conexion_impresora (
  id int NOT NULL AUTO_INCREMENT,
  nombre varchar(100) NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE impresora (
  id int NOT NULL AUTO_INCREMENT,
  serie VARCHAR(100) NOT NULL,
  num_inventario VARCHAR(100) DEFAULT NULL,
  ip_id int DEFAULT NULL,
  sala_id int DEFAULT NULL,
  marca_id int DEFAULT NULL,
  modelo_id int DEFAULT NULL,
  tipo_id int DEFAULT NULL,
  conexion_id int DEFAULT NULL,
  candado_id int DEFAULT NULL,
  corriente_id int DEFAULT NULL,
  observaciones text,
  estado_id int DEFAULT NULL,
  funcionario_id INT DEFAULT NULL,
  proveedor_id INT DEFAULT NULL,
  user_crea_id bigint(20) unsigned DEFAULT NULL,
  fecha_crea datetime DEFAULT NULL,
  user_mod_id bigint(20) unsigned DEFAULT NULL,
  fecha_mod datetime DEFAULT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (ip_id) REFERENCES ip(id), 
  FOREIGN KEY (sala_id) REFERENCES sala(id),
  FOREIGN KEY (marca_id) REFERENCES marca_dispositivo(id),
  FOREIGN KEY (modelo_id) REFERENCES modelo_dispositivo(id),
  FOREIGN KEY (tipo_id) REFERENCES tipo_impresora(id),
  FOREIGN KEY (conexion_id) REFERENCES conexion_impresora(id),
  FOREIGN KEY (candado_id) REFERENCES candado(id),
  FOREIGN KEY (corriente_id) REFERENCES corriente(id),
  FOREIGN KEY (estado_id) REFERENCES estado_dispositivo(id),
  FOREIGN KEY (proveedor_id) REFERENCES proveedor(id),
  FOREIGN KEY (funcionario_id) REFERENCES funcionario(id),
  FOREIGN KEY (user_crea_id) REFERENCES users(id),
  FOREIGN KEY (user_mod_id) REFERENCES users(id)
);



UPDATE impresora AS imp
SET 
-- imp.marca_id = 5, -- 3 kyocera , 5 zebra
-- imp.modelo_id = 25, 
-- imp.tipo_id = 3, -- 1 Laser , 2 tinta , 3 termica
imp.conexion_id = 1 -- 1 USB , 2 - RJ45 
-- imp.estado_id = 1,
-- imp.proveedor_id = 1 -- 1 CAPLC, 2 Nueva Atlanta
WHERE imp.serie 
IN 
(
'VRG3806757',
'VRG7Y00780',
'VRG3306218',
'vrg8902110',
'VRG4107571',
'VRG8902337',
'VRG6Z00078',
'VRG8902129',
'VRG3406287',
'VRG1104506',
'VRG3906969',
'VRG3906984',
'VRG8902328',
'VRG3806782',
'VRG2405917',
'VRG3Y07336',
'VRG3Y07327',
'VRG3Y07327',
'VRG1404530',
'VRG8401450',
'VRG8901945',
'VRG8902126',
'VRG8901958',
'VRG3906979',
'VRG1404534',
'VRG8902101',
'VRG1404621',
'VRG1404770',
'VRG1404611',
'VRG1404758',
'VRG8901954.',
'VRG8401731',
'VRG8401581',
'VRG0Y04396',
'VRG3Y07272',
'VRG8902015',
'VRG8901967',
'LZC7102472',
'VRG3506405',
'VRG8902312.',
'VRG8401726',
'VRG2705487',
'VRG8401571',
'LCZ6Z02288',
'VRG8902109',
'VRG3806833',
'VRG8901941.',
'VRG8902287',
'VRG8902313.',
'VRG8901974.',
'VRG8902318.',
'VRG8401575.',
'VRG8901939.',
'VRG8401767.',
'VRG8901933',
'VRG8902295',
'VRG8902303',
'VRG8902306',
'VRG8902301.',
'VRG8401583',
'VRG8401701',
'VRG8902310',
'VRG1404782',
'VRG8902275',
'VRG8901940',
'VRG8401576',
'VRG3906998',
'VRG8401585',
'VRG8401582',
'VRG8401584',
'VRG3906980',
'VRG3906970',
'VRG3406238',
'LZC4301079',
'Q5V3905749',
'Q5V3X06148',
'VRG8901972',
'LZC5201598',
'LZC5201589',
'Q5V3X06246',
'VRG8901949',
'VRG2Y05896',
'VRG1404761',
'LZC7102406',
'VRG3906990',
'LZC4200663',
'LZC6Z02339',
'LZC5901930',
'LZC3Z00019',
'VRG3306173',
'LZC5201592',
'VRG8100825',
'LZC5201531',
'LZC7102447',
'LZC4301092',
'VRG8901937',
'VRG8901946',
'VRG8902293',
'VRG8902308.',
'VRG8902309',
'VRG8902305',
'VRG8901942',
'VRG8401578',
'VRG8401565.',
'VRG8401694',
'Vrg3806831',
'LZC6Z02288'
)

INSERT INTO ip (direccion_ip, segmento_id, perfil_id)
VALUES
('10.69.30.1', 10, 1),
('10.69.30.2', 10, 1),
('10.69.30.3', 10, 1),
('10.69.30.4', 10, 1),
('10.69.30.5', 10, 1),
('10.69.30.6', 10, 1),
('10.69.30.7', 10, 1),
('10.69.30.8', 10, 1),
('10.69.30.9', 10, 1),
('10.69.30.10', 10, 1),
('10.69.30.11', 10, 1),
('10.69.30.12', 10, 1),
('10.69.30.13', 10, 1),
('10.69.30.14', 10, 1),
('10.69.30.15', 10, 1),
('10.69.30.16', 10, 1),
('10.69.30.17', 10, 1),
('10.69.30.18', 10, 1),
('10.69.30.19', 10, 1),
('10.69.30.20', 10, 1),
('10.69.30.21', 10, 1),
('10.69.30.22', 10, 1),
('10.69.30.23', 10, 1),
('10.69.30.24', 10, 1),
('10.69.30.25', 10, 1),
('10.69.30.26', 10, 1),
('10.69.30.27', 10, 1),
('10.69.30.28', 10, 1),
('10.69.30.29', 10, 1),
('10.69.30.30', 10, 1),
('10.69.30.31', 10, 1),
('10.69.30.32', 10, 1),
('10.69.30.33', 10, 1),
('10.69.30.34', 10, 1),
('10.69.30.35', 10, 1),
('10.69.30.36', 10, 1),
('10.69.30.37', 10, 1),
('10.69.30.38', 10, 1),
('10.69.30.39', 10, 1),
('10.69.30.40', 10, 1),
('10.69.30.41', 10, 1),
('10.69.30.42', 10, 1),
('10.69.30.43', 10, 1),
('10.69.30.44', 10, 1),
('10.69.30.45', 10, 1),
('10.69.30.46', 10, 1),
('10.69.30.47', 10, 1),
('10.69.30.48', 10, 1),
('10.69.30.49', 10, 1),
('10.69.30.50', 10, 1),
('10.69.30.51', 10, 1),
('10.69.30.52', 10, 1),
('10.69.30.53', 10, 1),
('10.69.30.54', 10, 1),
('10.69.30.55', 10, 1),
('10.69.30.56', 10, 1),
('10.69.30.57', 10, 1),
('10.69.30.58', 10, 1),
('10.69.30.59', 10, 1),
('10.69.30.60', 10, 1),
('10.69.30.61', 10, 1),
('10.69.30.62', 10, 1),
('10.69.30.63', 10, 1),
('10.69.30.64', 10, 1),
('10.69.30.65', 10, 1),
('10.69.30.66', 10, 1),
('10.69.30.67', 10, 1),
('10.69.30.68', 10, 1),
('10.69.30.69', 10, 1),
('10.69.30.70', 10, 1),
('10.69.30.71', 10, 1),
('10.69.30.72', 10, 1),
('10.69.30.73', 10, 1),
('10.69.30.74', 10, 1),
('10.69.30.75', 10, 1),
('10.69.30.76', 10, 1),
('10.69.30.77', 10, 1),
('10.69.30.78', 10, 1),
('10.69.30.79', 10, 1),
('10.69.30.80', 10, 1),
('10.69.30.81', 10, 1),
('10.69.30.82', 10, 1),
('10.69.30.83', 10, 1),
('10.69.30.84', 10, 1),
('10.69.30.85', 10, 1),
('10.69.30.86', 10, 1),
('10.69.30.87', 10, 1),
('10.69.30.88', 10, 1),
('10.69.30.89', 10, 1),
('10.69.30.90', 10, 1),
('10.69.30.91', 10, 1),
('10.69.30.92', 10, 1),
('10.69.30.93', 10, 1),
('10.69.30.94', 10, 1),
('10.69.30.95', 10, 1),
('10.69.30.96', 10, 1),
('10.69.30.97', 10, 1),
('10.69.30.98', 10, 1),
('10.69.30.99', 10, 1),
('10.69.30.100', 10, 1),
('10.69.30.101', 10, 1),
('10.69.30.102', 10, 1),
('10.69.30.103', 10, 1),
('10.69.30.104', 10, 1),
('10.69.30.105', 10, 1),
('10.69.30.106', 10, 1),
('10.69.30.107', 10, 1),
('10.69.30.108', 10, 1),
('10.69.30.109', 10, 1),
('10.69.30.110', 10, 1),
('10.69.30.111', 10, 1),
('10.69.30.112', 10, 1),
('10.69.30.113', 10, 1),
('10.69.30.114', 10, 1),
('10.69.30.115', 10, 1),
('10.69.30.116', 10, 1),
('10.69.30.117', 10, 1),
('10.69.30.118', 10, 1),
('10.69.30.119', 10, 1),
('10.69.30.120', 10, 1),
('10.69.30.121', 10, 1),
('10.69.30.122', 10, 1),
('10.69.30.123', 10, 1),
('10.69.30.124', 10, 1),
('10.69.30.125', 10, 1),
('10.69.30.126', 10, 1),
('10.69.30.127', 10, 1),
('10.69.30.128', 10, 1),
('10.69.30.129', 10, 1),
('10.69.30.130', 10, 1),
('10.69.30.131', 10, 1),
('10.69.30.132', 10, 1),
('10.69.30.133', 10, 1),
('10.69.30.134', 10, 1),
('10.69.30.135', 10, 1),
('10.69.30.136', 10, 1),
('10.69.30.137', 10, 1),
('10.69.30.138', 10, 1),
('10.69.30.139', 10, 1),
('10.69.30.140', 10, 1),
('10.69.30.141', 10, 1),
('10.69.30.142', 10, 1),
('10.69.30.143', 10, 1),
('10.69.30.144', 10, 1),
('10.69.30.145', 10, 1),
('10.69.30.146', 10, 1),
('10.69.30.147', 10, 1),
('10.69.30.148', 10, 1),
('10.69.30.149', 10, 1),
('10.69.30.150', 10, 1),
('10.69.30.151', 10, 1),
('10.69.30.152', 10, 1),
('10.69.30.153', 10, 1),
('10.69.30.154', 10, 1),
('10.69.30.155', 10, 1),
('10.69.30.156', 10, 1),
('10.69.30.157', 10, 1),
('10.69.30.158', 10, 1),
('10.69.30.159', 10, 1),
('10.69.30.160', 10, 1),
('10.69.30.161', 10, 1),
('10.69.30.162', 10, 1),
('10.69.30.163', 10, 1),
('10.69.30.164', 10, 1),
('10.69.30.165', 10, 1),
('10.69.30.166', 10, 1),
('10.69.30.167', 10, 1),
('10.69.30.168', 10, 1),
('10.69.30.169', 10, 1),
('10.69.30.170', 10, 1),
('10.69.30.171', 10, 1),
('10.69.30.172', 10, 1),
('10.69.30.173', 10, 1),
('10.69.30.174', 10, 1),
('10.69.30.175', 10, 1),
('10.69.30.176', 10, 1),
('10.69.30.177', 10, 1),
('10.69.30.178', 10, 1),
('10.69.30.179', 10, 1),
('10.69.30.180', 10, 1),
('10.69.30.181', 10, 1),
('10.69.30.182', 10, 1),
('10.69.30.183', 10, 1),
('10.69.30.184', 10, 1),
('10.69.30.185', 10, 1),
('10.69.30.186', 10, 1),
('10.69.30.187', 10, 1),
('10.69.30.188', 10, 1),
('10.69.30.189', 10, 1),
('10.69.30.190', 10, 1),
('10.69.30.191', 10, 1),
('10.69.30.192', 10, 1),
('10.69.30.193', 10, 1),
('10.69.30.194', 10, 1),
('10.69.30.195', 10, 1),
('10.69.30.196', 10, 1),
('10.69.30.197', 10, 1),
('10.69.30.198', 10, 1),
('10.69.30.199', 10, 1),
('10.69.30.200', 10, 1),
('10.69.30.201', 10, 1),
('10.69.30.202', 10, 1),
('10.69.30.203', 10, 1),
('10.69.30.204', 10, 1),
('10.69.30.205', 10, 1),
('10.69.30.206', 10, 1),
('10.69.30.207', 10, 1),
('10.69.30.208', 10, 1),
('10.69.30.209', 10, 1),
('10.69.30.210', 10, 1),
('10.69.30.211', 10, 1),
('10.69.30.212', 10, 1),
('10.69.30.213', 10, 1),
('10.69.30.214', 10, 1),
('10.69.30.215', 10, 1),
('10.69.30.216', 10, 1),
('10.69.30.217', 10, 1),
('10.69.30.218', 10, 1),
('10.69.30.219', 10, 1),
('10.69.30.220', 10, 1),
('10.69.30.221', 10, 1),
('10.69.30.222', 10, 1),
('10.69.30.223', 10, 1),
('10.69.30.224', 10, 1),
('10.69.30.225', 10, 1),
('10.69.30.226', 10, 1),
('10.69.30.227', 10, 1),
('10.69.30.228', 10, 1),
('10.69.30.229', 10, 1),
('10.69.30.230', 10, 1),
('10.69.30.231', 10, 1),
('10.69.30.232', 10, 1),
('10.69.30.233', 10, 1),
('10.69.30.234', 10, 1),
('10.69.30.235', 10, 1),
('10.69.30.236', 10, 1),
('10.69.30.237', 10, 1),
('10.69.30.238', 10, 1),
('10.69.30.239', 10, 1),
('10.69.30.240', 10, 1),
('10.69.30.241', 10, 1),
('10.69.30.242', 10, 1),
('10.69.30.243', 10, 1),
('10.69.30.244', 10, 1),
('10.69.30.245', 10, 1),
('10.69.30.246', 10, 1),
('10.69.30.247', 10, 1),
('10.69.30.248', 10, 1),
('10.69.30.249', 10, 1),
('10.69.30.250', 10, 1),
('10.69.30.251', 10, 1),
('10.69.30.252', 10, 1),
('10.69.30.253', 10, 1),
('10.69.30.254', 10, 1),
('10.69.30.255', 10, 1);

