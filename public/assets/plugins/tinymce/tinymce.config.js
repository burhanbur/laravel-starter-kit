tinymce.init({
  selector: 'textarea.editor-textarea',
  menubar: false,
  relative_urls : true,
  remove_script_host : true,
  convert_urls: false,
  height: 500,
  plugins: 'advlist autolink lists link image table anchor searchreplace fullscreen paste code help wordcount',

  toolbar: 
  'fullscreen | bold italic underline | formatselect | alignleft aligncenter alignright alignjustify | numlist bullist | link | image | table | forecolor | backcolor | removeformat |  undo redo',
  toolbar_sticky: false,

  file_picker_callback (callback, value, meta) {
    let x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth
    let y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight

    tinymce.activeEditor.windowManager.openUrl({
      url : '/file-manager/tinymce5',
      title : 'File manager',
      width : x * 0.8,
      height : y * 0.8,
      onMessage: (api, message) => {
        callback(message.content, { text: message.text })
      }
    })
  }
});



