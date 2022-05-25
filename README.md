
## Overview

### What is it?

The LogConfig module lets you configure the Xaraya logging system. It is
essentially a wrapper for the logging parts of the configuration files
found at

  - var/config.system.php
  - var/logs/config.log.php

In other words, anything this module does can be done by directly
editing those two files. Nonetheless, unless you know what you're doing,
using this module to configure logging is the recommended way to go.

### How to use it?

You can:

  - List the loggers that are currently configured. From here you can
    then edit the settings for each logger, including whether or not it
    is active. Note that an active logger will not do anything until you
    enable loggind in the modifyconfig page (see below).
  - Turn Xaraya logging on/off globally. This makes Xaraya log (or not)
    according to the loggers configured. This setting in the
    modifyconfig page is identical to the setting found under the
    logging tab in the modifyconfig page of the base module. The latter
    can be found
    [here]().

The loggers are shipped with the Xaraya core and are located in
lib/xaraya/log/loggers. You can, of course, run several loggers
simultaneously, but be aware that this many degrade performance, not to
mention using up disk space faster for loggers that write to disk or
database.

The logging system depends on the timezone settings found
[here]().
You should set the Host Timezone to the timezone you want the timestamps
of the logged messages to show.

### Fallback System:

If logging is set to on in this module and none of the loggers are
active, then there is a fallback system that will log to a text file.
This fallback can be configured under the logging tab in the
modifyconfig page of the base module, found
[here]().

### Message levels

The Xaraya loggers recognize the following message levels. Each logger
can be configured to track one or more of these message levels.


| Name      | Numeric Value | Application                                                                             |
| --------- | :-----------: | --------------------------------------------------------------------------------------- |
| EMERGENCY |       1       | Tracks errors that call for immediate intervention                                      |
| ALERT     |       2       | Tracks errors that call for intervention                                                |
| CRITICAL  |       3       | Tracks errors that result in major consequences for processing                          |
| ERROR     |       4       | Tracks behavior that is unexpected or undesired, with minor consequences for processing |
| WARNING   |       5       | Tracks anomalities or abnormal behavior without consequences for processing             |
| NOTICE    |       6       | Tracks high level core processes and main module processes                              |
| INFO      |       7       | Tracks low level core and module processes                                              |
| DEBUG     |       8       | Used for fine grained debugging                                                         |


### Available loggers

  - The errorlog logger: writes log data to the web server's error log
  - The html logger: writes log data to an HTML file
  - ~~The javascript logger: opens a debug window with the log
    information~~
  - The mail logger: sends log data to a recipient via email
  - ~~The mozilla logger: opens a debug window with the log
    information~~
  - The simple logger: writes log data to a text file
  - The sql logger: writes log data to a database table
  - The syslog logger: write log data to server logs

The loggers are all subclasses of a parent xarLogger class, found at
lib/xaraya/log/loggers/xarLogger.php. This class is responsible for:

  - Defining the log message levels that Xaraya uses (see above)
  - Defining the timestamp formats that are used in displays.
  - Creating a unique universal identifier (UUID) based on PHP's
    random\_bytes function. This is used by several of the loggers to
    differentiate between one pageview and the next.

### Notes on the errorlog logger

This logger writes to PHP's error log, which can be accessed by the PHP
funcion error\_log(), as described
[here](https://www.php.net/manual/en/function.error-log.php).

### Notes on the mail logger

The mail logger will send you an email with the error message and some
additional information. You cannot edit the lay-out and content of the
message via the mail templates as the message is created by PHP code.

Because of the vagaries and continuously changing (improving) standards
for email and the major email providers, it is recommended that you
first test Xaraya's email functionality in your environment and make
sure everything works. You can do this by sending test messages from the
mail module. Helpful information can also be had by setting the mail
module's debug functionality, which is found on the mail module's
modifyconfig page
[here]().

### Notes on the SQL logger

The SQL logger needs a database table to write its data to. This table
should be added to your database. For MySQL you can use the following
code:

``` 
                CREATE TABLE `xar_log_messages` (
                  `id` int(10) NOT NULL,
                  `ident` varchar(32) NOT NULL,
                  `logtime` varchar(255) NOT NULL DEFAULT '',
                  `priority` tinyint(4) NOT NULL DEFAULT '0',
                  `message` text NOT NULL
                  PRIMARY KEY  (`id`)
                );
                
```

The SQL logger will log all messages to this database table. Currently,
there is no interface to manage the entries. In configuring this logger,
make sure that your entry for the SQL Table parameter corresponds to the
name of the database table you have created.

### Notes on the syslog logger

Depending on its configuration, this logger writes to a server log. as
described [here](https://www.php.net/manual/en/function.syslog.php). It
should be noted that different server operating systems have different
types of logs. We make no claims about which of this loggers
configurations will work in any given case.

### Further Information

To be added on occasion\!

** LogConfig Module Overview**  
 Version 1.0.0  2022-5-01

