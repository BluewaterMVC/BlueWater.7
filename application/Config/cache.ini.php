<?php

// Make sure this file can be not directly opened.
// DO NOT remove this EXIT. It is here for security reasons
exit;

?>
; This is the settings page, do not modify the above PHP code.

; Section headers are REQUIRED

; Change any settings in this file to satisfy a particular
; project requirements.

; ============================================================
; ============================================================
; This section needs to be first in the file
[constants]

; Memcache Servers
MEM1    = /mem1.mine.com, mem2.mine.com/
MEM1DEV = mem1dev.mine.com


; End CONSTANT SECTION
; ============================================================

; ============================================================
CACHing, all definitions and properties are defined here

; duration - Specify how long items in this cache live in seconds.
; tags - List of tags associated to every key stored.
; prefix - Prefix appended to all entries.
; servers - Used by memcache. The (IP/DNS) address of the memcached servers to use, comma seperated.
; compress - Enables memcache's compressed format, or GZIP for FileCache.
; serialize - Used by FileCache. Should cache objects be serialized first.
; path - Used by FileCache. Path to where cachefiles should be saved.
; lock - Used by FileCache. Should files be locked before writing to them?
; user - Username for XCache
; password - Password for XCache


[cache]
type = file, memcache   ; comma delimited list of caching types

; ===========================
; FILE CACHE Sources and their properties

[cache:file]
path = {CACHE_ROOT}/file
compress = 'true'

; ===========================
; CACHE Sources and their properties

[cache:memcache]
port = 11211

[cache:memcache:dev]
server = {MEM1DEV}    ; comma delimited list of servers
compress = 'true'
duration = 2

[cache:memcache:prod]
server = {MEM1DEV}    ; comma delimited list of servers
compress = 'true'
duration = 5

; eof
