<?php
// Don't cache this page!
header('Expires: Mon, 26 Jul 1900 05:00:00 GMT');
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
header('Cache-Control: no-cache');

// Send the right error codes.
header('HTTP/1.1 503 Service Temporarily Unavailable', true, 503);
header('Status: 503 Service Temporarily Unavailable');
header('Retry-After: 3600');
?>
<!DOCTYPE html>
<html xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>The Name of the CMS</title>
</head>
<body>
<h1>Under Maintenance</h1>
<p>Sorry for the inconvenience.</p>
</body>
</html>
