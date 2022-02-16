<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$options = Cookie_Notice::$options_schema;
$fields  = $options[0]['fields'];
$enable  = get_option( 'enableCookieNotice' ) ? get_option( 'enableCookieNotice' ) : $fields[0]['default'];

$style_options    = $options[1]['fields'];
$bg               = get_option( 'cookieNoticeBg' ) ? get_option( 'cookieNoticeBg' ) : $style_options[0]['default'];
$text_font_size   = get_option( 'cookieNoticeFontSize' ) ? get_option( 'cookieNoticeFontSize' ) : $style_options[1]['default'];
$text_aligh       = get_option( 'cookieNoticeAlign' ) ? get_option( 'cookieNoticeAlign' ) : $style_options[2]['default'];
$text_color       = get_option( 'cookieNoticeTextColor' ) ? get_option( 'cookieNoticeTextColor' ) : $style_options[3]['default'];
$btn_font_size    = get_option( 'cookieNoticeBtnFontSize' ) ? get_option( 'cookieNoticeBtnFontSize' ) : $style_options[4]['default'];
$btn_bg           = get_option( 'cookieNoticeBtnBgColor' ) ? get_option( 'cookieNoticeBtnBgColor' ) : $style_options[5]['default'];
$btn_text_color   = get_option( 'cookieNoticeBtnTextColor' ) ? get_option( 'cookieNoticeBtnTextColor' ) : $style_options[6]['default'];
$btn_border_color = get_option( 'cookieNoticeBtnBorderColor' ) ? get_option( 'cookieNoticeBtnBorderColor' ) : $style_options[7]['default'];

if ( $enable ) {
	?>
	<style>
		.cookie-popup {
			background-color: <?php echo $overlay_bg; ?>;
		}
		.cookie-popup__txt,
		.cookie-popup__txt p {
			font-size: <?php echo $text_font_size; ?>px;
			text-align: <?php echo $text_aligh; ?>;
			color: <?php echo $text_color; ?>;
		}
		.cookie-popup__btn .btn-primary {
			font-size: <?php echo $btn_font_size; ?>px;
			color: <?php echo $btn_text_color; ?>;
			background-color: <?php echo $btn_bg; ?>;
			border-color: <?php echo $btn_border_color; ?>;
		}
	</style>
<?php } ?>
