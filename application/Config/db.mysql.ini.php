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
MYDB1    = mydb1.mine.com
MYDB1DEV = mydb1.dev.mine.com


; End CONSTANT SECTION
; ============================================================
; ============================================================
[db:mysql]
type = mysql
port = 1495

; All mySQL Source definitions must contain these properties
dns = modelHost, modelId, modelPwd

[db:mysql:dev]
modelHost = {MYDB1DEV}
modelId = root
modelPwd = abcdef
debug_enabled = 'true'
cacheType = file
cacheLife = 5

[db:mysql:prod]
modelHost = {MYDB1}
modelId = root
modelPwd = abcdef
debug_enabled = 'false'
cacheType = file
cacheLife = 1

; eof


