<div class="search_box">
    <form action="<?php echo esc_url(home_url('/')) ?>" method="GET" class="input-append">
        <input name="post_type" type="hidden" value="<?php  echo BravoInput::request('post_type','post') ?>">
        <input type="text" value="<?php echo BravoInput::request('s') ?>" placeholder="<?php _e("Search","bizone") ?>" name="s" >
        <i  class="btn_search_box fa fa-search"></i>
    </form>
</div>