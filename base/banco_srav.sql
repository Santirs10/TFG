
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
id_cuenta int auto_increment, -- CREAR TRIGGER QUE TE COMPRUEBE QUE LA CUENTA ES CORRECTA Y NO AUTOINCREMENT
tipo_cuenta varchar(10) not null, -- ahorro/corriente/cheque
saldo decimal (15,2) not null,
fecha_apertura datetime not null,
fecha_cierre date,
tipo_interes varchar(20) not null,
limite_retiro decimal (15,2),
estado_cuenta varchar(10) not null, -- activa,cerrada,bloqueada,
primary key (id_cuenta),
check (fecha_apertura <=fecha_cierre), -- la fecha apertura debe ser menor o igual a la de cierre
check (tipo_cuenta in( "ahorro","corriente")),
check (estado_cuenta in ("activa","cerrada","bloqueada"))
);
create table titularcuenta(
id_cuenta int auto_increment,
dni_c  varchar(9) not null,
tipo_titularidad varchar(10) not null, -- TITULAR, AUTORIZADOS
primary key (id_cuenta,dni_c),
foreign key (dni_c) references clientes (dni_cliente),
check (tipo_titularidad in( "titular","auturizado"))
);

create table transacciones (
id_transaccion int auto_increment,
num_cuenta_origen int  null,
num_cuenta_destino int  null,
fecha_transaccion datetime not null,
tipo_transaccion varchar(20) not null, -- deposito,retiro,transferencia,pago,bizum
cantidad_transaccion decimal (15,2) not null,
estado_transaccion varchar(10) not null, -- correcta,fallida,pendiente
primary key (id_transaccion),
foreign key (num_cuenta_origen) references cuenta (id_cuenta),
foreign key (num_cuenta_destino) references cuenta (id_cuenta),
check (cantidad_transaccion >=0),
check (fecha_transaccion <= sysdate()), -- la fecha no puede estar en el futuro
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

create table sesiones (
id_sesion int auto_increment,
dni_cliente varchar(9),
dni_empleado varchar(9),
fecha_inicio datetime not null,
fecha_fin  datetime not null,
primary key (id_sesion),
foreign key (dni_cliente) references clientes (dni_cliente),
foreign key (dni_empleado) references empleados (dni_empleado),
check (fecha_fin >=fecha_inicio)
);

create table tarjetas (
num_tarjeta varchar(16) not null,
dni_titular varchar(9) not null,
num_cuenta  int not null,
tipo_tarjeta varchar (20) not null, -- debito,credito,monedero
fecha_vencimiento date not null,
estado_tarjeta varchar(10) not null, -- activa,bloqueada,vencida
primary key (num_tarjeta),
foreign key (dni_titular) references clientes (dni_cliente),
foreign key (num_cuenta) references cuenta (id_cuenta),
check (tipo_tarjeta in ("debito","credito","monedero")),
check (estado_tarjeta in("activa","bloqueada","vencida"))
);

