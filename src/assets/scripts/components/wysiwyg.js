function editorInit() {

    // tinymce.init({
    //     selector: "textarea[data-editor='true']",
    //     theme: "modern",
    //     height: 300,
    //     menubar: false,
    //     relative_urls: false,
    //     remove_script_host: false,
    //     content_css : '/assets/stylesheets/css/admin/content.css',
    //     body_class: 'content-text',
    //     plugins: [
    //         "placeholder",
    //         "searchreplace wordcount",
    //         "paste"
    //     ],
    //     placeholder_attrs: {
    //         style: {
    //             position: 'absolute',
    //             top:'25px',
    //             left: '8px',
    //             color: '#888',
    //             padding: '1%',
    //             width:'98%',
    //             overflow: 'hidden',
    //             'white-space': 'pre-wrap'
    //         }
    //     },
    //     formats: {
    //         removeformat: [
    //           {selector: 'b,strong,em,i,font,u,strike', remove : 'all', split : true, expand : false, block_expand: true, deep : true},
    //           {selector: 'span', attributes : ['style', 'class'], remove : 'empty', split : true, expand : false, deep : true},
    //           {selector: '*', attributes : ['style', 'class'], split : false, expand : false, deep : true}
    //         ]
    //     },
    //     toolbar: 'searchreplace | undo redo | removeformat',
    //     toolbar_items_size: 'small',
    //     init_instance_callback: function (editor) {
    //         editor.on('blur', function (e) {
    //             tinyMCE.triggerSave();
    //             $("#" + editor.id).valid();
    //         });
    //     },
    // });

}

$(document).ready(function() {
    editorInit();
});