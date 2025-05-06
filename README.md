# DynamicPage Symfony Project

A starter Symfony application bundled with Docker plus a reusable **DynamicPageBundle** for managing “components” (small bits of page content) via either:

- A **built-in admin UI** (simple CRUD controllers & Twig templates), or  
- **EasyAdminBundle** (full-fledged admin backend)

---

## Table of Contents

- [Project Structure](#project-structure)  
- [Prerequisites](#prerequisites)  
- [Installation & Docker](#installation--docker)  
- [Database Setup](#database-setup)  
- [DynamicPageBundle Configuration](#dynamicpagebundle-configuration)  
  - [Global Bundle Config](#global-bundle-config)  
  - [Using the Built-in Admin UI](#using-the-built-in-admin-ui)  
  - [Using EasyAdminBundle](#using-easyadminbundle)  
- [Rendering Components in Your Templates](#rendering-components-in-your-templates)  
- [Overriding Bundle Templates](#overriding-bundle-templates)  
- [Directory Layout](#directory-layout)  
- [License](#license)  

---

## Project Structure

```
├── docker/               # Docker Compose + service configs
│   ├── docker-compose.yml
│   ├── nginx/
│   └── php/
├── src/                  # Symfony application (“App\” namespace)
├── packages/             # Local Symfony bundle(s)
│   └── DynamicPageBundle/
│       ├── src/          # Bundle PHP code (Controller, Service, Entity, etc.)
│       └── Resources/
│           ├── config/
│           │   ├── admin/          # services.yaml & controllers for built-in UI
│           │   └── easyadmin/      # easyadmin.yaml & services.yaml
│           └── views/              # Twig templates for both UIs & components
├── config/               # App config (routes, packages, services)
├── migrations/           # Doctrine migrations
├── public/               # Document root
└── README.md             # ← you are here
```

---

## Prerequisites

- **Docker & Docker Compose** (for local containers)  
- **PHP 8.1+**, **Composer** (for installing PHP dependencies)  
- **Node.js & npm/Yarn** (optional, if you build front-end assets)  

---

## Installation & Docker

1. **Clone the repo**  
   ```bash
   git clone git@github.com:ahmad-dadoush/cms-bundle.git && cd cms-bundle
   ```

2. **Copy & configure environment**  
   ```bash
   cp src/.env .env.local
   # Edit DATABASE_URL, APP_SECRET, etc. in .env.local
   ```

3. **Install PHP dependencies**  
   ```bash
   composer install --working-dir=src
   ```

4. **Build & start Docker**  
   ```bash
   cd docker/
   docker-compose up -d
   ```

5. **Install JS dependencies & build assets** (if applicable)  
   ```bash
   cd src
   yarn install && yarn watch
   ```

---

## Database Setup

From the Symfony app directory (`src/`):

```bash
# create the database (if it doesn’t exist)
php bin/console doctrine:database:create

# run migrations
php bin/console doctrine:migrations:migrate
```

---

## DynamicPageBundle Configuration

### Global Bundle Config

The bundle ships with a default Twig template for rendering components:

```yaml
# src/config/packages/dynamic_page.yaml
dynamic_page:
    # path to the template used when no custom template is set on a Component
    default_template: '@DynamicPage/components/default.html.twig'
```

By default that parameter is set to the above value; override it here if you want to supply your own.

---

### Using the Built-in Admin UI

1. **Do not install EasyAdminBundle** (the bundle auto-detects absence of EasyAdmin and loads its own admin services).  
2. **Enable annotation-based routes** in your `config/routes.yaml` (should already be active for `App\Controller`).  
3. **Uncomment or add** the `dynamic_page_admin` block:

    ```yaml
    # src/config/routes.yaml
    dynamic_page_admin:
        resource: '@DynamicPageBundle/Controller/Admin'
        type: attribute
        prefix: /admin # change this to desired prefix of your choice
    ```

4. **Clear the cache** and visit:  
   ```
   http://localhost/<prefix>/component
   ```

   You’ll get a simple CRUD for `Component` entities — create a name, choose a Twig template (or use default), and enter a JSON “fields” object.

---

### Using EasyAdminBundle

1. **Install EasyAdmin & dependencies**  
   ```bash
   composer require easycorp/easyadmin-bundle
   composer require symfony/ux-twig-component
   # optional, if you use SVG icon sets:
   composer require symfony/ux-icons symfony/http-client
   ```

2. **Enable EasyAdmin routes**:

   ```yaml
   # src/config/routes/easyadmin.yaml
   easyadmin:
     resource: .
     type: easyadmin.routes
     prefix: /admin # change this to desired prefix of your choice
   ```

3. **Clear cache & visit**:  
   ```
   http://localhost/<prefix>/component
   ```

   You’ll see “Dynamic Components” in the sidebar, with full CRUD powered by EasyAdmin.

---

## Rendering Components in Your Templates

Use the bundle’s rendering service or Twig helper:

```twig
{# anywhere in your Twig #}
{{ cms_component('my_component_name', { foo: 'bar', baz: 123 }) }}
```

---

## Overriding Bundle Templates

All Twig templates live under:

```
DynamicPageBundle/src/Resources/views/
```

To override:

1. Copy the file into your app’s `src/templates/bundles/DynamicPageBundle/…`  
2. Make your edits there — Symfony’s bundle inheritance will prefer your version.

---

## License

This project (and the DynamicPageBundle) is released under the **MIT License**.  
Feel free to use and adapt as needed.
