<?php
include plugin_dir_path( __FILE__ ) . 'store.php';

add_action('admin_menu', 'add_menu');

function add_menu() {
  add_menu_page( "Spring IDX", "Spring IDX", "publish_posts", "spring-api/main", "SPRINGAPIWP_menu", '', 6);
  add_submenu_page( "spring-api/main", "Search", "Search", "publish_posts", "spring-api/quick", "SPRINGAPIWP_quick_menu");
  add_submenu_page( "spring-api/main", "Listing Details", "Listing Details", "publish_posts", "spring-api/listing", "SPRINGAPIWP_listing_menu");
  add_submenu_page( "spring-api/main", "Agent Listings", "Agent Listings", "publish_posts", "spring-api/agent", "SPRINGAPIWP_agent_menu");
}

function SPRINGAPIWP_menu() {
  if(isset($_POST["main"])) {
      $data = array(
          'api_key' => $_POST['apikey'],
          'sitename' => $_POST['siteselect'],
          'template' => stripslashes($_POST['template']),
          'ids' => $_POST['ids']
      );

    SPRINGAPIWP_set_data($data,'spring_settings');
  }

  $data = SPRINGAPIWP_get_data('spring_settings');

  $default_template = '
    <div class="spring-slider">
      <ul>
        {{#results}}
          <li>
            <img src="{{img}}" />
            {{#location}}{{#address}}
              <p>{{StreetNumber}} {{StreetName}}</p>
              <p>{{City}}, {{StateOrProvince}}</p>
            {{/address}}{{/location}}

            {{#listingPrice}}
              <p>${{listPrice}}</p>
            {{/listingPrice}}
          </li>
        {{/results}}
      </ul>
    </div>

    <script>
      SpringPlugin
      .jQuery(".spring-slider")
      .unslider({dots: true});
    </script>
  ';

  //$siteValue = $data[1];
  //$template = $data[2];

  if ($data['template'] == '') {
    $data['template'] = $default_template;
  }

  $html = '
    <h1>Spring IDX from Solid Earth - Slider</h1>
    <form action="" method="POST">

      <br><br>'. SPRINGAPIWP_siteSelect($data['sitename'], $data['api_key']) . '

      <h2 style="display: inline;">API Key:</h2>
      <p style="display: inline;">Keys are available at <a href="http://developer.solidearth.com">SolidEarth</a>. The installed Key is a SandBox Key returning faked data for testing.</p>
      <br />
      <input style="margin-top: 10px;" type="text" name="apikey" value="' . $data['api_key'] . '">
      <br>

      <h2>Template:</h2>
      <textarea name="template" cols="50" rows="20">' . $data['template'] . '</textarea>

      <h2>MLS Numbers:</h2>
      <p>Enter the MLS numbers you would like to feature in the slider feature. Listings that go off market will be skipped.</p>
      <textarea name="ids" cols="50" rows="5">' . $data['ids'] . '</textarea>

      <br>
      <input type="hidden" name="main" value="main" />
      <input type="submit">
    </form>
    <p>For more information about signing up for API keys and other questions see <a target="_blank" href="http://www.solidearth.com">www.solidearth.com</a> and/or send an email to <a href="mailto:api@solidearth.com">api@solidearth.com</a>.</p>
  ';

  echo $html;
}

function SPRINGAPIWP_listing_menu() {
  if(isset($_POST["listing"])) {
    $data = array(
        'api_key' => esc_attr($_POST["apikey"]),
        'sitename' => esc_attr($_POST["siteselect"]),
        'template' => stripslashes($_POST["template"]),
        'telephone' => esc_attr($_POST['telephone']),
        'googleMapsKey' => esc_attr($_POST["googleMapsKey"]),
        'ids' => ''
    );

    SPRINGAPIWP_set_data($data, 'listing_settings');
  }

  $data = SPRINGAPIWP_get_data('listing_settings');


  $default_template = '
  <div class="listing-overarch">
      {{#results}}
        {{#.}}
          <div class="listing-photo-gallery">
            <div id="listing-current-photo">
            </div>
            <div class="listing-detail-photos">
              <ul>
              {{#Media}}
                <li><img class="listing-direct-img" src="{{file}}" /></li>
              {{/Media}}
              </ul>
            </div>
          </div>
          <div class="clearfix"></div>

          <div class="listing-address-information">
            <p>{{location.address.StreetNumber}} {{location.address.StreetName}} | {{location.address.City}}, {{location.address.StateOrProvince}} {{location.address.PostalCode}}</p>
            <p>${{listingPricing.listPrice}}</p>
          </div>

          <div class="listing-property-description">
            <h1>Property Description</h1>
            <p>{{{remarks.publicRemarks}}}</p>
          </div>

          <div class="listing-full-block">
            <div class="listing-property-full-address">
              <h1>Property Details for {{location.address.StreetNumber}} {{location.address.StreetName}}, {{location.address.City}}, {{location.address.StateOrProvince}} {{location.address.PostalCode}}</h1>
              <ul>
                <li>Property type: {{property.Type}}, {{property.SubType}}</li>
                <li>Bedrooms total: {{structure.BedroomsTotal}}</li>
                <li>Bathrooms total: {{structure.BathroomsTotal}}</li>
                <li>MLS&reg; #: {{ListingId}}</li>
              </ul>
            </div>

            <div class="listing-interior-information">
              <h1>Interior Information</h1>
              <ul>
                <li>Bedrooms total: {{structure.BedroomsTotal}}</li>
                <li>Bathrooms total: {{structure.BathroomsTotal}}</li>
                <li>Bathrooms (full): {{structure.BathroomsFull}}</li>
                <li>Bathrooms (half): {{structure.BathroomsHalf}}</li>
                <li>Bathrooms (three-quarter): {{structure.BathroomsThreeQuarter}}</li>
                <li>Living Area: {{structure.livingArea}}</li>
                <li>Cars: {{structure.carsTotal}}</li>
              </ul>
            </div>

            <div class="listing-features">
              <h1>Features</h1>
              <ul>
              {{#each Features}}
                <li>{{@key}}: {{this}}</li>
              {{/each}}
              </ul>
            </div>

            <div class="listing-school-information">
              <h1>School Information</h1>
              <ul>
                <li>Elementary: {{location.school.elementarySchool}}</li>
                <li>Middle: {{location.school.middleOrJuniorSchool}}</li>
                <li>High: {{location.school.highSchool}}</li>
              </ul>
            </div>

            <div class="listing-agent">
              <h1>Listing Agent</h1>
              <ul>
                <li>Agent Name: {{agentOffice.ListAgent.FullName}}</li>
                <li>Agent Phone: {{agentOffice.ListAgent.OfficePhone}}</li>
                <li>Listing Office: {{agentOffice.ListOffice.Name}}</li>
                <li>Listing Office Phone: {{agentOffice.ListOffice.Phone}}</li>
                <li>Listing Office Email: <a href="mailto:{{agentOffice.ListOffice.Email}}?Subject=MLS%20#%20{{ListingId}}" target="_top">{{agentOffice.ListOffice.Email}}</a></li>
              </ul>
            </div>
          </div>
        {{/.}}
      {{/results}}
  </div>
  ';

  $siteValue = $data['sitename'];
  $template = htmlspecialchars_decode($data['template']);
  $telephone = $data['telephone'];
  $googleMapsKey = $data['googleMapsKeyPost'];

  if ($template == '') {
    $template = $default_template;
  }

  $html = '
    <h1>Spring IDX from Solid Earth - Listing Details</h1>
    <form method="POST">

      <br><br>' . SPRINGAPIWP_siteSelect($siteValue, $data['api_key']) . '

      <h2 style="display: inline;">API Key:</h2>
      <p style="display: inline;">Keys are available at <a href="http://developer.solidearth.com">SolidEarth</a>. The installed Key is a SandBox Key returning faked data for testing.</p>
      <br />
      <input style="margin-top: 10px;" type="text" name="apikey" value="' . $data['api_key']. '"/>
      <br>

      <h2>Template:</h2>
      <textarea name="template" cols="50" rows="20">' . htmlspecialchars($template) . '</textarea>

      <h2>Telephone:</h2>
      <input style="margin-top: 10px;" type="text" name="telephone" value="' . $telephone . '"/>

      <h2>Google Maps Key:</h2>
      <input style="margin-top: 10px;" type="text" name="googleMapsKey" value="' . $googleMapsKey . '"/>

      <br>
      <input type="hidden" name="listing" value="listing" />
      <input type="submit">
    </form>
    <p>For more information about signing up for API keys and other questions see <a target="_blank" href="http://www.solidearth.com">www.solidearth.com</a> and/or send an email to <a href="mailto:api@solidearth.com">api@solidearth.com</a>.</p>
  ';

  echo $html;
}

function SPRINGAPIWP_quick_menu() {
  if(isset($_POST["quick"])) {
    $data = array(
        'api_key' => esc_attr($_POST["apikey"]),
        'sitename' => esc_attr($_POST["siteselect"]),
        'template' => stripslashes($_POST["template"]),
        'ids' => ''
    );

    SPRINGAPIWP_set_data($data, 'quicksearch_settings');
  }

  $data = SPRINGAPIWP_get_data('quicksearch_settings');

  $default_template = '
    <div class="spring-quick-search">
      <div class="spring-search-options" style="float:right;">
        <select form="advanced-search-form" name="sorting" id="sorting-select" onchange="this.form.submit()">
          <option value="ListPrice">Price Low to High</option>
          <option value="ListPrice desc">Price High to Low</option>
          <option value="created desc" selected="selected">Newest</option>
          <option value="created">Oldest</option>
        </select>
      </div>
      <div class="spring-clear-line" />
      <div class="spring-quick-search-background">
        <ul class="spring-quick-search-pages">
          <li class="spring-quick-left-float">Page {{pageInfo.currentPage}}, results {{pageInfo.range}} of {{pageInfo.count}}</li>
          {{#pages}}
            {{#previous}}
              <li><a href="{{{.}}}">Previous<a/></li>
            {{/previous}}
              {{#selected}}
                <li><a style="text-decoration:underline !important;" href="{{{url}}}">{{num}}</a></li>
              {{/selected}}
              {{^selected}}
                <li><a href="{{{url}}}">{{num}}</a></li>
              {{/selected}}
            {{#next}}
              <li><a href="{{{.}}}">Next</a></li>
            {{/next}}
          {{/pages}}
        </ul>
      </div>
      <div class="spring-clear-line" />
      <ul class="spring-quick-search-listings">
        {{#results}}
          <li class="spring-quick-search-listing">
            <img class="spring-quick-search-photo-wrapper" src="{{img}}" />
            {{#listingPricing}}
              <p class="spring-quick-search-price">${{listPrice}}</p>
            {{/listingPricing}}

            {{#location}}{{#address}}
              <p class="spring-quick-search-address">{{StreetNumber}} {{StreetName}}</p>
              <p class="spring-quick-search-address">{{City}}, {{StateOrProvince}}</p>
            {{/address}}{{/location}}

            {{#structure}}
              <p class="spring-quick-search-rooms">{{BedroomsTotal}} Bed, {{BathroomsTotal}} Bath</p>
            {{/structure}}

            {{#property}}
              <p>Property Type: {{Type}}, {{SubType}}</p>
            {{/property}}

            {{#agentOffice}}
              {{#ListAgent}}
                <p>Courtesy of {{FullName}},
              {{/ListAgent}}
              {{#ListOffice}}
                {{Name}}</p>
              {{/ListOffice}}
            {{/agentOffice}}
          </li>
        {{/results}}
      </ul>
      <div class="clear-line" />
      <div class="spring-quick-search-background">
        <ul class="spring-quick-search-pages">
          <li class="quick-left-float">Page {{pageInfo.currentPage}}, results {{pageInfo.range}} of {{pageInfo.count}}</li>
          {{#pages}}
            {{#previous}}
              <li><a href="{{{.}}}">Previous<a/></li>
            {{/previous}}
              {{#selected}}
                <li><a style="text-decoration:underline !important;" href="{{{url}}}">{{num}}</a></li>
              {{/selected}}
              {{^selected}}
                <li><a href="{{{url}}}">{{num}}</a></li>
              {{/selected}}
            {{#next}}
              <li><a href="{{{.}}}">Next</a></li>
            {{/next}}
          {{/pages}}
        </ul>
      </div>
    </div>
  ';

  $siteValue = $data['sitename'];
  $template = $data['template'];

  if ($template == '') {
    $template = $default_template;
  }

  $html = '
    <h1>Spring IDX from Solid Earth - Search</h1>
    <form action="" method="POST">

      <br><br>' . SPRINGAPIWP_siteSelect($siteValue, $data['api_key']) . '

      <h2 style="display: inline;">API Key:</h2>
      <p style="display: inline;">Keys are available at <a href="http://developer.solidearth.com">SolidEarth</a>. The installed Key is a SandBox Key returning faked data for testing.</p>
      <br />
      <input style="margin-top: 10px;" type="text" name="apikey" value="' . $data['api_key'] . '">
      <br>

      <h2>Template:</h2>
      <textarea name="template" cols="50" rows="20">' . $template . '</textarea>

      <br>
      <input type="hidden" name="quick" value="quick" />
      <input type="submit">
    </form>
    <p>For more information about signing up for API keys and other questions see <a target="_blank" href="http://www.solidearth.com">www.solidearth.com</a> and/or send an email to <a href="mailto:api@solidearth.com">api@solidearth.com</a>.</p>
  ';

  echo $html;
}

function SPRINGAPIWP_agent_menu() {
  if(isset($_POST["agent"])) {
    $apikey = $_POST["apikey"];

    // YF 27-08-2015 Start.
    update_option( 'sesa_apikey', $apikey );
    // End.

    $sitename = $_POST["siteselect"];
    $template = stripslashes($_POST["template"]);
    $ids = "";

    $data = array('api_key' => $apikey,'sitename' => $sitename,'template'=> $template, 'ids' =>$ids);

    SPRINGAPIWP_set_data($data, 'agentpage_settings');
  }
  $data = SPRINGAPIWP_get_data('agentpage_settings');

  $default_template = '
    <div class="spring-quick-search">
      <div class="spring-clear-line" />
      <ul class="spring-quick-search-listings">
        {{#results}}
          {{#.}}
            <a href="/property/{{ListingId}}/{{location.address.StreetNumber}}-{{location.address.StreetName}}-{{location.address.City}}-{{location.address.StateOrProvince}}"><li class="quick-search-listing">
              <img class="spring-quick-search-photo-wrapper" src="{{Media.1.file}}" />
              {{#listingPricing}}
                <p class="spring-quick-search-price">${{listPrice}}</p>
              {{/listingPricing}}

              {{#location}}{{#address}}
                <p class="spring-quick-search-address">{{StreetNumber}} {{StreetName}}</p>
                <p class="spring-quick-search-address">{{City}}, {{StateOrProvince}}</p>
              {{/address}}{{/location}}

              {{#structure}}
                <p class="spring-quick-search-rooms">{{BedroomsTotal}} Bed, {{BathroomsTotal}} Bath</p>
              {{/structure}}`

              {{#property}}
                <p>Property Type: {{Type}}, {{SubType}}</p>
              {{/property}}

              {{#agentOffice}}
                {{#ListAgent}}
                  <p>Courtesy of {{{FullName}}},
                {{/ListAgent}}
                {{#ListOffice}}
                  {{{Name}}}</p>
                {{/ListOffice}}
              {{/agentOffice}}
            </li></a>
          {{/.}}
        {{/results}}
        {{^results}}
          <p>No listings available at this time.</p>
        {{/results}}
      </ul>
      <div class="clear-line" />
    </div>
  ';

  $siteValue = $data['sitename'];
  $template = $data['template'];

  if ($template == '') {
    $template = $default_template;
  }

  $html = '
    <h1>Spring IDX from Solid Earth - Agent Details</h1>
    <form action="" method="POST">

      <br><br>' . SPRINGAPIWP_siteSelect($siteValue, $data['api_key']) . '

      <h2 style="display: inline;">API Key:</h2>
      <p style="display: inline;">Keys are available at <a href="http://developer.solidearth.com">SolidEarth</a>. The installed Key is a SandBox Key returning faked data for testing.</p>
      <br />
      <input style="margin-top: 10px;" type="text" name="apikey" value="' . $data['api_key'] . '">
      <br>

      <h2>Template:</h2>
      <textarea name="template" cols="50" rows="20">' . $template . '</textarea>

      <br>
      <input type="hidden" name="agent" value="agent" />
      <input type="submit">
    </form>
    <p>For more information about signing up for API keys and other questions see <a target="_blank" href="http://www.solidearth.com">www.solidearth.com</a> and/or send an email to <a href="mailto:api@solidearth.com">api@solidearth.com</a>.</p>
  ';

  echo $html;
}

function SPRINGAPIWP_siteSelect ( $curVal, $api_key ) {
   $json_url = "https://api.solidearth.com/v1/sites?format=json&api_key=".$api_key."";
    $json = file_get_contents($json_url);
    $data = json_decode($json, TRUE);

    $siteTypes = array();
    foreach($data as $name){
        array_push($siteTypes, $name['site']);
    }


  //$siteTypes = array('gbrar', 'gcar', 'mlsbox', 'tuscar', 'mibor', 'baarmls', 'sandicor', 'rafgc');
    $siteSelect = '<h2 style="display: inline;">Site Select:</h2>
  <p style="display: inline;">Choose the Market or Markets in which you or your customer have an MLS Membership.</p>
  <br />
  <select style="margin-bottom:10px;" name="siteselect">';

  foreach($siteTypes as $selectVal) {
    if ($curVal == $selectVal) {
      $siteSelect .= '<option value="' . $selectVal . '" selected="selected">' . $selectVal . '</option>';
    }
    else {
      $siteSelect .= '<option value="' . $selectVal . '">' . $selectVal . '</option>';
    }
  }

  $siteSelect .= '</select><br />';

  return $siteSelect;
}

?>