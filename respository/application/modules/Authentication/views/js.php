<script type="text/javascript">

    $.ajaxSetup({
        beforeSend: function(jqXHR, settings) {
            settings.data = settings.data+'&<?php echo $this->security->get_csrf_token_name()?>='+ getCookie('csrf_cookie_name');
        },
        complete: function(){
            if($('input[name=<?php echo $this->security->get_csrf_token_name(); ?>]').val())
            {
                $('input[name=<?php echo $this->security->get_csrf_token_name(); ?>]').val(getCookie('csrf_cookie_name'));
            }
        }
    });

    var csrf_token_name = '<?php echo $this->security->get_csrf_token_name()?>';

    function GETSCRF()
    {
        return {
            name:'<?php echo $this->security->get_csrf_token_name()?>',
            value:getCookie('csrf_cookie_name')
        };
    }

    function getCookie( key )
    {
        var keyValue = document.cookie.match('(^|; ) ?' + key + '=([^;]*)(;|$)');

        return keyValue ? keyValue[2] : null;
    }

</script>