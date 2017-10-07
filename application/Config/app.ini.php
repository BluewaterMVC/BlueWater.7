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

; Logging settings
LOGGER_SQL = 'false'
LOGGER_ERR = 'false'
LOGGER_TRACE = 'false'


; DOC Types can be:
; - h4.1 = HTML 4.1
; - h5   = HTML 5
; - x1   = xHTML 1.0 strict
; - x1.1 = xHTML 1.1 strict
DOC_TYPE = h5

; Used to add 'salt' to encryption routines
; Place anything you like in here, but change this
SALT = mary_had_a_little_lamb

; Normally MVC is not a path based system; controllers are files in the
; 'Controller' directory. This flag changes the behavour to utilize a
; directory based controller system, with all associated files to a
; controller in the same directory as the controller.
; Modify this flag in the app level config file.
PATH_BASE = 'true'


; Static server
STATIC_ROOT = {HTTP_PROTOCOL}staticzacks.dev.zacks.com
;STATIC_ROOT = {HTTP_PROTOCOL}cloud.staticzacks.net
;STATIC_ROOT = {HTTP_PROTOCOL}b7d61a7c6b8c307bf531-a92a66b9587e2a0aa805bd4e70b98407.{CDN_PROTOCOL_SUBDOMAIN}.cf2.rackcdn.com


; This determines if a SESSION is to be created, and which
; type of session: false, server, cookie
;    'false' - no session to be created
;   'server' - standard Server based sessions
;   'cookie' - cookie based sessions for load balanced serves
SESSION =  'false'


; End CONSTANT SECTION
; ============================================================

[general]
tz = America/Chicago


; eof
