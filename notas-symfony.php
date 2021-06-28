<!-- 

DOCUMENTACIÓN: https://symfony.com/legacy/doc/jobeet/1_4/es/01?orm=Doctrine

php symfony generate:app frontend -> crea una aplicación dentro de la carpeta app.

SVN -> permite el control de versiones de la aplicación que se quiere desarrollar (hace la misma función que git).

ORM -> es un modelo de programación que permite mapear las estrcuturas de una base de datos relacional.

Doctrine o propel -> herramienta ORM o Mapeador, permite que la información de la base de datos (relacional) sea mapeada a un modelo de objetos.

php symfony doctrine:build-schema -> comando que genera el schema de la base de datos relacionada a la aplicación

YAML -> YAML es un lenguaje sencillo para describir los datos (strings, integers, dates, arrays, y hashes).

php symfony configure:database "mysql:host=localhost;dbname=dbName" nombreUsuario password -> Comando para configurar la base de datos de la aplicación. Por defecto los 2 ultimos atributos son root root

php symfony doctrine:build --model -> este comando genera el modelo a partir del schema

php symfony doctrine:build --sql -> genera e inserta el SQL a partir del modelo creado. Se encuentra en el directorio data/sql/

php symfony doctrine:insert-sql -> crea las tablas en la base de datos

help -> las tareas symfony pueden tener argumentos y opciones. Cada tarea viene con un mensaje de ayuda que se puede mostrar ejecutando la tarea help. Ejemplo: php symfony help doctrine:insert-sql

------------------------------------------------

Los valores de las columnas de un registro se pueden manipular con el modelo de objetos mediante uso de algunos métodos get*() y métodos set*()
EJEMPLO:

$job = new JobeetJob();
$job->setPosition('Web developer');
$job->save();
 
echo $job->getPosition();
 
$job->delete();

------------------------------------------------

Se pueden definir claves foráneas directamente por la vinculación de objetos:
EJEMPLO:

$category = new JobeetCategory();
$category->setName('Programming');
 
$job = new JobeetJob();
$job->setCategory($category);

------------------------------------------------

php symfony doctrine:build --all --no-confirmation -> genera formularios y validadores para el modelo de clases

------------------------------------------------

Hay tres tipodes de datos:
- Datos iniciales: necesarios para que la aplicación funcione.
- Datos de prueba: necesarios para que la aplicación sea probada.
- Datos del usuario: creados por los usuarios en la vida normal de la aplicación.

------------------------------------------------

php symfony doctrine:data-load -> carga los datos iniciales en la base de datos. Estos son los valores que se encuentran dentro de los archivos .yml en el directorio data\fixtures\
La tarea doctrine:build --all --and-load es un atajo para la tarea doctrine:build --all seguida de la tarea doctrine:data-load.

------------------------------------------------

Definición de módulo en Symfony.
Un módulo es un conjunto de código PHP auto-contenido que representa una característica de la aplicación, o un conjunto de manipulaciones que el usuario puede hacer sobre un objeto del modelo.

php symgony doctrine:generate-module --with-show --non-verbose-templates nombreApp nombreModulo nombreModelo

Ejemplo:
php symfony doctrine:generate-module --with-show --non-verbose-templates frontend job JobeetJob

La tarea doctrine:generate-module genera módulo job en la aplicación frontend para el modelo JobeetJob. Como con la mayoría de las tareas symfony, algunos archivos y directorios se han creado para ti bajo el directorio apps/frontend/modules/job/

El archivo actions.class.php define todas las acciones disponibles para el módulo:

- index: muestra los registros de la tabla
- show: muestra los campos de un registro
- new: muestra un formulario para crear un nuevo registro
- create: crea un nuevo registro
- edit: muestra un formulario para editar un registro existente
- update: actualiza un registro con los valores que envió el usuario
- delete: borra un registro de la tabla

------------------------------------------------

Patrón de diseño MVC
Define una manera de organizar el código de acuerdo a su naturaleza. Separa el código en tres capas:

