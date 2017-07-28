$( document ).ready(function() {
  $.ajax({
    type: "POST",
    url: location + '/get_version_data',
    dataType : 'json',
    success: function(resp){
      var markup;
       for(row in resp){

         markup = '<div class="row" style="margin:10px;"><label class="col-sm-4">' + firstLetterToUpper(resp[row]['name']) + ' Version: </label>' +
                  '<input class="col-sm-6" id="' + resp[row]['name'] + '" type="text"  placeholder="' + resp[row]['version'] + '">' +
                  '<div class="col-sm-1"></div><button class="col-sm-1" id="update_' + resp[row]['name'] + '" style="width:auto;">Update</button></div>';

         $('div#versions').append(markup);
       };
    },
  });
});

function firstLetterToUpper(str){
  return str.substring(0,1).toUpperCase() + str.substring(1);
}
