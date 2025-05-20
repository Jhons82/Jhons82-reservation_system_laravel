TODO: Pasos para instalar Laravel desde cero

1. TODO: ir a la carpeta del proyecto
2. TODO: Abrir el terminal de git bash o cmd
3. TODO: Ejecutar el comando => 
   1. composer global require laravel/installer
   2. composer create-project laravel/laravel ApiRest_Laravel
4. TODO: Ejecutar laravel serve:
   1. php artisan serve

TODO: MIGRACIONES - Crear migraciones con:
5. TODO: Create Migration
   1. php artisan make:migration create_rol_table
6. TODO: Create migration - add estado in categorias table (si se necesita agregar un campo extra en una tabla ya existente)
   1. php artisan make:migration add_estado_to_rol --table=categorias
7. TODO: Migrating laravel database to the main database
   1. php artisan migrate
   
TODO: Models - Crear Models con:
8. TODO: Create Migration - Model (Esquema para migrar a la bd principal)
   1. php artisan make:model Categoria -m

TODO: SEEDERS - Crear Seeders con:
9. TODO: Create Seeders (Ingresar datos iniciales o de prueba a la base de datos)
   1. php artisan make:seeder RolTablesSeder
10. Ejecutar seeder para enviar los datos a la BD
    1.  php artisan db:seed --class=RolTableSeeder 
    
TODO: Si desea ejecutar los migraciones desde cero:
11. php artisan migrate:fresh
    
TODO: Si necesitas reiniciar la base de datos y ejecutar las migraciones y seeders desde cero, puedes usar:
12.  php artisan migrate:fresh --seed

TODO: Controllers - Crear controladors con:
13.   TODO: Create Controller
   1. php artisan make:controller categoriacontroller

TODO: LIST OF ALL ROUTES
14.  TODO: List of all routes registered in your application
   1. php artisan route:list



TODO: LARAVEL BREEZE

TODO: Ejecutar Laravel Freeze
1.  composer require laravel/breeze --dev

TODO: Rutas y vistas para breeze
15. php artisan breeze:install
16. Instalar solo blade con: 
    1.  blade (en la terminal)
17. Activar dark mode support (si es de preferencia)
    1. yes (en la terminal)
18. testing framework do you prefer:
    1.  PHPUnit (terminal)
19. Node:
    1.  npm install
    2.  npm run dev
20. Para migrar lo de Breeeze:
    1.  php artisan migrate
21. Para vizualizar los nuevos cambios con:
    1.  php artisan serve



TODO: Para modificar columnas existentes de una tabla, asegúrate de tener instalada la extensión doctrine/dbal

composer require doctrine/dbal




Ventajas:

Mayor rendimiento: Ideal para insertar grandes cantidades de datos rápidamente, ya que evita la sobrecarga del ORM.

Simplicidad: El código es directo y fácil de entender para inserciones básicas.

Desventajas:

No previene duplicados: Si el seeder se ejecuta múltiples veces, puede insertar registros duplicados a menos que se implementen verificaciones adicionales.

No gestiona marcas de tiempo automáticamente: Si la tabla tiene columnas created_at y updated_at, debes proporcionarlas manualmente.

No activa eventos del modelo: Se omiten eventos como creating o created, lo que puede ser relevante en ciertas situaciones.