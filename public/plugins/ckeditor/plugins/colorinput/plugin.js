CKEDITOR.plugins.add( 'colorinput', {
    requires: 'dialog,colordialog',
    lang: 'en',
    init: function(editor) {
        var lang = editor.lang.colorinput;
        CKEDITOR.dialog.addUIElement('color', {
            build: function(dialog, elementDefinition, htmlList) {
                function colorinput(dialog, elementDefinition, htmlList) {
                    this._ = {
                        domId : CKEDITOR.tools.getNextId() + '_colorInput',
                        textId : CKEDITOR.tools.getNextId() + '_colorTxt',
                        chooseId : CKEDITOR.tools.getNextId() + '_colorChoose',
                        previewId : CKEDITOR.tools.getNextId() + '_colorPreview',
                    };
                    this._['default'] = this._.initValue = elementDefinition['default'] || '';
                    this._.required = elementDefinition.required || false;

                    if ( elementDefinition.validate )
                        this.validate = elementDefinition.validate;

                    this.layout = this.layout || elementDefinition.layout;
                    this.layout = this.layout || editor.config.colorInputLayout;
                    this.layout = this.layout || 'expanded';

                    dialog.on('load', function() {
                        this.textField().on('input', function() {
                            this.setPreview(this.getValue());
                        }, this);
                        this.dialogOpener().on('click', function() {
                            editor.getColorFromDialog(function(color) {
                                if ( color != null )
                                    this.setValue(color);
                            }, this, {
                                selectionColor: this.getValue()
                            });
                        }, this);
                    }, this);


                    var innerHTML = function() {
                        function wrapperDiv() {
                            var html = [];
                            html.push('<div id="' + this._.domId + '" class="cke_dialog_ui_input_text" role="presentation">');
                            for ( var i = 0; i < arguments.length; i++ )
                                html.push(arguments[i]);
                            html.push('</div>');
                            return html.join('');
                        }
                        wrapperDiv = wrapperDiv.bind(this);

                        function textInput() {
                            var attributes = {
                                'class': 'cke_dialog_ui_input_text',
                                style: 'width:100px;margin-right:8px;',
                                id: this._.textId,
                                type: 'text'
                            };
                            attributes[ 'aria-labelledby' ] = this._.labelId;
                            this._.required && ( attributes[ 'aria-required' ] = this._.required );

                            var html = [];
                            html.push('<input ' );
                            for ( var i in attributes )
                                html.push( i + '="' + attributes[ i ] + '" ' );
                            html.push(' />');
                            return html.join('');
                        }
                        textInput = textInput.bind(this);

                        function button(innerHtml) {
                            return [
                                '<a id="'+this._.chooseId+'" href="javascript:void(0)" title="button" hidefocus="true" class="cke_dialog_ui_button" role="button" aria-labelledby="'+this._.labelid+'">',
                                innerHtml,
                                '</a>'
                            ].join('');
                        }
                        button = button.bind(this);

                        function buttonText() {
                            return '<span class="cke_dialog_ui_button">'+lang.chooseColor+'</span>'
                        }
                        buttonText = buttonText.bind(this);

                        function preview() {
                            return '<div id="'+this._.previewId+'" style="margin:3px;display:inline-block;width:16px;height:16px;border:solid 1px black;margin:auto 8px;">&nbsp;</div>';
                        }
                        preview = preview.bind(this);

                        if ( this.layout == 'expanded' ) {
                            return wrapperDiv(
                                textInput(),
                                button(
                                    buttonText()
                                ),
                                preview()
                            );
                        }
                        else if ( this.layout == 'compact' ) {
                            return wrapperDiv(
                                textInput(),
                                button(
                                    preview()
                                )
                            );
                        }
                        else if ( this.layout == 'minimal' ) {
                            return wrapperDiv(
                                textInput()
                            );
                        }
                        else {
                            throw 'Unhandled layout: ' + this.layout;
                        }
                    };
                    CKEDITOR.ui.dialog.labeledElement.call( this, dialog, elementDefinition, htmlList, innerHTML );
                };
                function getEl(id) {
                    var el = document.getElementById(id)
                    if (!el) return null;
                    return new CKEDITOR.dom.element(el);
                }
                colorinput.prototype = CKEDITOR.tools.extend( CKEDITOR.ui.dialog.labeledElement.prototype, {
                    textField: function() {
                        return getEl(this._.textId);
                    },
                    chooseField: function() {
                        return getEl(this._.chooseId);
                    },
                    previewField: function() {
                        return getEl(this._.previewId);
                    },
                    domField: function() {
                        return getEl(this._.domId);
                    },
                    isChanged: function() {
                        return this.getValue() != this.getInitValue();
                    },
                    reset: function( noChangeEvent ) {
                        this.setValue( this.getInitValue(), noChangeEvent );
                    },
                    setInitValue: function() {
                        this._.initValue = this.getValue();
                    },
                    resetInitValue: function() {
                        this._.initValue = this._[ 'default' ];
                    },
                    getInitValue: function() {
                        return this._.initValue;
                    }
                });
                colorinput.prototype.dialogOpener = function() {
                    switch( this.layout ) {
                        case 'expanded': return this.chooseField();
                        case 'compact': return this.chooseField();
                        case 'minimal': return this.textField();
                        default:
                            throw 'Unknown color input layout: ' + this.layout;
                    }
                };
                colorinput.prototype.setPreview = function(color) {
                    var field = this.previewField();
                    field && field.setStyle('background-color', color);
                };
                colorinput.prototype.getValue = function() {
                    return this.textField().getValue();
                };
                colorinput.prototype.setValue = function(v) {
                    this.textField().setValue(v);
                    this.setPreview(v);
                    return this;
                };
                return new colorinput(dialog, elementDefinition, htmlList);
            }
        });
    }
});
