create database if not exists banco_sv;
use banco_sv;

create table clientes (
dni_cliente varchar (9) not null,
id_cliente int auto_increment,
clave varbinary (200) not null,
nombre varchar (20) not null,
apellido1 varchar (20) not null,
apellido2 varchar (20) not null,
direccion varchar (60) not null,
num_telefono varchar (11) not null,
email varchar (50) not null, 
primary key (dni_cliente),
unique key (id_cliente)
);

create table empleados (
dni_empleado varchar (9) not null,
id_empleado int auto_increment,
clave_e varchar (60) not null,
nombre_e varchar (20) not null,
apellido1_e varchar (20) not null,
apellido2_e varchar (20) not null,
direccion_e varchar (60) not null,
num_telefono_e varchar (11) not null, 
email_e varchar (50) not null, 
primary key (dni_empleado),
unique key (id_empleado)
);

create table cuenta (
id_cuenta int, 
tipo_cuenta varchar(10) not null, 
saldo decimal (15,2) not null,
fecha_apertura datetime not null,
fecha_cierre date,
tipo_interes varchar(20) not null,
limite_retiro decimal (15,2),
estado_cuenta varchar(10) not null, 
primary key (id_cuenta),
check (fecha_apertura <=fecha_cierre),
check (tipo_cuenta in( "ahorro","corriente")),
check (estado_cuenta in ("activa","cerrada","bloqueada"))
);

select*from cuenta;
INSERT INTO cuenta(id_cuenta, tipo_cuenta, saldo, fecha_apertura, fecha_cierre, tipo_interes, limite_retiro, estado_cuenta) 
values(900000001,"ahorro",46700.56,"1994-01-03 15:00:00",NULL,"variable",2300,"activa");
INSERT INTO cuenta(id_cuenta, tipo_cuenta, saldo, fecha_apertura, fecha_cierre, tipo_interes, limite_retiro, estado_cuenta) 
values(900000002,"ahorro",0,"1994-04-11 13:25:22","2024-05-01","fijo",0,"cerrada");
INSERT INTO cuenta(id_cuenta, tipo_cuenta, saldo, fecha_apertura, fecha_cierre, tipo_interes, limite_retiro, estado_cuenta) 
values(900000003,"corriente",6476.45,"2023-12-21 09:14:25",NULL,"variable",400,"activa");
INSERT INTO cuenta(id_cuenta, tipo_cuenta, saldo, fecha_apertura, fecha_cierre, tipo_interes, limite_retiro, estado_cuenta) 
values(900000004,"ahorro",4000,"2024-05-01",NULL,"fijo",1200,"activa");
INSERT INTO cuenta(id_cuenta, tipo_cuenta, saldo, fecha_apertura, fecha_cierre, tipo_interes, limite_retiro, estado_cuenta) 
values(900000005,"corriente",130000,"2024-05-01 12:05:33",NULL,"variable",12000,"activa");
INSERT INTO cuenta(id_cuenta, tipo_cuenta, saldo, fecha_apertura, fecha_cierre, tipo_interes, limite_retiro, estado_cuenta) 
values(900000006,"corriente",1200,"2024-05-01 18:44:24",NULL,"fijo",250,"activa");
INSERT INTO cuenta(id_cuenta, tipo_cuenta, saldo, fecha_apertura, fecha_cierre, tipo_interes, limite_retiro, estado_cuenta) 
values(900000007,"ahorro",1450000,"2024-05-01 19:00:55",NULL,"fijo",24000,"bloqueada");
create table titularcuenta( 
id_cuenta int auto_increment,
dni_c  varchar(9) not null,
tipo_titularidad varchar(10) not null, 
primary key (id_cuenta,dni_c),
foreign key (dni_c) references clientes (dni_cliente),
check (tipo_titularidad in( "titular","autorizado"))
);
INSERT INTO titularcuenta (id_cuenta, dni_c, tipo_titularidad)
VALUES (900000001, "12345678Z", "titular");
INSERT INTO titularcuenta (id_cuenta, dni_c, tipo_titularidad)
VALUES (900000003, "87654321X", "titular");
INSERT INTO titularcuenta (id_cuenta, dni_c, tipo_titularidad)
VALUES (900000004, "23456789D", "autorizado");
INSERT INTO titularcuenta (id_cuenta, dni_c, tipo_titularidad)
VALUES (900000005, "98765432M", "autorizado");
INSERT INTO titularcuenta (id_cuenta, dni_c, tipo_titularidad)
VALUES (900000006, "34567890V", "titular");

create table transacciones ( 
id_transaccion int auto_increment,
num_cuenta_origen int  null,
num_cuenta_destino int  null,
fecha_transaccion datetime not null,
tipo_transaccion varchar(20) not null,
cantidad_transaccion decimal (15,2) not null,
estado_transaccion varchar(10) not null, 
primary key (id_transaccion),
foreign key (num_cuenta_origen) references cuenta (id_cuenta),
foreign key (num_cuenta_destino) references cuenta (id_cuenta),
check (cantidad_transaccion >=0),
check (fecha_transaccion <= sysdate()), 
check (tipo_transaccion in("deposito","retiro","transferencia","pago","bizum")),
check (estado_transaccion in ("correcta","fallida","pendiente"))
);

