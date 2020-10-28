# Browscap downloader
Console application for downloading browscap.ini file and getting info from browscap.org site.

## App Commands 

### App Info Command
Browscap version information.
```
> php console info
Browscap app local version: not found
Browscap origin server version: 6000040
```
 
### App Download Command
Download browscap.ini file from browscap.org into DATA_DIR folder.  
Two files will be created. File `browscap.ini` and `version.json`.  
Default path: `./data/browscap.ini` and `./data/version.json`

```
> php console download
Browscap local not found
Browscap origin server version: 6000040
Browscap load... Done.
Browscap app local version: 6000040

> php console info
Browscap app local version: 6000040
Browscap origin server version: 6000040
Nothing to update.
```

Param `--type`. Specifies browscap.ini file type. There are the following types:
* BrowsCapINI
* Full_BrowsCapINI
* Lite_BrowsCapINI
* PHP_BrowsCapINI
* Full_PHP_BrowsCapINI (default for application)
* Lite_PHP_BrowsCapINI
* BrowsCapXML
* BrowsCapCSV
* BrowsCapJSON
* BrowsCapZIP

### App Dev Commands 
* `php console env` Print env values.
* `php console help` Displays help for a command.
* `php console list` Lists command.
* `php console ping` Ping command for hello word.

## App Environments
`DATA_DIR` - Folder for a download. Default `./data`.

## browscap.org links

### Current Version
* https://browscap.org/version
* https://browscap.org/version-number

### Download ASP browscap.ini
* https://browscap.org/stream?q=BrowsCapINI
* https://browscap.org/stream?q=Full_BrowsCapINI
* https://browscap.org/stream?q=Lite_BrowsCapINI

### Download PHP browscap.ini
* https://browscap.org/stream?q=PHP_BrowsCapINI
* https://browscap.org/stream?q=Full_PHP_BrowsCapINI
* https://browscap.org/stream?q=Lite_PHP_BrowsCapINI

### Download Others extensions
* https://browscap.org/stream?q=BrowsCapXML
* https://browscap.org/stream?q=BrowsCapCSV
* https://browscap.org/stream?q=BrowsCapJSON
* https://browscap.org/stream?q=BrowsCapZIP