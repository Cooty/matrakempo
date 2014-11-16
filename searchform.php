<form method="get" role="search" action="<?php bloginfo('url');?>" class="search__wrapper" data-search-form>
    <input type="search" placeholder="Keresés a matrakempose.hu-n"  value="<?= (isset($_REQUEST['s']) ? $_REQUEST['s'] : ''); ?>" name="s" class="search__query wf wf--roboto wf--roboto--light" data-search-query>
    <span style="background:red;"><?php echo $_REQUEST['s']?></span>
    
    <button type="submit" class="btn search__submit" title="Keresés!">
        <span class="icon sprite loupe"></span>
    </button>
    <?php if(!is_search()): ?>
        <button type="reset" class="btn search__close" title="Keresés bezárása" data-search-toggler>
            <span class="icon sprite close"></span>
        </button>
    <?php endif; ?>
</form>