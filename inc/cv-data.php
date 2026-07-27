<?php
/**
 * CV content used by the dedicated CV template.
 *
 * @package Morten_Portfolio
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

return array(
    'profile' => array(
        'title'       => 'CV Morten Hammarstrøm',
        'portrait'    => get_template_directory_uri() . '/assets/images/morten.jpg',
        'portraitAlt' => 'Portrett av Morten Hammarstrøm',
    ),
    'contact' => array(
        'address' => 'Norddalsheia 57, 4641 Søgne',
        'phone'   => '+47 959 15 899',
        'email'   => 'morten.hammarstrom@gmail.com',
        'website' => 'hammarstrom.no',
    ),
    'shortFacts' => array(
        '44 år (f. 1982)',
        'Emigrert nordlending',
        'Samboer med Dag Alexander og katten Ella',
        'Reiseglad med forkjærlighet for Hellas og Thailand',
        'Engasjert i trening og fysisk aktivitet',
        'Motiveres av å bidra til andres utvikling og trivsel',
    ),
    'qualifications' => array(
        'Effektiv og nøyaktig',
        'Trives i hektiske og utfordrende arbeidsmiljøer',
        'Pedagogisk, ærlig og fleksibel',
        'Strukturert, ryddig og målrettet',
        'Hardtarbeidende med høy arbeidsmoral',
        'Optimistisk tilnærming og høy gjennomføringsevne',
    ),
    'languages' => array(
        array( 'name' => 'Norsk',   'level' => 100 ),
        array( 'name' => 'Engelsk', 'level' => 100 ),
        array( 'name' => 'Svensk',  'level' => 80 ),
        array( 'name' => 'Dansk',   'level' => 50 ),
    ),
    'references' => 'Tilgjengelige på forespørsel.',
    'digitalCv'  => array(
        'label' => 'Digital CV',
        'url'   => 'hammarstrom.no/cv',
        'note'  => '',
    ),
    'experience' => array(
        array(
            'company' => 'EnterCard',
            'period'  => 'Mars 2018–Mars 2026',
            'roles'   => array(
                array( 'title' => 'AML Investigator', 'description' => 'Ansvar for transaksjonsmonitorering av kredittkort og lån, sanksjonstreff, PEP/RCA, utvidet KYC og rapportering av potensielt mistenkelige saker.' ),
                array( 'title' => 'Application Handling Consultant', 'description' => 'Vurdering, analyse og avvikskontroll av refinansiering, lån og kredittkort, samt fraud-analyse, faglig støtte og opplæring i teamet.' ),
                array( 'title' => 'Collection Agent', 'description' => 'Kommunikasjon med debitorer, nedbetalingsplaner og behandling av kravsforespørsler fra NAV og Namsmannen.' ),
            ),
        ),
        array(
            'company' => 'Norwegian Air Shuttle',
            'period'  => 'April 2007–August 2017',
            'roles'   => array(
                array( 'title' => 'Resepsjonist Administrasjon | Hovedkontor Fornebu', 'description' => 'Resepsjon, møtebooking, sentralbord, post, kantinerapportering, fakturaoppfølging og koordinering mellom avdelinger.' ),
                array( 'title' => 'Cabin Line Trainer (CLT, 2014–2015)', 'description' => 'Oppfølging av nyutdannet kabinpersonell i tråd med gjeldende regelverk og prosedyrer.' ),
                array( 'title' => 'Kabinsjef (SCCM, 2013–2014)', 'description' => 'Ansvar for sikkerhet, punktlighet, kundeservice, koordinering og avviksrapportering om bord.' ),
                array( 'title' => 'Kabinansatt (CCM, 2007–2013)', 'description' => 'Erfaring som kabinbesetning.' ),
            ),
        ),
        array(
            'company' => 'Aftenposten',
            'period'  => 'Juni 2002–Mai 2007',
            'roles'   => array(
                array( 'title' => 'Kundekonsulent', 'description' => 'Oppfølging av abonnenter og annonsører via e-post, telefon og faks, samt sentralbord, skranke og distribusjonskoordinering.' ),
            ),
        ),
        array(
            'company' => 'Tidligere arbeidserfaring',
            'period'  => 'November 2010–Mai 2011',
            'roles'   => array(
                array( 'title' => 'Bartender | SoHo, Oslo sentrum' ),
                array( 'title' => 'Salgsmedarbeider | Shell Bjerkvik, Narvik' ),
            ),
        ),
    ),
    'education' => array(
        array( 'title' => 'Bachelor of Management | Handelshøyskolen BI', 'period' => 'Januar 2018–Februar 2022', 'description' => 'Bachelorgrad med fordypning i ledelse, endringsledelse og økonomi. Studiet omfattet blant annet teamutvikling, coaching, logistikk, finans, regnskap, mikroøkonomi, digital forretningsforståelse, rekruttering og statistikk.' ),
        array( 'title' => 'Samfunnsfag | Sonans', 'period' => 'August 2011–Desember 2011', 'description' => 'Privatist i samfunnsfag.' ),
        array( 'title' => 'Allmennfaglig studieretning | Frydenlund Videregående skole', 'period' => 'August 1998–Juni 2001', 'description' => 'Generell studiekompetanse.' ),
    ),
    'courses' => array(
        array( 'title' => 'Farmen | Realityprogram, TV2', 'period' => 'August 2001–Desember 2001', 'description' => 'Deltaker i TV2s første sesong av konseptet Farmen.' ),
        array( 'title' => 'Tillitsvalgt / Varamedlem | Norwegian Cabin Union', 'period' => 'Februar 2015–September 2015', 'description' => 'Varamedlem i NKF.' ),
        array( 'title' => 'Lederskapskurs Cabin Management | Norwegian', 'period' => 'Oktober 2013', 'description' => 'Kabinledelseskurs med fokus på motivasjon, kommunikasjon og ledelse.' ),
        array( 'title' => 'Recurrent Training | Norwegian', 'period' => 'Årlig 2007–2015', 'description' => 'Årlige sertifiserings- og vedlikeholdstreninger innen førstehjelp, sikkerhetsprosedyrer og Crew Resource Management.' ),
        array( 'title' => 'Initialkurs Cabin Crew | Norwegian', 'period' => 'April 2007–Mai 2007', 'description' => 'Åtte ukers grunnkurs med fokus på sikkerhetsprosedyrer, førstehjelp og regelverk for sivil luftfart.' ),
    ),
);
