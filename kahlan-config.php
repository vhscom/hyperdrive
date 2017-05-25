<?php
use Kahlan\Filter\Filter;
use Kahlan\Reporter\Coverage\Exporter\Clover;

// Override default options.
// https://kahlan.github.io/docs/cli-options.html
$commandLine = $this->commandLine();
$commandLine->option('ff', 'default', 1); // fast fail
$commandLine->option('coverage', 'default', 2); // organize report by
$commandLine->option(
  'coverage-clover', 'default', 'clover.xml'
); // output clover file to

// Logic to include into the workflow.
Filter::register('hyperdrive.coverage', function ($chain) {

  // Get the reporter called `'coverage'` from the list of reporters.
  $reporter = $this->reporters()->get('coverage');

  // Get the environment variable called `'CI'` from PHP.
  $ci = getenv('CI');

  // Abort if not running in CI.
  if (!$ci) {
    return $chain->next();
  }

  // Abort if no coverage is available.
  if (!$reporter || !$this->commandLine()->exists('coverage-clover')) {
    return $chain->next();
  }

  // Use the `Clover` class to write the XML coverage into a file.
  Clover::write([
    'collector' => $reporter,
    'file' => $this->commandLine()->get('coverage-clover'),
    'service_name' => 'travis-ci',
    'service_job_id' => getenv('TRAVIS_JOB_ID') ?: null
  ]);

  // Continue the chain.
  return $chain->next();
});

// Apply the logic to the `'reporting'` entry point.
Filter::apply($this, 'reporting', 'hyperdrive.coverage');
