bkLib.onDomLoaded(function(){
    editor = new nicEditor({
        fullPanel : true
    }).panelInstance('content');
});
             
function toggleEditor() {
    if(!editor) {
        editor = new nicEditor({
            fullPanel : true
        }).panelInstance('content');
        count = 0;
        $('.editor-toggle-button').html('HTML editor');
    } else {
        editor.removeInstance('content');
        editor = null;
        $('.editor-toggle-button').html('WYSIWYG editor');
    }
}
