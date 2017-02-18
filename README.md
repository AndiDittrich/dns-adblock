DNSMASQD Adblock Converter
=============================

Use the amazing [StevenBlack/hosts](https://github.com/StevenBlack/hosts) Adblock Lists with [dnsmasqd](http://www.thekelleys.org.uk/dnsmasq/doc.html) on your router

Usage
----------------------------

### Fetch the latest List ###

To grab the latest list (default: adware + malware + fakenews) run the `update.sh` script

**Example**

```terminal
$ ./update.sh
--2017-02-18 09:09:57--  https://raw.githubusercontent.com/StevenBlack/hosts/master/alternates/fakenews/hosts
Resolving raw.githubusercontent.com (raw.githubusercontent.com)... 151.101.112.133
Connecting to raw.githubusercontent.com (raw.githubusercontent.com)|151.101.112.133|:443... connected.
HTTP request sent, awaiting response... 200 OK
Length: 1021501 (998K) [text/plain]
Saving to: ‘hosts.txt’

2017-02-18 09:09:58 (2.38 MB/s) - ‘hosts.txt’ saved [1021501/1021501]

35093 Entries processed..
1 Whitelist Hosts processed..
32750 Hosts added to adblock.conf!
```

### Ad the Adblock list to dnsmasq ###

**1.** Copy the `adblock.conf` file to a persistent location (e.g. `/etc` or `/jffs/etc` on WRT Routers)

**2.** Add the following directive to your **dnsmasq.conf** file

```conf
conf-file=/etc/adblock.conf
```

**3.** Restart dnsmasq

**4.** You're Ready!

### Whitelist ###
Add a bunch of hostnames which **should not getting blocked**

**Example**

```
analytics.google.com
mydommain.tld
```

## License ##
The Script is OpenSource and licensed under the Terms of [The MIT License (X11)](http://opensource.org/licenses/MIT) - your're welcome to contribute