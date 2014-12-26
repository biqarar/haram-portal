(function( $ ) {
	$.widget( "custom.combobox", {
		options: {
			change: false,
			create: false
		},
		_create: function() {
			this.element.addClass('notselect');
			this.wrapper = $( "<span>" )
			.addClass( "custom-combobox" )
			.insertAfter( this.element );
			this.element.addClass("orginal-combo-box");
			this.element.hide();
			this._createAutocomplete();
			this._createShowAllButton();
		},

		_createAutocomplete: function() {
			var selected = this.element.children( ":selected" );


			value = selected.val() ? selected.text() : "";

			this.input = $( "<input>" )
			.appendTo( this.wrapper )
			.val( value )
			.attr( "title", "" )
			.addClass( "custom-combobox-input" )
			.autocomplete({
				delay: 0,
				minLength: 0,
				source: $.proxy( this, "_source" )
			})
			.tooltip({
				tooltipClass: "ui-state-highlight"
			});

			this._on( this.input, {
				autocompleteselect: function( event, ui ) {
					if(this.options.change){
						this.options.change.call(this, ui);
					}
					ui.item.option.selected = true;
					this._trigger( "select", event, {
						item: ui.item.option
					});
				},

				autocompletechange: "_removeIfInvalid"
			});
		},

		_createShowAllButton: function() {
			var input = this.input,
			wasOpen = false;

			$('<span class="ui-icon ui-icon-triangle-1-s"></span>').appendTo(this.wrapper)
			.mousedown(function() {
				wasOpen = input.autocomplete( "widget" ).is( ":visible" );
			})
			.click(function() {
				input.focus();

            // Close if already visible
            if ( wasOpen ) {
            	return;
            }

            // Pass empty string as value to search for, displaying all results
            input.autocomplete( "search", "" );
       });
		},
		_source: function( request, response ) {
			var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
			response( this.element.children( "option" ).map(function() {
				var text = $( this ).text();
				if ( this.value && ( !request.term || matcher.test(text) ) )
					return {
						label: text,
						value: text,
						option: this
					};
				}) );
		},

		_removeIfInvalid: function( event, ui ) {

			if ( ui.item ) {
				return;
			}

			var value = this.input.val(),
			valueLowerCase = value.toLowerCase(),
			valid = false;
			this.element.children( "option" ).each(function() {
				if ( $( this ).text().toLowerCase() === valueLowerCase ) {
					this.selected = valid = true;
					return false;
				}
			});

			if ( valid ) {
				return;
			}

			this.input
			.val( "" )
			.attr( "title", "«"+value + "» در لیست موجود نیست" )
			.tooltip( "open" );
			this.element.val( "" );
			this._delay(function() {
				this.input.tooltip( "close" ).attr( "title", "" );
			}, 2500 );
			this.input.autocomplete( "instance" ).term = "";
		},

		_destroy: function() {
			this.wrapper.remove();
			this.element.show();
		}
	});
})( jQuery );