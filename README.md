# SistemaRolesPermisos

El Sistema_base es un sistema de usuarios, roles y permisos realizado en Laravel 7 para el Ente Provincial de Energía del Neuquén.

La finalidad del mismo es el de ser utilizado como base para la implementación de sistemas más complejos.

## Installation

Para la instalación del mismo, se debe tener instalado [Composer](https://getcomposer.org/).
Descargar el archivo sistema_base en una carpeta y luego correr el comando:

```bash
composer update
```

## Usage

Para utilizar la herramienta hay que segir una serie de pasos:

1- Configurar en el archivo .env la información correspondiente a la base de datos a utilizar y el servidor de emails.

```php
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=[Nombre de la base de datos a utilizar]
DB_USERNAME=[usuario]
DB_PASSWORD=[contraseña]

MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=null
MAIL_FROM_NAME="${APP_NAME}"
```
2- Ejecutar las migraciones en la base de datos y los seeders:

```bash
php artisan migrate:fresh --seed
```
3- Ejecutar el servidor e ingresar con el usuario **admin** y contraseña **admin**

## Consideraciones
Agregar los permisos corresponde al programador. Para ello debe agregarlos directamente en la base de datos con el slug correspondiente en la tabla permissions. También puede hacerlo desde el archivo

```
database> seed> PermisosInitSeed.php
``` 

La contraseña del administrador también puede modficarse desde **PermisosInitSeed-php**

## License
MIT License

Copyright (c) [2020] [fullname]

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
