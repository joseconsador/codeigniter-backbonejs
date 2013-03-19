// Patch Model and Collection.
_.each(["Model", "Collection"], function(name) {
  // Cache Backbone constructor.
  var ctor = Backbone[name];
  // Cache original fetch.
  var fetch = ctor.prototype.fetch;

  // Override the fetch method to emit a fetch event.
  ctor.prototype.fetch = function() {
    // Trigger the fetch event on the instance.
    this.trigger("fetch", this);

    // Pass through to original fetch.
    return fetch.apply(this, arguments);
  };
});

/**
 * Month names
 * 
 */
window.monthNames = [ "January", "February", "March", "April", "May", "June",
    "July", "August", "September", "October", "November", "December" ];

function getDocHeight() {
    var D = document;
    return Math.max(
        Math.max(D.body.scrollHeight, D.documentElement.scrollHeight),
        Math.max(D.body.offsetHeight, D.documentElement.offsetHeight),
        Math.max(D.body.clientHeight, D.documentElement.clientHeight)
    );
}


/**
 * Converts mysql date to javascript 
 */
Date.createFromMysql = function(mysql_string)
{ 
   if(typeof mysql_string === 'string')
   {
      var t = mysql_string.split(/[- :]/);
      //when t[3], t[4] and t[5] are missing they defaults to zero
      return new Date(t[0], t[1] - 1, t[2], t[3] || 0, t[4] || 0, t[5] || 0);          
   }

   return null;   
}

function get_popover_placement(pop, dom_el) {
  var width = window.innerWidth;
  if (width<500) return 'bottom';
  var left_pos = $(dom_el).offset().left;
  if (width - left_pos > 400) return 'right';
  return 'left';
}

/**
 * Capitalize the first letter of a string
 * Usage:
 *   string = 'hello';
 *   string.capitalize(); 
 */
String.prototype.capitalize = function() {
    return this.charAt(0).toUpperCase() + this.slice(1);
}

$(document).ready(function () {
  $('[rel="clickover"]').clickover({
    placement: get_popover_placement,
    html: true
  });

  $('a[rel*=popover]').popover({placement: get_popover_placement, html: true, trigger: 'hover'});

  $('a[rel="tooltip"]').tooltip({delay: {show: 1000, hide: 200}});
});

/**
 * Checks if date is valid ()
 */
function isValidDate(d) {
  if ( Object.prototype.toString.call(d) !== "[object Date]" )
    return false;
  return !isNaN(d.getTime());
}

function init_datepicker() {
  $('.datepicker').each(function(index, e) {
      var alt = $('input[name="' + $(e).attr('rel') + '"]');
      $(e).datepicker({
          altField : alt,
          altFormat: "yy-mm-dd",
          onSelect: function(dateText, inst) {
              alt.trigger('change');
          }
      });

      $(e).datepicker("setDate", new Date(alt.val()));
  });
  $('.datepicker').each(function(index, e) {
      var alt = $('input[name="' + $(e).attr('rel') + '"]');
      $(e).datepicker({
          altField : alt,
          altFormat: "yy-mm-dd",
          onSelect: function(dateText, inst) {
              alt.trigger('change');
          }
      });

      $(e).datepicker("setDate", new Date(alt.val()));
  });  
}