# BaseFrame — Universal Joomla Template Framework

## Security First
- **Never output unescaped user input.** All `$siteName`, param values, and dynamic content must use `htmlspecialchars()` or Joomla's `$this->escape()`.
- **Never use raw SQL.** Use Joomla's `DatabaseInterface` or PDO with prepared statements.
- **All file includes must use `defined('_JEXEC') or die;`** as the first line.
- **No inline JavaScript.** All JS goes in `baseframe.js` with event listeners, never `onclick` attributes.
- **CSP-safe.** No inline styles via `style=""` in PHP output. All styling via CSS classes.
- **Validate all template params.** Cast to expected types, fallback to defaults.

## Stability
- **No external CDN dependencies in production.** All CSS framework files ship locally in `css/lib/`.
- **No JavaScript frameworks.** Vanilla JS only. Zero dependencies.
- **No build tools required.** The template ships as compiled CSS. Source files are for development only.
- **Test on Joomla 5 and 6.** Use only stable Joomla APIs (`Factory`, `Uri`, `HTMLHelper`, `Route`).
- **Never modify Joomla core files.** All customization via template overrides in `html/`.

## Architecture
```
baseframe/
├── templates/baseframe/
│   ├── index.php              ← One file for all frameworks
│   ├── error.php              ← Error page (framework-independent)
│   ├── component.php          ← Component-only view
│   ├── templateDetails.xml    ← Template manifest + framework param
│   └── html/                  ← Shared HTML overrides (bf-* classes)
│       ├── com_content/category/blog.php, blog_item.php
│       └── layouts/chromes/baseframe.php
├── media/templates/site/baseframe/
│   ├── css/
│   │   ├── base.css           ← Framework-agnostic layout + Joomla fixes
│   │   ├── custom.css         ← User overrides (never modified by updates)
│   │   ├── adapters/          ← One CSS file per framework
│   │   │   ├── bulma.css
│   │   │   ├── daisyui.css
│   │   │   ├── pico.css
│   │   │   └── ...
│   │   └── lib/               ← Framework CSS libraries (shipped locally)
│   │       ├── bulma.min.css
│   │       ├── daisyui.css
│   │       └── ...
│   └── js/
│       └── baseframe.js       ← Mobile menu, card links (vanilla JS)
```

## How It Works
1. **index.php** reads the `framework` param from `templateDetails.xml`
2. Loads `base.css` (layout + Joomla fixes) → `lib/{framework}.css` → `adapters/{framework}.css` → `custom.css`
3. HTML uses `bf-*` semantic classes (bf-header, bf-card, bf-module, etc.)
4. Each adapter maps `bf-*` classes to framework-specific visuals
5. Switching frameworks = changing one dropdown in template settings

## Class Convention
All BaseFrame classes use the `bf-` prefix:
- `bf-header`, `bf-nav`, `bf-hamburger` — header/navigation
- `bf-hero` — hero section
- `bf-main`, `bf-content`, `bf-sidebar`, `bf-layout` — page structure
- `bf-card`, `bf-card-image`, `bf-card-body`, `bf-card-title` — blog cards
- `bf-tag` — tag pills
- `bf-module`, `bf-module-title` — sidebar modules
- `bf-footer`, `bf-footer-cols`, `bf-footer-bottom` — footer
- `bf-blog`, `bf-blog-grid`, `bf-blog-leading` — blog layout
- `bf-pagination` — pagination wrapper

## Adding a New CSS Framework
1. Download the framework CSS → `css/lib/{name}.min.css`
2. Create `css/adapters/{name}.css` that styles all `bf-*` classes
3. Add entry to `$frameworks` array in `index.php`
4. Add option to `templateDetails.xml`
5. Test all Joomla views: blog, article, contact, tags, FAQ, pricing

## Rules
- **custom.css is for the end user.** Never put template styles there.
- **base.css is framework-agnostic.** No framework-specific variables or classes.
- **Adapters are self-contained.** Each adapter file works only with its own framework's lib CSS.
- **HTML overrides use only bf-* classes.** Never put framework-specific classes in PHP files.
- **index.php has zero framework-specific markup.** The `$frameworks` config array is the only place frameworks are referenced.
