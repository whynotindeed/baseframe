# BaseFrame

**One Joomla template. 13 CSS frameworks. One dropdown.**

BaseFrame is a universal Joomla 5/6 template that swaps CSS frameworks with a single admin setting. Same HTML, same content, completely different look — from Bulma to NES.css.

Built entirely by AI using [Claude Code](https://claude.ai/claude-code).

## Made for AI-assisted development

BaseFrame is designed for developers working with **VS Code + Claude Code** in a **Docker environment** (local or VPS). The template ships as pure CSS and vanilla JS — no build tools, no Node.js, no npm. Describe what you want changed, your AI reads the adapter CSS, writes the fix, and deploys it. No manual coding required.

Works with any AI coding assistant (Claude Code, GitHub Copilot, Cursor, ChatGPT). Works on any Docker setup — local development or production VPS. Power users can of course install and customize it however they prefer — the AI workflow is a recommendation, not a requirement.

## Quick start

1. Download the zip from [Releases](https://github.com/whynotindeed/baseframe/releases)
2. Joomla admin → System → Install → Upload the zip
3. System → Templates → Site Template Styles → click the star next to BaseFrame to set as default
4. Click BaseFrame to open settings → pick a CSS framework → Save

Your existing content — articles, menus, modules, contact forms — renders in the new framework instantly.

## Live Demos

Every framework has a full demo site with Home, About, Services, Portfolio, Blog, Team, FAQ, Pricing, Components, and Contact pages.

| Framework | Type | Demo |
|-----------|------|------|
| [Bulma](https://bulma.io) | Full framework | [Demo](https://claudejoomla.com/tf-bulma) |
| [Chota](https://jenil.github.io/chota/) | Micro (3KB) | [Demo](https://claudejoomla.com/tf-chota) |
| [Cirrus](https://cirrus-ui.netlify.app) | Micro | [Demo](https://claudejoomla.com/tf-cirrus) |
| [DaisyUI](https://daisyui.com) | Full framework | [Demo](https://claudejoomla.com/tf-daisyui) |
| [Fomantic UI](https://fomantic-ui.com) | Full framework | [Demo](https://claudejoomla.com/tf-fomantic) |
| [Foundation](https://get.foundation) | Full framework | [Demo](https://claudejoomla.com/tf-foundation) |
| [Halfmoon](https://www.gethalfmoon.com) | Dark-first | [Demo](https://claudejoomla.com/tf-halfmoon) |
| [MVP.css](https://andybrewer.github.io/mvp/) | Classless | [Demo](https://claudejoomla.com/tf-mvp) |
| [NES.css](https://nostalgic-css.github.io/NES.css/) | Retro/8-bit | [Demo](https://claudejoomla.com/tf-nes) |
| [Open Props](https://open-props.style) | Design tokens | [Demo](https://claudejoomla.com/tf-openprops) |
| [Pico CSS](https://picocss.com) | Classless | [Demo](https://claudejoomla.com/tf-picocss) |
| [Sakura](https://oxal.org/projects/sakura/) | Classless | [Demo](https://claudejoomla.com/tf-sakura) |
| [UIkit](https://getuikit.com) | Full framework | [Demo](https://claudejoomla.com/tf-uikit) |
| Vanilla CSS | No framework | [Demo](https://claudejoomla.com/tf-vanilla) |

## Demo

- **Live demos:** [claudejoomla.com](https://claudejoomla.com) — all 13 frameworks with full content
- **Demo content download:** [go.claudejoomla.com/baseframe-demo](https://go.claudejoomla.com/baseframe-demo) — seed script to populate your site with the same demo articles, menus, and modules

## How It Works

```
index.php reads the "framework" param from templateDetails.xml
    ↓
Loads: base.css → lib/{framework}.min.css → adapters/{framework}.css → custom.css
    ↓
HTML uses tf-* semantic classes (tf-header, tf-card, tf-nav, etc.)
    ↓
Each adapter maps tf-* classes to framework-specific visuals
    ↓
Switching frameworks = changing one dropdown in template settings
```

All HTML uses `tf-*` prefixed classes. No framework-specific classes in PHP files. The adapters handle all visual mapping.

## Architecture

```
templates/baseframe/
├── index.php                 ← One file for all 13 frameworks
├── templateDetails.xml       ← Framework dropdown param
├── error.php                 ← Error page
├── component.php             ← Component-only view
└── html/                     ← Joomla HTML overrides (tf-* classes only)

media/templates/site/baseframe/
├── css/
│   ├── base.css              ← Framework-agnostic layout
│   ├── custom.css            ← User overrides (never modified by updates)
│   ├── adapters/             ← One CSS file per framework
│   │   ├── bulma.css
│   │   ├── daisyui.css
│   │   ├── nes.css
│   │   └── ... (13 total)
│   └── lib/                  ← Framework CSS libraries (shipped locally)
│       ├── bulma.min.css
│       ├── daisyui.css
│       └── ... (13 total)
└── js/
    └── baseframe.js          ← Hamburger menu, card links (vanilla JS)
```

## Install

### Docker (recommended)

```bash
git clone https://github.com/whynotindeed/baseframe.git
cd baseframe
docker compose up -d
# Wait 30s for MariaDB, then:
docker exec baseframe-dev-joomla-app-1 php installation/joomla.php install \
  --site-name="BaseFrame" --admin-user="Admin" --admin-username="admin" \
  --admin-password="BaseFrame2026!" --admin-email="admin@example.com" \
  --db-host="joomla-db" --db-user="joomla" --db-pass="joomla_local_pass" \
  --db-name="joomla" --db-prefix="tf_" --db-type="mysqli"
```

Then discover and enable the template:
```bash
docker exec baseframe-dev-joomla-app-1 php cli/joomla.php extension:discover
docker exec baseframe-dev-joomla-app-1 php cli/joomla.php extension:discover:install
```

### Manual

1. Copy `templates/baseframe/` to your Joomla's `templates/` directory
2. Copy `media/templates/site/baseframe/` to your Joomla's `media/templates/site/` directory
3. Go to System → Discover in the Joomla admin panel
4. Install BaseFrame
5. Set as default template in System → Templates → Site Template Styles

## What's styled

Every adapter includes custom CSS for these Joomla views:

- **Blog category** — card grid with leading article, sidebar modules, pagination
- **Single article** — full typography: headings, lists, tables, code blocks, blockquotes, images
- **Contact form** — styled inputs, labels, textarea, submit button, CAPTCHA
- **FAQ** — `<details>/<summary>` accordion with open/closed states
- **Pricing** — card grid with featured card highlight
- **Components** — buttons, alerts, marks, statistics, tables
- **Tags** — tag pills, tagged items list
- **Navigation** — desktop menu, hamburger mobile menu, "More" dropdown
- **Footer** — three-column layout with links
- **Sidebar** — module titles, article lists, tag clouds
- **Pagination** — styled page numbers with active/disabled states
- **Read more** — styled buttons

Other Joomla views (login, registration, search results, news feeds, category list) render using the framework's default styles — functional but not custom-styled.

## Adding a New CSS Framework

1. Download the framework CSS → `css/lib/{name}.min.css`
2. Create `css/adapters/{name}.css` mapping all `tf-*` classes
3. Add entry to `$frameworks` array in `index.php`
4. Add `<option>` to `templateDetails.xml`
5. Test all views: blog, article, contact, tags, FAQ, pricing

## What's Styled

Every Joomla component view is styled in every framework:

- **Blog** — card grid with leading article, sidebar, pagination
- **Articles** — full typography, headings, lists, tables, code blocks, blockquotes
- **Contact** — form with styled inputs, labels, submit button
- **Tags** — tag cloud, tagged items list
- **FAQ** — `<details>/<summary>` accordion
- **Pricing** — card grid with featured card highlight
- **Components Showcase** — buttons, alerts, marks, statistics, tables

## No Build Tools

BaseFrame ships as compiled CSS. No Node.js, no npm, no webpack, no Tailwind CLI. Edit the CSS files directly. The `custom.css` file is for your overrides — it's never modified by template updates.

## No JavaScript Dependencies

One vanilla JS file. No jQuery, no React, no Alpine.js. The JS handles:
- Mobile hamburger menu toggle
- "More" dropdown submenu
- Clickable card links
- Back-to-top button visibility

## License

GPL v2+ — same as Joomla.

## Credits

Built by [Claude Code](https://claude.ai/claude-code) as part of the [Claude Joomla](https://claudejoomla.com) project.
