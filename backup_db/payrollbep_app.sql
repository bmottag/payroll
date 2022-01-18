-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 12-01-2022 a las 09:13:20
-- Versión del servidor: 5.6.51-cll-lve
-- Versión de PHP: 7.3.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `payrollbep_app`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `app_company`
--

CREATE TABLE `app_company` (
  `id_company` int(10) NOT NULL,
  `company_name` varchar(100) NOT NULL,
  `company_contact` varchar(100) NOT NULL,
  `company_movil` varchar(12) NOT NULL,
  `company_email` varchar(70) NOT NULL,
  `company_address` text NOT NULL,
  `fk_id_city` int(10) NOT NULL,
  `company_status` tinyint(4) NOT NULL COMMENT '1:Acrive;2:Inactive',
  `company_gst` varchar(15) NOT NULL,
  `start_date` date NOT NULL,
  `company_logo` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `app_company`
--

INSERT INTO `app_company` (`id_company`, `company_name`, `company_contact`, `company_movil`, `company_email`, `company_address`, `fk_id_city`, `company_status`, `company_gst`, `start_date`, `company_logo`) VALUES
(1, 'MOTTACLICK', 'BENJAMIN MOTTA', '4034089921', 'mottaclick@gmail.com', '', 1, 1, '', '2021-08-09', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `app_param_cities`
--

CREATE TABLE `app_param_cities` (
  `id_city` int(10) NOT NULL,
  `fk_id_contry` int(10) NOT NULL,
  `city` varchar(100) NOT NULL,
  `time_zona` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `app_param_cities`
--

INSERT INTO `app_param_cities` (`id_city`, `fk_id_contry`, `city`, `time_zona`) VALUES
(1, 1, 'Calgary', 'GMT-6'),
(2, 1, 'Edmonton', 'GMT-6'),
(3, 1, 'Vancouver', 'GMT-7'),
(4, 1, 'Toronto', 'GMT-4'),
(5, 1, 'Montreal', 'GMT-4'),
(6, 2, 'New York', 'GMT-4'),
(7, 2, 'Los Angeles', 'GMT-7'),
(8, 2, 'Chicago', 'GMT-5');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `app_param_countries`
--

CREATE TABLE `app_param_countries` (
  `id_country` int(10) NOT NULL,
  `country` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `app_param_countries`
--

INSERT INTO `app_param_countries` (`id_country`, `country`) VALUES
(1, 'CANADA'),
(2, 'USA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `invoice`
--

CREATE TABLE `invoice` (
  `id_invoice` int(10) NOT NULL,
  `fk_id_param_client_i` int(10) NOT NULL,
  `invoice_number` int(10) NOT NULL,
  `invoice_date` date NOT NULL,
  `terms` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `invoice_services`
--

CREATE TABLE `invoice_services` (
  `id_invoice_service` int(10) NOT NULL,
  `fk_id_invoice` int(10) NOT NULL,
  `service` text NOT NULL,
  `description` text NOT NULL,
  `quantity` float NOT NULL,
  `rate` float NOT NULL,
  `value` float NOT NULL,
  `invoice_service_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1:Active;2:Inactive'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `param_client`
--

CREATE TABLE `param_client` (
  `id_param_client` int(10) NOT NULL,
  `fk_id_app_company` int(10) NOT NULL,
  `param_client_name` varchar(100) NOT NULL,
  `param_client_contact` varchar(100) NOT NULL,
  `param_client_movil` varchar(12) NOT NULL,
  `param_client_email` varchar(70) NOT NULL,
  `param_client_address` text NOT NULL,
  `param_client_status` tinyint(4) NOT NULL COMMENT '1:Acrive;2:Inactive',
  `date_issue` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `param_company_taxes`
--

CREATE TABLE `param_company_taxes` (
  `id_param_company_taxes` int(10) NOT NULL,
  `fk_id_app_company_t` int(10) NOT NULL,
  `taxes_description` varchar(50) NOT NULL,
  `taxes_value` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `param_jobs`
--

CREATE TABLE `param_jobs` (
  `id_job` int(10) NOT NULL,
  `fk_id_param_client` int(10) NOT NULL,
  `job_description` varchar(250) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1' COMMENT '1: Active; 2: Inactive'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `param_menu`
--

CREATE TABLE `param_menu` (
  `id_menu` int(3) NOT NULL,
  `menu_name` varchar(50) NOT NULL,
  `menu_url` varchar(200) NOT NULL DEFAULT '0',
  `menu_icon` varchar(50) NOT NULL,
  `menu_order` int(1) NOT NULL,
  `menu_type` tinyint(1) NOT NULL COMMENT '1:Left; 2:Top',
  `menu_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1:Active; 2:Inactive'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `param_menu`
--

INSERT INTO `param_menu` (`id_menu`, `menu_name`, `menu_url`, `menu_icon`, `menu_order`, `menu_type`, `menu_status`) VALUES
(1, 'Settings', '', 'fa-cog', 2, 2, 1),
(2, '', '', 'fa-user', 6, 2, 1),
(3, 'Manage System Acces', '', 'fa-cogs', 5, 2, 1),
(4, 'Invoice', 'invoice', 'fa-book ', 4, 1, 1),
(5, 'Reports', 'settings/procesos', 'fa-list', 1, 2, 1),
(10, 'Time Stamp', 'payroll/add_payroll', 'fa-clock', 2, 1, 1),
(11, 'SUPER ADMIN', 'dashboard/super_admin', 'fa-chess-knight', 1, 1, 1),
(12, 'Dashboard ADMIN', 'dashboard/admin', 'fa-tachometer-alt', 1, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `param_menu_access`
--

CREATE TABLE `param_menu_access` (
  `id_access` int(3) NOT NULL,
  `fk_id_menu` int(3) NOT NULL,
  `fk_id_link` int(3) NOT NULL,
  `fk_id_role` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `param_menu_access`
--

INSERT INTO `param_menu_access` (`id_access`, `fk_id_menu`, `fk_id_link`, `fk_id_role`) VALUES
(15, 1, 6, 1),
(6, 1, 6, 99),
(16, 1, 15, 1),
(12, 1, 15, 99),
(10, 1, 18, 1),
(21, 1, 18, 99),
(7, 1, 19, 1),
(22, 1, 19, 99),
(25, 1, 20, 1),
(24, 1, 20, 99),
(8, 2, 4, 1),
(1, 2, 4, 99),
(9, 2, 5, 1),
(2, 2, 5, 99),
(3, 3, 1, 99),
(4, 3, 2, 99),
(5, 3, 3, 99),
(13, 3, 16, 99),
(14, 3, 17, 99),
(26, 4, 0, 1),
(23, 4, 0, 99),
(17, 10, 0, 1),
(11, 10, 0, 99),
(18, 11, 0, 99),
(19, 12, 0, 1),
(20, 12, 0, 99);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `param_menu_links`
--

CREATE TABLE `param_menu_links` (
  `id_link` int(3) NOT NULL,
  `fk_id_menu` int(3) NOT NULL,
  `link_name` varchar(100) NOT NULL,
  `link_url` varchar(200) NOT NULL,
  `link_icon` varchar(50) NOT NULL,
  `order` int(1) NOT NULL,
  `date_issue` datetime NOT NULL,
  `link_status` tinyint(1) NOT NULL COMMENT '1:Active;2:Inactive',
  `link_type` tinyint(1) NOT NULL COMMENT '1:System URL;2:Complete URL; 3:Divider; 4:Complete URL, Videos; 5:Complete URL, Manuals'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `param_menu_links`
--

INSERT INTO `param_menu_links` (`id_link`, `fk_id_menu`, `link_name`, `link_url`, `link_icon`, `order`, `date_issue`, `link_status`, `link_type`) VALUES
(1, 3, 'Menu Links', 'access/menu', 'fa-link', 3, '2021-02-16 06:21:56', 1, 1),
(2, 3, 'Submenu Links', 'access/links', 'fa-link', 4, '2021-02-16 06:21:56', 1, 1),
(3, 3, 'Role Access', 'access/role_access', 'fa-puzzle-piece', 5, '2021-02-16 06:21:56', 1, 1),
(4, 2, 'Change Password', 'users', 'fa-lock', 1, '2021-02-16 06:28:04', 1, 1),
(5, 2, 'Log Out', 'menu/salir', 'fa-sign-out-alt', 2, '2021-02-16 06:29:08', 1, 1),
(6, 1, 'Users', 'settings/users', 'fa-users', 1, '2021-02-16 08:39:49', 1, 1),
(15, 1, 'Jobs', 'settings/job', 'fa-briefcase', 5, '2021-06-10 09:50:11', 1, 1),
(16, 3, 'APP Companies', 'access/companies', 'fa-puzzle-piece', 1, '2021-06-12 12:47:25', 1, 1),
(17, 3, 'DIVIDER', 'DIVIDER', 'fa-divider', 2, '2021-06-12 12:50:15', 1, 3),
(18, 1, 'DIVIDER', 'DIVIDER', 'fa-divider', 3, '2021-07-04 10:27:22', 1, 3),
(19, 1, 'Clients', 'settings/param_clients', 'fa-building', 4, '2021-07-04 10:35:57', 1, 1),
(20, 1, 'Company Information', 'settings/company', 'fa-puzzle-piece', 2, '2021-07-19 15:54:39', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `param_role`
--

CREATE TABLE `param_role` (
  `id_role` int(1) NOT NULL,
  `role_name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `style` varchar(50) NOT NULL,
  `dashboard_url` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `param_role`
--

INSERT INTO `param_role` (`id_role`, `role_name`, `description`, `style`, `dashboard_url`) VALUES
(1, 'Administrator', 'Se encarga de la configuracion del sistema. Cargar tabla de Usuarios.', 'text-success', 'dashboard/admin'),
(2, 'Worker', 'Solo tiene acceso al dashboard, para ver listado de visitas', 'text-violeta', 'dashboard/admin'),
(99, 'SUPER ADMIN', 'Con acceso a todo el sistema, encargaado de tablas parametricas del sistema.', 'text-danger', 'dashboard/super_admin');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `payroll`
--

CREATE TABLE `payroll` (
  `id_payroll` int(10) NOT NULL,
  `fk_id_user` int(10) NOT NULL,
  `fk_id_job` int(4) NOT NULL,
  `task_description` text NOT NULL,
  `start` datetime NOT NULL,
  `finish` datetime NOT NULL,
  `working_time` varchar(30) DEFAULT '0',
  `working_hours` float DEFAULT '0',
  `regular_hours` float DEFAULT '0',
  `overtime_hours` float DEFAULT '0',
  `observation` text NOT NULL,
  `latitude_start` double DEFAULT '0',
  `longitude_start` double DEFAULT '0',
  `address_start` text,
  `latitude_finish` double DEFAULT '0',
  `longitude_finish` double DEFAULT '0',
  `address_finish` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `id_user` int(10) NOT NULL,
  `fk_id_app_company_u` int(10) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `log_user` varchar(50) NOT NULL,
  `movil` varchar(12) NOT NULL,
  `email` varchar(70) DEFAULT NULL,
  `password` varchar(50) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0' COMMENT '0: newUser; 1:active; 2:inactive',
  `fk_id_user_role` int(1) NOT NULL DEFAULT '7' COMMENT '99: Super Admin;',
  `photo` varchar(250) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id_user`, `fk_id_app_company_u`, `first_name`, `last_name`, `log_user`, `movil`, `email`, `password`, `status`, `fk_id_user_role`, `photo`) VALUES
(1, 1, 'Benjamin', 'Motta', 'Bmottag', '4034089921', 'benmotta@gmail.com', '67b56225f00ae43560fc471bcf3bb820', 1, 99, 'images/users/thumbs/1.jpg'),
(2, 1, 'BRYAN', 'SANCHEZ', 'bsanchez', '3213949317', 'bsanchez1507@gmail.com', '23c796ddcd868728df2d1e058062daf4', 1, 99, 'images/users/thumbs/2.png'),
(3, 1, 'EDWIN', 'SANCHEZ', 'esanchez', '3006411061', 'esanchez1988@gmail.com', '3e61005a7a0e3ed80d8ceede62b2f83c', 1, 99, 'images/users/thumbs/3.png'),
(4, 1, 'FABIAN', 'VILLAMIL', 'fito1982', '4162490927', 'fito@gmail.com', 'ffd50cc312cc363b88db921c92e6d166', 1, 1, '');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `app_company`
--
ALTER TABLE `app_company`
  ADD PRIMARY KEY (`id_company`),
  ADD KEY `fk_id_city` (`fk_id_city`);

--
-- Indices de la tabla `app_param_cities`
--
ALTER TABLE `app_param_cities`
  ADD PRIMARY KEY (`id_city`),
  ADD KEY `fk_id_contry` (`fk_id_contry`);

--
-- Indices de la tabla `app_param_countries`
--
ALTER TABLE `app_param_countries`
  ADD PRIMARY KEY (`id_country`);

--
-- Indices de la tabla `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`id_invoice`),
  ADD KEY `fk_id_param_client_i` (`fk_id_param_client_i`);

--
-- Indices de la tabla `invoice_services`
--
ALTER TABLE `invoice_services`
  ADD PRIMARY KEY (`id_invoice_service`),
  ADD KEY `fk_id_invoice` (`fk_id_invoice`);

--
-- Indices de la tabla `param_client`
--
ALTER TABLE `param_client`
  ADD PRIMARY KEY (`id_param_client`),
  ADD KEY `fk_id_app_company` (`fk_id_app_company`);

--
-- Indices de la tabla `param_company_taxes`
--
ALTER TABLE `param_company_taxes`
  ADD PRIMARY KEY (`id_param_company_taxes`),
  ADD KEY `fk_id_app_company_t` (`fk_id_app_company_t`);

--
-- Indices de la tabla `param_jobs`
--
ALTER TABLE `param_jobs`
  ADD PRIMARY KEY (`id_job`),
  ADD KEY `fk_id_client_pj` (`fk_id_param_client`);

--
-- Indices de la tabla `param_menu`
--
ALTER TABLE `param_menu`
  ADD PRIMARY KEY (`id_menu`),
  ADD KEY `menu_type` (`menu_type`);

--
-- Indices de la tabla `param_menu_access`
--
ALTER TABLE `param_menu_access`
  ADD PRIMARY KEY (`id_access`),
  ADD UNIQUE KEY `indice_principal` (`fk_id_menu`,`fk_id_link`,`fk_id_role`),
  ADD KEY `fk_id_menu` (`fk_id_menu`),
  ADD KEY `fk_id_role` (`fk_id_role`),
  ADD KEY `fk_id_link` (`fk_id_link`);

--
-- Indices de la tabla `param_menu_links`
--
ALTER TABLE `param_menu_links`
  ADD PRIMARY KEY (`id_link`),
  ADD KEY `fk_id_menu` (`fk_id_menu`),
  ADD KEY `link_type` (`link_type`);

--
-- Indices de la tabla `param_role`
--
ALTER TABLE `param_role`
  ADD PRIMARY KEY (`id_role`);

--
-- Indices de la tabla `payroll`
--
ALTER TABLE `payroll`
  ADD PRIMARY KEY (`id_payroll`),
  ADD KEY `fk_id_user` (`fk_id_user`),
  ADD KEY `fk_id_job` (`fk_id_job`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `log_user` (`log_user`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `perfil` (`fk_id_user_role`),
  ADD KEY `fk_id_app_company_u` (`fk_id_app_company_u`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `app_company`
--
ALTER TABLE `app_company`
  MODIFY `id_company` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `app_param_cities`
--
ALTER TABLE `app_param_cities`
  MODIFY `id_city` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `app_param_countries`
--
ALTER TABLE `app_param_countries`
  MODIFY `id_country` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `invoice`
--
ALTER TABLE `invoice`
  MODIFY `id_invoice` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `invoice_services`
--
ALTER TABLE `invoice_services`
  MODIFY `id_invoice_service` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `param_client`
--
ALTER TABLE `param_client`
  MODIFY `id_param_client` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `param_company_taxes`
--
ALTER TABLE `param_company_taxes`
  MODIFY `id_param_company_taxes` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `param_jobs`
--
ALTER TABLE `param_jobs`
  MODIFY `id_job` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `param_menu`
--
ALTER TABLE `param_menu`
  MODIFY `id_menu` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `param_menu_access`
--
ALTER TABLE `param_menu_access`
  MODIFY `id_access` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `param_menu_links`
--
ALTER TABLE `param_menu_links`
  MODIFY `id_link` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `param_role`
--
ALTER TABLE `param_role`
  MODIFY `id_role` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT de la tabla `payroll`
--
ALTER TABLE `payroll`
  MODIFY `id_payroll` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `app_company`
--
ALTER TABLE `app_company`
  ADD CONSTRAINT `app_company_ibfk_1` FOREIGN KEY (`fk_id_city`) REFERENCES `app_param_cities` (`id_city`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `app_param_cities`
--
ALTER TABLE `app_param_cities`
  ADD CONSTRAINT `app_param_cities_ibfk_1` FOREIGN KEY (`fk_id_contry`) REFERENCES `app_param_countries` (`id_country`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `invoice`
--
ALTER TABLE `invoice`
  ADD CONSTRAINT `invoice_ibfk_1` FOREIGN KEY (`fk_id_param_client_i`) REFERENCES `param_client` (`id_param_client`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `invoice_services`
--
ALTER TABLE `invoice_services`
  ADD CONSTRAINT `invoice_services_ibfk_1` FOREIGN KEY (`fk_id_invoice`) REFERENCES `invoice` (`id_invoice`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `param_client`
--
ALTER TABLE `param_client`
  ADD CONSTRAINT `param_client_ibfk_1` FOREIGN KEY (`fk_id_app_company`) REFERENCES `app_company` (`id_company`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `param_company_taxes`
--
ALTER TABLE `param_company_taxes`
  ADD CONSTRAINT `param_company_taxes_ibfk_1` FOREIGN KEY (`fk_id_app_company_t`) REFERENCES `app_company` (`id_company`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `param_jobs`
--
ALTER TABLE `param_jobs`
  ADD CONSTRAINT `param_jobs_ibfk_1` FOREIGN KEY (`fk_id_param_client`) REFERENCES `param_client` (`id_param_client`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `param_menu_access`
--
ALTER TABLE `param_menu_access`
  ADD CONSTRAINT `param_menu_access_ibfk_1` FOREIGN KEY (`fk_id_role`) REFERENCES `param_role` (`id_role`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `param_menu_access_ibfk_2` FOREIGN KEY (`fk_id_menu`) REFERENCES `param_menu` (`id_menu`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `param_menu_links`
--
ALTER TABLE `param_menu_links`
  ADD CONSTRAINT `param_menu_links_ibfk_1` FOREIGN KEY (`fk_id_menu`) REFERENCES `param_menu` (`id_menu`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `payroll`
--
ALTER TABLE `payroll`
  ADD CONSTRAINT `payroll_ibfk_1` FOREIGN KEY (`fk_id_job`) REFERENCES `param_jobs` (`id_job`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
