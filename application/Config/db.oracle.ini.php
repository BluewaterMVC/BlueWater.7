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

; Database Servers
DB1    = db1.mine.com
ORAID  = orc.mine.com

DB1DEV   = db1.dev.mine.com
ORAIDDEV = dev.mine.com


; End CONSTANT SECTION
; ============================================================

; ============================================================
[db:oracle]
type = oracle

[db:oracle]
; All Oracle Source definitions must contain these properties
dns = oraSID, modelHost, modelId, modelPwd

[db:oracle:dev]
oraSID     = {ORAIDDEV}
modelHost  = {DB1DEV}
modelId    = dev
modelPwd   = password

cacheType = file
cacheLife = 900

[db:oracle:prod]
oraSID     = {ORAID}
modelHost  = {DB1}
modelId    = orc
modelPwd   = password

cacheType = file
cacheLife = 900

; ------------------------------------------
; "zer_widget_functions" Package
;
[db:oracle:package:widget_functions]
credentials = data_holder
debug = 'false'

; ------------------------------------------
; "company_ratio_statistics" Package
;
[db:oracle:package:ratio_stats]
credentials = data_sack
debug = 'false'


; eof


