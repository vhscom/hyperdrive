# [Hyperdrive](http://hyperdrive.vhs.codeberg.page)

> The fastest way to load pages in WordPress.

![Hyperdrive](https://codeberg.org/vhs/hyperdrive/blob/master/logo.png "Hyperdrive Plugin for WordPress")

[![Packagist](https://img.shields.io/packagist/v/vhs/hyperdrive.svg?style=flat-square)](https://packagist.org/packages/vhs/hyperdrive)
[![Travis](https://img.shields.io/travis/vhs/hyperdrive.svg?style=flat-square)](https://travis-ci.org/vhs/hyperdrive)
[![Code Climate](https://img.shields.io/codeclimate/github/vhs/hyperdrive.svg?style=flat-square)](https://codeclimate.com/github/vhs/hyperdrive)
[![Test Coverage](https://img.shields.io/codeclimate/coverage/github/vhs/hyperdrive.svg?style=flat-square)](https://codeclimate.com/github/vhs/hyperdrive)

Hyperdrive is a WordPress plugin that helps you increase the speed of your WordPress site using [modern Web standards](https://fetch.spec.whatwg.org/).

## How it works

Hyperdrive uses a performance optimization technique known as [Fetch Injection](https://hackcabin.com/post/managing-async-dependencies-javascript/) available in [supported browsers](http://caniuse.com/#search=fetch). Fetch is the modern replacement for Ajax.

## Requirements

- WordPress >= 4.6
- PHP >= 5.6

## Installation

Two types of installations are possible during the beta period. Choose the one which best meets your development workflow.

### Composer

To automate installation using [Composer](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx) run the following command from your WordPress installation:

    composer require vhs/hyperdrive:dev-master

The above script will download Hyperdrive and install it automatically to the `/wp-content/plugins` directory of your WordPress installation.

### Manual

If you experience any issues with automatic installation, or would prefer to install the plugin manually, simply:

1. Upload `hyperdrive.php` to the `/wp-content/plugins/` directory,
2. Activate the plugin through the *Plugins* menu in WordPress.

## Todo before 1.0.0 release

- [ ] Only dequeue scripts if [browser supports Fetch](http://caniuse.com/#search=fetch) for backwards compatibility with older browsers
- [ ] Integrate localization behaviors [as shown here](https://gist.github.com/vhs/64e8380010e43a526fb9c9ee511fad17#file-functions-php-L507).
- [ ] Test with a few different themes and open bugs and needed

## Post 1.0.0 roadmap

- [ ] Integrate User Interface created by [@wedangsu](https://github.com/wedangsusu)
- [ ] Ensure interface gives ability to defer script execution for scripts querying the DOM until after the DOM is fully parsed.
- [ ] Give ability to perform grouping, so non-jQuery scripts can download and execute without waiting for jQuery.
- [ ] Add ability to load icon fonts and [non-critical CSS](https://gist.github.com/scottjehl/87176715419617ae6994) (also possible with Fetch Inject)
- [ ] Build API enabling theme authors greater control

## Contributing

Hundreds of thousands of individuals and users rely on WordPress every day to consume and share information online. For that reason Hyperdrive has strict requirements for code contributions.

Though Hyperdrive may have a high bar for quality, please don't let that deter you from making contribution. We take all comers.

Where possible project owners, collaborators and contributors should embrace the [values of the Agile Manifesto](https://pragdave.me/blog/2014/03/04/time-to-kill-agile.html):

> - **Individuals and Interactions** over Processes and Tools
> - **Working Software** over Comprehensive Documentation
> - **Customer Collaboration** over Contract Negotiation, and
> - **Responding to Change** over Following a Plan

And, most importantly, always proceed with authenticity. :saxophone:

### Issues

Hyperdrive accepts any issue. Be it gratuitously worded, devoid of information or just plain dumb. Feedback is a gift and will be treated as such. No question is stupid, even the stupid ones.

### Pull requests

Please open issues when creating PRs and PR against the issue to close it. This establishes a need (the issue) and helps separate the need from the implementation (the pull), resulting in more robust solutions.

Before working on a pull please install and configure [EditorConfig](http://editorconfig.org/) for your editor or IDE to help normalize your code syntax with that of the project.

## License

[AGPLv3+](http://www.gnu.org/licenses/)
