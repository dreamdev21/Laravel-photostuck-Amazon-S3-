<script type="text/javascript">
jQuery(document).ready(function($) {
    if('{{App::getLocale()}}' == 'ar'){
      var lang = 'Arabic';
    }else{
      var lang = 'English';
    }

    $('#ps_table').DataTable({
      language: {
        url: 'http://cdn.datatables.net/plug-ins/1.10.15/i18n/'+lang+'.json'
      },
      "order": [[ 0, "desc" ]]
    });
} );


</script>
