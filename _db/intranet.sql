-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-06-2021 a las 19:31:27
-- Versión del servidor: 10.4.13-MariaDB
-- Versión de PHP: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `intranet`
--
/* CREACION DE LA BASE DE DE DATOS PARA EL PROYECTO LIGAFF */
CREATE DATABASE IF NOT EXISTS `intranet` CHARACTER SET = utf8mb4;
USE `intranet`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes`
--
CREATE TABLE `mensajes` (
    `Id_mensaje` INT(11) NOT NULL AUTO_INCREMENT,
    `Asunto` VARCHAR(150) NOT NULL,
    `Mensaje` TEXT NOT NULL,
    `De` INT (11)NOT NULL,
    `Para` INT (11)NOT NULL,
    `Fecha` DATE NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `Leido` INT (11) NOT NULL  DEFAULT 1,
    `Estado` VARCHAR (150) NOT NULL DEFAULT 'Activo',
    PRIMARY KEY(Id_mensaje)
) ENGINE = INNODB DEFAULT CHARSET = utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--


CREATE TABLE `clientes` (
  `Id_cliente` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(150) DEFAULT NULL,
  `Representante` varchar(50) DEFAULT NULL,
  `Telefono` VARCHAR(50) DEFAULT NULL,
  `Direccion` varchar(255) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `RFC` VARCHAR(15) NOT NULL,
  `Foto` VARCHAR(255) DEFAULT 'img/cliente.jpg',
  `Estado` INT(2) NOT NULL DEFAULT 1,
  PRIMARY KEY (Id_cliente)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `Id_producto` int(11) NOT NULL AUTO_INCREMENT,
  `Producto` varchar(250) DEFAULT NULL,
  `Num_piezas` int(11) DEFAULT NULL,
  `Marca` varchar(50) DEFAULT NULL,
  `Precio` decimal(6,2) DEFAULT NULL,
  `Categoria` varchar(50) DEFAULT NULL,
  `Foto` VARCHAR(250) DEFAULT 'img/product.jpg',
  `Descripcion` text,
  `Estado` INT(2) NOT NULL DEFAULT 1,
  PRIMARY KEY(Id_producto)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `Id_proveedor` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre_empresa` varchar(50) DEFAULT NULL,
  `Telefono` VARCHAR (50) DEFAULT NULL,
  `Direccion` varchar(100) DEFAULT NULL,
  `CP` varchar(30) DEFAULT NULL,
  `RFC` varchar(50) DEFAULT NULL,
  `Foto` varchar(255) DEFAULT 'img/prov.jpg',
  `Email` varchar(50) DEFAULT NULL,
  `Estado` INT(2) NOT NULL DEFAULT 1,
  PRIMARY KEY (Id_proveedor)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios`(
    `Id_empleado` INT(11) NOT NULL AUTO_INCREMENT,
    `Nombre` VARCHAR(50) NOT NULL,
    `Apellido_p` VARCHAR(50) NOT NULL,
    `Apellido_m` VARCHAR(50) NOT NULL,
    `Fecha_nac` DATE NOT NULL,
    `RFC` VARCHAR(11) NOT NULL,
    `Sexo` VARCHAR(10) NOT NULL,
    `Calle` VARCHAR(50) NOT NULL,
    `Colonia` VARCHAR(50) NOT NULL,
    `CP` VARCHAR(5) NOT NULL,
    `Entidad` VARCHAR(50) NOT NULL,
    `Telefono` VARCHAR(20) NOT NULL,
    `Sucursal` VARCHAR(20) NOT NULL,
    `Turno` VARCHAR(15) NOT NULL,
    `Departamento` VARCHAR(25) NOT NULL,
    `Email` VARCHAR(150) NOT NULL UNIQUE,
    `Pass` VARCHAR(255) NOT NULL,
    `Fecha_reg` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `Ultima_sesion` datetime,
    `Activacion` INT (2) DEFAULT 0,
    `Token` VARCHAR(255),
    `Token_pass` VARCHAR(255),
    `Pedir_pass` VARCHAR(255),
    `Foto` VARCHAR(255) DEFAULT 'img/user.jpg',
    `Permisos` INT (2) DEFAULT 4,
    `Estado` INT(2) DEFAULT 0,
    `Cuenta` INT(2) NOT NULL DEFAULT 1,
    PRIMARY KEY(Id_empleado)
) ENGINE = INNODB DEFAULT CHARSET = utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `anuncios`
--


CREATE TABLE `anuncios` (
  `Id_anuncio` int(11) NOT NULL AUTO_INCREMENT,
  `Titulo` varchar(150) DEFAULT NULL,
  `Fecha` DATE NOT NULL DEFAULT NOW(),
  `Descripcion` TEXT NOT NULL,
  `Anuncio` TEXT NOT NULL,
  `Autor` INT(11) NOT NULL,
  `Estado` INT(11) DEFAULT 1,
  PRIMARY KEY (Id_anuncio)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `formatos`

--

CREATE TABLE `formatos` (
  `Id_doc` INT (11) NOT NULL AUTO_INCREMENT,
  `Documento` VARCHAR(150) DEFAULT NULL,
  `Extension` VARCHAR(5) DEFAULT NULL,
  `Size` INT (5) DEFAULT NULL,
  `Ruta` VARCHAR(255) DEFAULT NULL,
  `Fecha` DATE NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  `Estado` INT(2) NOT NULL DEFAULT 1,
  `Upload_by` INT (11),
  PRIMARY KEY (Id_doc)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

