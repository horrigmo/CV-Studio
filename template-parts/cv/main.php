<?php $settings=morten_portfolio_cv_get_settings(); ?>
<section class="cv-main">
<header class="cv-header"><p class="cv-kicker"><?php echo esc_html(morten_cv_setting('headline',$settings['headline'])); ?></p><h1><?php echo esc_html($settings['name']); ?></h1></header>
<?php get_template_part('template-parts/cv/section',null,array('post_type'=>'cv_experience','title'=>morten_cv_label('Arbeidserfaring','Experience'))); ?>
<?php get_template_part('template-parts/cv/section',null,array('post_type'=>'cv_education','title'=>morten_cv_label('Utdanning','Education'))); ?>
<?php get_template_part('template-parts/cv/section',null,array('post_type'=>'cv_course','title'=>morten_cv_label('Kurs og øvrig erfaring','Courses and additional experience'))); ?>
</section>
