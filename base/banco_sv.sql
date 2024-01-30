create database banco_sv;
use banco_sv;

create table cliente (
dni_cliente varchar (9),
id_cliente int auto_increment,
nombre varchar (15),
apellido1 varchar (15),
apellido2 varchar (15),
direccion varchar (40),
num_telefono varchar (40),
primary key (dni_cliente),
unique key (id_cliente)
);

create table cuenta (
id_cuenta int auto_increment,
dni_c varchar (6),
tipo_cuenta varchar(10), -- ahorro/corriente/cheque
saldo decimal (10,2),
fecha_apertura datetime,
fecha_cierre date,
tipo_interes varchar(20),
limite_retiro decimal (10,2),
estado_cuenta varchar(10), -- activa,cerrada,bloqueada,
primary key (id_cuenta),
foreign key (dni_c) references cliente (dni_cliente),
check (fecha_apertura <=fecha_cierre), -- la fecha apertura debe ser menor o igual a la de cierre
check (tipo_cuenta in( "ahorro","corriente","cheque"))
);

create table transacciones (
id_transaccion int auto_increment,
num_cuenta_origen int,
num_cuenta_destino int,
fecha_transaccion datetime,
tipo_transaccion varchar(20), -- deposito,retiro,transferencia,pago,bizum
cantidad_transaccion decimal (10,2),
estado_transaccion varchar(10), -- correcta,fallida,pendiente
primary key (id_transaccion),
foreign key (num_cuenta_origen) references cuenta (id_cuenta),
foreign key (num_cuenta_destino) references cuenta (id_cuenta),
check (cantidad_transaccion >=0),
check (fecha_transaccion <= now()), -- la fecha no puede estar en el futuro
check (tipo_transaccion in("deposito","retiro","transferencia","pago","bizum")),
check (estado_transaccion in ("correcta","fallida","pendiente"))
);

create table beneficiarios (
id_beneficiario int auto_increment,
num_cuenta_origen int,
nombre_beneficiario varchar (20),
num_cuenta_destino int,
primary key (id_beneficiario),
foreign key (num_cuenta_origen) references cuenta (id_cuenta),
foreign key (num_cuenta_destino) references cuenta (id_cuenta)
);

create table prestamos (
id_prestamo int auto_increment,
num_cuenta int,
cantidad_prestamo decimal (10,2),
tasa_de_interes decimal (5,2),
plazo_meses int,
fecha_aprobacion datetime,
estado_prestamo varchar(20),
primary key (id_prestamo),
foreign key (num_cuenta) references cuenta (id_cuenta),
check (estado_prestamo in("aprobado","pendiente","rechazado","pagado","vencido"))
);

create table sesiones (
id_sesion int auto_increment,
dni_cliente varchar(9),
fecha_inicio datetime,
fecha_fin datetime,
primary key (id_sesion),
foreign key (dni_cliente) references cliente (dni_cliente),
check (fecha_fin >=fecha_inicio)
);

create table tarjetas (
id_tarjeta int auto_increment,
num_tarjeta varchar(16),
dni_titular varchar(9),
tipo_tarjeta varchar (20), --
fecha_vencimiento date,
estado_tarjeta varchar(10), -- activa,bloqueada,vencida
primary key (id_tarjeta),
check (tipo_tarjeta in ("debito","credito","monedero")),
check (estado_tarjeta in("activa","bloqueada","vencida"))
);
