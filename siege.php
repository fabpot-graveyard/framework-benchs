#!/usr/bin/env php
<?php
ini_set('error_reporting', E_ALL|E_STRICT);
ini_set('display_errors', true);

// reads a csv file of targets
function fetch_target_list($file)
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

// write out the siegerc file, mostly so we can maintain a log location
function write_siege_file($vars = array())
{
    // the base config vars
    $base = array (
        'verbose'           => 'false',
        // csv              => true,
        // fullurl          => true,
        // display-id       => '',
        'show-logfile'      => 'false',
        'logging'           => 'true',
        // 'logfile'           => '',
        'protocol'          => 'HTTP/1.0',
        'chunked'           => 'true',
        'connection'        => 'close',
        'concurrent'        => '10',
        'time'              => '60s',
        // reps             => '',
        // file             => '',
        // url              => '',
        // 'delay'             => '1',
        // timeout          => '',
        // expire-session   => '',
        // failures         => '',
        // 'internet'          => 'false',
        'benchmark'         => 'true',
        // user-agent       => '',
        // 'accept-encoding'   => 'gzip',
        'spinner'           => 'false',
        // login            => '',
        // username         => '',
        // password         => '',
        // ssl-cert         => '',
        // ssl-key          => '',
        // ssl-timeout      => '',
        // ssl-ciphers      => '',
        // login-url        => '',
        // proxy-host       => '',
        // proxy-port       => '',
        // proxy-login      => '',
        // follow-location  => '',
        // zero-data-ok     => '',
    );
    
    // make sure we have base vars for everything
    $vars = array_merge($base, $vars);
    
    // build the text for the file
    $text = '';
    foreach ($vars as $key => $val) {
        $text .= "$key = $val\n";
    }
    
    // write the siegerc file
    file_put_contents("/root/.siegerc", $text);
}

// store logs broken down by time
$time = date("Y-m-d\TH:i:s");
passthru("mkdir -p ./log/$time");

// run each benchmark target
$list = fetch_target_list($_SERVER['argv'][1]);
foreach ($list as $key => $val) {
    
    $name = $val[0];
    $path = $val[1];
    
    // write the siegerc file
    write_siege_file(array(
        'logfile' => "./log/$time/$name.log",
    ));
    
    // restart the server for a fresh environment
    passthru("/etc/init.d/apache2 restart");
    
    // what href are we targeting?
    $href = "http://localhost/$name/$path";
    
    // prime the cache
    echo "$name: prime the cache\n";
    passthru("curl $href");
    echo "\n";
    
    // bench runs
    for ($i = 1; $i <= 5; $i++) {
        echo "$name: pass $i\n";
        passthru("siege $href");
        echo "\n";
    }
}

// do reporting
echo "Logs saved at ./log/$time.\n\n";
passthru("php ./report.php ./log/$time");
exit(0);
