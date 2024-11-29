<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# Laravel Bookingtrap Boilerplate
Este repositorio aloja un boilerplate con toda la lógica que maneja el Front de las agencias.

## Setup

### 1.- Descargar e Instalar XAMPP
- Ve al sitio oficial de [XAMPP](https://www.apachefriends.org/es/index.html) y descarga la última versión.
- Durante la instalación, asegúrate de incluir PHP en la configuración
- Una vez instalado, verifica que XAMPP esté funcionando iniciando los servicios de Apache y MySQL desde el panel de control de XAMPP.
- Verifica la versión de PHP usando CMD
```bash
php -v
```

### 2.- Instalar Composer
- Descarga [Composer](https://getcomposer.org/download/) en su versión .exe
- Durante la instalación, selecciona el ejecutable de PHP que se encuentra en el directorio de XAMPP, debe de estar en la ruta
```bash
C:\xampp\php\php.exe
```
- Verifica que Composer se haya instalado correctamente ejecutando en la consola:
```bash
composer -v
```

### 3.- Clonar el Proyecto
- Navega hacia el directorio htdocs de XAMPP y realiza la clonación del proyecto
```bash
cd C:\xampp\htdocs\
git clone https://github.com/programadorbt7/booking-boilerplate.git
```
- Ingresa a la ruta del proyecto e instala las dependencias usando composer
```bash
cd C:\xampp\htdocs\booking-boiler-plate
git clone https://github.com/programadorbt7/booking_boilerplate
composer install
```
- Ejecuta el proyecto usando artisan
```bash
php artisan serve
```
El proyecto debería ejecutarse en la dirección local [127.0.0.1:8000](http://127.0.0.1:8000/)