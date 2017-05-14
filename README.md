# Hyperdrive

> The fastest way to load pages in WordPress.

![Hyperdrive Plugin for WordPress](https://codeberg.org/vhs/hyperdrive/blob/master/logo.png)

# Installation

Hyperdrive is [available on Packagist](https://packagist.org/packages/vhs/hyperdrive).

- Installing with Composer: `composer require vhs/hyperdrive`

# Documentation

Hyperdrive docs available online at:
http://hyperdrive.vhs.codeberg.page/

# Todo before 1.0.0 release

- [ ] Only dequeue scripts if [browser supports Fetch](http://caniuse.com/#search=fetch) for backwards compatibility with older browsers
- [ ] Integrate localization behaviors [as shown here](https://gist.github.com/vhs/64e8380010e43a526fb9c9ee511fad17#file-functions-php-L507).
- [ ] Test with a few different themes and open bugs and needed

# Post 1.0.0 roadmap

- [ ] Integrate User Interface created by [@wedangsu](https://github.com/wedangsusu)
- [ ] Ensure interface gives ability to defer script execution for scripts querying the DOM until after the DOM is fully parsed.
- [ ] Give ability to perform grouping, so non-jQuery scripts can download and execute without waiting for jQuery.
- [ ] Add ability to load icon fonts and [non-critical CSS](https://gist.github.com/scottjehl/87176715419617ae6994) (also possible with Fetch Inject)
- [ ] Build API enabling theme authors greater control

# How it works

Hyperdrive uses a performance optimization technique known as [Fetch Injection](https://hackcabin.com/post/managing-async-dependencies-javascript/), available in [browsers with support](http://caniuse.com/#search=fetch) for the Fetch API. Fetch is a modern replacement for Ajax.

# Contributing

Please open issues when creating PRs and PR against the issue to close it. This helps separate the need (the issue) from the implementation (the pull), resulting in more robust solutions.

All code must follow WordPress [PHP Documentation Standards](https://make.wordpress.org/core/handbook/best-practices/inline-documentation-standards/).

Though not required, if you plan on contributing code please consider installing [EditorConfig](http://editorconfig.org/) for your editor or IDE to help normalize your code with our coding standards.

# License

[GPL-3.0](https://opensource.org/licenses/GPL-3.0)
