# GG Forms

A lightweight and extensible Gutenberg block plugin that enables interactive stories and options for WordPress websites. Ideal for building quiz-like experiences, decision trees, and rich multimedia storytelling with video, choices, and logic.

## Features

- Gutenberg block support:
  - `GG Forms`: Main container block
  - `GG Story`: Add video stories with timed questions
  - `GG Option`: Create selectable options linked to other stories
- Video playback control with conditional interactions
- Fully translatable and internationalized
- Extensible architecture with clean, modular code

## Installation

1. Upload the plugin files to the `/wp-content/plugins/gg-forms` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress.
3. Go to `Settings > GG Forms` to configure basic options.

## External Requests

This plugin does not make any external HTTP API requests. All features run locally within WordPress.

## Data Removal

When uninstalling the plugin, the user has the option to remove all related settings and saved options via the **"Delete data on uninstall"** checkbox available in the settings page.

## Development

- Follows WordPress Coding Standards
- JavaScript written using modern ESNext syntax and bundled with webpack
- SCSS compiled to CSS via `@wordpress/scripts`
- PHP structure follows PSR-12 recommendations

## Internationalization

- Text domain: `gg-forms`
- All strings are wrapped with `__()` or `esc_html__()` and ready for translation
- `.pot` file located in `/languages`

## Changelog

### 1.0.0
- Initial release with GG Forms, GG Story, and GG Option blocks.
- Video interaction logic with timed question overlay.
- Option linking logic between story blocks.

## License

This plugin is licensed under the GNU General Public License v2.0 or later.
