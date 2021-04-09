(function() {
    tinymce.PluginManager.add('GSBEH_mce_button', function( editor, url ) {
        editor.addButton( 'GSBEH_mce_button', {
            title: 'GS Behance Projects Portfolio',
            type: 'button',
            icon: 'icon gsbeh-mce-icon',
            onclick: function() {
                editor.windowManager.open( {
                    title: 'Insert Behance Info ',
                    body: [{
                        type: 'textbox',
                        name: 'UserId',
                        label: 'Behance User Id',
                        placeholder:'Id like - creativemints'
                    },
                    {
                        type: 'textbox',
                        name: 'Count',
                        label: 'Number of Shots',
                        value:'6'
                    },
                    {
                        type: 'listbox', 
                        name: 'column', 
                        label: 'Column', 
                        'values': [
                            {text: '3 Columns', value: '4'},
                            {text: '4 Columns', value: '3'}
                        ]
                    },
                    {
                        type: 'listbox', 
                        name: 'theme', 
                        label: 'Theme', 
                        'values': [
                            {text: 'Theme 1 (Projects)', value: 'gs_beh_theme1'},
                            {text: 'Theme 2 (Projects Stat)', value: 'gs_beh_theme2'},
                            {text: 'Theme 3 (Hover)', value: 'gs_beh_theme3'},
                            {text: 'Theme 4 (Popup)', value: 'gs_beh_theme4'},
                            {text: 'Theme 5 (Slider)', value: 'gs_beh_theme5'},
                            {text: 'Theme 6 (Profile)', value: 'gs_beh_theme6'},
                            {text: 'Theme 7 (Filter)', value: 'gs_beh_theme7'}                         
                        ]
                    }

                    ],
                    onsubmit: function( e ) {
                        editor.insertContent( '[gs_behance userid="' + e.data.UserId + '" count="' + e.data.Count + '" column="' + e.data.column + '" theme="' + e.data.theme + '"]');
                    }
                });
    }
        });
    });
})();