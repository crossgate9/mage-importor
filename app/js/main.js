(function($) {
  $(function() {

    var _ajax = function(url, data, callback, failure) {
      $.ajax({
        url: url,
        data: data,
        type: 'post',
        beforeSend: function() { $.fancybox.showLoading(); }
      }).done(function(response) {
        $.fancybox.hideLoading();
        response = $.parseJSON(response);
        if (response.success == true) {
          callback(response);
        } else {
          failure(response);
        }
      });
    };

    $('#form-config').on('submit', function() {
      return false;
    });

    $('#form-config').on('click', '.btn-submit', function() {
      var $form = $('#form-config'),
          url = $form.attr('action'),
          data = $form.serialize();
      _ajax(url, data, function(response) {
        var $notice = $form.find('.notice');
        $notice.addClass('success');
        $notice.removeClass('failure');
        $notice.html(response.message);
      }, function(response) {
        var $notice = $form.find('.notice');
        $notice.removeClass('success');
        $notice.addClass('failure');
        $notice.html(response.message);
      });
      return false;
    });

    $('#form-csv').on('click', function('.btn-submit'), function() {
      return false;
    });

  });
})(jQuery);