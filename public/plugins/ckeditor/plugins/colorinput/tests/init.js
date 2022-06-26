/* bender-tags: colorinput */
/* bender-ckeditor-plugins: colordialog,colorinput */

(function() {
    'use strict';

    function resumable(tc, fn) {
        return function() {
            var args = arguments;
            tc.resume(function() {
                fn.apply(this, args);
            }.bind(this));
        }.bind(this);
    }

    function setup(open_dlg, callback, html) {
        var bot = this;
        var tc = bot.testCase;

        bot.editor.once('selectionChange', function() {
            bot.dialog( 'testDialog', function( dialog ) {
                open_dlg(dialog);
                bot.editor.once('dialogShow', resumable(tc, function(evt) {
                    callback(evt, dialog);
                }));
                tc.wait();
            } );
        });
        bot.setHtmlWithSelection(
            html
        );
    }

    function close(evt, callback) {
        var bot = this;
        var tc = bot.testCase;

        bot.editor.once('dialogHide', resumable(tc, callback));
        evt.data.getButton( 'ok' ).click();
        tc.wait();
    }

    function checkInput(input, val) {
        assert.areSame( val, input.getValue());
        if (input.previewField())
            assert.areSame( val, input.previewField().getStyle('background-color'));
    }

    function testSetColorDialog(input_id, open_dlg, initial_color) {
        return function() {
            var bot = this.editorBot;
            var tc = bot.testCase;

            setup.bind(bot)(open_dlg, function (evt, dialog) {
                assert.areSame(initial_color, evt.data.getContentElement('picker', 'selectedColor').getValue());
                evt.data.getContentElement('picker', 'selectedColor').setValue('red');
                close.bind(bot)(evt, function (evt) {
                    checkInput(dialog.getContentElement('info', input_id), 'red');
                    dialog.getButton( 'ok' ).click();
                });
            }, '[<div data-expandedcolor="#333" data-compactcolor="#444" data-minimalcolor="#555">&nbsp;</div>]');
        }
    }

    function testClearColorDialog(input_id, open_dlg, initial_color, whileopen) {
        return function() {
            var bot = this.editorBot;
            var tc = bot.testCase;

            setup.bind(bot)(open_dlg, function (evt, dialog) {
                assert.areSame(initial_color, evt.data.getContentElement('picker', 'selectedColor').getValue());
                evt.data.getContentElement('picker', 'clear').click();
                close.bind(bot)(evt, function (evt) {
                    checkInput(dialog.getContentElement('info', input_id), '');
                    dialog.getButton( 'ok' ).click();
                });
            }, '[<div data-expandedcolor="#333" data-compactcolor="#444" data-minimalcolor="#555">&nbsp;</div>]');
        };
    }

    function testDefaultColorDialog(input_id, open_dlg, default_color, initial_color) {
        return function() {
            var bot = this.editorBot;
            var tc = bot.testCase;

            setup.bind(bot)(open_dlg, function (evt, dialog) {
                assert.areSame(default_color, evt.data.getContentElement('picker', 'selectedColor').getValue());
                checkInput(dialog.getContentElement('info', input_id), default_color);
                dialog.getButton( 'ok' ).click();
            }, '[<div>&nbsp;</div>]');

            setup.bind(bot)(open_dlg, function (evt, dialog) {
                assert.areSame(default_color, evt.data.getContentElement('picker', 'selectedColor').getValue());
                checkInput(dialog.getContentElement('info', input_id), initial_color);
                dialog.getButton( 'ok' ).click();
            }, '[<div data-expandedcolor="#333" data-compactcolor="#444" data-minimalcolor="#555">&nbsp;</div>]');
            setup.bind(bot)(open_dlg, function (evt, dialog) {
                assert.areSame(default_color, evt.data.getContentElement('picker', 'selectedColor').getValue());
                checkInput(dialog.getContentElement('info', input_id), default_color);
                dialog.getButton( 'ok' ).click();
            }, '[<div>&nbsp;</div>]');
        };
    }

    bender.editor = true;
    bender.test( {
        setUp: function() {
            this.editor.addCommand( 'testDialog', new CKEDITOR.dialogCommand( 'testDialog' ));

            CKEDITOR.dialog.add( 'testDialog' , function(editor) {
                return {
                    title: 'Color Input View',
                    contents: [{
                        id: 'info',
                        label: 'Info',
                        elements: [{
                            id: 'expandedpreview',
                            type: 'color',
                            label: 'Expanded Color Input',
                            layout: 'expanded', // default layout
                            'default': 'chartreuse',
                            setup: function(el) {
                                if (el.data('expandedcolor'))
                                    this.setValue(el.data('expandedcolor'));
                            },
                            commit: function(el) {
                                el.data('expandedcolor', this.getValue());
                            }
                        },{
                            id: 'compactpreview',
                            type: 'color',
                            label: 'Compact Color Input',
                            layout: 'compact',
                            'default': 'rgb(255, 153, 51)',
                            setup: function(el) {
                                if (el.data('compactcolor'))
                                    this.setValue(el.data('compactcolor'));
                            },
                            commit: function(el) {
                                el.data('compactcolor', this.getValue());
                            }
                        },{
                            id: 'minimalpreview',
                            type: 'color',
                            label: 'Minimal Color Input (popup on click)',
                            layout: 'minimal',
                            'default': '#909',
                            setup: function(el) {
                                if (el.data('minimalcolor'))
                                    this.setValue(el.data('minimalcolor'));
                            },
                            commit: function(el) {
                                el.data('minimalcolor', this.getValue());
                            }
                        }]
                    }],
                    onShow: function() {
                        this.setupContent(editor.getSelection().getStartElement());
                    },
                    onOk: function() {
                        this.commitContent(editor.getSelection().getStartElement());
                    }
                }
            } );
        },
        'test getValue setValue': function() {
            var bot = this.editorBot;
            bot.editor.once('selectionChange', function() {
                bot.dialog( 'testDialog', function( dialog ) {
                    assert.areSame( '#333', dialog.getContentElement('info', 'expandedpreview').getValue() );
                    assert.areSame( '#444', dialog.getContentElement('info', 'compactpreview').getValue() );
                    assert.areSame( '#555', dialog.getContentElement('info', 'minimalpreview').getValue() );
                    dialog.getButton( 'ok' ).click();
                    assert.areSame( '#333', bot.editor.getSelection().getStartElement().data('expandedcolor'));
                    assert.areSame( '#444', bot.editor.getSelection().getStartElement().data('compactcolor'));
                    assert.areSame( '#555', bot.editor.getSelection().getStartElement().data('minimalcolor'));
                } );
            });
            bot.setHtmlWithSelection(
                '[<div data-expandedcolor="#333" data-compactcolor="#444" data-minimalcolor="#555">&nbsp;</div>]'
            );
        },
        'test colordialog expanded': testSetColorDialog('expandedpreview', function(dialog) {
            dialog.getContentElement('info', 'expandedpreview').chooseField().fire('click');
        }, '#333'),
        'test colordialog compact': testSetColorDialog('compactpreview', function(dialog) {
            dialog.getContentElement('info', 'compactpreview').chooseField().fire('click');
        }, '#444'),
        'test colordialog minimal': testSetColorDialog('minimalpreview', function(dialog) {
            dialog.getContentElement('info', 'minimalpreview').textField().fire('click');
        }, '#555'),
        'test colordialog clear expanded': testClearColorDialog('expandedpreview', function(dialog) {
            dialog.getContentElement('info', 'expandedpreview').chooseField().fire('click');
        }, '#333'),
        'test colordialog clear compact': testClearColorDialog('compactpreview', function(dialog) {
            dialog.getContentElement('info', 'compactpreview').chooseField().fire('click');
        }, '#444'),
        'test colordialog clear minimal': testClearColorDialog('minimalpreview', function(dialog) {
            dialog.getContentElement('info', 'minimalpreview').textField().fire('click');
        }, '#555'),
        'test colordialog default expanded': testDefaultColorDialog('expandedpreview', function(dialog) {
            dialog.getContentElement('info', 'expandedpreview').chooseField().fire('click');
        }, 'chartreuse', '#333'),
        'test colordialog default compact': testDefaultColorDialog('compactpreview', function(dialog) {
            dialog.getContentElement('info', 'compactpreview').chooseField().fire('click');
        }, 'rgb(255, 153, 51)', '#444'),
        'test colordialog default minimal': testDefaultColorDialog('minimalpreview', function(dialog) {
            dialog.getContentElement('info', 'minimalpreview').textField().fire('click');
        }, '#909', '#555'),
    } );
})();
