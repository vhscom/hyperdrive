# Hyperdrive

> The fastest way to load pages in WordPress.

![Hyperdrive Plugin for WordPress](https://codeberg.org/vhs/hyperdrive/blob/master/logo.png)

[![Build Status](https://travis-ci.org/vhs/hyperdrive.svg?branch=master)](https://travis-ci.org/vhs/hyperdrive)
[![Code Climate](https://codeclimate.com/github/vhs/hyperdrive/badges/gpa.svg)](https://codeclimate.com/github/vhs/hyperdrive)
[![Test Coverage](https://codeclimate.com/github/vhs/hyperdrive/badges/coverage.svg)](https://codeclimate.com/github/vhs/hyperdrive)

## Installation

Hyperdrive is [available on Packagist](https://packagist.org/packages/vhs/hyperdrive).

- Installing with Composer: `composer require vhs/hyperdrive`

## Documentation

Hyperdrive docs available online at:
http://hyperdrive.vhs.codeberg.page/

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

## How it works

Hyperdrive uses a performance optimization technique known as [Fetch Injection](https://hackcabin.com/post/managing-async-dependencies-javascript/), available in [browsers with support](http://caniuse.com/#search=fetch) for the Fetch API. Fetch is a modern replacement for Ajax.

## Contributing

Hundreds of thousands of individuals and users rely on WordPress every day to consume and share information online. For that reason Hyperdrive has strict conventions when it comes to code contributions.

And though Hyperdrive may have a high bar for quality, please don't let that deter you from making contribution. Where possible project owners, collaborators and contributors should make every effort possible to foster the following values [shared by Dave Thomas](https://pragdave.me/blog/2014/03/04/time-to-kill-agile.html):

> - **Individuals and Interactions** over Processes and Tools
> - **Working Software** over Comprehensive Documentation
> - **Customer Collaboration** over Contract Negotiation, and
> - **Responding to Change** over Following a Plan

That said, always proceed with authenticity. :saxophone:

### Issues

Hyperdrive accepts any issue. Be it gratuitously worded, devoid of information or just plain dumb: all feedback should be perceived as a gift and treated as such. No question is stupid, even the stupid ones.

### Pull requests

Please open issues when creating PRs and PR against the issue to close it. This helps establish a need (the issue) and helps separate it from the implementation (the pull), resulting in more robust solutions and helps ensure ongoing code quality.

Pull requests will be statically analyzed to identify code smells and style inconsistencies, and a report generated automatically each time a change is made on a branch. See [`.codeclimate.yml`](https://codeberg.org/vhs/hyperdrive/blob/master/.codeclimate.yml) for a listing of analysis engines and configured rulesets.

Before working on a pull please install and configure [EditorConfig](http://editorconfig.org/) for your editor or IDE to help normalize your code syntax with that of the project.

## License

[GPL-3.0](https://opensource.org/licenses/GPL-3.0)
