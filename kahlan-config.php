<?php
use Kahlan\Filter\Filter;
use Kahlan\Reporter\Coverage\Exporter\Clover;

// Override default options.
// https://kahlan.github.io/docs/cli-options.html
$commandLine = $this->commandLine();

// Export code coverage report into a Clover XML format.
// Use the same directory and filename WordPress Core uses.
$commandLine->option('coverage-clover', 'default', 'clover.xml');

// Logic to include into the workflow.
Filter::register('hyperdrive.coverage', function ($chain) {

  // Get the reporter called `'coverage'` from the list of reporters.
  $coverage = $this->reporters()->get('coverage');
  print_r($coverage);

  // Abort if no coverage is available.
  if (!$coverage || !$this->commandLine()->exists('coverage-clover')) {
    return $chain->next();
  }

  // Use the `Clover` class to write the XML coverage into a file.
  Clover::write([
    'coverage' => $coverage,
    'file' => $this->commandLine()->get('coverage-clover'),
    'service_name' => 'travis-ci',
    'service_job_id' => getenv('TRAVIS_JOB_ID') ?: null
  ]);

  // Continue the chain.
  return $chain->next();
});

// Apply the logic to the `'reporting'` entry point.
Filter::apply($this, 'reporting', 'hyperdrive.coverage');
