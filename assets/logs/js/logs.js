$(document).ready(function() {
    var start_date = moment().subtract(1, 'days').format('YYYY-MM-DD');
    var end_date = moment().format('YYYY-MM-DD');
    var data ={
      'start': start_date,
      'end': end_date,
    };
    new DatePicker(start_date, end_date, 0 );
    $.post(location + '/update_sql_data',data);
    Table.init('logs', location + '/get_data', ['Username', 'Date', 'Login', 'Logout'], false);
    $('button#apply').on('click', function(){
      data ={
        'start': window.DatePicker.daterange.start,
        'end': window.DatePicker.daterange.end,
      };
      $.post(location + '/update_sql_data',data);
      $('table').DataTable().destroy(false);
      $('tbody').empty();
      setTimeout(Table.init('logs', location + '/get_data', ['Username', 'Date', 'Login', 'Logout'], false),1000);
    });
    $('button#clear').on('click', function(){
      $('div#drp').empty();
      new DatePicker(start_date, end_date, 0 );
    });
});
