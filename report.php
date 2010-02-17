#!/usr/bin/env php
<?php
ini_set('error_reporting', E_ALL|E_STRICT);
ini_set('display_errors', true);

// reads a csv file of targets
function fetch_csv($file)
{
    $line = 0;
    $handle = fopen($file, "r");
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        // skip blank lines
        $k = count($data);
        if (! $k) {
            continue;
        }
        // retain the line of data
        for ($i = 0; $i < $k; $i++) {
            $list[$line][$i] = $data[$i];
        }
        $line ++;
    }
    fclose($handle);
    return $list;
}

if (empty($argv[1])) {
   echo "Please specify a log directory as the first argument.\n";
   exit(1);
}

$log_dir = $argv[1];

// all report data: keyed by row, then by col
$report = array();

// keep track of the comparison bench average
$cmp = 99999999;

// number formatting
$format = '%8.2f';

// each of the frameworks benched
$files = glob("$log_dir/*.log");
foreach ($files as $file) {
    
    // what is the famework name? (less the ".log" extension)
    $name = substr(basename($file), 0, -4);
    
    // output the bench on its own line
    $report[$name] = array('rel' => null, 'avg' => null);
    
    // get the CSV data, remove the field-names line
    $data = fetch_csv($file);
    array_shift($data);
    
    foreach ($data as $key => $val) {
        // save the req/sec
        $i = $key + 1;
        $report[$name][(string) $i] = sprintf($format, $val[5]);
    }
    
    // figure the average
    $avg = array_sum($report[$name]) / (count($report[$name]) - 2); // -2 for rel, avg
    $report[$name]['avg'] = sprintf($format, $avg);
    
    // if this is the baseline-php report, save the comparison value
    if ($name == 'baseline-php') {
        $cmp = $avg;
    }
}

$fwpad = 24;

// header line
$val = array('     rel', '     avg', '       1', '       2', '       3', '       4', '       5');
echo str_pad('framework', $fwpad) . " | " . implode(" | ", $val) . "\n";

$val = array('--------', '--------', '--------', '--------', '--------', '--------', '--------');
echo str_pad('', $fwpad, '-') . " | " . implode(" | ", $val) . "\n";

// output each data line, figuring %-of-php score as we go
foreach ($report as $key => $val) {
    $val['rel'] = sprintf("%8.4f", $val['avg'] / $cmp);
    echo str_pad($key, $fwpad) . " | " . implode(" | ", $val) . "\n";
}
