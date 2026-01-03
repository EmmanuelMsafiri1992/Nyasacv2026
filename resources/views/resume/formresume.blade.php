  <!doctype html>
  <html lang="{{ app()->getLocale() }}" dir="ltr">
  
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <meta http-equiv="Content-Language" content="{{ app()->getLocale() }}" />
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <meta name="msapplication-TileColor" content="#2d89ef">
      <meta name="theme-color" content="#4188c9">
      <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
      <meta name="apple-mobile-web-app-capable" content="yes">
      <meta name="mobile-web-app-capable" content="yes">
      <meta name="HandheldFriendly" content="True">
      <meta name="MobileOptimized" content="320">
      <link rel="icon" href="{{ asset('img/favicon.png') }}" type="image/x-icon" />
      <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/favicon.png') }}" />
      <title>@yield('title', config('app.name'))</title>
      <link rel="dns-prefetch" href="//fonts.gstatic.com">
      <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Source+Sans+Pro:300,300i,400,400i,500,500i,600,600i,700,700i&amp;subset=latin-ext">
      <link rel="stylesheet" href="{{ mix('css/app.bundle.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/grapesjs/dist/css/grapes.min.css">


  </head>
<body>

@csrf
<input type="text" id="rb_content" name="content" hidden class="form-control" >
<input type="text" id="rb_style" name="style" hidden class="form-control">
<div id="editor_container">
    <div id="gjs"></div>
</div>
<input type="text" name = "action" value = "{!! $action !!}" hidden class="form-control">
<input type="text" id="rb_style" name="id" value="@if(isset($id)) {!! $id !!} @endif" hidden class="form-control">

<script src="{{ mix('js/app.bundle.js') }}"></script>
<script src="https://unpkg.com/grapesjs"></script>
<script>
"use strict";

const LandingPage = {
            html: `{!! $data->content !!}`,
            css: `<style type="text/css">
                  {!! $data->style !!}
                  </style>`,
            components: null,
            style: null,
        };
grapesjs.plugins.add('example-plugin', function(editor, options) {
    // remove the devices switcher
    editor.getConfig().showDevices = false;
    editor.getConfig().allowScripts = 0;
    

    // console.log(editor.getConfig());
    // remove the view code 
    editor.Panels.removeButton("views", "open-layers");
    editor.Panels.removeButton('options', 'export-template');
    editor.Panels.removeButton('views', 'open-blocks');
    editor.Panels.removeButton('views', 'open-tm');
    editor.Panels.removeButton('views', 'sw-visibility');


    editor.Panels.addButton('options', [ { id: 'undo', className: 'fa fa-undo', command: function(e) { e.runCommand('core:undo') }}]);

    editor.Panels.addButton('options', [ { id: 'redo', className: 'fa fa-repeat', command: function(e) { e.runCommand('core:redo') }}]);


    editor.Panels.addPanel({
     id: 'myNewPanel',
     visible  : true,
     content: `
      <div class="input-group">
          <span class="input-group-btn">

          <a href='{{ route('resume.template') }}' class="btn btn-secondary">@lang("Select Template")</a>
        </span>
        <input type="text" name="name" value = "@if(isset($name)) {!! $name !!} @endif" class="form-control" placeholder="@lang('Enter name')" autocomplete="off">
        <span class="input-group-btn">

          <button id="save_resume"class="btn btn-success">
              <i class="fe fe-save"></i> @lang("Save")
              </button>
          </span>
          <span class="input-group-btn"></span>
      </div>`
    });
  

})

$(document).ready(function() {
        "use strict";
        $("#save_resume").on( "click", function(e) {
          e.preventDefault();
            var content = editor.getHtml();
            var style = editor.getCss();
            var name = $("input[name='name']").val();
            var id = $("input[name='id']").val();
            var _token = $("input[name='_token']").val();
            var action = $("input[name='action']").val();

            var url_post = '';
            var data = '';
            if(action == "create"){
              url_post ="{{ route('resume.save') }}";
              data = {_token:_token, name:name, content:content, style:style};
            }
            if(action == "update"){

              url_post = "{{ route('resume.update') }}";
              data = {_token:_token, id:id, name:name, content:content, style:style};
            }
            if(url_post){
              $.ajax({
                url: url_post,
                type:'POST',
                data: data,
                success: function(data) {
                    if($.isEmptyObject(data.error)){
                      var url = "{{ url('resume/exportpdf') }}"+"/"+ data.id;
                      Swal.fire({
                          title: "Success?",
                          html:data.success,
                          showCloseButton: true,
                          icon: "success",
                          confirmButtonText: "@lang("Export PDF")",
                        }).then((res) => {
                            if(res.value){
                              window.open(url, '_blank');
                            }
                        });
                      
                    }else{
                      
                      var error = printErrorMsg(data.error);
                      Swal.fire({
                          title: 'Error!',
                          html: error,
                          icon: 'error',
                          confirmButtonText: 'OK'
                      });
                      
                    }
                }
              });
            }
        });
      
        function printErrorMsg (msg) {
            var mess = "";
            $.each( msg, function( key, value ) {
                mess += '<li>'+value+'</li>';
            });
            return mess;
        }
    });

var editor = grapesjs.init({
  container: '#gjs',
  protectedCss: ` body {font-family: 'Roboto', sans-serif !important;max-width: 210mm;min-height: 290mm;height:auto;margin: 20px auto;background: #fff;box-shadow: 0 3px 1px -2px rgba(0,0,0,.2), 0 2px 2px 0 rgba(0,0,0,.14), 0 1px 5px 0 rgba(0,0,0,.12);}`,
  components: LandingPage.components || LandingPage.html,
  canvas: {
    styles: ['https://fonts.googleapis.com/css?family=Archivo+Narrow:400,400i,700,700i|Roboto:300,300i,400,400i,500,500i,700,700i|Raleway:300,300i,400,400i,500,500i,700,700i|Lato:300,300i,400,400i,500,500i,700,700i|Montserrat:300,300i,400,400i,500,500i,700,700i|Spartan:300,300i,400,400i,500,500i,700,700i&subset=latin,latin-ext','https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css'],
  },
  style: LandingPage.style || LandingPage.css,
  storageManager: {
    autoload: false,
  },
  plugins: ["example-plugin"]
  
});


editor.stopCommand('sw-visibility');



</script>
</body>
</html>
