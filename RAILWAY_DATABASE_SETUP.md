# TestLink Railway Configuration Guide

## Configuración de Base de Datos para Railway

Railway no incluye servicios de base de datos MariaDB/MySQL integrados. Necesitas configurar una base de datos externa.

### Opciones Recomendadas:

#### Opción 1: PlanetScale (Recomendado - Gratis hasta 1GB)
1. Ve a https://planetscale.com/
2. Crea una cuenta gratuita
3. Crea una nueva base de datos
4. Copia la URL de conexión
5. En Railway, ve a Variables → Añade: `DATABASE_URL=mysql://usuario:password@host:puerto/database`

#### Opción 2: Supabase PostgreSQL (Gratis hasta 500MB)
1. Ve a https://supabase.com/
2. Crea un proyecto
3. Ve a Settings → Database → Connection String
4. En Railway, configura las variables:
   - `DB_HOST=db.xxx.supabase.co`
   - `DB_USER=postgres`
   - `DB_PASSWORD=tu_password`
   - `DB_NAME=postgres`
   - `DB_PORT=5432`

#### Opción 3: Railway Database Service
1. En tu proyecto Railway, haz clic en "New Service"
2. Selecciona "Database" → "MySQL"
3. Railway configurará automáticamente las variables de entorno

### Variables de Entorno Requeridas:

```
DATABASE_URL=mysql://usuario:password@host:puerto/database
```

O individualmente:
```
DB_HOST=tu_host
DB_USER=tu_usuario
DB_PASSWORD=tu_password
DB_NAME=testlink
DB_PORT=3306
```

### Pasos para Configurar:

1. **Elige tu proveedor de base de datos**
2. **Configura las variables en Railway:**
   - Ve a tu proyecto en Railway
   - Click en "Variables"
   - Añade las variables de conexión
3. **Redespliega el proyecto**
4. **Ejecuta la configuración inicial de TestLink**

### Nota de Seguridad:
- Nunca hardcodees credenciales en el código
- Usa variables de entorno para toda la configuración sensible
- Las credenciales de base de datos deben estar solo en Railway Variables