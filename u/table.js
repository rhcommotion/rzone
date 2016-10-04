(function() {
'use strict';

  this.table = {
    gen: function (rows, fields) {
      var table = document.createElement('table');
      if (fields !== void 0 && fields.length !== 0) {
        var header = document.createElement('thead');
        var row = document.createElement('tr');
        fields.forEach(function (name) {
          var th = document.createElement('th');
          th.textContent = name;
          row.appendChild(th);
        });
        header.appendChild(row);
        table.appendChild(header);
      }
      var len = fields.length;
      // body
      var body = document.createElement('tbody');
      rows.forEach(function (row) {
        var tr = document.createElement('tr');
        for (var i = 0; i < len; i++) {
          var td = document.createElement('td');
          td.textContent = row[i];
          tr.appendChild(td);
        }
        body.appendChild(tr);
      });
      table.appendChild(body);
      return table;
    }
  };

}).call_global();;