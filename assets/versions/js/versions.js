$( document ).ready(function() {
  $.ajax({
    type: "POST",
    url: location + '/get_version_data',
    dataType : 'json',
    success: function(resp){
      var markup;
       for(row in resp){
         markup = '<div class="row" style="margin:10px;"><label class="col-sm-4" style="width:30%;">' + resp[row]['name'] + ' Version: </label>' +
                  '<input class="col-sm-6" id="' + resp[row]['name'] + '" type="text"  placeholder="' + resp[row]['version'] + '">' +
                  '<button class="col-sm-2" id="update_' + resp[row]['name'] + '" style="width:auto;">Update</button></div>';

         $('div#versions').append(markup);
       };
    },
  });
});
