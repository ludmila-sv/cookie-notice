<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$options = Cookie_Notice::$options_schema;
$fields  = $options[0]['fields'];

$enable   = get_option( 'enableCookieNotice' ) ? get_option( 'enableCookieNotice' ) : $fields[0]['default'];
$text     = get_option( 'cookieNoticeText' ) ? get_option( 'cookieNoticeText' ) : $fields[1]['default'];
$btn_text = get_option( 'cookieNoticeBtnText' ) ? get_option( 'cookieNoticeBtnText' ) : $fields[2]['default'];

if ( $enable ) {
	?>
	<div class="cookie-popup">
		<div class="container">
			<div class="cookie-popup__body">
				<div class="cookie-popup__txt">
					<?php echo esc_html( $text ); ?>
				</div>
				<div class="cookie-popup__btn">
					<button class="btn btn-primary" id="cookie-btn"><?php echo esc_html( $btn_text ); ?></button>
				</div>
			</div>
		</div>
	</div>
<?php } ?>

