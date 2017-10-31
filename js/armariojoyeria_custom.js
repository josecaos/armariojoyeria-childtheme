// Agregados: ready tema armariojoyeria
// ready
jQuery(document).ready(function() {

	sticker_descuentos()

})// fin ready

// Agregados: funciones tema armariojoyeria

function sticker_descuentos() {


	jQuery('.product-wrapper').each(function(index) {
		// var descuento = jQuery(this).find('.special-price .woocommerce-Price-amount').text()
		// var precio = jQuery(this).find('.old-price .woocommerce-Price-amount').text()
		var precioFinal,precioInicial,precioFinalClean,precioInicialClean
		var oper,tdescuento,tprecio,oper,descuento

		// si el elemento contiene descuento
		if (jQuery(this).has('.onsale').length > 0) {

			// limpia los precios para la operacion
			precioFinal = jQuery(this).find('span.special-price span.amount')
			precioFinal.children().remove()//quita elemento antes del texto
			precioFinalClean = precioFinal.text()//regresa el precio sin simbolo

			precioInicial = jQuery(this).find('span.old-price span.amount')
			precioInicial.children().remove()
			precioInicialClean = precioInicial.text()

			// console.log(precioFinalClean + ' descuento ' + precioFinalClean.length/4 )// regresa el precio sin repeticiones
			// console.log(precioInicialClean + ' precio ' + precioInicialClean.length/4)

			tDescuento = precioFinalClean.slice(0,precioFinalClean.length/4)
			tPrecio = precioInicialClean.slice(0,precioInicialClean.length/4)

			oper = (1 - (tDescuento/tPrecio) ) * 100

			// console.log(tDescuento + ' descuento ')// regresa el precio sin repeticiones
			// console.log(tPrecio + ' precio ')

			descuento = Math.round(oper)

			// console.log(total + '%' + ' Total ')

			if ( oper >= 1) {

				jQuery(this).find('span.sale-text').html('- ' + descuento + '%')//imprime resultado

			} else {

				jQuery(this).find('span.sale-text').html('99%')//resultado fijo

			}
		}
	})
}




// function sticker_descuentos() {
// 	// Hack para utilizar el sticker de descuento por defecto de Woocommerce,
// 	//para mostrar distintos mensajes, según su precio final
// 	var descuentos = ['uno%'/*0*/,'dos%'/*1*/,'Ajua%'/*2*/,'cuatro%'/*3*/,'X%'/*4*/]
// 	//relacionar indices con el indice de el array -> precios.
//
// 	var precios = [
// 		'99.9999.9999.9999.99',//indice 0  - $99.99
// 		'100.00100.00100.00100.00',//indice 1  - $100.00
// 		'100.99100.99100.99100.99',//indice 2  - $100.99
// 		'60.9960.9960.9960.99',//indice 3  - $60.99
// 		'50.9950.9950.9950.99'//indice 4  - $50.99
// 	]//sustituir por los precios reales
//
// 	// debug: en la iteracion del each manda los valores 4 veces sin espacio
//
// 	var comparacion
//
// 	jQuery('.product-wrapper').each(function(index) {
//
// 		// si existe sticker en el contenedor del producto
// 		if (jQuery(this).has('.onsale').length > 0) {
//
//
// 			clone = jQuery(this).find('span.special-price span.amount')
// 			clone.children().remove()
// 			comparacion = clone.text()
//
// 			switch (comparacion) {
// 				case precios[0]:
// 				jQuery(this).find('span.sale-text').html(descuentos[0])
// 				// console.log(comparacion)
// 				break;
// 				case precios[1]:
// 				jQuery(this).find('span.sale-text').html(descuentos[1])
// 				// console.log(comparacion)
// 				break;
// 				case precios[2]:
// 				jQuery(this).find('span.sale-text').html(descuentos[2])
// 				// console.log(comparacion)
// 				break;
// 				case precios[3]:
// 				jQuery(this).find('span.sale-text').html(descuentos[3])
// 				// console.log(comparacion)
// 				break;
// 				case precios[4]:
// 				jQuery(this).find('span.sale-text').html(descuentos[4])
// 				// console.log(comparacion)
// 				break;
// 				default:
//
// 			}
//
// 		}
//
// 	})
//
// 	// console.log(comparacion);
// }
