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

; Database Servers
MSDB1    = msdb1.mine.com
MSDB1DEV = msdb1.dev.mine.com


; End CONSTANT SECTION
; ============================================================
; ============================================================
[db:mssql]
type = mssql
port = 1495

; All mySQL Source definitions must contain these properties
dns = modelHost, modelId, modelPwd

[db:mssql:dev]
modelHost = {MSDB1DEV}
modelId = root
modelPwd = abcdef
debug_enabled = 'true'
cacheType = file
cacheLife = 5

[db:mssql:prod]
modelHost = {MSDB1}
modelId = root
modelPwd = abcdef
debug_enabled = 'false'
cacheType = file
cacheLife = 1

; eof


