##geoIP Location Mod
---
Introduction

This modification adds the ability to determine the latitude & longitude of a member given their IP address. This is commonly referred to as geolocation. The mod makes use of the GeoLite? data created by MaxMind?, available from http://www.maxmind.com/

In some instances the IP address will not be found in the installed database, or will have incomplete data. In this case the mod will make use of the hostip.info site as a secondary source to gather its information.

A note on accuracy: Maxmind shows that this database (which is updated on a monthly basis) is over 99.5% accurate on a country level making it a viable source for registration blocking.

When it comes to the city level accuracy this number is and 79% for the US (within a 25 mile radius). That is the best accuracy, and other countries city/region location accuracy tapper off from that. Even with that it still makes for an entertaining online member map.

###Licensed
The software is licensed under [Mozilla Public License 1.1 (MPL-1.1)](http://www.mozilla.org/MPL/1.1/).

###Features
* Adds the ability to block or allow member registrations on a per country basis
* Adds an on-line member map which will show a map pin for each IP currently on your forum (needs the Country & City database)
* Adds in the geoIP information under the track IP sections, allows you to see city / region (state) / country of the IP address
* Currently only for IP4 addresses 

There are admin settings available with this mod, go to admin - configuration - modification settings - geoIP.
Installation

**IMPORTANT NOTES:**

The package will install on all systems, however to have the mod install the maxmind geoIP databases you need to be running MYSQL

If you do not have the zip module installed (the mod will inform you of this) then you may run into an out of memory issue when unzipping the large database. Without the zip module the memory requirements are 272M which may be a problem on some systems. If you get an out of memory error or white screen your options are to use the country only database or to use the manual install option which requires that you upload the unzipped CSV files and then mod will install them.

Often the maxmind download site is slow, as such some sites may timeout when downloading the database files. The mod does request more time but some hosts still do not allow this. If you time out, simply try again at another time. 

This mod is compatible with SMF 2.0 Only.