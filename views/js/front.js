
$(document).ready(() => {
  extmodulename.init();
});

const extmodulename = {
  requestStartSelector: 'ajax-request',

  init() {
    $.ajax({
      type: 'GET',
      headers: {
        'accept': 'application/json',
        'cache-control': 'no-cache'
      },
      url: prestashop.urls.shop_domain_url,
      async: true,
      data: {
        fc: 'module',
        module: 'extmodulename',
        controller: 'bar',
        action: 'indexAction',
        ajax: true
      },
      beforeSend: extmodulename.startRequest,
      success: extmodulename.updateVar,
      error: extmodulename.showError,
      complete: extmodulename.finishRequest
    });
  },

  startRequest(jqXHR, settings) {
    $('#content').append(
      '<div class="'
      + extmodulename.requestStartSelector
      + '">Ajax request in progress...</div>'
    );
  },

  finishRequest(jqXHR, statusText) {
    $('#content .' + extmodulename.requestStartSelector).remove();
  },

  updateVar(data, statusText, jqXHR) {
    console.log('OK');

    console.log('data: ', data);
    console.log('statusText: ', statusText);
    console.log('jqXHR: ', jqXHR);

    $('.var').text(data.var);
  },

  showError(jqXHR, statusText, errorThrown) {
    console.log('Error');

    console.log('jqXHR: ', jqXHR);
    console.log('statusText: ', statusText);
    console.log('errorThrown: ', errorThrown);

    let errorMessage = jqXHR.responseJSON.message
      ? jqXHR.responseJSON.message
      : errorThrown
    ;

    $('#content').append(
      '<div class="error">Error: ' + errorMessage + '</div>'
    );
  }
}
