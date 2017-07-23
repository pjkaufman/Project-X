$(document).ready(function() {
    Table.init('logs', location + '/get_data', ['Username', 'Date', 'Login', 'Logout']);
    $('.paginate_button').click(function(){
      console.log("Hi");
    });
} );
