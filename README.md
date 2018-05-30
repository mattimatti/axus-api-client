AXUS API CLIENT
------------

This repository provides an UNOFFICIAL php library to ease connection to Axus Travel App V1 endpoints as described in this documentation page

https://axustravelapp.com/api/v1/docs




    
#### Build

Each task has its own options, run help command, you should see the options from these tasks:

    $ phprelease help
    PHPRelease - The Fast PHP Release Manager

    Usage
        phprelease [options] [command] [argument1 argument2...]

    Options
               -v, --verbose   Print verbose message.
                 -d, --debug   Print debug message.
                 -q, --quiet   Be quiet.
                  -h, --help   help
                   --version   show version
                       --dry   dryrun mode.
                --bump-major   bump major (X) version.
                --bump-minor   bump minor (Y) version.
                --bump-patch   bump patch (Z) version, this is the default.
     -s, --stability <value>   set stability
                       --dev   set stability to dev.
                        --rc   set stability to rc.
                       --rc1   set stability to rc1.
                       --rc2   set stability to rc2.
                       --rc3   set stability to rc3.
                       --rc4   set stability to rc4.
                       --rc5   set stability to rc5.
                      --beta   set stability to beta.
                     --alpha   set stability to alpha.
                    --stable   set stability to stable.
           --remote <value>+   git remote names for pushing.


So to bump the major verion, simply pass the flag:

    phprelease --bump-major

You can also test your release steps in dry-run mode:

    phprelease --dryrun

    