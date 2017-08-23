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

// domains to hostname => [subdomain] array
$hosts = array();

// process data
foreach ($rawdata as $row){

    // valid line ? format <IP> <hostname>
    if (preg_match('/^0\.0\.0\.0\s+(\w+\S+\.)(\w+\.[a-z]{2,10})\s*$/Ui', $row, $matches) === 1){

        $fullDomain = $matches[1] . $matches[2];

        // host entry in whitelist ?
        if (!isWhitelisted($fullDomain)){
            // domain in list ?
            if (!isset($hosts[$matches[2]])){
                $hosts[$matches[2]] = array();
            }

            // push host
            $hosts[$matches[2]][] = $matches[1];
        }
    }
}
echo count(array_keys($hosts)), " Domains total..\n";

// reduce array to dnsmasq format
$dnsmasq = '';
array_walk($hosts, function($hostnames, $domain) use (&$dnsmasq){
    // generate local zone entry
    foreach ($hostnames as $host){
        $dnsmasq .= 'address=/' . $host . $domain . '/0.0.0.0'."\n";
    }
});

// reduce array to unbound format
$unbound = '';
array_walk($hosts, function($hostnames, $domain) use (&$unbound){
    // generate local zone entry
    $z = 'local-zone: "' . $domain . '." redirect'."\n";
    foreach ($hostnames as $host){
        $z .= 'local-data: "' . $host .  $domain . '. A 0.0.0.0"'."\n";
    }

    // append result
    $unbound .= $z;
});

// save
file_put_contents('dist/dnsmasq.adblock.conf', $dnsmasq);
file_put_contents('dist/unbound.adblock.conf', $unbound);
