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
      <title>{!! $name !!}</title>

      <link rel="icon" href="{{ asset('img/favicon.png') }}" type="image/x-icon" />
      <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/favicon.png') }}" />
  
      
  </head>
<body id="resume">
    <div class="btn_print">
      <div class="input-group">
          <span class="input-group-btn">
          <a href="{{ route('settings.resumetemplate.index') }}" class="btn btn-secondary">@lang("All Templates")</a>
        </span>
        <span class="input-group-btn">
          <button id="pdfDownloader" class="btn btn-primary">
              <i class="fe fe-save"></i>@lang("Download")
              </button>
          </span>
      </div>
    </div>
    <div id="exportpdf">
        {!! $content !!}
    </div>
</body>

<style>
body{
    margin 0 auto !important;
    -webkit-print-color-adjust:exact; color-adjust: exact;
}
.btn_print{
  padding:10px;
  background-color:#ffff;
}
.input-group-btn{
  margin-right: 5px;
}
#exportpdf{
  
}
@page {
  size: A4;
  margin: 0;
}
@media print {
  html, body {
    width: 210mm;
    /* margin: 0px auto; */
    /* height: 297mm; */
  }
  .btn_print { display: none; }
}
{!! $style !!}

body {
  margin: 0px auto;
}

.btn-primary:hover{
    color: #fff;
    background-color: #316cbe;
    border-color: #2f66b3;
}
.btn-secondary:hover{
    color: #fff;
    background-color: #316cbe;
    border-color: #2f66b3;
}
.btn-secondary{

font-family: "Source Sans Pro", -apple-system, BlinkMacSystemFont, "Segoe UI", "Helvetica Neue", Arial, sans-serif;
display: inline-block;
text-align: center;
vertical-align: middle;
user-select: none;
border: 1px solid transparent;
padding: 0.375rem 0.75rem;
line-height: 1.84615385;
border-radius: 3px;
transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
cursor: pointer;
font-weight: 600;
letter-spacing: .03em;
font-size: 0.8125rem;
min-width: 2.375rem;
box-shadow: 0 1px 1px 0 rgba(0, 0, 0, 0.05);
text-decoration: none;
height: 100%;
border-color: rgba(0, 15, 36, 0.12);
color: #495057;
    background-color: #ffff;
    border-color: rgba(0, 15, 36, 0.12);
}
.btn-primary{
font-family: "Source Sans Pro", -apple-system, BlinkMacSystemFont, "Segoe UI", "Helvetica Neue", Arial, sans-serif;

overflow: visible;
text-transform: none;
-webkit-appearance: button;
display: inline-block;
text-align: center;
vertical-align: middle;
user-select: none;
border: 1px solid transparent;
padding: 0.375rem 0.75rem;
line-height: 1.84615385;
border-radius: 3px;
transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
color: #fff;
background-color: #467fcf;
font-weight: 600;
letter-spacing: .03em;
font-size: 0.8125rem;
min-width: 2.375rem;
cursor: pointer;
height: 100%;
border-color: rgba(0, 40, 100, 0.12);
}
</style>
<script>
"use strict";

document.getElementById("pdfDownloader").addEventListener("click", myFunction);

function myFunction() {
  window.print();
}
</script>
</html>
