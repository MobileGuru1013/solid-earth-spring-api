window.SpringPlugin =
  handlebars: window.Handlebars
  jQuery: window.jQuery.noConflict()
  api: (opts) -> new SpringAPI(opts)

class SpringAPI
  constructor: ({apiKey, site, http, sandbox}) ->
    protocol = window.location.protocol.replace(':', '')
    suffix = (if sandbox then '/sandbox/v1' else '/v1')
    @base = "#{protocol}://api.solidearth.com#{suffix}"
    @apiKey = apiKey or 'vzp5akyqhazsuavqa5mgcw9u'
    @site = site or 'baarmls'
    @http = http or jQuery


  route: (endpoint, params={}) ->
    params.format = 'JSON'
    params.expand = true
    params.api_key = @apiKey
    qs = '?' + ("&#{k}=#{v}" for k,v of params).join('')

    url = @base + endpoint + qs
    "/wp-content/plugins/spring_api/proxy.php/#{url}"

  get: (endpoint, params={}) -> @http.get @route(endpoint, params)

  listing: (id, site) ->
    @get "/listing/#{site or @site}/#{id}", {expand: true}

  attach: (selector) ->
    SpringPlugin.jQuery(selector)
    .unslider {dots: true}




