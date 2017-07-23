/*
 * clock
 * @author Peter Kaufman
 * @param $i is the interval at which the clock updates in milliseconds
 * credit to Gabriel https://codepen.io/gab/pen/KLhgr
 */
var clock =function( $i ){
  function update() {
    $('#clock').html(moment().format('D MMMM, YYYY, H:mm:ss'));
  }

  setInterval(update, $i);

};

/*
 * cpu_chart
 * @author Peter Kaufman
 * @param $i is the interval at which the clock updates in milliseconds
 * credit to CarterTsai https://codepen.io/CarterTsai/pen/fFDAx
 */
 var cpu_chart = function(){
   var timeoutId = 0;
   var data = [];

   var margin = {top: 20, right: 20, bottom: 30, left: 50},
      width = 300 - margin.left - margin.right,
      height = 200 - margin.top - margin.bottom;

      var parseDate = d3.time.format("%H:%M:%S").parse;

      var xcenter =  width/2;

      var x = d3.time.scale()
      . range([0, width]);

      var y = d3.scale.linear()
      .range([height, 0]);

      var xAxis = d3.svg.axis()
      .scale(x)
      .orient("bottom")
      .tickFormat(d3.time.format("%S"));

      var yAxis = d3.svg.axis()
      .scale(y)
      .orient("left");

      var line = d3.svg.line()
      .x(function(d) { return x(d.creatTime);})
      .y(function(d) { return y(d.cpuTime); });

      // function

      function myGetTime() {
        var dd = new Date();
        var hh = dd.getHours();
        var mm = dd.getMinutes();
        var ss = dd.getSeconds();
        return hh + ":" + mm + ":" + ss;
      }

      function getRandomArbitrary(min, max) {
        return Math.round (Math.random() * (max - min) + min) -1;
      }

      function getTime(data) {
        if(data.length === 12) {
          // when length of data equal 11 then pop data[0]
          data.shift();
        }
        data.push({
          "creatTime":  myGetTime(),
          "cpuTime": getRandomArbitrary(0,101),
        });
      }

      function update() {
        getTime(data);
        render();
        timeoutId = setTimeout("update()", 1000);
      }

      function render() {

        d3.select("svg")
          .remove();

          var svg = d3.select("body").append("svg")
          .attr("width", width + margin.left + margin.right)
          .attr("height", height + margin.top + margin.bottom + 40)
          .append("g")
          .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

          data.forEach(function(d) {
            if(typeof d.creatTime === "string") {
              d.cpuTime = +d.cpuTime;
              d.creatTime = parseDate(d.creatTime);
            }

          });

          x.domain(d3.extent(data, function(d) { return d.creatTime; }));
          y.domain(d3.extent(data, function(d) { return d.cpuTime; }));

          svg.append("g")
          .attr("class", "x axis")
          .attr("transform", "translate(0," + height + ")")
          .style("text-anchor", "end")
          .call(xAxis)
          .append("text")
          .attr("transform", "rotate(0)")
          .attr("y", 40)
          .attr("dx", xcenter)
          .attr("font-size", "1.3em")
          .style("text-anchor", "end")
          .text("time(s)");

          svg.append("g")
          .attr("class", "y axis")
          .attr("transform", "translate("+ height +",-180px)")
          .style("text-anchor", "end")
          .call(yAxis)
          .append("text")
          .attr("transform", "rotate(-90)")
          .attr("y", -40)
          .attr("dy", ".41em")
          .attr("font-size", "1.3em")
          .style("text-anchor", "end")
          .text("CPU%");

          svg.append("path")
          .datum(data)
          .attr("class", "line")
          .attr("d", line);
        }

        // Start
        setInterval(update, 1000);
};
/**
 * @author Rance Aaron
 * @class Table
 * @type object
 * @version 1.5 Under Git control and Grunt task managers.
 * @description Wrapper for {@link https://datatables.net DataTables}.
 *  Table objects allow easy construction for data tables with connections
 *  to the data sources.
 *
 */
var Table = {
    /**
     *
     * @function init
     * @description Initializes the table object
     * @memberOf Table
     * @param {string} name Name used as dom element id
     * @param {string} url Url to data source
     * @param {array} columns Column names
     * @returns void
     */
    init: function(name,url,columns) {
        this.col_array = columns;
        this.name = name;
        this.url = url;
        this.createTable();

        $('table#'+this.name).DataTable( {
                serverSide: true,
                ajax: url,
                columns: this.getColumns()
        });

        var dTable = $('table#'+this.name).DataTable();
        for(var i in this.col_array){
            $(dTable.column(i).header()).text(this.col_array[i]);
        }

    },
    /**
     * @function createTable
     * @description Creates a dom element for the table object
     * @memberOf Table
     * @returns void
     */
    createTable: function() {
        $("div#table ").append('<table id="'+this.name+'" class="display" cellspacing="0" width="100%" />');
    },
    /**
     * @function getColumns
     * @description Return an array of column data
     * @memberOf Table
     * @returns {Array|Table.getColumns.c}
     */
    getColumns: function(){
        var c = [];

        for(var k in this.col_array){
            c.push({ "data": this.col_array[k]});
        }

        return c;
    }
};
