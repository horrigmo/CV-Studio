<?php
if(!defined('ABSPATH')) exit;

class CV_Studio_Dashboard {
    public static function init(){
        add_action('admin_menu',[__CLASS__,'menu']);
    }
    public static function menu(){
        add_menu_page(
            'CV Studio',
            'CV Studio',
            'edit_posts',
            'cv-studio',
            [__CLASS__,'render'],
            'dashicons-id',
            25
        );
    }
    public static function render(){ ?>
<div class="wrap cvstudio">
<h1>CV Studio</h1>
<div class="cvstudio-grid">
<div class="card"><h2>Experience</h2><p>--</p></div>
<div class="card"><h2>Education</h2><p>--</p></div>
<div class="card"><h2>Courses</h2><p>--</p></div>
<div class="card"><h2>CV Health</h2><p>Coming in Sprint 1.4</p></div>
</div>
</div>
<?php }
}
CV_Studio_Dashboard::init();
