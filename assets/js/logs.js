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
      clearTable();
      Table.init('logs', location + '/get_data', ['Username', 'Date', 'Login', 'Logout'], false);
    });
    $('button#clear').on('click', function(){
      $('div#drp').empty();
      new DatePicker(start_date, end_date, 0 );
      data ={
        'start': window.DatePicker.daterange.start,
        'end': window.DatePicker.daterange.end,
      };
      $.post(location + '/update_sql_data',data);
      clearTable();
      Table.init('logs', location + '/get_data', ['Username', 'Date', 'Login', 'Logout'], false);
    });
});
function clearTable(){
  $('table').DataTable().destroy(true);
  $('tbody').empty();
};
