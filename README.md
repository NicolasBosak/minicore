Sistema de Comisiones de Vendedores
Un sistema web desarrollado en Laravel que permite calcular comisiones de vendedores basándose en sus ventas realizadas dentro de un rango de fechas específico.
Descripción del Proyecto
Este proyecto implementa un sistema de cálculo de comisiones para vendedores que:

Permite seleccionar un rango de fechas
Calcula automáticamente las comisiones según las reglas establecidas
Muestra un reporte detallado con estadísticas visuales
Implementa el patrón MVC de Laravel

Funcionalidades
Características Principales

Cálculo automático de comisiones por vendedor
Filtrado por rango de fechas personalizable
Reporte detallado con estadísticas visuales
Interfaz responsive y moderna
Validación de datos en tiempo real
Detalle expandible de ventas por vendedor

Reglas de Negocio

Cada vendedor tiene asignada una regla de comisión específica
Las comisiones se calculan como: Total de Ventas × Porcentaje de Comisión
Solo se consideran las ventas dentro del rango de fechas seleccionado
Los vendedores sin ventas en el período muestran comisión $0.00

Tecnologías Utilizadas

Backend: Laravel 10+
Frontend: Bootstrap 5.3, Font Awesome 6.0
Base de Datos: MySQL
Lenguaje: PHP 8.1+
Patrón: MVC (Model-View-Controller)

Instalación y Configuración
Prerrequisitos

PHP 8.1 o superior
Composer
MySQL/PostgreSQL
Node.js (opcional, para compilar assets)

Pasos de Instalación

Clonar el repositorio
git clone [https://github.com/NicolasBosak/minicore.git]
cd sistema-comisiones

Instalar dependencias
composer install

Configurar el archivo de entorno
cp .env.example .env
php artisan key:generate

Configurar la base de datos
Editar el archivo .env:
envDB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=minicore
DB_USERNAME=root
DB_PASSWORD=

Ejecutar migraciones y seeders
php artisan migrate
php artisan db:seed

Iniciar el servidor de desarrollo
php artisan serve