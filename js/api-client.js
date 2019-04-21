var SpringAPI;

window.SpringPlugin = {
  handlebars: window.Handlebars,
  jQuery: window.jQuery.noConflict(),
  api: function(opts) {
    return new SpringAPI(opts);
  }
};

SpringAPI = (function() {
  function SpringAPI(arg) {
    var apiKey, http, protocol, sandbox, site, suffix;
    apiKey = arg.apiKey, site = arg.site, http = arg.http, sandbox = arg.sandbox;
    protocol = window.location.protocol.replace(':', '');
    suffix = (sandbox ? '/sandbox/v1' : '/v1');
    this.base = protocol + "://api.solidearth.com" + suffix;
    this.apiKey = apiKey || 'vzp5akyqhazsuavqa5mgcw9u';
    this.site = site || 'baarmls';
    this.http = http || jQuery;
  }

  SpringAPI.prototype.route = function(endpoint, params) {
    var k, qs, url, v;
    if (params == null) {
      params = {};
    }
    params.format = 'JSON';
    params.expand = true;
    params.api_key = this.apiKey;
    qs = '?' + ((function() {
      var results;
      results = [];
      for (k in params) {
        v = params[k];
        results.push("&" + k + "=" + v);
      }
      return results;
    })()).join('');
    url = this.base + endpoint + qs;
    return "/wp-content/plugins/spring_api/proxy.php/" + url;
  };

  SpringAPI.prototype.get = function(endpoint, params) {
    if (params == null) {
      params = {};
    }
    return this.http.get(this.route(endpoint, params));
  };

  SpringAPI.prototype.listing = function(id, site) {
    return this.get("/listing/" + (site || this.site) + "/" + id, {
      expand: true
    });
  };

  SpringAPI.prototype.attach = function(selector) {
    return SpringPlugin.jQuery(selector).unslider({
      dots: true
    });
  };

  return SpringAPI;

})();
