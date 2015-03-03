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

    $('#form-csv').on('click','.btn-submit', function() {
      var $form = $('#form-csv');
      if($("#form-config .btn-set").children('.success').text()=="") {
        $("#form-csv .notice").addClass('failure');
        $("#form-csv .notice").html('Config information is invalid.');
        return false;
      } else {
            $form.submit();
            $.fancybox.showLoading();
          }
    }).done(function(){$.fancybox.hideLoading();});
  });
})(jQuery);
