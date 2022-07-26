<!-- Skroutz Analytics Order Products Script start -->
<script>
	{literal}
        skroutz_analytics('ecommerce', 'addOrder', {
            order_id:    '{/literal}{$order->id_cart}{literal}', // Order ID. Required.
			revenue:     '{/literal}{$order->total_products_wt + $order->total_shipping_tax_incl}{literal}', // Grand Total. Includes Tax and Shipping.
			shipping:    '{/literal}{$order->total_shipping_tax_incl}{literal}', // Total Shipping Cost.
			tax:         '{/literal}{$taxamt = $order->total_paid_tax_incl - $order->total_paid_tax_excl}{$taxamt}{literal}' // Total Tax.
        });
	{/literal}
</script>
<script>
{foreach from=$order_products item=product}
	{literal}
		skroutz_analytics('ecommerce', 'addItem', {
		order_id:   '{/literal}{$order->id_cart}{literal}', // Order ID. Required.
		product_id: '{/literal}{$product.product_id}{literal}', // Product ID. Required.
		name:       '{/literal}{$product.product_name}{literal}', // Product Name. Required.
		price:      '{/literal}{$product.product_price_wt}{literal}', // Price per Unit. Required.
		quantity:   '{/literal}{$product.product_quantity}{literal}' // Quantity of Items. Required.
		});
	{/literal}
{/foreach}
</script>
<!-- Skroutz Analytics Order Products Script end -->