create table prestamos ( 
id_prestamo int auto_increment,
num_cuenta int not null,
cantidad_prestamo decimal (15,2) not null,
cantidad_a_deber decimal (15,2) not null,
tasa_de_interes decimal (5,2) not null,
plazo_meses int not null,
fecha_aprobacion datetime not null,
estado_prestamo varchar(20) not null,
primary key (id_prestamo),
foreign key (num_cuenta) references cuenta (id_cuenta),
check (estado_prestamo in("aprobado","pendiente","rechazado","pagado","vencido"))
);
INSERT INTO prestamos (num_cuenta, cantidad_prestamo, cantidad_a_deber, tasa_de_interes, plazo_meses, fecha_aprobacion, estado_prestamo)
VALUES (900000001, 5000.00, 5000.00, 5.00, 24, "2023-05-01 10:00:00", "aprobado");
INSERT INTO prestamos (num_cuenta, cantidad_prestamo, cantidad_a_deber, tasa_de_interes, plazo_meses, fecha_aprobacion, estado_prestamo)
VALUES (900000003, 8000.00, 8000.00, 4.50, 36, "2023-04-15 09:00:00", "pendiente");
INSERT INTO prestamos (num_cuenta, cantidad_prestamo, cantidad_a_deber, tasa_de_interes, plazo_meses, fecha_aprobacion, estado_prestamo)
VALUES (900000004, 2000.00, 1500.00, 3.75, 12, "2023-03-20 08:30:00", "pagado");
INSERT INTO prestamos (num_cuenta, cantidad_prestamo, cantidad_a_deber, tasa_de_interes, plazo_meses, fecha_aprobacion, estado_prestamo)
VALUES (900000005, 15000.00, 15000.00, 6.00, 48, "2023-02-25 14:00:00", "rechazado");
INSERT INTO prestamos (num_cuenta, cantidad_prestamo, cantidad_a_deber, tasa_de_interes, plazo_meses, fecha_aprobacion, estado_prestamo)
VALUES (900000006, 12000.00, 11000.00, 5.25, 60, "2023-01-05 11:00:00", "vencido");

create table sesiones (
id_sesion int auto_increment,
dni_cliente varchar(9),
dni_empleado varchar(9),
fecha_inicio datetime,
fecha_fin  datetime,
comentario varchar(50),
primary key (id_sesion),
foreign key (dni_cliente) references clientes (dni_cliente),
foreign key (dni_empleado) references empleados (dni_empleado),
check (fecha_fin >=fecha_inicio)
);

create table tarjetas ( 
num_tarjeta varchar(16) not null,
dni_titular varchar(9) not null,
num_cuenta  int not null,
tipo_tarjeta varchar (20) not null, 
fecha_vencimiento date not null,
estado_tarjeta varchar(10) not null, 
primary key (num_tarjeta),
foreign key (dni_titular) references clientes (dni_cliente),
foreign key (num_cuenta) references cuenta (id_cuenta),
check (tipo_tarjeta in ("debito","credito","monedero")),
check (estado_tarjeta in("activa","bloqueada","vencida"))
);
INSERT INTO tarjetas (num_tarjeta, dni_titular, num_cuenta, tipo_tarjeta, fecha_vencimiento, estado_tarjeta)
VALUES ("1234567890123456", "12345678Z", 900000001, "debito", "2027-05-01", "activa");
INSERT INTO tarjetas (num_tarjeta, dni_titular, num_cuenta, tipo_tarjeta, fecha_vencimiento, estado_tarjeta)
VALUES ("2345678901234567", "87654321X", 900000003, "credito", "2029-06-01", "bloqueada");
INSERT INTO tarjetas (num_tarjeta, dni_titular, num_cuenta, tipo_tarjeta, fecha_vencimiento, estado_tarjeta)
VALUES ("3456789012345678", "23456789D", 900000004, "monedero", "2028-07-01", "vencida");
INSERT INTO tarjetas (num_tarjeta, dni_titular, num_cuenta, tipo_tarjeta, fecha_vencimiento, estado_tarjeta)
VALUES ("4567890123456789", "98765432M", 900000005, "debito", "2030-08-01", "activa");
INSERT INTO tarjetas (num_tarjeta, dni_titular, num_cuenta, tipo_tarjeta, fecha_vencimiento, estado_tarjeta)
VALUES ("5678901234567890", "34567890V", 900000006, "credito", "2026-09-01", "bloqueada");

/*funcion para generar un CVV dinamico posible implementacion para una tarjeta virtual
DELIMITER $$
CREATE FUNCTION GenerarCVV() RETURNS CHAR(3)
    DETERMINISTIC BEGIN
		RETURN FLOOR(RAND() * 900) + 100;
	END$$
DELIMITER ;
SELECT GenerarCVV() AS CVV_Generado;
-- SELECT FLOOR(RAND() * 900) + 100 AS numero_aleatorio
*/
select*from clientes;
select*from sesiones;
