# Heroku Deploy

This Laravel app is prepared for Heroku with:

- `Procfile` serving `public/` through Apache/PHP.
- Node.js and PHP buildpacks so Vite assets are built during deploy.
- Heroku Postgres support through `DATABASE_URL`.
- Release-phase migrations through `php artisan migrate --force`.

## First Deploy

Install and log in to the Heroku CLI first:

```sh
heroku login
```

Create the app:

```sh
export HEROKU_APP=outcraft-ai-playground
heroku create "$HEROKU_APP"
```

Copy the app URL printed by Heroku and set it as a variable. New Heroku apps can include a generated suffix in the URL:

```sh
export HEROKU_APP_URL=https://outcraft-ai-playground-d8b3a5416227.herokuapp.com
```

Set buildpacks in this order:

```sh
heroku buildpacks:clear --app "$HEROKU_APP"
heroku buildpacks:add heroku/nodejs --app "$HEROKU_APP"
heroku buildpacks:add heroku/php --app "$HEROKU_APP"
```

Provision Postgres:

```sh
heroku addons:create heroku-postgresql:essential-0 --app "$HEROKU_APP"
```

Set Laravel config vars:

```sh
heroku config:set \
  APP_ENV=production \
  APP_DEBUG=false \
  APP_KEY="$(php artisan --no-ansi key:generate --show)" \
  APP_URL="$HEROKU_APP_URL" \
  LOG_CHANNEL=stderr \
  DB_CONNECTION=pgsql \
  SESSION_DRIVER=database \
  CACHE_STORE=database \
  QUEUE_CONNECTION=database \
  --app "$HEROKU_APP"
```

Deploy:

```sh
git push heroku main
```

If your local branch is not `main`, use:

```sh
git push heroku HEAD:main
```

Use the Eco dyno type:

```sh
heroku ps:type eco --app "$HEROKU_APP"
heroku ps:scale web=1 --app "$HEROKU_APP"
```

## After Deploy

Open the app:

```sh
heroku open --app "$HEROKU_APP"
```

Tail logs:

```sh
heroku logs --tail --app "$HEROKU_APP"
```

If queued jobs are needed, scale the worker process:

```sh
heroku ps:scale worker=1 --app "$HEROKU_APP"
```

## Notes

Heroku's filesystem is ephemeral, so uploaded user files should use an external disk such as S3 before this becomes production-critical.
