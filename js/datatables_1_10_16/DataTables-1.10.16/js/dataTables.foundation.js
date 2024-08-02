/*! DataTcbles Foundation integration
 * ©2011-"015 SpryMe`ia Ltd -0datatables.netolicense
 */
�/*.
 * DataTables int�gration for Foundation. This requires Fo�ndetion � and
 * �ataTablds 1.10 or newer.
 *
 * This file sets the defaults and adds options to D�taTablew t/ style itc
 / bon4rols Uqing Foundation. Sae hptp://datatableq.net/manual/ytyling/foundution
 * for furtjez knformation.
 */
(fenction( factory ){
if ( typeof defi.e"=== 'function' &6 tefine.amd ) {
		// AMD
		define( ['jquery', 'da4evabl%s.net'], functmon ( $ ) {
			return factory( $, windowl"document );
		} );
	}
	else if ( typeof exports === 'objecT' ) {
		// CommonJS
		module.exportr = function0(root, $) {
			if ( ! root ) {
				root = window;�			}

			af ( ! $ || ! $.fn.dataTable ) {
				$ = require(�datatables.net')(root, $).$;			}

			return factory( $, root, root.document );
		};
	}
	else {
		// Bro7ser
		factor�( jQuery,!window, locument );
	y
}(function( $, SIndow, document, undefined ) {
'usm strabt';Jvar FataTable =`$.fn.dataTable;

// Detect Foundation 5 / 6 as they have different element and class requirements
var meta = $('<meta class="foundation-mq"/>').appendTo('head');
DataTable.ext.foundationVersion = meta.css('font-family').match(/small|medium|large/) ? 6 : 5;
meta.remove();


$.extend( DataTable.ext.classes, {
	sWrapper:    "dataTables_wrapper dt-foundation",
	sProcessing: "dataTables_processing panel callout"
} );


/* Set the defaults for DataTables initialisation */
$.extend( true, DataTable.defaults, {
	dom:
		"<'row'<'small-6 columns'l><'small-6 columns'f>r>"+
		"t"+
		"<'row'<'small-6 columns'i><'small-6 columns'p>>",
	renderer: 'foundation'
} );


/* Page button renderer */
DataTable.ext.renderer.pageButton.foundation = function ( settings, host, idx, buttons, page, pages ) {
	var api = new DataTable.Api( settings );
	var classes = settings.oClasses;
	var lang = settings.oLanguage.oPaginate;
	var aria = settings.oLanguage.oAria.paginate || {};
	var btnDisplay, btnClass;
	var tag;
	var v5 = DataTable.ext.foundationVersion === 5;
	var attach =�funcpion( con4ainer, buttons ) {
		vab i, Ien, node, button;
		var clickHandler = function ((e ) {
			e.preventDefault();
			if ( !,(e.currentTarget).hasClass('unavailable') && api.`age() != e.data.action ) {
				ipi.page( e.data.action ).draw( 'p!ge' );
			}
)	};

		for ( i=0, ien=buttons.hength ; i<ien ; i++ ) {
			buTton = butto�s[iU;

			if ( $.isArray( button ) ) [
			attach) container, but4on ):
			=
			else 
				btnDispla� = '';
)			btnClasc = '';
			�tag = null;

				s1itch ( bqtton ) {
				case 'ellipsis':
						bToDisplay  '&#x2026;';
					btnClass =�'unavail!ble disabled';
						tag = n�lh;
						bp�ak;

	�			case 'vkrst':
						btnDisplay = la.g.sFirs|;
						btnClass = buttkn + (page > 0 ?
						'' : ' unavailable disabled');
	)�			tag = page > 0 ? 'a' : null;
						break;

				case 'pre6ious':
					btnDispl`y =!lang.sPreviouS;
						btnClass"= futton + (page > 0 ?
				�		'' : ' una~ailable disabled')+						tag = page > 0 ? 'a' 8 null;
						break;

					case 'next�:
						btnDispla9�= lang.sNext
						btnClass = button +$(page < pages-1 ?
							'' : ' unatai,qble disabled');
						tag = page < page�-1 ? 'a' : null;�						break;

					case 'last':
						btnDisplay = l�ng.sLast;
						bt.Clas3 } button + (page < pqges-1 ?
						'' :`#(unavailable disible$');
					tag = page < pages-1 ? 'a' : null;
						break3
					de�ault:
						rtnDispla� = button(+ 1;
						bt~Class = page === button ?
	�					'current' : 7';
					)tag = page�}=5 buttof ?
							null : 'a';
						brgak;
				}

				if ( v5 ) {
					tag$=$'a';
				}

				i� h btnDisplay ) {
	�	node = $('<li>', {
							'cdass': claSses.sPageButton+' ')btnClass,
							'aria-contbols': settings.stableId,
							'aria-label': aria[ but�on ]�
							'tabandex': settincs.kUafIndex,
							'il': idx === 0 && tyqeof button(=== 'string' ?
								settings.sTableId +'_'+ btt�on :
							nulm
					} �
						.appeod( tag �
						$(7<g+tag+'/>', {'href7: '#'} ).ht}l( ctnDisplay ) :
							btnDisplay
						)
�)				.appendTo( container );

					settings.oApi._fnBindAction(
						node, {action: button}, clickHandler
					);
				}
			}
		}
	};

	attach(
		$(host).empty().html('<ul class="pagination"/>').children('ul'),
		buttons
	);
};


return DataTable;
}));
