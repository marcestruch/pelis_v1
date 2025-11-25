# Pelis v1 🎬

Una aplicación web desarrollada en PHP para la gestión y visualización de películas y juegos. Este proyecto permite a los usuarios registrarse, iniciar sesión y gestionar su catálogo personal de contenido multimedia.

## 📋 Características

- **Autenticación de usuarios**: Sistema de registro e inicio de sesión
- **Gestión de sesiones**: Control seguro de sesiones de usuario
- **Base de datos integrada**: Almacenamiento de películas y juegos
- **Interfaz web**: Diseño responsive con header y footer reutilizables
- **Catálogo multimedia**: Organización de películas y juegos

## 🛠️ Tecnologías Utilizadas

- **PHP** - Lenguaje principal del servidor
- **MySQL** - Base de datos
- **HTML/CSS** - Frontend


## 📁 Estructura del Proyecto

```
pelis_v1/
├── index.php           # Página principal de la aplicación
├── login.php           # Página de inicio de sesión
├── registre.php        # Página de registro de usuarios
├── header.php          # Componente header reutilizable
├── footer.php          # Componente footer reutilizable
├── tancarsessio.php    # Cierre de sesión
├── database.sql        # Esquema de la base de datos
├── inserts.sql         # Datos iniciales de la base de datos
├── assets/             # Archivos estáticos (imágenes, CSS, JS)
├── uploads/            # Carpeta para archivos subidos
├── peliculas/          # Sección de películas
├── juegos/             # Sección de juegos
└── models/             # Modelos de datos (en desarrollo)
```

## 🚀 Instalación

1. **Clonar el repositorio**
   ```bash
   git clone https://github.com/marcestruch/pelis_v1.git
   cd pelis_v1
   ```

2. **Configurar la base de datos**
   - Crear una base de datos MySQL
   - Ejecutar los scripts SQL:
     ```bash
     mysql -u usuario -p nombre_bd < database.sql
     mysql -u usuario -p nombre_bd < inserts.sql
     ```

3. **Configurar el servidor web**
   - Colocar el proyecto en la raíz del servidor web (htdocs si usas XAMPP, www si usas WAMP)
   - Acceder a través del navegador: `http://localhost/pelis_v1`

## 📝 Uso

### Registro
1. Acceder a la página de registro (`registre.php`)
2. Completar el formulario con los datos requeridos
3. Se creará automáticamente una nueva cuenta

### Inicio de Sesión
1. Ir a la página de login (`login.php`)
2. Ingresar credenciales
3. Acceder al catálogo de películas y juegos

### Cierre de Sesión
- Hacer clic en la opción de logout que ejecuta `tancarsessio.php`

## 🔧 Requisitos del Sistema

- PHP 7.4 o superior
- MySQL 5.7 o superior
- Servidor web (Apache, Nginx, etc.)
- Navegador web moderno

## 📚 Estructura de la Base de Datos

El proyecto incluye scripts SQL (`database.sql` e `inserts.sql`) que configuran automáticamente:
- Tablas de usuarios
- Tablas de películas
- Tablas de juegos
- Relaciones entre entidades

## 🤝 Contribuir

Para contribuir a este proyecto:

1. Fork el repositorio
2. Crear una rama para tu feature (`git checkout -b feature/nueva-funcionalidad`)
3. Commit tus cambios (`git commit -am 'Añadir nueva funcionalidad'`)
4. Push a la rama (`git push origin feature/nueva-funcionalidad`)
5. Abrir un Pull Request

## 📄 Licencia

Este proyecto se distribuye sin licencia especificada. Para más información sobre el uso, contacta con el propietario.

## 👤 Autor

- **marcestruch** - [GitHub Profile](https://github.com/marcestruch)

## 📞 Contacto

Para preguntas o sugerencias, puedes abrir un issue en el [repositorio](https://github.com/marcestruch/pelis_v1).

---

**Última actualización:** 25 de noviembre de 2025