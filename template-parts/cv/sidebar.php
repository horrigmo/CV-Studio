<?php
$settings=morten_portfolio_cv_get_settings();
$portrait_id=(int)($settings['portrait_id']??0); if(!$portrait_id&&has_post_thumbnail())$portrait_id=get_post_thumbnail_id();
$short=morten_portfolio_cv_lines(morten_cv_setting('short_facts',$settings['short_facts']));
$quals=morten_portfolio_cv_lines(morten_cv_setting('qualifications',$settings['qualifications']));
$languages=morten_portfolio_cv_lines(morten_cv_setting('languages',$settings['languages']));
?>
<aside class="cv-sidebar">
<div class="portrait-ring<?php echo $portrait_id?'':' portrait-missing'; ?>"><?php if($portrait_id)echo wp_get_attachment_image($portrait_id,'large',false,array('class'=>'portrait','alt'=>esc_attr($settings['name']))); ?></div>
<div class="contact-list" aria-label="<?php echo esc_attr(morten_cv_label('Kontaktinformasjon','Contact information')); ?>">
<?php if($settings['address']):?><div class="contact-row"><span>⌂</span><p><?php echo esc_html($settings['address']);?></p></div><?php endif;?>
<?php if($settings['phone']):?><div class="contact-row"><span>☎</span><p><?php echo esc_html($settings['phone']);?></p></div><?php endif;?>
<?php if($settings['email']):?><div class="contact-row"><span>✉</span><p><?php echo esc_html(antispambot($settings['email']));?></p></div><?php endif;?>
<?php if($settings['website']):?><div class="contact-row"><span>↗</span><p><?php echo esc_html($settings['website']);?></p></div><?php endif;?>
</div>
<?php foreach(array(array($short,morten_cv_label('Kort fortalt','Profile')),array($quals,morten_cv_label('Nøkkelkvalifikasjoner','Key qualifications'))) as $block): if(!$block[0])continue;?><section class="sidebar-section"><h3><?php echo esc_html($block[1]);?></h3><ul><?php foreach($block[0] as $line):?><li><?php echo esc_html($line);?></li><?php endforeach;?></ul></section><?php endforeach;?>
<?php if($languages):?><section class="sidebar-section"><h3><?php echo esc_html(morten_cv_label('Språk','Languages'));?></h3><?php foreach($languages as $line){$parts=array_map('trim',explode('|',$line));$name=$parts[0]??'';$level=max(0,min(100,(int)($parts[1]??100)));?><div class="language"><span><?php echo esc_html($name);?></span><i style="--p:<?php echo esc_attr($level);?>%"></i><b><?php echo esc_html($level);?>%</b></div><?php }?></section><?php endif;?>
<?php $refs=morten_cv_setting('references',$settings['references']);if($refs):?><section class="sidebar-section"><h3><?php echo esc_html(morten_cv_label('Referanser','References'));?></h3><p><?php echo esc_html($refs);?></p></section><?php endif;?>
<?php if($settings['digital_cv_url']):?><section class="sidebar-section"><h3><?php echo esc_html(morten_cv_setting('digital_cv_label',$settings['digital_cv_label']));?></h3><p><?php echo esc_html($settings['digital_cv_url']);?></p></section><?php endif;?>
</aside>
