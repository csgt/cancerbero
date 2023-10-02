# cancerbero

Cancerbero is a Laravel package to manage access control based on routes and a permissions database table.

## Upgrade guides

### 6.x -> 7.x

_WARNING: Roles will be reset to defaults. You need to specify permissions again._

1. Update `composer.json` to the new versions

```
"csgt/cancerbero": "^7.0",
"csgt/menu": "^7.0",
"csgt/ui": "^3.0",
"csgt/utils": "^8.0",
```

2. Publish and run migrations

```
php artisan vendor:publish --tag=migrations
php artisan migrate
```

3. Modify `PermissionSeeder`, `ModulePermissionsSeeder`, `MenuSeeder`, `GodSeeder`, `InitialSeeder` seeders for new schema. You may copy them from
   `\packages\ui\src\Auth\stubs\seeders\`

4. Update `\database\seeds\CsgtModule.php` for new schema. You may copy it from
   `\packages\cancerbero\src\`

5. Remove `menu` middleware from routes (if they exist)
