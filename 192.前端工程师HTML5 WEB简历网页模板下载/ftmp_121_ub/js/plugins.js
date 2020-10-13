
jQuery.fn.extend({

    freezeHeight: function () {
        var $t = this;
        if ($t.length > 1) {
            $t.each(function () {
                $(this).defaultValue(args);
            })
            return $t;
        }
        $t.css('height', $t.outerHeight());
        return $t;
    }

});