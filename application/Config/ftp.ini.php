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
; This section needs to be first in the file
[constants]

; FTP Servers
FTP1    = ftp1.mine.com
FTP1DEV = ftp1.dev.mine.com

FTPS1    = ftps1.mine.com
FTPS1DEV = ftps1.dev.mine.com


; End CONSTANT SECTION
; ============================================================
; ============================================================
[ftp]

; All mySQL Source definitions must contain these properties
dns = modelHost, modelId, modelPwd

[ftp:ftp:dev]
modelHost = {FTP1DEV}
modelId = root
modelPwd = abcdef
debug_enabled = 'true'
cacheType = file
cacheLife = 5

[ftp:ftp:prod]
modelHost = {FTP1}
modelId = root
modelPwd = abcdef
debug_enabled = 'false'
cacheType = file
cacheLife = 1


[ftp:ftps:dev]
modelHost = {FTPS1DEV}
modelId = root
modelPwd = abcdef
debug_enabled = 'true'
cacheType = file
cacheLife = 5

[ftp:ftps:prod]
modelHost = {FTPS1}
modelId = root
modelPwd = abcdef
debug_enabled = 'false'
cacheType = file
cacheLife = 1

; eof


