# FerroProject - Página Web

El proyecto consiste en la página web de una carpintería metálica.

Esta proporciona información clave sobre la empresa, sus trabajadores y sus servicios. Además, contará con funcionalidades para la gestión interna de la empresa, como un chat para los trabajadores, una lista de tareas y un generador de facturas.

La web está construida con **Laravel - Jetstream** y **Tailwind CSS**.

## Características

### Para los usuarios:
- **Página principal:** Información relevante sobre la empresa.
- **Galería de trabajos realizados:** Visualización de imágenes de proyectos anteriores.
- **Blog de noticias y posts:** Sección de publicaciones sobre los últimos proyectos y temas relacionados.
- **Formulario de contacto:** Los usuarios podrán ponerse en contacto mediante un formulario.

### Para los trabajadores:
- **Chat interno:** Comunicación directa entre los miembros del equipo.
- **Lista de tareas:** Asignación y seguimiento de tareas para los empleados.
- **Generador de facturas:** Herramienta para crear facturas de forma automática.
- **Creador de bocetos:** Pizarra o cuaderno donde poder hacer bocetos.

## Info Adicional

El usuario tiene un campo **rol**, que otorgará diferentes permisos dependiendo de su valor:

- **0**: Cliente 
- **1**: Trabajador
- **2**: Trabajador con + permisos
- **3**: Admin

#
Las tareas tienen un campo "**priority**", siendo **5** la más importante y **0** la menos. 

También, un campo "**done**", que indicará si la tarea se ha realizado o no.

#

Cosas que faltan:
- Añadir verificación de correo electrónico.
- Solucionar la **vista de los vídeos** (si es posible)
- Terminar la **Landing Page**
- Crear un **logotipo** de empresa
- Añadir **accesibilidad** a la página 
- **Repasar** la página por completo

Último:
- **Desplegar** el proyecto en AWS
- Meter la lógica del **formulario** (configurar AWS SES)
- Comprar un dominio y configurarlo
- Añadir el login con Google
- Añadir datos "reales"
- Terminar la **documentación**.

#

Fecha de finalización prevista: **01/06/2025**