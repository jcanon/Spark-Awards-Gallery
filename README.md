# Spark Awards Gallery

A CodeIgniter 4 gallery application for Spark Awards entries, winners, search, and entry detail pages.

## Stack

- PHP 8.1+
- CodeIgniter 4
- MySQL (via `MySQLi`)
- PHPUnit 10 for tests

## Project Structure

- `app/Controllers/GalleryController.php`: Main gallery flow (grid/search/details)
- `app/Models/GalleryModel.php`: Query layer for competitions, entries, photos, winners
- `app/Views/gallery/`: Gallery templates (`index`, `grid`, `search`, `details`)
- `app/Libraries/WpMenuService.php`: Reads WordPress nav menu tables for header navigation
- `public/js/gallery-ui.js`: Gallery infinite-scroll and modal behavior (moved out of inline footer script)

## Local Setup

1. Install dependencies:

```bash
composer install
```

2. Configure environment:

- Copy/create `.env`
- Set:
  - `CI_ENVIRONMENT`
  - `app.baseURL`
  - `database.default.*`
  - `gallery.uploadsBaseUrl` (remote uploads host, or blank for local)

3. Start app:

```bash
php spark serve
```

4. Open:

- `http://localhost:8080/gallery`

## Environment Matrix

`development`

- `CI_ENVIRONMENT=development`
- `app.baseURL` points to local dev host (for example `https://spark-awards-gallery.local/`)
- `gallery.uploadsBaseUrl` can be blank to use local `/uploads/...`, or set to remote origin
- HTTPS is optional but recommended for parity
- Debug tooling enabled

`production`

- `CI_ENVIRONMENT=production`
- `app.baseURL` must be public HTTPS URL
- `gallery.uploadsBaseUrl` should point to the production media host (for example `https://www.sparkawards.com`)
- HTTPS is enforced by app config
- CSP is enabled by app config
- Secure headers filter is enabled globally
- Debug must be disabled

## Routes

- `GET|POST /gallery`
- `GET /gallery/{entryId}`
- `GET /`

## Gallery Behavior

### Main views

- Year overview grid: competitions + winner group tile
- Competition grid: entries in selected competition
- Winner grid: winner entries in selected year
- Search: design/user/company search across published gallery entries
- Detail page: full entry details, photos, certificate links

### Winner context behavior

When browsing winners (`comp=Winners`):

- Entry detail URL stays in winner context:
  - `gallery?year={year}&comp=Winners&entry={id}`
- Breadcrumbs stay in winner context
- Previous/Next entry links stay scoped to winners in that year
- Detail page includes a `Back to List` action that preserves current gallery context

## Security and Quality Notes

Recent hardening/refactor includes:

- Removed deprecated input sanitization usage (`FILTER_SANITIZE_STRING`)
- Added strict normalization/validation for `year`, `comp`, and `entry`
- Added safer YouTube embed handling (extract/validate embed ID)
- Added `rel="noopener noreferrer"` to external `_blank` links
- Removed database calls from `grid`/`details` views (controller now prepares data)
- Removed unused model methods and unused dev dependencies
- Added canonical URL and Open Graph metadata support
- Added caching for heavy read queries and slow-operation logging
- Added diagnostics endpoints: `/healthz` and `/admin/diagnostics`

## Composer / Dependencies

Direct dependencies:

- `codeigniter4/framework`
- `phpunit/phpunit` (dev)

Notes:

- No Composer plugins are defined in this project
- `composer audit` reports no known vulnerabilities

## Testing

Run:

```bash
vendor/bin/phpunit
```

Current test suite runs successfully. In environments without Xdebug/PCOV, PHPUnit may warn that code coverage is unavailable.

Additional UI contract coverage includes:

- Frontend smoke checks for infinite-scroll/modal hooks
- Lightweight visual-contract checks for critical modal/card CSS selectors

## Deployment Checklist (Production)

1. Set `CI_ENVIRONMENT=production`.
2. Set `app.baseURL` to the final HTTPS URL.
3. Run `composer install --no-dev --optimize-autoloader`.
4. Ensure `writable/` subfolders are writable by the web process.
5. Confirm `/healthz` returns `200` and `"status":"ok"`.
6. Verify gallery details, winner context navigation, and search results links.
7. Confirm TLS/HTTPS termination is correctly configured upstream.

## Operational Notes

- This app expects existing Spark schema/tables (including WordPress menu tables such as `spark_posts`, `spark_terms`, etc.)
- Gallery media URL resolution is controlled by `gallery.uploadsBaseUrl`:
  - blank: use local `/uploads/...`
  - set: rewrite `/uploads/...` assets (images and certificate PDFs) to that host
- Header/footer assets are based on Avada/Fusion static assets under `public/theme`
