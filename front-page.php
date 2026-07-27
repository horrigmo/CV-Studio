<?php
/**
 * Portfolio front page.
 *
 * @package Morten_Portfolio
 */
get_header();

$primary_url = get_theme_mod( 'hero_primary_url', '/cv' );
if ( 0 === strpos( $primary_url, '/' ) ) {
    $primary_url = home_url( $primary_url );
}
$secondary_url = get_theme_mod( 'hero_secondary_url', '#kontakt' );
?>
<main id="main-content">
    <section class="hero">
        <div class="container hero-grid">
            <div class="hero-content reveal">
                <span class="eyebrow"><?php echo esc_html( get_theme_mod( 'hero_eyebrow', 'Profesjonell profil' ) ); ?></span>
                <h1>
                    <?php echo esc_html( get_theme_mod( 'hero_title', 'Struktur, analyse og' ) ); ?>
                    <span><?php echo esc_html( get_theme_mod( 'hero_highlight', 'menneskelig forståelse.' ) ); ?></span>
                </h1>
                <p class="hero-lead"><?php echo esc_html( get_theme_mod( 'hero_lead', 'Erfaring fra finans, luftfart og kundeservice, kombinert med en bachelorgrad i ledelse. Jeg trives best i roller der kvalitet, ansvar og tydelig kommunikasjon står sentralt.' ) ); ?></p>
                <div class="hero-actions">
                    <a class="button primary" href="<?php echo esc_url( $primary_url ); ?>"><?php echo esc_html( get_theme_mod( 'hero_primary_label', 'Se full CV' ) ); ?></a>
                    <a class="button secondary" href="<?php echo esc_url( $secondary_url ); ?>"><?php echo esc_html( get_theme_mod( 'hero_secondary_label', 'Ta kontakt' ) ); ?></a>
                </div>
            </div>
            <div class="hero-visual reveal" aria-hidden="true">
                <div class="hero-monogram">MH</div>
            </div>
        </div>
    </section>

    <section class="section section-light" id="profil">
        <div class="container narrow">
            <div class="section-heading reveal">
                <span class="eyebrow"><?php esc_html_e( 'Profil', 'morten-portfolio' ); ?></span>
                <h2><?php echo esc_html( get_theme_mod( 'profile_title', 'En rolig og løsningsorientert tilnærming.' ) ); ?></h2>
                <p><?php echo esc_html( get_theme_mod( 'profile_intro', 'Jeg arbeider strukturert, lærer raskt og tar ansvar for at oppgaver blir fulgt helt i mål.' ) ); ?></p>
            </div>
            <div class="focus-grid">
                <article class="focus-item reveal"><span class="focus-number">01</span><h3><?php esc_html_e( 'Analyse og kvalitet', 'morten-portfolio' ); ?></h3><p><?php esc_html_e( 'Grundig vurdering, avvikskontroll og risikoforståelse fra finansielle tjenester og AML.', 'morten-portfolio' ); ?></p></article>
                <article class="focus-item reveal"><span class="focus-number">02</span><h3><?php esc_html_e( 'Kommunikasjon', 'morten-portfolio' ); ?></h3><p><?php esc_html_e( 'Tydelig dialog med kunder, kolleger og eksterne samarbeidspartnere.', 'morten-portfolio' ); ?></p></article>
                <article class="focus-item reveal"><span class="focus-number">03</span><h3><?php esc_html_e( 'Opplæring og utvikling', 'morten-portfolio' ); ?></h3><p><?php esc_html_e( 'Erfaring med trening, oppfølging og kompetanseutvikling i operative miljøer.', 'morten-portfolio' ); ?></p></article>
            </div>
        </div>
    </section>

    <section class="section" id="erfaring">
        <div class="container narrow">
            <div class="section-heading reveal"><span class="eyebrow"><?php esc_html_e( 'Erfaring', 'morten-portfolio' ); ?></span><h2><?php echo esc_html( get_theme_mod( 'experience_title', 'Arbeidserfaring fra tre tydelige fagområder.' ) ); ?></h2></div>
            <div class="experience-list">
                <article class="experience-item reveal"><div class="experience-period"><span>2018–2026</span></div><div class="experience-content"><span class="company">EnterCard</span><h3><?php esc_html_e( 'Finans, AML og søknadsbehandling', 'morten-portfolio' ); ?></h3><p><?php esc_html_e( 'Arbeid med transaksjonsmonitorering, sanksjoner, KYC, svindelvurdering, kredittsøknader og kundedialog.', 'morten-portfolio' ); ?></p></div></article>
                <article class="experience-item reveal"><div class="experience-period"><span>2007–2017</span></div><div class="experience-content"><span class="company">Norwegian Air Shuttle</span><h3><?php esc_html_e( 'Luftfart, ledelse og service', 'morten-portfolio' ); ?></h3><p><?php esc_html_e( 'Erfaring som kabinansatt, kabinsjef, Cabin Line Trainer og resepsjonist ved hovedkontoret.', 'morten-portfolio' ); ?></p></div></article>
                <article class="experience-item reveal"><div class="experience-period"><span>2002–2007</span></div><div class="experience-content"><span class="company">Aftenposten</span><h3><?php esc_html_e( 'Kundeservice og koordinering', 'morten-portfolio' ); ?></h3><p><?php esc_html_e( 'Oppfølging av abonnenter og annonsører, sentralbord, skranke og distribusjon.', 'morten-portfolio' ); ?></p></div></article>
            </div>
        </div>
    </section>

    <section class="section education-section" id="utdanning">
        <div class="container education-grid">
            <div class="reveal"><span class="eyebrow eyebrow-light"><?php esc_html_e( 'Utdanning', 'morten-portfolio' ); ?></span><h2><?php echo esc_html( get_theme_mod( 'education_title', 'Bachelor of Management' ) ); ?></h2></div>
            <div class="education-content reveal"><span class="education-school"><?php echo esc_html( get_theme_mod( 'education_school', 'Handelshøyskolen BI' ) ); ?></span><span class="education-period"><?php echo esc_html( get_theme_mod( 'education_period', '2018–2022' ) ); ?></span><p><?php echo esc_html( get_theme_mod( 'education_text', 'Fordypning i ledelse, endringsledelse og økonomi, med fag innen blant annet teamutvikling, coaching, logistikk, finans og digital forretningsforståelse.' ) ); ?></p><div class="education-tags"><span>Ledelse</span><span>Endringsledelse</span><span>Økonomi</span><span>Analyse</span></div></div>
        </div>
    </section>

    <section class="section contact-section" id="kontakt">
        <div class="container contact-grid">
            <div class="contact-content reveal"><span class="eyebrow eyebrow-light"><?php esc_html_e( 'Kontakt', 'morten-portfolio' ); ?></span><h2><?php echo esc_html( get_theme_mod( 'contact_title', 'Ta gjerne kontakt.' ) ); ?></h2><p><?php echo esc_html( get_theme_mod( 'contact_text', 'Kontaktinformasjon er også tilgjengelig i den fullstendige CV-en.' ) ); ?></p><a class="button light" href="<?php echo esc_url( $primary_url ); ?>"><?php echo esc_html( get_theme_mod( 'hero_primary_label', 'Åpne CV' ) ); ?></a></div>
            <div class="contact-details reveal">
                <?php $email = get_theme_mod( 'contact_email', 'morten.hammarstrom@gmail.com' ); ?>
                <div class="contact-detail"><span><?php esc_html_e( 'E-post', 'morten-portfolio' ); ?></span><a href="mailto:<?php echo esc_attr( antispambot( $email ) ); ?>"><?php echo esc_html( antispambot( $email ) ); ?></a></div>
                <?php $phone = get_theme_mod( 'contact_phone', '+47 959 15 899' ); ?>
                <div class="contact-detail"><span><?php esc_html_e( 'Telefon', 'morten-portfolio' ); ?></span><a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a></div>
                <div class="contact-detail"><span><?php esc_html_e( 'Nettside', 'morten-portfolio' ); ?></span><a href="<?php echo esc_url( get_theme_mod( 'contact_website', 'https://hammarstrom.no' ) ); ?>"><?php echo esc_html( get_theme_mod( 'contact_website_label', 'hammarstrom.no' ) ); ?></a></div>
            </div>
        </div>
        <div class="container footer"><span>© <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?></span><span><?php esc_html_e( 'Personlig portefølje', 'morten-portfolio' ); ?></span></div>
    </section>
</main>
<?php get_footer(); ?>
