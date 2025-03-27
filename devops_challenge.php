<?php
/**
 * Plugin para exibir letras do Tchan no rodapé do WordPress.
 *
 * @package     Devops_Challenge_Junior
 * @version     1.0.0
 * @author      Apiki WordPress
 * @license     GPL-2.0+
 */

/*
Plugin Name: Devops Challenge Júnior
Plugin URI: https://apiki.com/
Description: Plugin que exibe letras do Tchan no rodapé do WordPress
Author: Apiki WordPress
Version: 1.0.0
Text Domain: devops-challenge
Domain Path: /languages
License: GPL-2.0+
*/

// Previne acesso direto ao arquivo
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Registra o domínio de texto para internacionalização
 */
function devops_challenge_load_textdomain() {
    load_plugin_textdomain('devops-challenge', false, dirname(plugin_basename(__FILE__)) . '/languages');
}
add_action('plugins_loaded', 'devops_challenge_load_textdomain');

/**
 * Retorna uma letra aleatória do Tchan
 *
 * @return string Letra aleatória do Tchan
 */
function devops_challenge_get_lyrics() {
    $lyrics = array(
        __('Pau que nasce torto nunca se endireita', 'devops-challenge'),
        __('Menina que requebra a mãe pega na cabeça', 'devops-challenge'),
        __('Domingo ela não vai (vai, vai)', 'devops-challenge'),
        __('Domingo ela não vai não (vai, vai, vai)', 'devops-challenge'),
        __('Olha, domingo ela não vai (vai, vai)', 'devops-challenge'),
        __('Domingo ela não vai não (vai, vai, vai)', 'devops-challenge'),
        __('Segure o tchan', 'devops-challenge'),
        __('Amare o tchan', 'devops-challenge'),
        __('Segure o tchan tchan tchan tchan', 'devops-challenge'),
        __('Depois de nove meses você vê o resultado', 'devops-challenge'),
        __('Esse é o Gera Samba arrebentando no pedaço', 'devops-challenge'),
        __('Joga ela no meio, mete em cima, mete embaixo', 'devops-challenge')
    );

    return wptexturize($lyrics[array_rand($lyrics)]);
}

/**
 * Exibe a letra do Tchan no rodapé
 */
function devops_challenge_display() {
    // Verifica se estamos no admin ou no editor de blocos
    if (is_admin() || (function_exists('is_block_editor') && is_block_editor())) {
        return;
    }

    // Adiciona nonce para segurança
    $nonce = wp_create_nonce('devops_challenge_display');
    
    $lang = '';
    if (strpos(get_user_locale(), 'en_') !== 0) {
        $lang = ' lang="en"';
    }

    $chosen = devops_challenge_get_lyrics();
    printf(
        '<div id="devops-challenge" class="devops-challenge"%s data-nonce="%s"><span class="devops-challenge-title">%s</span> <span class="devops-challenge-lyrics">%s</span></div>',
        esc_attr($lang),
        esc_attr($nonce),
        esc_html__('Segure o Tchan, by Apiki WordPress:', 'devops-challenge'),
        esc_html($chosen)
    );
}
add_action('wp_footer', 'devops_challenge_display');

/**
 * Registra e enfileira os estilos CSS
 */
function devops_challenge_enqueue_styles() {
    wp_register_style(
        'devops-challenge-styles',
        false,
        array(),
        '1.0.0'
    );
    
    $css = '
    .devops-challenge {
        display: flex;
        justify-content: center;
        padding: 5px 10px;
        margin: 0;
        font-size: 12px;
        line-height: 1.6666;
    }
    .rtl .devops-challenge {
        float: left;
    }
    @media screen and (max-width: 782px) {
        .devops-challenge,
        .rtl .devops-challenge {
            float: none;
            padding-left: 0;
            padding-right: 0;
            text-align: center;
        }
    }
    .devops-challenge-title {
        font-weight: bold;
    }';

    wp_add_inline_style('devops-challenge-styles', $css);
    wp_enqueue_style('devops-challenge-styles');
}
add_action('wp_enqueue_scripts', 'devops_challenge_enqueue_styles');
?>