<h1 align="center">
  <a href="http://hyperdrive.vhs.codeberg.page"><img src="https://codeberg.org/vhs/hyperdrive/blob/master/logo.png" alt="Hyperdrive plugin for WordPress" title="Hyperdrive - The fastest way to load pages in WordPress" width="888"></a>
  <span style="clip: rect(1px, 1px, 1px, 1px); clip-path: polygon(0px 0px, 0px 0px,0px 0px, 0px 0px); position: absolute !important; white-space: nowrap; height: 1px; width: 1px; overflow: hidden;">Hyperdrive</span>
</h1>

<p align="center">
  <a href="https://packagist.org/packages/vhs/hyperdrive"><img src="https://img.shields.io/packagist/v/vhs/hyperdrive.svg?style=flat-square" alt="Packagist"></a>
  <a href="https://php.net/"><img src="https://img.shields.io/badge/php-%3E%3D%205.6-8892BF.svg?style=flat-square" alt="PHP"></a>
  <a href="https://wordpress.com/"><img src="https://img.shields.io/badge/wordpress-%3E%3D%204.6-0087BE.svg?style=flat-square" alt="WordPress"></a>
  <a href="https://travis-ci.org/vhs/hyperdrive"><img src="https://img.shields.io/travis/vhs/hyperdrive.svg?style=flat-square" alt="Travis"></a>
  <a href="https://codecov.io/gh/vhs/hyperdrive"><img src="https://img.shields.io/codecov/c/github/vhs/hyperdrive.svg" alt="Codecov"></a>
</p>

<h4 align="center">The fastest way to load pages in WordPress</h4>

<p align="center"><em>Hyperdrive is a WordPress plugin that increases site performance using <a href="https://fetch.spec.whatwg.org/">modern Web standards</a>. Based on initial testing Hyperdrive <a href="https://hackernoon.com/putting-wordpress-into-hyperdrive-4705450dffc2">has been shown</a> to reduce perceived latency in the Twenty Seventeen theme by 200-300%.</em></p>

<p align="center">
  Translations:
  <a href="docs/README_ru.md">ру́сский</a>
</p>

## How it works

Hyperdrive uses a performance optimization technique known as [Fetch Injection](https://hackcabin.com/post/managing-async-dependencies-javascript/) available in [supported browsers](http://caniuse.com/#search=fetch). Fetch Injection leverages [Fetch](https://github.com/whatwg/fetch), the modern replacement for Ajax.

## Installation

Several installation options are available. Choose the one which best meets your skill level and desired workflow.

### Ensign

To install the plugin manually, simply:

1. Upload `hyperdrive.php` to the `/wp-content/plugins/` directory,
1. Activate the plugin through the *Plugins* menu in WordPress.

### Lieutenant

To install and manage with [Composer](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx) run the following from the WP installation directory:

    composer require vhs/hyperdrive:1.0.x-dev

The above will download the Hyperdrive beta under version control and install it directly to the `/wp-content/plugins` directory. Run `composer update` to get the new and shiny.

### Commander

The only thing here you may not recognize is [`rupa/z`](https://github.com/rupa/z/):

```shell
ssh user:pass@wordpressbox.tld
z plugins
curl -O https://raw.githubusercontent.com/vhs/hyperdrive/master/src/hyperdrive.php
wp plugin activate hyperdrive
```

## Todo before 1.0.0 release candidates

- [ ] Only dequeue scripts if [browser supports Fetch](http://caniuse.com/#search=fetch) for backwards compatibility with older browsers
- [ ] Integrate localization behaviors [as shown here](https://gist.github.com/vhs/64e8380010e43a526fb9c9ee511fad17#file-functions-php-L507).
- [ ] Test with a few different themes and open bugs and needed

## Contributing

Hundreds of thousands of individuals and users rely on WordPress every day to consume and share information online. For that reason Hyperdrive has strict requirements for code contributions.

And though Hyperdrive may have a high bar for quality, please don't let that deter you from making contributions. We take on all comers.

Where possible project owners, collaborators and contributors should embrace the [values of the Agile Manifesto](https://pragdave.me/blog/2014/03/04/time-to-kill-agile.html):

> - **Individuals and Interactions** over Processes and Tools
> - **Working Software** over Comprehensive Documentation
> - **Customer Collaboration** over Contract Negotiation, and
> - **Responding to Change** over Following a Plan

### Issues

Hyperdrive accepts any issue. Be it gratuitously worded, devoid of information or just plain dumb. Feedback is a gift and will be treated as such. No question is stupid, even the stupid ones.

### Pull requests

Please open issues when creating PRs and PR against the issue to close it. This establishes a need (the issue) and helps separate the need from the implementation (the pull), resulting in more robust solutions.

Before working on a pull please install and configure [EditorConfig](http://editorconfig.org/) for your editor or IDE to help normalize your code syntax with that of the project.

## License

[![AGPL-3.0](https://img.shields.io/github/license/vhs/hyperdrive.svg?style=flat-square)](https://choosealicense.com/licenses/agpl-3.0/ "GNU Afferno General Public License v3.0")
