"use strict";
$(document).ready(function() {
    Table.init('users', location + '/getUserData', ['ID', 'Username', 'Email', 'Created At', 'Status', 'Last Login', 'Number of Logins'], false);
});