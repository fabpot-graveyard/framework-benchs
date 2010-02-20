Replicating Benchmarks
======================

This document explains how to replicate the benchmarks easily on Amazon EC2.

The Machine
-----------

The benchmarks are done on Amazon EC2. The AMI is "ami-80446ff4" (EU) and the
instance type is "c1.xlarge" (High-CPU Extra Large Instance):

 * 7 GB of memory
 * 20 EC2 Compute Units (8 virtual cores with 2.5 EC2 Compute Units each)
 * 1690 GB of local instance storage
 * 64-bit platform

One EC2 Compute Unit (ECU) provides the equivalent CPU capacity of a 1.0-1.2
GHz 2007 Opteron or 2007 Xeon processor.

Installation
------------

To install the machine, I have done the following steps:

  * add dotdeb repository (/etc/apt/sources.list)

      deb http://php53.dotdeb.org stable all
      deb-src http://php53.dotdeb.org stable all

  * apt-get update && apt-get upgrade

  * apt-get install php5 php5-cli php5-dev apache2-dev php-pear lynx siege

  * pecl install APC-beta

  * edit /etc/php5/apache2/php.ini

      date.timezone=Europe/Paris

      extension = apc.so
      apc.enabled = 1
      apc.shm_segments=1
      apc.shm_size=128
      apc.num_files_hint=1024
      apc.gc_ttl=3600
      apc.ttl=3600
      apc.mmap_file_mask=/tmp/apc.XXXXXX
      apc.filters=
      apc.stat=0
      apc.enable_cli = 0
      apc.include_once_override = 1
      apc.max_file_size=4M

  * also change the timezone in /etc/php5/cli/php.ini

  * edit /etc/apache2/sites-enabled/000-default
    and remove the line about CustomLog (to avoid tons of logs)

  * ulimit -n 99999

  * /etc/init.d/apache2 restart

The web root is at /var/www. This is where you should clone the Git
repository.

Benchmarks
----------

To run the benchmark, just execute the siege.php script:

    php siege.php target.csv
    php siege.php target_products.csv