- la capa modelo: define la lógica de negocio (la base de datos pertenece a esta capa). Ya sabes que Symfony guarda todas las clases y archivos relacionados con el modelo en el directorio lib/model/.
- la capa vista: es con lo que el usuario interactúa (un motor de plantillas es parte de esta capa). En Symfony, la vista es principalmente la capa de plantillas PHP. Estas son guardadas en varios directorios templates/ como veremos más adelante en el día de hoy.
- la capa controlador: es la pieza de código que llama al Modelo para obtener algunos datos que le pasa a la Vista para la presentación al cliente.

Helpers: un helper es una función, definida por symfony, que puede tener parámetros y devolver código HTML.

view.yml -> El archivo view.yml establece la configuración por defecto para todas las plantillas de la aplicación. Por ejemplo, para las hojas de estilo define un array de archivos de estilo para incluir en todas las páginas de la aplicación (la inclusión se hace por el helper include_stylesheets()).

------------------------------------------------

Principios de configuración en Symfony

Para los muchos archivos de configuración de Symfony, la misma configuración se puede definir en diferentes niveles:

La configuración por defecto se encuentra en el framework
La configuración global para el proyecto (en config/)
La configuración local de una aplicación (en apps/APP/config/)
La configuración local limitada a un módulo (en apps/APP/modules/MODULE/config/)
En tiempo de ejecución, la configuración del sistema combina todos los valores de los diferentes archivos si existen y guarda en la memoria cache el resultado para un mejor rendimiento.

------------------------------------------------

La Petición
La clase sfWebRequest envuelve a los arrays PHP globales $_SERVER, $_COOKIE, $_GET, $_POST, y $_FILES:

NOMBRE DEL MÉTODO   ..  PHP EQUIVALENTE
getMethod()         ->	$_SERVER['REQUEST_METHOD']
getUri()            ->	$_SERVER['REQUEST_URI']
getReferer()        ->	$_SERVER['HTTP_REFERER']
getHost()           ->	$_SERVER['HTTP_HOST']
getLanguages()      ->	$_SERVER['HTTP_ACCEPT_LANGUAGE']
getCharsets()       ->	$_SERVER['HTTP_ACCEPT_CHARSET']
isXmlHttpRequest()  ->	$_SERVER['X_REQUESTED_WITH'] == 'XMLHttpRequest'
getHttpHeader()     ->	$_SERVER
getCookie()         ->	$_COOKIE
isSecure()          ->	$_SERVER['HTTPS']
getFiles()          ->	$_FILES
getGetParameter()   ->	$_GET
getPostParameter()  ->	$_POST
getUrlParameter()   ->	$_SERVER['PATH_INFO']
getRemoteAddress()  ->	$_SERVER['REMOTE_ADDR']

------------------------------------------------

La Respuesta
La clase sfWebResponse envuelve a los métodos PHP header() y setrawcookie():

Nombre del método           ..	PHP equivalente
setCookie()                 ->	setrawcookie()
setStatusCode()             ->	header()
setHttpHeader()             ->	header()
setContentType()            ->	header()
addVaryHttpHeader()         ->	header()
addCacheControlHttpHeader() ->	header()

------------------------------------------------

El framework de enrutamiento

Una variable en una ruta tiene dos puntos antes del nombre (:).
Ejemplo:
/:id    -> id = 5 -> /5

php symfony app:routes nombreApp -> muestra todas las rutas para una aplicación determinada

php symfony app:routes nombreApp nombreRuta -> se puede tener una gran cantidad de información de depuración para una ruta pasando su nombre como un argumento adicional.

------------------------------------------------

Las variables declaradas en el archivo app.yml están disponibles a través de la clase sfConfig
Este archivo es una buena forma de centralizar configuraciones globales para la aplicación.

Ejemplo:
sfConfig::get('app_nombreVariable')

------------------------------------------------

Si vas a comenzar la implementación de una nueva funcionalidad, es una buena práctica primero pensar acerca de la URL y crear la ruta asociada. Y esto es obligatorio si quitas las reglas de enrutamiento por defecto.

------------------------------------------------

php symfony doctrine:build --all --and-load --no-confirmation



-->