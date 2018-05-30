function confirmDelete(element){
  var currentUrl = $(element).attr('href');
  event.preventDefault();
  swal({
    title: "Are you sure?",
    text: "You will not be able to recover this imaginary file!",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#DD6B55",
    confirmButtonText: "Yes, delete it!",
    closeOnConfirm: false
  },
  function(){
    window.location.href = currentUrl;
  });
}
