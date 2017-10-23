<?php
    /**
     * Socail share links for Matra Kempo WP theme - included in the loop.php, appears on the bottom of the single post pages
    */
?>

<?php # Social share widgets ?>
<div class="blk blk--i ie7-i-blk-fix mr-20 pb-20">
  <a class="blk social-button fb" href="https://www.facebook.com/sharer/sharer.php?u=<?php urlencode(the_permalink()); ?>" title="Megosztás Facebookon">
    <span class="icon sprite fb"></span>
    Facebook
  </a>
</div><div class="blk blk--i ie7-i-blk-fix mr-20 pb-20">
  <a class="blk social-button twit" href="https://twitter.com/intent/tweet?text=<?php urlencode(the_title()); ?>&url=<?php urlencode(the_permalink()); ?>" title="Megosztás Twitter">
    <span class="icon sprite twit"></span>
    Twitter
  </a>
</div><div class="blk blk--i ie7-i-blk-fix mr-20 pb-20">
  <a class="blk social-button gplus" href="https://plus.google.com/share?url=<?php urlencode(the_permalink()); ?>" title="Megosztás Google+">
    <span class="icon sprite gplus"></span>
    Google+
  </a>
</div>
<?php # End social share widgets ?>
