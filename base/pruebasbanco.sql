use banco_sv;
select*from cliente;

Drop function VerificarTarjetaCredito;

DELIMITER $$
CREATE FUNCTION VerificarTarjetaCredito(numero_tarjeta VARCHAR(16)) RETURNS VARCHAR(50)
    DETERMINISTIC BEGIN
		DECLARE suma INT DEFAULT 0;
		DECLARE longitud INT;
		DECLARE i INT DEFAULT 1;
		DECLARE digito INT;
		SET longitud = CHAR_LENGTH(numero_tarjeta);
		WHILE (i <= longitud) DO
			SET digito = CAST(SUBSTRING(numero_tarjeta, longitud - i + 1, 1) AS UNSIGNED);
			IF (i MOD 2 = 0) THEN
				SET digito = digito * 2;
				IF (digito > 9) THEN
					SET digito = digito - 9;
				END IF;
			END IF;
			SET suma = suma + digito;
			SET i = i + 1;
		END WHILE;
		IF (suma MOD 10 = 0) THEN
			RETURN 'Número de Tarjeta Válido';
		ELSE
			RETURN 'Número de Tarjeta Inválido';
		END IF;
	END$$
DELIMITER ;


select VerificarTarjetaCredito(4018645749030718);



DELIMITER $$
CREATE FUNCTION ComprobarTarjeta(numero_tarjeta VARCHAR(16)) RETURNS VARCHAR(100)
    DETERMINISTIC BEGIN
		DECLARE mensaje VARCHAR(50);
		DECLARE tipo_tarjeta VARCHAR(20);
		DECLARE primeros_digitos VARCHAR(6);
		DECLARE suma INT DEFAULT 0;
		DECLARE longitud INT;
		DECLARE i INT DEFAULT 1;
		DECLARE digito INT;

		SET longitud = CHAR_LENGTH(numero_tarjeta);

		-- Verificar validez del número de tarjeta usando algoritmo de Luhn
		WHILE (i <= longitud) DO
			SET digito = CAST(SUBSTRING(numero_tarjeta, longitud - i + 1, 1) AS UNSIGNED);
			IF (i MOD 2 = 0) THEN
				SET digito = digito * 2;
				IF (digito > 9) THEN
					SET digito = digito - 9;
				END IF;
			END IF;
			SET suma = suma + digito;
			SET i = i + 1;
		END WHILE;

		IF (suma MOD 10 = 0) THEN
			SET mensaje = 'Válido';
		ELSE
			SET mensaje = 'Inválido';
		END IF;

		-- Identificar tipo de tarjeta basado en los primeros dígitos
		SET primeros_digitos = LEFT(numero_tarjeta, 6);
		IF (primeros_digitos LIKE '4%') THEN
			SET tipo_tarjeta = 'Visa';
		ELSEIF (primeros_digitos BETWEEN '510000' AND '559999') THEN
			SET tipo_tarjeta = 'Mastercard';
		ELSEIF (primeros_digitos BETWEEN '222100' AND '272099') THEN
			SET tipo_tarjeta = 'Mastercard';
		ELSEIF (primeros_digitos BETWEEN '340000' AND '349999') THEN
			SET tipo_tarjeta = 'American Express';
		ELSE
			SET tipo_tarjeta = 'Desconocido';
		END IF;

		RETURN CONCAT('Estado: ', mensaje, ', Tipo de Tarjeta: ', tipo_tarjeta);
	END$$
DELIMITER ;
select ComprobarTarjeta(4018645749030718) as Tarjeta;



 -- FUNCIONES QUE SE PUEDEN IMPLEMENTAR 
/*funcion para generar un CVV dinamico posible implementacion para una tarjeta virtual*/
DELIMITER $$
CREATE FUNCTION GenerarCVV() RETURNS CHAR(3)
    DETERMINISTIC BEGIN
		RETURN FLOOR(RAND() * 900) + 100;
	END$$
DELIMITER ;
SELECT GenerarCVV() AS CVV_Generado;
-- SELECT FLOOR(RAND() * 900) + 100 AS numero_aleatorio


DELIMITER $$
CREATE FUNCTION ComprobarTarjeta(numero_tarjeta VARCHAR(16)) RETURNS VARCHAR(100)
    DETERMINISTIC BEGIN
		DECLARE mensaje VARCHAR(50);
		DECLARE tipo_tarjeta VARCHAR(20);
		DECLARE primeros_digitos VARCHAR(6);
		DECLARE suma INT DEFAULT 0;
		DECLARE longitud INT;
		DECLARE i INT DEFAULT 1;
		DECLARE digito INT;

		SET longitud = CHAR_LENGTH(numero_tarjeta);

		-- Verificar validez del número de tarjeta usando algoritmo de Luhn
		WHILE (i <= longitud) DO
			SET digito = CAST(SUBSTRING(numero_tarjeta, longitud - i + 1, 1) AS UNSIGNED);
			IF (i MOD 2 = 0) THEN
				SET digito = digito * 2;
				IF (digito > 9) THEN
					SET digito = digito - 9;
				END IF;
			END IF;
			SET suma = suma + digito;
			SET i = i + 1;
		END WHILE;

		IF (suma MOD 10 = 0) THEN
			SET mensaje = 'Número de Tarjeta Válido';
		ELSE
			SET mensaje = 'Número de Tarjeta Inválido';
		END IF;

		-- Identificar tipo de tarjeta basado en los primeros dígitos
		SET primeros_digitos = LEFT(numero_tarjeta, 6);
		IF (primeros_digitos LIKE '4%') THEN
			SET tipo_tarjeta = 'Visa';
		ELSEIF (primeros_digitos BETWEEN '510000' AND '559999') THEN
			SET tipo_tarjeta = 'Mastercard';
		ELSEIF (primeros_digitos BETWEEN '222100' AND '272099') THEN
			SET tipo_tarjeta = 'Mastercard';
		ELSEIF (primeros_digitos BETWEEN '340000' AND '349999') THEN
			SET tipo_tarjeta = 'American Express';
		ELSE
			SET tipo_tarjeta = 'Desconocido';
		END IF;

		RETURN CONCAT('Estado: ', mensaje, ', Tipo de Tarjeta: ', tipo_tarjeta);
	END$$
DELIMITER ;
select ComprobarTarjeta(4018645749030718) as Tarjeta;


select * from clientes;
