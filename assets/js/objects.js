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
