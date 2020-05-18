<footer class="main-footer">
  <div class="pull-right hidden-xs">
    <b>Version</b> 1.0.0
  </div>
  <strong>Copyright &copy; 2020 Rawad j. Khair</strong> All rights
  reserved.
</footer>
</div>
<!-- ./wrapper -->

<!-- App JS -->
<script src="{{asset('js/app.js')}}"></script>
<!-- CKEditor Plugin -->
<script src="{{asset('js/plugins/ckeditor/ckeditor.js')}}"></script>
<!-- Script App -->
<script src="{{asset('js/script.js')}}"></script>
<!-- Custom Script -->
<script src="{{asset('js/custom.js')}}"></script>
<!-- CK Editor RTL -->
<script>  
    CKEDITOR.config.language = "{{app()->getLocale()}}";
</script>

</body>
</html>