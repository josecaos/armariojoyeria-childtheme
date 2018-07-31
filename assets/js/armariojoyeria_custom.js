// Agregados: ready tema armariojoyeria
// ready
jQuery(document).ready(function() {

	sticker_descuentos()
	alert('test JS')

})// fin ready

function sticker_descuentos() {

	jQuery('.product-wrapper').each(function(index) {
		var precioFinal,precioInicial,precioFinalClean,precioInicialClean
		var oper,tdescuento,tprecio,descuento
		var cleanOldNumber,cleanNewNumber

		// si el elemento contiene descuento
		if (jQuery(this).has('span.onsale')) {

			// limpia los precios para la operacion
			precioFinal = jQuery(this).find('span.special-price span.amount')
			precioFinal.children().remove()//quita elemento antes del texto
			precioFinalClean = precioFinal.text()//regresa el precio sin simbolo
			cleanNewNumber=precioFinalClean.replace(/\,/g,'') // 1125, but a string, so convert it to number
			cleanNewNumber=parseInt(cleanNewNumber,10)
			console.log(cleanNewNumber)

			precioInicial = jQuery(this).find('span.old-price span.amount')
			precioInicial.children().remove()
			precioInicialClean = precioInicial.text()
			cleanOldNumber=precioInicialClean.replace(/\,/g,'') // 1125, but a string, so convert it to number
			cleanOldNumber=parseInt(cleanOldNumber,10)
			console.log(cleanOldNumber)

			tDescuento = cleanNewNumber
			tPrecio = cleanOldNumber

			oper = (1 - (tDescuento/tPrecio) ) * 100

			console.log(oper)

			descuento = Math.round(oper)

			if ( oper >= 1) {

				jQuery(this).find('span.sale-text').html('- ' + descuento + '%')//imprime resultado

			} else {

				jQuery(this).find('span.sale-text').html('Oferta')//resultado fijo

			}
		}
	})
}
