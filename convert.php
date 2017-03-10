<?php

// fetch data
$rawdata = explode("\n", trim(file_get_contents('hosts.txt')));
echo count($rawdata), " Entries processed..\n";

// fetch whitelist
$whitelist = explode("\n", trim(file_get_contents('whitelist.txt')));
echo count($whitelist), " Whitelist Hosts processed..\n";

// utility function
// @TODO performance optimization...
function isWhitelisted($host){
    global $whitelist;

    foreach ($whitelist as $entry){
        // wildcard ?
        if (strpos($entry, '.') == 0){

            // strip dot
            $entry = substr($entry, 1);

            if (substr($host, -strlen($entry)) === $entry){
                return true;
            }

        // singlular match
        }else{
            // match found ?
            if ($entry == $host){
                return true;
            }
        }
    }

    // not in the list
    return false;
}

// output hosts
$hosts = array();

// process data
foreach ($rawdata as $row){

    // valid line ? format IP hostname
    if (preg_match('/^0\.0\.0\.0\s+(\w+\S+)\s*$/i', $row, $matches) === 1){
        // host entry in whitelist ?
        if (!isWhitelisted($matches[1])){
            $hosts[] = $matches[1];
        }
    }
}

// add dnsmasq directive
$hosts = array_map(function($host){
    return 'address=/' . $host . '/0.0.0.0';
}, $hosts);

// convert and save
file_put_contents('adblock.conf', implode("\n", $hosts));

echo count($hosts), " Hosts added to adblock.conf!\n";

