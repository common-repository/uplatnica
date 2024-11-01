<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://deutrix.com
 * @since      1.0.0
 *
 * @package    Uplatnica
 * @subpackage Uplatnica/public/partials
 */

function qr_kod($atts)
{
    return '<div class="qr_kod" data-platilac="' . esc_attr($atts['platilac']) . '"  data-primalac="' . esc_attr($atts['primalac']) . '" data-svrha="' . esc_attr($atts['svrha']) . '" data-sifra="' . esc_attr($atts['sifra']) . '" data-valuta="' . esc_attr($atts['valuta']) . '" data-iznos="' . esc_attr($atts['iznos']) . '" data-racun="' . esc_attr($atts['racun']) . '" data-model="' . esc_attr($atts['model']) . '" data-poziv="' . esc_attr($atts['poziv']) . '" data-size="' . esc_attr($atts['size']) . '"></div>';
}

add_shortcode('qr_kod', 'qr_kod');


function uplatnica($atts)
{
    extract(shortcode_atts(array(
        'iznos' => '0,00',
        'model' => '',
    ), $atts));

    $prefix = substr($atts['racun'], 0, 3);
    $sufix = substr($atts['racun'], -2);
    $broj = substr($atts['racun'], 3, -2);

    $brojRacuna = $prefix . '-' . $broj . '-' . $sufix;

    $qr = 'true' === $atts['qr'] ? qr_kod($atts) : '';
    $iznos = number_format((float)$atts['iznos'], 2);

    $allowed_html = array(
        'br'     => array(),
    );

    return sprintf('<div class="nalog-wrapper"><div class="nalog-row"><div class="nalog-column nalog-top"><div>НАЛОГ ЗА УПЛАТУ</div></div><div class="nalog-column nalog-left"><div class="nalog-input nalog-large"><span>платилац</span><div>%s</div></div><div class="nalog-input nalog-large"><span>сврха уплате</span><div>%s</div></div><div class="nalog-input nalog-large"><span>прималац</span><div>%s</div></div><div class="nalog-line">печат и потпис уплатиоца</div></div><div class="nalog-column-separator"><div class="separator"></div></div><div class="nalog-column nalog-right"><div class="nalog-first"><div><div class="nalog-input nalog-small"><span>шифра<br>плаћања</span><div>%d</div></div></div><div> <div class="nalog-input nalog-small"><span><br>валута</span><div style="text-transform:uppercase">%s</div></div></div><div><div class="nalog-input nalog-small"><span><br>износ</span><div>%s</div></div></div></div><div class="nalog-second"><div class="nalog-input nalog-small"><span>рачун примаоца</span><div>%s</div></div></div><div class="label"><span>модел и позив на одобрење</span></div><div class="nalog-third"><div><div class="nalog-input nalog-small"><div>%s</div></div></div><div><div class="nalog-input nalog-small"><div>%s</div></div></div></div><div class="nalog-qr">%s</div></div><div class="nalog-column nalog-bottom"><div><div class="nalog-line">место и датум пријема</div></div><div></div><div><div class="nalog-line">датум валуте</div></div></div></div></div>', wp_kses($atts['platilac'], $allowed_html), esc_attr($atts['svrha']), esc_attr($atts['primalac']), esc_attr($atts['sifra']), esc_attr($atts['valuta']), esc_attr($iznos), esc_attr($brojRacuna), esc_attr($atts['model']), esc_attr($atts['poziv']), $qr);
}
add_shortcode('uplatnica', 'uplatnica');
