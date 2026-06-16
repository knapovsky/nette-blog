# Nette Blog

Nette Blog is a small blog/CMS application built on the Nette Framework. It demonstrates a classic PHP MVC structure with presenters, Latte templates, Doctrine entities, user authentication, article management, image handling, and Bootstrap styling.

> Status: archived / historical reference.
>
> This project targets an old PHP/Nette stack. Do not deploy it publicly without upgrading dependencies and completing a security review.

## Features

- article list and article detail pages
- article creation and editing screens
- user sign-in and sign-up flows
- Nette presenters, components, forms, and Latte templates
- Doctrine-backed `Users` and `Articles` models
- Bootstrap-based front-end styling
- Adminer bundled under `www/adminer/` for local database inspection
- sanitized example database schema/data in `db.example.sql`

## Technology stack

- PHP >= 5.6, as defined in `composer.json`
- Nette Framework 2.4 components
- Kdyby Doctrine
- Latte templates
- Bootstrap 4
- MySQL / MariaDB
- Nette Tester for the sample test scaffold

## Repository structure

```text
.
├── app/
│   ├── components/           # Reusable UI controls
│   ├── config/               # Nette configuration
│   ├── forms/                # Form factories for articles and auth
│   ├── model/                # Doctrine entities / domain models
│   ├── presenters/           # Application presenters and Latte templates
│   └── router/               # Route definitions
├── tests/                    # Nette Tester bootstrap and example test
├── www/                      # Public document root
│   ├── index.php             # Front controller
│   ├── css/                  # Bootstrap and custom styles
│   ├── js/                   # Nette AJAX and app JavaScript
│   └── adminer/              # Adminer helper for local DB access
├── composer.json             # PHP dependencies
├── db.example.sql            # Sanitized example database
└── README.md
```

## Local setup

Use an isolated local environment. The dependency set is old and may not install cleanly on a modern PHP runtime without adjustments.

1. Install PHP, Composer, and MySQL/MariaDB.
2. Install dependencies:

   ```bash
   composer install
   ```

3. Create a database for the app.
4. Import the sanitized example data:

   ```bash
   mysql -u root -p nette_blog < db.example.sql
   ```

5. Configure database credentials in the Nette config files under `app/config/`.
6. Point your web server document root at `www/`.

For quick local inspection only, you can try:

```bash
php -S 127.0.0.1:8080 -t www
```

Then open `http://127.0.0.1:8080/`.

## Common commands

Install dependencies:

```bash
composer install
```

Run the sample Nette Tester test, if dependencies are installed:

```bash
vendor/bin/tester tests
```

Start a temporary local server:

```bash
php -S 127.0.0.1:8080 -t www
```

## Security and maintenance notes

This repository is preserved as a legacy example. Before production use:

- upgrade PHP to a supported version
- upgrade Nette, Doctrine, Tracy, Bootstrap, and all third-party packages
- remove or protect Adminer in public environments
- review authentication and password hashing
- verify all forms have CSRF protection and server-side validation
- replace sample database data
- run dependency and static-analysis security checks

The current repository contains only a sanitized example database. Historical git history may still contain data that was later removed.

## License

`composer.json` inherits the Nette sandbox licensing metadata: BSD-3-Clause, GPL-2.0, or GPL-3.0. Review dependencies and project-specific ownership before redistribution.
