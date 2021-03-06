<?php
/**
 * Try to get addons from the transient.
 * 
 * @var object
 */
$items = get_transient( 'wpas_addons' );
setlocale( LC_MONETARY, get_locale() );

if ( false === $items ) {

	$route    = esc_url( 'http://getawesomesupport.com/edd-api/products/' );
	$api_key  = trim( 'd83df1849d3204ed6641faa92ed55eb2' );
	$token    = trim( '39e17c3737d608900e2f403b55dda68d' );
	$endpoint = add_query_arg( array( 'key' => $api_key, 'token' => $token ), $route );
	$response = wp_remote_get( $endpoint );

	if ( 200 === wp_remote_retrieve_response_code( $response ) ) {

		$body = wp_remote_retrieve_body( $response );
		$content = json_decode( $body );
		
		if ( is_object( $content ) && isset( $content->products ) ) {
			set_transient( 'wpas_addons', $content->products, 60 * 60 * 24 ); // Cache for 24 hours
			$items = $content->products;
		}

	}
}
?>

<style type="text/css">
.wpas-addon-all {
	padding-top: 40px;
}
.wpas-addon-item + .wpas-addon-item {
	margin-top: 40px;
	padding-top: 40px;
	border-top: 1px solid #ddd;	
}
.wpas-addon-item .inside {
	padding-left: 30px;
}
.wpas-addon-item h3 {
	margin-top: 0px;
	padding-top: 0px;
}
.wpas-addon-img {
	box-shadow: 0px 0px 25px rgba(0,0,0,0.25);
}
.wpas-addon-item-pricing {
	background: white;
	padding: 5px 10px;
	border: 1px solid #ddd;
	border-radius: 3px;
}
.wpas-btn-group .button-secondary {
	cursor: default;
}
</style>

<div class="wrap about-wrap">
	<h1>Addons</h1>
	<div class="about-text">Even though Awesome Support has a lot of built-in features, it is impossible to make everyone happy. This is why we have lots of addons to help you tailor your support system.</div>

	<div class="changelog wpas-addon-all">
		<?php
		if ( false === $items ):
			?><p>To check out all our addons please visit <a href="http://getawesomesupport.com/addons" target="_blank">http://getawesomesupport.com/addons</a></p><?php
		else:
			// wpas_debug_display( $items );
			foreach ( $items as $key => $item ):

				$content = wp_trim_words( $item->info->content, $num_words = 70, $more = '…' );

				/* Get the item price */
				$price = false;

				/* This item has a fixed price */
				if ( isset( $item->pricing->amount ) ) {
					$price = number_format( $item->pricing->amount, 0 );
				}

				/* This item has variable pricing */
				else {
					if ( isset( $item->pricing->singlesite ) ) {
						$price = number_format( $item->pricing->singlesite, 0 );
					}
				} ?>

				<div class="row wpas-addon-item" id="wpas-addon-item-<?php echo intval( $item->info->id ); ?>">
					<div class="col-xs-12 col-sm-6 col-md-5 col-lg-5 wpas-addon-img-wrap">
						<?php if ( !empty( $item->info->thumbnail ) ): ?><img class="wpas-addon-img" src="<?php echo esc_url( $item->info->thumbnail ); ?>"><?php endif; ?>
					</div>
					<div class="col-xs-12 col-sm-6 col-md-7 col-lg-7">
						<div class="inside">
							<h3><?php echo esc_attr( $item->info->title ); ?> <small class="wpas-addon-item-pricing">from <?php if ( false !== $price ): ?><strong>$<?php echo $price; ?></strong><?php endif; ?></small></h3>
							<p><?php if ( !empty( $content ) ): echo wpautop( $content ); endif; ?></p>
							<div class="wpas-btn-group">
								<span class="button-secondary"><?php if ( false !== $price ): ?>$<?php echo $price; ?><?php endif; ?></span><a class="button-primary" href="<?php echo esc_url( $item->info->link ); ?>&amp;utm_source=plugin&amp;utm_medium=addon_page&amp;utm_campaign=promote_addons" target="_blank">Details and Buy</a>
							</div>
						</div>
					</div>
				</div>
			<?php endforeach;

		endif; ?>
	</div>
</div>