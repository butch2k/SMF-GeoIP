[hr]
[center][size=16pt][b]geoIP Location Mod[/b][/size]
[url=http://custom.simplemachines.org/mods/index.php?action=search;author=11359][b]By Spuds[/b][/url]
[/center]
[hr]

[color=blue][b][size=12pt][u]License[/u][/size][/b][/color]
o This modification is released under a MPL V1.1 license, a copy of it with its provisions is included with the package.
o This mod makes use of the GeoLite data created by MaxMind, available from [url=href=http://www.maxmind.com/]MaxMind[/url] which is released under an OPEN DATA LICENSE.

[color=blue][b][size=12pt][u]Introduction[/u][/size][/b][/color]
This modification adds the ability to determine the latitude & longitude of a member given their IP address. This is commonly referred to as geolocation.  The mod makes use of the GeoLite data created by MaxMind, available from http://www.maxmind.com/  

In some instances the IP address will not be found in the installed database, or will have incomplete data.  In this case the mod will make use of the hostip.info site as a secondary source to gather its information.

[b]A note on accuracy:[/b]  
Maxmind shows that this database (which is updated on a monthly basis) is over 99.5% accurate on a country level making it a viable source for registration blocking.

When it comes to the city level accuracy this number is and 79% for the US (within a 25 mile radius).  That is the best accuracy, and other countries city/region location accuracy tapper off from that.  Even with that it still makes for an entertaining online member map.

[color=blue][b][size=12pt][u]Features[/u][/size][/b][/color]
o Adds the ability to block or allow member registrations on a per country basis
o Adds an on-line member map which will show a map pin for each IP currently on your forum (needs the Country & City database)
o Adds in the geoIP information under the track IP sections, allows you to see city / region (state) / country of the IP address
o Currently only for IP4 addresses

There are admin settings available with this mod, go to admin - configuration - modification settings - geoIP.

[color=blue][b][size=12pt][u]Installation[/u][/size][/b][/color]
[b][color=red]IMPORTANT NOTES:[/color][/b]
o The package will install on all systems, however to have the mod install the maxmind geoIP databases you need to be running [b]MYSQL[/b].
o If you do not have the zip module installed (the mod will inform you of this) then you may run into an out of memory issue when unzipping the large database. Without the zip module the memory requirements are [b]272M[/b] which may be a problem on some systems.  If you get an out of memory error or white screen your options are to use the country only database or to use the manual install option which requires that you upload the unzipped CSV files and then mod will install them.
o Often the maxmind download site is very slow, as such some sites may timeout when downloading the database files.  The mod does request more time but some hosts still do not allow this.  If you time out, simply try again at another time.
o The mySQL database size for the full country city database table will be approximately [b]80M[/b], if storage space is an issue on your host / server please keep this in mind.

This mod is compatible with SMF 2.0 Only.

[color=blue][b][size=12pt][u]Support[/u][/b][/color]
Please use the geoIP modification thread for support with this modification.

[color=blue][b][size=12pt][u]Changelog[/u][/size][/b][/color]
[b]1.1.1 - 23 Jan 2012[/b]
! fixed error with county only database and Invalid Value Sent to Database error
! fixed issue with external lookups parsing

[b]1.1 - 08 Dec 2011[/b]
+ Country flags next to member names in whos online list
+ Membergroup permissions for IDing member pin on online map (was on/off for all)
+ Improved logic for geoIP lookups
+ Released under BSD license
+ Stores geo data as part of the online table when the user lands instead of as on-demand data.

[b]1.0 - 07 Sep 2011[/b]
+ Initial Release
