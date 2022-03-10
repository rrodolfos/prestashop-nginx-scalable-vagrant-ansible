<?php
  include_once('../config/config.inc.php');
  include_once('../config/settings.inc.php');
  include_once('../classes/Cookie.php');
  $cCookie = new Cookie('ps-s1'); // Customer cookie
  $aCookie = new Cookie('psAdmin'); // Employee cookie
?>
<p>
  <strong>Customer Cookie</strong>
  <pre><?php print_r($cCookie); ?></pre>
</p>
<p>
  <strong>Admin Cookie</strong>
  <pre><?php print_r($aCookie); ?></pre>
</p>

