Dev Notes
=========

- When running `magento setup:upgrade`, make sure the PHP executable being used on the command line is the same one being used on the server
  - Run `which php` to see which one is being used
  - Error received before figuring issue out:
    - `'SQLSTATE[HY000] [2002] No such file or directory `