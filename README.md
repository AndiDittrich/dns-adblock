DNSMASQD/UNBOUND Adblock Converter
=============================

Use the amazing [StevenBlack/hosts](https://github.com/StevenBlack/hosts) Adblock Lists with [dnsmasqd](http://www.thekelleys.org.uk/dnsmasq/doc.html) or [unbound](https://www.unbound.net/) on your router

Fetch the latest List
------------------------------------

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

44006 Entries processed..
5 Whitelist Hosts processed..
10493 Domains total..
```

Configure dnsmasq
------------------------------------

**1.** Copy the `dist/dnsmasq.adblock.conf` file to a persistent location (e.g. `/etc` or `/jffs/etc` on WRT Routers)

**2.** Add the following directive to your **dnsmasq.conf** file

```conf
conf-file=/etc/dnsmasq.adblock.conf
```

**3.** Restart dnsmasq

**4.** You're Ready!

Configure unbound
------------------------------------

**1.** Copy the `dist/unbound.adblock.conf` file to a persistent location (e.g. `/etc` or `/jffs/etc` on WRT Routers)

**2.** Add the following directive to your **unbound.conf** file into `server` section

```conf
server:
     ...
     include: /etc/unbound.adblock.conf
```

**3.** Restart unbound

**4.** You're Ready!


Whitelist
------------------------------------

Add a bunch of hostnames which **should not getting blocked**. Wildcards are supported using leading dot

**Example**

```
analytics.google.com
.twitter.com
mydommain.tld
.mywildcarddomain.tld
```

License
------------------------------------

The Script is OpenSource and licensed under the Terms of [The MIT License (X11)](http://opensource.org/licenses/MIT) - your're welcome to contribute