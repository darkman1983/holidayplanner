/**
 * jQuery.urlParams | jQuery getUrlParam  - Get a parameter(s) of current url
 * 
 * @author tstepputtis
 */

(function($) {
	$.extend({
		getUrlParams : function() {
			var vars = [], hash;
			var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
			for (var i = 0; i < hashes.length; i++) {
				hash = hashes[i].split('=');
				vars.push(hash[0]);
				vars[hash[0]] = hash[1];
			}
			return vars;
		},
		getUrlParam : function(name) {
			var parameters = $.getUrlParams();
			return parameters[name] || '';
		}
	});
})(jQuery);