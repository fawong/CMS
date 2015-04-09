</div>
</div>
<footer>
<div class="container">
<p class="text-muted credit">Copyright &copy; <?php print '2007-'.date("Y") ?> FAWONG. All Rights Reserved. Not A CMS Version <?php print $cms_version ?></p>
<?php
if ($footer) {
?>
<p class="text-muted credit"><?php print $footer ?></p>
<?php
};
?>
</div>
</footer>


<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<!--
<script src="/assets/js/jquery.js"></script>
-->
<script src="/themes/default/js/bootstrap.min.js"></script>

<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>

<script type="text/javascript">
try {
    var pageTracker = _gat._getTracker("UA-3690486-1");
    pageTracker._trackPageview();
} catch(err) {}
</script>

<script type="text/javascript">
  var _cio = _cio || [];
  (function() {
    var a,b,c;a=function(f){return function(){_cio.push([f].
    concat(Array.prototype.slice.call(arguments,0)))}};b=["load","identify",
    "sidentify","track","page"];for(c=0;c<b.length;c++){_cio[b[c]]=a(b[c])};
    var t = document.createElement('script'),
        s = document.getElementsByTagName('script')[0];
    t.async = true;
    t.id    = 'cio-tracker';
    t.setAttribute('data-site-id', 'a38531baca441c7aa98f');
    t.src = 'https://assets.customer.io/assets/track.js';
    s.parentNode.insertBefore(t, s);
  })();
</script>
</body>
</html>
