<h1 align="center">
  <a href="http://hyperdrive.vhs.codeberg.page"><img src="https://codeberg.org/vhs/hyperdrive/blob/master/logo.png" alt="Hyperdrive plugin for WordPress" title="Hyperdrive - La forma más rápida de cargar páginas en WordPress" width="888"></a>
  <span style="clip: rect(1px, 1px, 1px, 1px); clip-path: polygon(0px 0px, 0px 0px,0px 0px, 0px 0px); position: absolute !important; white-space: nowrap; height: 1px; width: 1px; overflow: hidden;">Hyperdrive</span>
</h1>

<p align="center">
  <a href="https://packagist.org/packages/vhs/hyperdrive"><img src="https://img.shields.io/packagist/v/vhs/hyperdrive.svg?style=flat-square" alt="Packagist"></a>
  <a href="https://php.net/"><img src="https://img.shields.io/badge/php-%3E%3D%205.6-8892BF.svg?style=flat-square" alt="PHP"></a>
  <a href="https://wordpress.com/"><img src="https://img.shields.io/badge/wordpress-%3E%3D%204.6-0087BE.svg?style=flat-square" alt="WordPress"></a>
  <a href="https://travis-ci.org/vhs/hyperdrive"><img src="https://img.shields.io/travis/vhs/hyperdrive.svg?style=flat-square" alt="Travis"></a>
  <a href="https://codecov.io/gh/vhs/hyperdrive"><img src="https://img.shields.io/codecov/c/github/vhs/hyperdrive.svg?style=flat-square" alt="Codecov"></a>
</p>

<h4 align="center">La forma más rápida de cargar páginas en WordPress</h4>

<p align="center"><em>Hyperdrive es un plugin de WordPress el cual incrementa el rendimiento de un sitio web usando <a href="https://fetch.spec.whatwg.org/">estandares web modernos</a>. Basado en pruebas iniciales Hyperdrive <a href="https://hackernoon.com/putting-wordpress-into-hyperdrive-4705450dffc2">ha demostrado</a> reducir la latencia percibida al cargar el tema Twenty Seventeen en 200-300%.</em></p>

<p align="center">
  Traducciones:
  <a href="../README.md">English</a>,
  <a href="README_ru.md">ру́сский</a>
</p>

## Como funciona

Hyperdrive usa una técnica de optimización de rendimiento conocida como [Fetch Injection](https://hackcabin.com/post/managing-async-dependencies-javascript/) disponible en [navegadores compatibles](http://caniuse.com/#search=fetch). Fetch Injection aprovecha [Fetch](https://github.com/whatwg/fetch), el moderno reemplazo para Ajax.

## Instalación

Hay disponible varias formas para realizar la instalación. Utilice la opción que mejor se adapte a su nivel técnico y/o modo de trabajo.

### Sargento

Para instalar el plugin de forma manual, simplemente:

1. Suba el archivo `hyperdrive.php` al directorio `/wp-content/plugins/`,
1. Active el plugin utilizando el menú *Plugins* de WordPress.

### Teniente

Para instalar y administrar utilizando [Composer](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx) ejecute el siguiente comando desde el directorio de instalación de WP:

    composer require vhs/hyperdrive:1.0.x-dev

El comando anterior bajara la última versión beta de Hyperdrive disponible y la instalará en el directorio `/wp-content/plugins`. Ejecute `composer update` para obtener la versión más reciente.

### Commandante

Lo único que puede ser que no reconozca es [`rupa/z`](https://github.com/rupa/z/):

```shell
ssh user:pass@wordpressbox.tld
z plugins
curl -O https://raw.githubusercontent.com/vhs/hyperdrive/master/src/hyperdrive.php
wp plugin activate hyperdrive
```

## Cosas por hacer antes de la versión 1.0.0 RC.

- [ ] Sacar scripts de la cola (dequeue scripts) solo si el [Navegador es compatible con Fetch](http://caniuse.com/#search=fetch) para mantener compatibilidad con navegadores no actualizados.
- [ ] Integrar comportamientos de localización (localization behaviors) [tal como se muestra aquí](https://gist.github.com/vhs/64e8380010e43a526fb9c9ee511fad17#file-functions-php-L507).
- [ ] Probar con otros temas y reportar los errores o fallas encontrados.

## Como Contribuir

Cientos de miles de individuos y usuarios dependen de WordPress para consumir o compartir información en internet. Por esa razón Hyperdrive tiene requerimientos estrictos para hacer contribuciones a su código.

Aunque Hyperdrive tenga un alto estándard de calidad, por favor no permita que esto le impida hacer contribuciones. Nosotros evaluamos todas las contribuciones.

En lo posible los dueños de proyectos, colaboradores y contribuyentes deberán regirse por los [valores del manifiesto ágil](https://pragdave.me/blog/2014/03/04/time-to-kill-agile.html):

> - **Individuos e interacciones** por encima de procesos y Herramientas
> - **Software que funciona** por encima de Documentación Exhaustiva
> - **Colaboración con el Cliente** por encima de Negociación de Contrato, y
> - **Responder al Cambio** por encina de Seguir un Plan

### Reporte de Problemas

Hyperdrive acepta cualquier reporte de problemas. Bien sea extremadamente detallado, sin información relevante o simplemente estúpido. La información del usuario es un regalo y como tal será tratada. Niguna pregunta es estúpida, ni siquiera las realmente estúpidas.

### Contribuciones al Código (Pull requests)

Por favor abra un reporte (issue) antes de crear un PR y asegúrese que su PR este asociado a un reporte para poder cerrarlo. Este esquema establece una necesidad (el reporte) y ayuda a separar la necesidad de la implementación (el PR), resultando en soluciones más robustas.

Antes de implementar un PR por favor instale y configure [EditorConfig](http://editorconfig.org/) para su editor o IDE, esto ayuda a mantener la sintaxis de su código normalizada con la del resto del proyecto.

## Licencia

[![AGPL-3.0](https://img.shields.io/github/license/vhs/hyperdrive.svg?style=flat-square)](https://choosealicense.com/licenses/agpl-3.0/ "GNU Afferno General Public License v3.0")
