"use strict";
$(document).ready(function() {
    Table.init('users', location + '/get_user_data', ['ID', 'Username', 'Email', 'Created At', 'Status', 'Last Login', 'Number of Logins'], false);
});