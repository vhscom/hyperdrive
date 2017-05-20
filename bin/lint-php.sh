#!/usr/bin/env bash

VENDOR_DIR=vendor
SEARCH_DIR=.

if [[ $1 != "" ]]; then
  SEARCH_DIR=$1
fi

vendor/bin/phpcs --standard=phpcs.ruleset.xml $(find $SEARCH_DIR -name "*.php" -not -path "./$VENDOR_DIR")
